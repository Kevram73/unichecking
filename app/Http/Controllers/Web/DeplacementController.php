<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Enseignant;
use App\Models\TypeDeplacement;
use App\Models\Deplacement;

require 'constantes.php';

class DeplacementController extends Controller
{
	public function save(Request $request){
		$dpl = $request->all();
		$le_dpl = null;
		$status = [];
		
		$blUpdate = isset($dpl["id"]) && $dpl["id"] > 0;
		
		//id inconnu
		if (isset($dpl["id"]) && $dpl["id"] > 0)
		$le_dpl = $this->ctrlField_NotFound($dpl["id"], $status, status_dpl__idnotfnd, 
			function($id, &$le_dpl){ 
				$le_dpl = Deplacement::find($id);
				return $le_dpl == null;
			});		
			
		//type inconnu
		$le_tpd = $this->ctrlField_NotFound($dpl["type_deplacement_id"], $status, status_dpl__tpdunkwn, 
			function($id, &$le_dpl){ 
				$le_dpl = TypeDeplacement::find($id);
				return $le_dpl == null;
			});
			
			
		//date_debut non renseigné
		$this->ctrlField_Empty($dpl["date_debut"], $status, status_dpl__dtdebvide);
			
		//date_fin non renseigné
		$this->ctrlField_Empty($dpl["date_fin"], $status, status_dpl__dtfinvide);

		//incohérence chronologique entre les 2 dates
		if (isset($dpl["date_debut"]) && isset($dpl["date_fin"]))
			if ($dpl["date_debut"] >= $dpl["date_fin"])
				$status[] = status_dpl__dtchrono;

		//enseignant_id inconnu
		$this->ctrlField_NotFound($dpl["enseignant_id"], $status, status_dpl__ensunkwn, 
			function($id){ 
				return Enseignant::find($id) == null;
			});	
		
		//SI au moins l'une des erreurs plus haut sont retrouvées
		if (count($status) > 0) 
			return ["status" =>$status, "get"=> $le_dpl];

		if (!$blUpdate){
			$le_dpl = new Deplacement();
			$le_dpl->annee_id = session('annee_id', 1);
			$le_dpl->universite_id = session('universite_id', 1);			
		}
		
		try {
			DB::beginTransaction();
		
			$le_dpl->fill($dpl);
			$le_dpl->save();
			
			DB::commit();
			return ["status" =>$status, "get"=>$le_dpl];

		} catch (Throwable $e) {
			DB::rollback();
			return ["status" => [status_bderror], "get"=>$le_dpl];
		}	
			
		return ["status" =>$status, "get"=>$le_dpl];	
	}	
	
	public function liste(Request $request){
		$found = Deplacement::with([
			'type',
			'enseignant'
		])
		->when($request->id, function ($query, $id) {
			return $query->where('id', $id);
		})->when($request->type_deplacement_id, function ($query, $type_deplacement_id) {
			return $query->where('type_deplacement_id', $type_deplacement_id);
		})->when($request->enseignant_id, function ($query, $enseignant_id) {
			return $query->where('enseignant_id', $enseignant_id);
		})->when($request->annee_id, function ($query, $annee_id) {
			return $query->where('annee_id', $annee_id);
		})->when($request->universite_id, function ($query, $universite_id) {
			return $query->where('universite_id', $universite_id);
		})->orderBy('date_debut', 'ASC')
		->orderBy('date_fin', 'ASC');
		return $found->get()->toJson();
	}	
	
		
	public function supprimer($id){
		$status = [];
		
		$le_dpl = Deplacement::find($id);
		
		if ($le_dpl == null)
			$status[] = status_dpl__idnotfnd;
		
		//SI au moins l'une des erreurs plus haut sont retrouvées
		if (count($status) > 0) return $status;
	
		$le_dpl->delete();
		
		return $status;
	}
	
	public function vw_liste(Request $request){				
		$annee_id = session('annee_id', 1);
		$universite_id = session('universite_id', 1);
		
		$allData = array();
		$allData['data'] = $this->liste(new Request(
		[
		"annee_id"=>$annee_id,
		"universite_id"=>$universite_id,		
		]
		));
		return view('deplacement_all', $allData);
	}
	
	public function vw_new(Request $request){
		$annee_id = session('annee_id', 1);
		$universite_id = session('universite_id', 1);
			
		$allData = array();
		$allData['data'] = new Deplacement();
		$allData['id'] = 0;
		$allData['enseignants'] = Enseignant::get();
		$allData['types'] = TypeDeplacement::get();
		
		return view('deplacement_edit', $allData);		
	}	
	
	public function vw_edit($id, Request $request){		
		$annee_id = session('annee_id', 1);
		$universite_id = session('universite_id', 1);
		
		$le_dpl = Deplacement::with([
			'type', 'enseignant'
		])->find($id);
		
		if ($le_dpl == null){				
			session()->flash('status', [
				"succes" => [],
				"erreur" => ["déplacement inconnu"]
			]);	
			return back();
		}
		
		$allData = array();
		$allData['id'] = $id;
		
		$allData['enseignants'] = Enseignant::get();
		$allData['types'] = TypeDeplacement::get();
		
		if ($le_dpl == null) {
			$le_dpl = new Deplacement();
		}
		$allData['data'] = $le_dpl;	
		
		return view('deplacement_edit', $allData);		
	}
	
	public function vw_save(Request $request){
		$resultat = null;
		$id = $request->id;
		
		$resultat = $this->save($request);
		if (isset($id) && $id > 0) {} else $id = 0;

		$status = $this->statusToMessages($resultat["status"]);

		session()->flash('status', $status);
		if (count($resultat["status"]) == 0)
			return redirect()->route('deplacement.show');		
		else{			
			if ($id > 0)
				return redirect()->route('deplacement.edit', ["id" => $id]);	
			else
				return redirect()->route('deplacement.new');
		}	
	}
	
	public function vw_delete($id){
		$le_dpl = Deplacement::find($id);
		$resultat = $this->supprimer($id);
		$status = $this->statusToMessages($resultat);		
		session()->flash('status', $status);	
		
		return redirect()->route('deplacement.show');			
	}
	
	public function statusToMessages($status){		
		$messages = [];
		$suc = []; $err = [];
		
		foreach ($status as $s){			
			if ($s == status_dpl__tpdunkwn)
				$err[] = "Le type de déplacement est inconnu";
			if ($s == status_dpl__dtdebvide)
				$err[] = "La date de début des cours n'est pas renseignée";
			if ($s == status_dpl__dtfinvide)
				$err[] = "La date de fin de cours n'est pas renseignée";
			if ($s == status_dpl__dtchrono)
				$err[] = "La date de fin précède la date de début de cours";
			if ($s == status_dpl__ensunkwn)
				$err[] = "L'enseignant choisi est inconnu";	
			if ($s == status_dpl__idnotfnd)
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