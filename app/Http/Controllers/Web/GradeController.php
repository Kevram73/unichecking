<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Grade;

require 'constantes.php';

class GradeController extends Controller
{
	public function save(Request $request){
		$grd = $request->all();
		$la_grd = null;
		$status = [];
		
		$blUpdate = isset($grd["id"]) && $grd["id"] > 0;
		$id = $blUpdate ? $grd["id"] : 0;
		
		//id inconnu
		if (isset($grd["id"]) && $grd["id"] > 0)
		$la_grd = $this->ctrlField_NotFound($grd["id"], $status, status_grd__idnotfnd, 
			function($id, &$la_grd){ 
				$la_grd = Grade::find($id);
				return $la_grd == null;
			});					
			
		//intitule non renseigné
		$this->ctrlField_Empty($grd["intitule"], $status, status_grd__intitulevide);
			
		//intitule doublon
		$exists = !Grade::where("intitule", $grd["intitule"])
							->where("id", '<>', $id)
							->get()->isEmpty();	
		if ($exists) 
				$status[] = status_grd__intituledbl;

		//SI au moins l'une des erreurs plus haut sont retrouvées
		if (count($status) > 0) 
			return ["status" =>$status, "get"=> $la_grd];

		if (!$blUpdate)
			$la_grd = new Grade();
		
		try {
			DB::beginTransaction();
		
			$la_grd->fill($grd);
			$la_grd->save();
			
			DB::commit();
			return ["status" =>$status, "get"=>$la_grd];

		} catch (Throwable $e) {
			DB::rollback();
			return ["status" => [status_bderror], "get"=>$la_grd];
		}	
			
		return ["status" =>$status, "get"=>$la_grd];	
	}	
	
	public function liste(Request $request){
		$found = Grade::where('id', '<>', 0)
		->when($request->id, function ($query, $id) {
			return $query->where('id', $id);
		})->when($request->intitule, function ($query, $intitule) {
			return $query->where('intitule', 'like', "%$intitule%");
		})->orderBy('intitule', 'ASC');
		return $found->get()->toJson();
	}	
	
		
	public function supprimer($id){
		$status = [];
		
		$la_grd = Grade::find($id);
		
		if ($la_grd == null)
			$status[] = status_grd__idnotfnd;
		
		//SI au moins l'une des erreurs plus haut sont retrouvées
		if (count($status) > 0) return $status;
	
		$la_grd->delete();
		
		return $status;
	}
	
	public function vw_liste(Request $request){				
		$allData = array();
		$allData['data'] = $this->liste(new Request([]));
		return view('grade_all', $allData);
	}
	
	
	public function vw_save(Request $request){
		$resultat = null;
		$id = $request->id;
		
		$resultat = $this->save($request);
		if (isset($id) && $id > 0) {} else $id = 0;

		$status = $this->statusToMessages($resultat["status"]);

		session()->flash('status', $status);

		return redirect()->route('grade.show');
	}
	
	public function vw_delete($id){
		$la_grd = Grade::find($id);
		$resultat = $this->supprimer($id);
		$status = $this->statusToMessages($resultat);		
		session()->flash('status', $status);	
		
		return redirect()->route('grade.show');			
	}
	
	public function statusToMessages($status){		
		$messages = [];
		$suc = []; $err = [];
		
		foreach ($status as $s){			
			if ($s == status_grd__intitulevide)
				$err[] = "L'intitulé de la fonction n'est pas renseignée";
			if ($s == status_grd__intituledbl)
				$err[] = "L'intitulé de la fonction existe déjà";
			if ($s == status_grd__idnotfnd)
				$err[] = "La fonction n'a pas été retrouvée";	
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