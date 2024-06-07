<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Universite;

require 'constantes.php';

class UniversiteController extends Controller
{
	public function save(Request $request){
		$unv = $request->all();
		$l_unv = null;
		$status = [];

		$blUpdate = isset($unv["id"]) && $unv["id"] > 0;
		$id = $blUpdate ? $unv["id"] : 0;
		
		//id inconnu
		if (isset($unv["id"]) && $unv["id"] > 0)
		$l_unv = $this->ctrlField_NotFound($unv["id"], $status, status_unv__idnotfnd, 
			function($id, &$l_unv){ 
				$l_unv = Universite::find($id);
				return $l_unv == null;
			});				
						
		//nom non renseigné
		$this->ctrlField_Empty($unv["nom"], $status, status_unv__nomvide);
			
		//nom doublon
		$exists = !Universite::where("nom", $unv["nom"])
							->where("id", '<>', $id)
							->get()->isEmpty();	
		if ($exists) 
				$status[] = status_unv__nomdbl;

		//SI au moins l'une des erreurs plus haut sont retrouvées
		if (count($status) > 0) 
			return ["status" =>$status, "get"=> $l_unv];

		if (!$blUpdate)
			$l_unv = new Universite();
		
		try {
			DB::beginTransaction();
		
			$l_unv->fill($unv);
			$l_unv->save();
			
			DB::commit();
			return ["status" =>$status, "get"=>$l_unv];

		} catch (Throwable $e) {
			DB::rollback();
			return ["status" => [status_bderror], "get"=>$l_unv];
		}	
			
		return ["status" =>$status, "get"=>$l_unv];	
	}	
	
	public function liste(Request $request){
		$found = Universite::where('id', '<>', 0)
		->when($request->id, function ($query, $id) {
			return $query->where('id', $id);
		})->when($request->nom, function ($query, $nom) {
			return $query->where('nom', 'like', "%$nom%");
		})->orderBy('nom', 'ASC');
		return $found->get()->toJson();
	}	
	
		
	public function supprimer($id){
		$status = [];
		
		$l_unv = Universite::find($id);
		
		if ($l_unv == null)
			$status[] = status_unv__idnotfnd;
		
		//SI au moins l'une des erreurs plus haut sont retrouvées
		if (count($status) > 0) return $status;
	
		$l_unv->delete();
		
		return $status;
	}
	
	public function vw_liste(Request $request){				
		$allData = array();
		$allData['data'] = $this->liste(new Request([]));
		return view('universite_all', $allData);
	}
	
	
	public function vw_save(Request $request){
		$resultat = null;
		$id = $request->id;
		
		$resultat = $this->save($request);
		if (isset($id) && $id > 0) {} else $id = 0;

		$status = $this->statusToMessages($resultat["status"]);

		session()->flash('status', $status);

		return redirect()->route('universite.show');
	}

	
	public function vw_delete($id){
		$resultat = $this->supprimer($id);
		$status = $this->statusToMessages($resultat);		
		session()->flash('status', $status);
		return redirect()->route('universite.show');			
	}
	
	public function statusToMessages($status){		
		$messages = [];
		$suc = []; $err = [];
		foreach ($status as $s){			
			if ($s == status_unv__nomvide)
				$err[] = "Le nom de l'université n'est pas renseigné";
			if ($s == status_unv__nomdbl) 
				$err[] = "Ce nom de l'université est déjà enregistré";
			if ($s == status_unv__idnotfnd)
				$err[] = "Université inconnue";	
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