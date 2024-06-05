<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Poste;
use App\Models\CategoriePoste;

require 'constantes.php';

class PosteController extends Controller
{

	public function cat_save(Request $request){
		$cat = $request->all();
		$la_cat = null;
		$status = [];
		
		$blUpdate = isset($cat["id"]) && $cat["id"] > 0;
		$id = $blUpdate ? $cat["id"] : 0;
		
		//id inconnu
		if (isset($cat["id"]) && $cat["id"] > 0)
		$la_cat = $this->ctrlField_NotFound($cat["id"], $status, status_cat__idnotfnd, 
			function($id, &$la_cat){ 
				$la_cat = CategoriePoste::find($id);
				return $la_cat == null;
			});							
			
		//libelle non renseigné
		$this->ctrlField_Empty($cat["libelle"], $status, status_cat__libellevide);
			
		//libelle doublon
		$exists = !CategoriePoste::where("libelle", $cat["libelle"])
							->where("id", '<>', $id)
							->get()->isEmpty();	
		if ($exists) 
				$status[] = status_cat__libelledbl;

		//SI au moins l'une des erreurs plus haut sont retrouvées
		if (count($status) > 0) 
			return ["status" =>$status, "get"=> $la_cat];

		if (!$blUpdate)
			$la_cat = new CategoriePoste();
		
		try {
			DB::beginTransaction();
		
			$la_cat->fill($cat);
			$la_cat->save();
			
			DB::commit();
			return ["status" =>$status, "get"=>$la_cat];

		} catch (Throwable $e) {
			DB::rollback();
			return ["status" => [status_bderror], "get"=>$la_cat];
		}	
			
		return ["status" =>$status, "get"=>$la_cat];	
	}	
	
	public function cat_liste(Request $request){
		$found = CategoriePoste::with(['postes'])
		->when($request->id, function ($query, $id) {
			return $query->where('id', $id);
		})->when($request->libelle, function ($query, $libelle) {
			return $query->where('libelle', 'like', "%$libelle%");
		})->orderBy('exoneration_horaire', 'DESC');
		return $found->get()->toJson();
	}	
		
	public function cat_supprimer($id){
		$status = [];
		
		$la_cat = CategoriePoste::find($id);
		
		if ($la_cat == null)
			$status[] = status_cat__idnotfnd;
		
		//SI au moins l'une des erreurs plus haut sont retrouvées
		if (count($status) > 0) return $status;
		
		try {
			DB::beginTransaction();		
			Poste::where('categorie_poste_id', $id)->delete();
			$la_cat->delete();			
			DB::commit();
			return $status;

		} catch (Throwable $e) {
			DB::rollback();
			return [status_bderror];
		}
		
		
		return $status;
	}		
	
	
	
	
	
	
	public function save(Request $request){
		$pst = $request->all();
		$le_pst = null;
		$status = [];
		
		$blUpdate = isset($pst["id"]) && $pst["id"] > 0;
		$id = $blUpdate ? $pst["id"] : 0;
		
		//id inconnu
		if (isset($pst["id"]) && $pst["id"] > 0)
		$le_pst = $this->ctrlField_NotFound($pst["id"], $status, status_pst__idnotfnd, 
			function($id, &$le_pst){ 
				$le_pst = Poste::find($id);
				return $le_pst == null;
			});							
			
		//libelle non renseigné
		$this->ctrlField_Empty($pst["libelle"], $status, status_pst__libellevide);
			
		//libelle doublon
		$exists = !Poste::where("libelle", $pst["libelle"])
							->where("id", '<>', $id)
							->get()->isEmpty();	
		if ($exists) 
				$status[] = status_pst__libelledbl;
			
		// Catégorie inconnue
		$this->ctrlField_NotFound($pst["categorie_poste_id"], $status, status_pst__catunkwn, 
			function($id, &$la_cat){ 
				$la_cat = CategoriePoste::find($id);
				return $la_cat == null;
			});	

		//SI au moins l'une des erreurs plus haut sont retrouvées
		if (count($status) > 0) 
			return ["status" =>$status, "get"=> $le_pst];

		if (!$blUpdate)
			$le_pst = new Poste();
		
		try {
			DB::beginTransaction();
		
			$le_pst->fill($pst);
			$le_pst->save();
			
			DB::commit();
			return ["status" =>$status, "get"=>$le_pst];

		} catch (Throwable $e) {
			DB::rollback();
			return ["status" => [status_bderror], "get"=>$le_pst];
		}	
			
		return ["status" =>$status, "get"=>$le_pst];	
	}	
	
	public function liste(Request $request){
		$found = Poste::with(['categorie'])
		->when($request->id, function ($query, $id) {
			return $query->where('id', $id);
		})->when($request->categorie_poste_id, function ($query, $categorie_poste_id) {
			return $query->where('categorie_poste_id', $categorie_poste_id);
		})->when($request->libelle, function ($query, $libelle) {
			return $query->where('libelle', 'like', "%$libelle%");
		})->orderBy('libelle', 'DESC');
		return $found->get()->toJson();
	}		
		
	public function supprimer($id){
		$status = [];
		
		$le_pst = Poste::find($id);
		
		if ($le_pst == null)
			$status[] = status_pst__idnotfnd;
		
		//SI au moins l'une des erreurs plus haut sont retrouvées
		if (count($status) > 0) return $status;
	
		$le_pst->delete();
		
		return $status;
	}
	
	public function vw_liste_cat(Request $request){				
		$allData = array();
		$allData['data'] = $this->cat_liste(new Request([]));
		return view('poste_all', $allData);
	}
	
	
	public function vw_save(Request $request){
		$resultat = null;
		$id = $request->id;
		
		$resultat = $this->save($request);
		if (isset($id) && $id > 0) {} else $id = 0;

		$status = $this->statusToMessages($resultat["status"]);

		session()->flash('status', $status);

		return redirect()->route('poste.show');
	}
	
	
	public function vw_save_cat(Request $request){
		$resultat = null;
		$id = $request->id;
		
		$resultat = $this->cat_save($request);
		if (isset($id) && $id > 0) {} else $id = 0;

		$status = $this->statusToMessages($resultat["status"]);

		session()->flash('status', $status);

		return redirect()->route('poste.show');
	}
	
	public function vw_delete($id){
		$le_pst = Poste::find($id);
		$resultat = $this->supprimer($id);
		$status = $this->statusToMessages($resultat);		
		session()->flash('status', $status);	
		
		return redirect()->route('poste.show');			
	}
	
	public function vw_delete_cat($id){
		$la_cat = CategoriePoste::find($id);
		$resultat = $this->cat_supprimer($id);
		$status = $this->statusToMessages($resultat);		
		session()->flash('status', $status);	
		
		return redirect()->route('poste.show');			
	}
	
	public function statusToMessages($status){		
		$messages = [];
		$suc = []; $err = [];
		
		foreach ($status as $s){			
			if ($s == status_pst__libellevide)
				$err[] = "L'intitulé du poste n'est pas renseigné";
			if ($s == status_pst__libelledbl)
				$err[] = "L'intitulé du poste existe déjà";
			if ($s == status_pst__catunkwn)
				$err[] = "La catégorie de poste n'a pas été retrouvée";
			if ($s == status_pst__idnotfnd)
				$err[] = "La séance n'a pas été retrouvée";	
			if ($s == status_prob_bd) 	
				$err[] = "Problème de base de données. Veuillez réessayer!";		
			
			
			if ($s == status_cat__libellevide)
				$err[] = "Le libellé de la catégorie de poste n'est pas renseigné";
			if ($s == status_cat__libelledbl)
				$err[] = "Le libellé de la catégorie de poste existe déjà";
			if ($s == status_cat__idnotfnd)
				$err[] = "La séance n'a pas été retrouvée";	
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