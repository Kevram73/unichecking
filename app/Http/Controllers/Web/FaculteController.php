<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\UE;
use App\Models\Faculte;
use App\Models\FaculteUE;

require 'constantes.php';


class FaculteController extends Controller
{

	public function save(Request $request){
		$fac = $request->all();
		$la_fac = null;
		$the_year_id = session('annee_id', 1);

		$status = [];
		
		$blUpdate = isset($fac["id"]) && $fac["id"] > 0;
		$id = $blUpdate ? $fac["id"] : 0;
		
		//id inconnu
		if (isset($fac["id"]) && $fac["id"] > 0)
		$la_fac = $this->ctrlField_NotFound($fac["id"], $status, status_fac__idnotfnd, 
			function($id, &$la_fac){ 
				$la_fac = Faculte::find($id);
				return $la_fac == null;
			});
			
		//libelle non renseigné
		$this->ctrlField_Empty($fac["libelle"], $status, status_fac__libellevide);
		
		//libelle doublon
		$exists = !Faculte::where("libelle", $fac["libelle"])
							->where("id", '<>', $id)
							->get()->isEmpty();	
		if ($exists) 
				$status[] = status_fac__codedbl;	
			
		//code non renseigné
		$this->ctrlField_Empty($fac["code"], $status, status_fac__codevide);
		
		//code doublon
		$exists = !Faculte::where("code", $fac["code"])
							->where("id", '<>', $id)
							->get()->isEmpty();	
		if ($exists) 
				$status[] = status_fac__codedbl;	
		
		//SI au moins l'une des erreurs plus haut sont retrouvées
		if (count($status) > 0) 
			return ["status" =>$status, "get"=> $la_fac];

		if (!$blUpdate)
			$la_fac = new Faculte();
		
		try {
			DB::beginTransaction();
		
			$la_fac->fill($fac);
			$la_fac->save();
					
			DB::commit();
			return ["status" =>$status, "get"=>$la_fac];

		} catch (Throwable $e) {
			DB::rollback();
			return ["status" => [status_bderror], "get"=>$la_fac];
		}	
			
		return ["status" =>$status, "get"=>$la_fac];	
	}	
	
	public function liste(Request $request){
		
		$found = Faculte
		::with([
			'filieres'
		])->where('id', '<>', 0)
		->when($request->id, function ($query, $id) {
			return $query->where('id', $id);
		})->when($request->libelle, function ($query, $libelle) {
			return $query->where('libelle', 'like', "%$libelle%");
		})->when($request->code, function ($query, $code) {
			return $query->where('code', "$code");
		})->orderBy('libelle', 'ASC');
		return $found->get()->toJson();
	}	
	
	public function supprimer($id){
		$status = [];
		
		$la_fac = Faculte::find($id);
		
		if ($la_fac == null)
			$status[] = status_fac__idnotfnd;
		
		//SI au moins l'une des erreurs plus haut sont retrouvées
		if (count($status) > 0) $status;
	
		$la_fac->delete();
		
		return $status;
	}
	
	public function vw_liste(Request $request){
		$allData = array();
		$allData['data'] = $this->liste(new Request([]));
		return view('faculte_all', $allData);
	}
	
	public function vw_new(Request $request){
		$annee_id = session('annee_id', 1);
		$allData = array();
		$allData['data'] = new Faculte();
		$allData['id'] = 0;
		return view('faculte_edit', $allData);		
	}	
	
	public function vw_edit($id, Request $request){		
		$annee_id = session('annee_id', 1);
		
		$allData = array();
		$allData['id'] = $id;
		$la_fac = Faculte::find($id);

		if ($la_fac == null) {
			$la_fac = new Faculte();
		}
		$allData['data'] = $la_fac;		
		return view('faculte_edit', $allData);		
	}
	
	public function vw_save(Request $request){
		$resultat = null;
		$id = $request->id;
		
		$resultat = $this->save($request);
		if (isset($id) && $id > 0) {} else $id = 0;

		$status = $this->statusToMessages($resultat["status"]);

		session()->flash('status', $status);
		if (count($resultat["status"]) == 0)
			return redirect()->route('faculte.show');		
		else{			
			if ($id > 0)
				return redirect()->route('faculte.edit', ["id" => $id]);	
			else
				return redirect()->route('faculte.new');
		}	
	}
	
	public function vw_activate($id){
		$resultat = $this->activer($id);
		//$resultat = json_decode($resultat, true);
		$status = $this->statusToMessages($resultat);	
		session()->flash('status', $status);	
		return redirect()->route('faculte.show');			
	}
	
	public function vw_delete($id){
		$resultat = $this->supprimer($id);
		$status = $this->statusToMessages($resultat);		
		session()->flash('status', $status);
		return redirect()->route('faculte.show');			
	}
	
	public function statusToMessages($status){		
		$messages = [];
		$suc = []; $err = [];
		foreach ($status as $s){			
			if ($s == status_fac__libellevide)
				$err[] = "La désignation n'est pas renseignée";
			if ($s == status_fac__libelledbl)
				$err[] = "Il y a déjà une faculté de même désignation";
			if ($s == status_fac__codevide)
				$err[] = "Le code n'est pas renseigné";
			if ($s == status_fac__codedbl)
				$err[] = "Il y a déjà une faculté de même code";
			if ($s == status_fac__idnotfnd)
				$err[] = "Faculté non retrouvée";	
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