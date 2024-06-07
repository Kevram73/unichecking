<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\TypeDeplacement;

require 'constantes.php';

class TypeDeplacementController extends Controller
{
	public function save(Request $request){
		$tdpl = $request->all();
		$le_tdpl = null;
		$status = [];

		$blUpdate = isset($tdpl["id"]) && $tdpl["id"] > 0;
		$id = $blUpdate ? $tdpl["id"] : 0;
		
		//id inconnu
		if (isset($tdpl["id"]) && $tdpl["id"] > 0)
		$le_tdpl = $this->ctrlField_NotFound($tdpl["id"], $status, status_tdpl__idnotfnd, 
			function($id, &$le_tdpl){ 
				$le_tdpl = TypeDeplacement::find($id);
				return $le_tdpl == null;
			});				
						
		//désignation non renseigné
		$this->ctrlField_Empty($tdpl["designation"], $status, status_tdpl__dsgvide);
			
		//désignation doublon
		$exists = !TypeDeplacement::where("designation", $tdpl["designation"])
							->where("id", '<>', $id)
							->get()->isEmpty();	
		if ($exists) 
				$status[] = status_tdpl__dsgdbl;

		//SI au moins l'une des erreurs plus haut sont retrouvées
		if (count($status) > 0) 
			return ["status" =>$status, "get"=> $le_tdpl];

		if (!$blUpdate)
			$le_tdpl = new TypeDeplacement();
		
		try {
			DB::beginTransaction();
		
			$le_tdpl->fill($tdpl);
			$le_tdpl->save();
			
			DB::commit();
			return ["status" =>$status, "get"=>$le_tdpl];

		} catch (Throwable $e) {
			DB::rollback();
			return ["status" => [status_bderror], "get"=>$le_tdpl];
		}	
			
		return ["status" =>$status, "get"=>$le_tdpl];	
	}	
	
	public function liste(Request $request){
		$found = TypeDeplacement::where('id', '<>', 0)
		->when($request->id, function ($query, $id) {
			return $query->where('id', $id);
		})->when($request->designation, function ($query, $designation) {
			return $query->where('designation', 'like', "%$designation%");
		})->orderBy('designation', 'ASC');
		return $found->get()->toJson();
	}	
	
		
	public function supprimer($id){
		$status = [];
		
		$le_tdpl = TypeDeplacement::find($id);
		
		if ($le_tdpl == null)
			$status[] = status_tdpl__idnotfnd;
		
		//SI au moins l'une des erreurs plus haut sont retrouvées
		if (count($status) > 0) return $status;
	
		$le_tdpl->delete();
		
		return $status;
	}
	
	public function vw_liste(Request $request){				
		$allData = array();
		$allData['data'] = $this->liste(new Request([]));
		return view('type_deplacement_all', $allData);
	}
	
	
	public function vw_save(Request $request){
		$resultat = null;
		$id = $request->id;
		
		$resultat = $this->save($request);
		if (isset($id) && $id > 0) {} else $id = 0;

		$status = $this->statusToMessages($resultat["status"]);

		session()->flash('status', $status);

		return redirect()->route('type_deplacement.show');
	}

	
	public function vw_delete($id){
		$resultat = $this->supprimer($id);
		$status = $this->statusToMessages($resultat);		
		session()->flash('status', $status);
		return redirect()->route('type_deplacement.show');			
	}
	
	public function statusToMessages($status){		
		$messages = [];
		$suc = []; $err = [];
		foreach ($status as $s){			
			if ($s == status_tdpl__dsgvide)
				$err[] = "Désignation non renseignée";
			if ($s == status_tdpl__dsgdbl) 
				$err[] = "La désignation est déjà enregistrée";
			if ($s == status_tdpl__idnotfnd)
				$err[] = "Désignation inconnue";	
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