<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Specialite;

require 'constantes.php';

class SpecialiteController extends Controller
{
	public function save(Request $request){
		$spe = $request->all();
		$la_spe = null;
		$status = [];
		
		$blUpdate = isset($spe["id"]) && $spe["id"] > 0;
		$id = $blUpdate ? $spe["id"] : 0;
		
		//id inconnu
		if (isset($spe["id"]) && $spe["id"] > 0)
		$la_spe = $this->ctrlField_NotFound($spe["id"], $status, status_spe__idnotfnd, 
			function($id, &$la_spe){ 
				$la_spe = Specialite::find($id);
				return $la_spe == null;
			});				
			
		//code non renseigné
		$this->ctrlField_Empty($spe["code"], $status, status_spe__codevide);
			
		//code doublon
		$exists = !Specialite::where("code", $spe["code"])
							->where("id", '<>', $id)
							->get()->isEmpty();	
		if ($exists) 
				$status[] = status_spe__codedbl;			
			
		//intitule non renseigné
		$this->ctrlField_Empty($spe["intitule"], $status, status_spe__intitulevide);
			
		//intitule doublon
		$exists = !Specialite::where("intitule", $spe["intitule"])
							->where("id", '<>', $id)
							->get()->isEmpty();	
		if ($exists) 
				$status[] = status_spe__intituledbl;

		//SI au moins l'une des erreurs plus haut sont retrouvées
		if (count($status) > 0) 
			return ["status" =>$status, "get"=> $la_spe];

		if (!$blUpdate)
			$la_spe = new Specialite();
		
		try {
			DB::beginTransaction();
		
			$la_spe->fill($spe);
			$la_spe->save();
			
			DB::commit();
			return ["status" =>$status, "get"=>$la_spe];

		} catch (Throwable $e) {
			DB::rollback();
			return ["status" => [status_bderror], "get"=>$la_spe];
		}	
			
		return ["status" =>$status, "get"=>$la_spe];	
	}	
	
	public function liste(Request $request){
		$found = Specialite::where('id', '<>', 0)
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
		
		$la_spe = Specialite::find($id);
		
		if ($la_spe == null)
			$status[] = status_spe__idnotfnd;
		
		//SI au moins l'une des erreurs plus haut sont retrouvées
		if (count($status) > 0) return $status;
	
		$la_spe->delete();
		
		return $status;
	}
	
	public function vw_liste(Request $request){				
		$allData = array();
		$allData['data'] = $this->liste(new Request([]));
		return view('specialite_all', $allData);
	}
	
	
	public function vw_save(Request $request){
		$resultat = null;
		$id = $request->id;
		
		$resultat = $this->save($request);
		if (isset($id) && $id > 0) {} else $id = 0;

		$status = $this->statusToMessages($resultat["status"]);

		session()->flash('status', $status);

		return redirect()->route('specialite.show');
	}
	
	public function vw_delete($id){
		$la_spe = Specialite::find($id);
		$resultat = $this->supprimer($id);
		$status = $this->statusToMessages($resultat);		
		session()->flash('status', $status);	
		
		return redirect()->route('specialite.show');			
	}
	
	public function statusToMessages($status){		
		$messages = [];
		$suc = []; $err = [];
		
		foreach ($status as $s){			
			if ($s == status_spe__codevide)
				$err[] = "Le code de la spécialité n'est pas renseigné";
			if ($s == status_spe__codedbl)
				$err[] = "Le code de la spécialité existe déjà";
			if ($s == status_spe__intitulevide)
				$err[] = "L'intitulé de la spécialité n'est pas renseignée";
			if ($s == status_spe__intituledbl)
				$err[] = "L'intitulé de l'Specialite existe déjà";
			if ($s == status_spe__idnotfnd)
				$err[] = "L'Specialite n'a pas été retrouvée";	
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