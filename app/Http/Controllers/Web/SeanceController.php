<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Enseignant;
use App\Models\EnseignantUE;
use App\Models\UE;
use App\Models\Filiere;
use App\Models\Faculte;
use App\Models\FaculteUE;
use App\Models\Seance;
use App\Models\SeanceUE;
use App\Models\DateSeance;
use App\Models\Deplacement;

require 'constantes.php';

class SeanceController extends Controller
{
	//annee_academique_id, faculte_ue_id, enseignant_id, 
	//jour_semaine, heure_debut, heure_fin, date_debut, date_fin
	public function save(Request $request){
		$sce = $request->all();
		$la_sce = null;
		$the_year_id = session('annee_id', 1);

		$status = [];
		
		$blUpdate = isset($sce["id"]) && $sce["id"] > 0;
		
		//id inconnu
		if (isset($sce["id"]) && $sce["id"] > 0)
		$la_sce = $this->ctrlField_NotFound($sce["id"], $status, status_sce__idnotfnd, 
			function($id, &$la_sce){ 
				$la_sce = Seance::find($id);
				return $la_sce == null;
			});
			
		//jour_semaine non renseigné
		$this->ctrlField_Empty($sce["jour_semaine"], $status, status_sce__jourvide);
			
		//heure_debut non renseigné
		$this->ctrlField_Empty($sce["heure_debut"], $status, status_sce__hrdebvide);
			
		//heure_fin non renseigné
		$this->ctrlField_Empty($sce["heure_fin"], $status, status_sce__hrfinvide);

		//incohérence chronologique entre les 2 heures
		if (isset($sce["heure_debut"]) && isset($sce["heure_fin"]))
			if ($sce["heure_debut"] >= $sce["heure_fin"])
				$status[] = status_sce__hrchrono;	
			
		//date_debut non renseigné
		$this->ctrlField_Empty($sce["date_debut"], $status, status_sce__dtdebvide);
			
		//date_fin non renseigné
		$this->ctrlField_Empty($sce["date_fin"], $status, status_sce__dtfinvide);

		//incohérence chronologique entre les 2 dates
		if (isset($sce["date_debut"]) && isset($sce["date_fin"]))
			if ($sce["date_debut"] >= $sce["date_fin"])
				$status[] = status_sce__dtchrono;

		//enseignant_id inconnu
		$this->ctrlField_NotFound($sce["enseignant_id"], $status, status_sce__ensunkwn, 
			function($id){ 
				return Enseignant::find($id) == null;
			});	
			
		//ue_id inconnu
		$this->ctrlField_NotFound($sce["ue_id"], $status, status_sce__ueunkwn, 
			function($id){ 
				return UE::find($id) == null;
			});		
			
		//enseignant_ue_id inconnu
		$this->ctrlField_NotFound($sce["enseignant_ue_id"], $status, status_sce__ueunkwn, 
			function($id){ 
				return EnseignantUE::find($id) == null;
			});		
		
		//SI au moins l'une des erreurs plus haut sont retrouvées
		if (count($status) > 0) 
			return ["status" =>$status, "get"=> $la_sce];

		if (!$blUpdate)
			$la_sce = new Seance();
		
		try {
			DB::beginTransaction();
		
			$la_sce->fill($sce);
			$la_sce->annee_id = session('annee_id', 1);
			$la_sce->universite_id = session('universite_id', 1);
			$la_sce->save();

			if (isset($sce["sce_ue_id"]))
			foreach($sce["sce_ue_id"] as $ndx=>$value_id){
				$sce_ue = null;
				$blDel = 0;
				$blUpd = 0;
				if ($value_id > 0){
					$blDel = isset($ens["sce_ue_del"]) && $ens["sce_ue_del"][$ndx] > 0;
					$blUpd = !$blDel;					
				}
				$blAdd = $value_id == 0;
				if ($blAdd){
					$sce_ue = new SeanceUE();
				} else{
					$sce_ue = SeanceUE::find($value_id);
					if ($sce_ue)
						if ($blDel){
							$sce_ue->delete();					
						} else {					
						}						
				}	
				if (!$blDel && $sce_ue){					
					$sce_ue->ue_id = $sce["ue_id"];
					$sce_ue->filiere_id = $sce["filiere_id"][$ndx];
					$sce_ue->faculte_id = $sce["faculte_id"][$ndx];
					$sce_ue->seance_id = $la_sce->id;
					$sce_ue->semestre = $sce["semestre"][$ndx];
					$sce_ue->save();
				}
			}

			
			//Génération des DateSeance
			DateSeance::where('seance_id')->delete();
			/**/
			$db=date_create_from_format("Y-m-d", $sce["date_debut"]);
			$df=date_create_from_format("Y-m-d", $sce["date_fin"]);
			$first_date = $db;
			$dw = date_format($db, "N") + 0;
			$dw_inc = $sce["jour_semaine"] - $dw;
			if($dw_inc < 0) $dw_inc += 7;
			//le jour de semaine de $first_date sera $sce["jour_smenaine"]
			$first_date = date_add($db, date_interval_create_from_date_string("$dw_inc days"));
			$d_inc = $first_date;			
			while ($d_inc <= $df){
				//Avant la création de la DateSeance, vérifier si une des dates tombe
				//dans une des périodes de déplacement de l'Enseignant
				$dpl = Deplacement::where('enseignant_id', $la_sce->enseignant_id)
				->where('universite_id', $la_sce->universite_id)
				->where('annee_id', $la_sce->annee_id)
				->where('date_debut', '<=', $d_inc)
				->where('date_fin', '>=', $d_inc)
				->first();
				
				if ($dpl){} else{
					$dt_sce = new DateSeance();
					$dt_sce->seance_id = $la_sce->id;
					$dt_sce->date_seance = $d_inc;
					$dt_sce->save();				
				}	
				/**/
				date_add($d_inc,date_interval_create_from_date_string("7 days"));				
			}
			
			DB::commit();
			return ["status" =>$status, "get"=>$la_sce];

		} catch (Throwable $e) {
			DB::rollback();
			return ["status" => [status_bderror], "get"=>$la_sce];
		}	
			
		return ["status" =>$status, "get"=>$la_sce];	
	}	
	
	public function liste(Request $request){
		
		$found = Seance::with([
			'ue' => function($query) {
				return $query->with(['ue', 'faculte']);
			},
			'enseignant'
		])
		->when($request->id, function ($query, $id) {
			return $query->where('id', $id);
		})->when($request->faculte_ue_id, function ($query, $faculte_ue_id) {
			return $query->where('faculte_ue_id', $faculte_ue_id);
		})->when($request->enseignant_id, function ($query, $enseignant_id) {
			return $query->where('enseignant_id', $enseignant_id);
		})->when($request->annee_id, function ($query, $annee_id) {
			return $query->where('annee_id', $annee_id);
		})->when($request->universite_id, function ($query, $universite_id) {
			return $query->where('universite_id', $universite_id);
		})->orderBy('date_debut', 'ASC')
		->orderBy('heure_debut', 'ASC')
		->orderBy('heure_fin', 'ASC')
		->orderBy('date_fin', 'ASC');
		return $found->get()->toJson();
	}	
	
	public function liste_ens(Request $request){
		$annee_id = $request->annee_id;
		$universite_id = $request->universite_id;
		$found = Enseignant::with([
			'ues' => function($query)  use ($annee_id, $universite_id){
				return $query->with([
				'seances' => function($query) use ($annee_id, $universite_id){					
					return $query->with(
					['ue']
					)->when($annee_id, function ($query, $annee_id) {
						return $query->where('annee_id', $annee_id);
					})->when($universite_id, function ($query, $universite_id) {
						return $query->where('universite_id', $universite_id);
					});
				}, 
				'faculte',
				'ue']);
			},
			'ens_grade'
		])
		->when($request->id, function ($query, $id) {
			return $query->where('id', $id);
		})->when($request->faculte_ue_id, function ($query, $faculte_ue_id) {
			return $query->where('faculte_ue_id', $faculte_ue_id);
		})->when($request->enseignant_id, function ($query, $enseignant_id) {
			return $query->where('enseignant_id', $enseignant_id);
		})->orderBy('nom', 'ASC')
		->orderBy('prenoms', 'ASC');
		return $found->get()->toJson();
	}	
	
		
	public function supprimer($id){
		$status = [];
		
		$la_sce = Seance::find($id);
		
		if ($la_sce == null)
			$status[] = status_sce__idnotfnd;
		
		//SI au moins l'une des erreurs plus haut sont retrouvées
		if (count($status) > 0) return $status;
	
		$la_sce->delete();
		
		return $status;
	}
	
	public function vw_liste(Request $request){		
		
		$annee_id = session('annee_id', 1);
		$universite_id = session('universite_id', 1);
		
		$allData = array();
		$allData['data'] = $this->liste_ens(new Request(
		[
		"annee_id"=>$annee_id,
		"universite_id"=>$universite_id,		
		]
		));
		$allData['ues'] = UE::get();
		return view('seance_all', $allData);
	}
	
	public function vw_new($ens_ue_id, Request $request){
		$annee_id = session('annee_id', 1);
		$universite_id = session('universite_id', 1);
		
		$l_ens_ue = EnseignantUE::with(['enseignant', 'ue'])->find($ens_ue_id);
		if ($l_ens_ue == null){
				
			session()->flash('status', [
				"succes" => [],
				"erreur" => ["Vous devez d'abord choisir l'enseignant et son UE!"]
			]);	
			return back();
		}
			
		$allData = array();
		$allData['data'] = new Seance();
		$allData['id'] = 0;
		$allData['ens_ue_id'] = $ens_ue_id;
		$allData['jours'] = DAYS_OF_WEEK;
		$allData['facultes'] = Faculte::with('filieres')->get();
		
		$allData['ens_ue'] = $l_ens_ue;
		$allData['affectations'] = [];
		return view('seance_edit', $allData);		
	}	
	
	public function vw_edit($id, Request $request){		
		$annee_id = session('annee_id', 1);
		$universite_id = session('universite_id', 1);
		
		$la_sce = Seance::with([
			'ue',
			'enseignant',
			'ues' => function($query){
				return $query->with(['faculte', 'filiere']);
			}
		])
		->with('enseignant')
		->find($id);
		
		if ($la_sce == null){				
			session()->flash('status', [
				"succes" => [],
				"erreur" => ["Séance de cours inconnue"]
			]);	
			return back();
		}
		
		$l_ens_ue = EnseignantUE::with(['enseignant', 'ue'])->find($la_sce->enseignant_ue_id);
		$allData = array();
		$allData['id'] = $id;
		$allData['jours'] = DAYS_OF_WEEK;
		
		$allData['ens_ue_id'] = $la_sce->enseignant_ue_id;
		$allData['facultes'] = Faculte::with('filieres')->get();		
		$allData['ens_ue'] = $l_ens_ue;
		if ($la_sce == null) {
			$la_sce = new Seance();
		}
		$allData['data'] = $la_sce;	
		$allData['affectations'] = $la_sce->ues;
		
		return view('seance_edit', $allData);		
	}
	
	public function vw_save(Request $request){
		$resultat = null;
		$id = $request->id;
		$ens_ue_id = $request->enseignant_ue_id;
		
		$resultat = $this->save($request);
		if (isset($id) && $id > 0) {} else $id = 0;

		$status = $this->statusToMessages($resultat["status"]);

		session()->flash('status', $status);
		if (count($resultat["status"]) == 0)
			return redirect()->route('seance.show');		
		else{			
			if ($id > 0)
				return redirect()->route('seance.edit', ["id" => $id]);	
			else
				return redirect()->route('seance.new', ["ens_ue_id" => $ens_ue_id]);
		}	
	}
	
	public function vw_delete($id){
		$resultat = $this->supprimer($id);
		$status = $this->statusToMessages($resultat);		
		session()->flash('status', $status);	
		
		return redirect()->route('seance.show');			
	}
	
	public function statusToMessages($status){		
		$messages = [];
		$suc = []; $err = [];
		
		foreach ($status as $s){			
			if ($s == status_sce__jourvide)
				$err[] = "Le jour de semaine n'est pas renseigné";
			if ($s == status_sce__hrdebvide)
				$err[] = "L'heure début de cours n'est pas renseignée";
			if ($s == status_sce__hrfinvide)
				$err[] = "L'heure fin de cours n'est pas renseignée";
			if ($s == status_sce__hrchrono)
				$err[] = "L'heure fin vient avant l'heure de début de cours";
			if ($s == status_sce__dtdebvide)
				$err[] = "La date de début des cours n'est pas renseignée";
			if ($s == status_sce__dtfinvide)
				$err[] = "La date de fin de cours n'est pas renseignée";
			if ($s == status_sce__dtchrono)
				$err[] = "La date de fin précède la date de début de cours";
			if ($s == status_sce__ensunkwn)
				$err[] = "L'enseignant choisi est inconnu";	
			if ($s == status_sce__ueunkwn)
				$err[] = "L'Unité d'Enseignement est inconnue";	
			if ($s == status_sce__idnotfnd)
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