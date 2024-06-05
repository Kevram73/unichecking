<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\UE;

require 'constantes.php';

class UEController extends Controller
{
	public function save(Request $request){
		$ue = $request->all();
		$l_ue = null;
		$status = [];
		
		$blUpdate = isset($ue["id"]) && $ue["id"] > 0;
		$id = $blUpdate ? $ue["id"] : 0;
		
		//id inconnu
		if (isset($ue["id"]) && $ue["id"] > 0)
		$l_ue = $this->ctrlField_NotFound($ue["id"], $status, status_ue__idnotfnd, 
			function($id, &$l_ue){ 
				$l_ue = UE::find($id);
				return $l_ue == null;
			});				
			
		//code non renseigné
		$this->ctrlField_Empty($ue["code"], $status, status_ue__codevide);
			
		//code doublon
		$exists = !UE::where("code", $ue["code"])
							->where("id", '<>', $id)
							->get()->isEmpty();	
		if ($exists) 
				$status[] = status_ue__codedbl;			
			
		//intitule non renseigné
		$this->ctrlField_Empty($ue["intitule"], $status, status_ue__intitulevide);
			
		//intitule doublon
		$exists = !UE::where("intitule", $ue["intitule"])
							->where("id", '<>', $id)
							->get()->isEmpty();	
		if ($exists) 
				$status[] = status_ue__intituledbl;

		//SI au moins l'une des erreurs plus haut sont retrouvées
		if (count($status) > 0) 
			return ["status" =>$status, "get"=> $l_ue];

		if (!$blUpdate)
			$l_ue = new UE();
		
		try {
			DB::beginTransaction();
		
			$l_ue->fill($ue);
			$l_ue->save();
			
			DB::commit();
			return ["status" =>$status, "get"=>$l_ue];

		} catch (Throwable $e) {
			DB::rollback();
			return ["status" => [status_bderror], "get"=>$l_ue];
		}	
			
		return ["status" =>$status, "get"=>$l_ue];	
	}	
	
	public function liste(Request $request){
		$found = UE::where('id', '<>', 0)
		->when($request->id, function ($query, $id) {
			return $query->where('id', $id);
		})->when($request->code, function ($query, $code) {
			return $query->where('code', $code);
		})->when($request->intitule, function ($query, $intitule) {
			return $query->where('intitule', 'like', "%$intitule%");
		})->orderBy('code', 'ASC');
		return $found->get()->toJson();
	}	
	
		
	public function supprimer($id){
		$status = [];
		
		$l_ue = UE::find($id);
		
		if ($l_ue == null)
			$status[] = status_ue__idnotfnd;
		
		//SI au moins l'une des erreurs plus haut sont retrouvées
		if (count($status) > 0) return $status;
	
		$l_ue->delete();
		
		return $status;
	}
	
	public function vw_liste(Request $request){				
		$allData = array();
		$allData['data'] = $this->liste(new Request([]));
		return view('ue_all', $allData);
	}
	
	
	public function vw_save(Request $request){
		$resultat = null;
		$id = $request->id;
		
		$resultat = $this->save($request);
		if (isset($id) && $id > 0) {} else $id = 0;

		$status = $this->statusToMessages($resultat["status"]);

		session()->flash('status', $status);

		return redirect()->route('ue.show');
	}
	
	public function vw_delete($id){
		$l_ue = UE::find($id);
		$resultat = $this->supprimer($id);
		$status = $this->statusToMessages($resultat);		
		session()->flash('status', $status);	
		
		return redirect()->route('ue.show');			
	}
	
	public function statusToMessages($status){		
		$messages = [];
		$suc = []; $err = [];
		
		foreach ($status as $s){			
			if ($s == status_ue__codevide)
				$err[] = "Le code de l'UE n'est pas renseigné";
			if ($s == status_ue__codedbl)
				$err[] = "Le code de l'UE existe déjà";
			if ($s == status_ue__intitulevide)
				$err[] = "L'intitulé de l'UE n'est pas renseignée";
			if ($s == status_ue__intituledbl)
				$err[] = "L'intitulé de l'UE existe déjà";
			if ($s == status_ue__idnotfnd)
				$err[] = "L'UE n'a pas été retrouvée";	
			if ($s == status_prob_bd) 	
				$err[] = "Problème de base de données. Veuillez réessayer!";		
		}
		if (count($status) == 0)
			$suc[] = "Succès de l'opération!";
		
		$messages["succes"] = $suc;
		$messages["erreur"] = $err;
		
		return $messages;
	}	

	
	public function alreadyUsed($id){
		return 0;
	}
}