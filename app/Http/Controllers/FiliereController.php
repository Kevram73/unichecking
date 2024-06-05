<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\UE;
use App\Models\Faculte;
use App\Models\Filiere;
use App\Models\FaculteUE;
use App\Models\Seance;

require 'constantes.php';


class FiliereController extends Controller
{
	
	public function save(Request $request){
		$fil = $request->all();
		$la_fil = null;

		$status = [];
		
		$blUpdate = isset($fil["id"]) && $fil["id"] > 0;
		$id = $blUpdate ? $fil["id"] : 0;
		
		//id inconnu
		if (isset($fil["id"]) && $fil["id"] > 0)
		$la_fil = $this->ctrlField_NotFound($fil["id"], $status, status_fil__idnotfnd, 
			function($id, &$la_fil){ 
				$la_fil = Filiere::find($id);
				return $la_fil == null;
			});
		
		//nom non renseigné
		$this->ctrlField_Empty($fil["nom"], $status, status_fil__nomvide);
		
		//nom doublon
		if (isset($fil["nom"]) && (!empty($fil["nom"]))){
			$exists = !Filiere::where("nom", $fil["nom"])
								->where("id", '<>', $id)
								->get()->isEmpty();	
			if ($exists) 
					$status[] = status_fil__nomdbl;	
		}
		
		//faculte_id inconnu
		$this->ctrlField_NotFound($fil["faculte_id"], $status, status_fil__facunkwn, 
			function($id){ 
				return Faculte::find($id) == null;
			});		
		
		//SI au moins l'une des erreurs plus haut sont retrouvées
		if (count($status) > 0) 
			return ["status" =>$status, "get"=> $la_fil];

		if (!$blUpdate)
			$la_fil = new Filiere();
		
		try {
			DB::beginTransaction();
			$la_fil->fill($fil);
			$la_fil->save();
			
			
			if (isset($fil["fac_ue_id"]))
			foreach($fil["fac_ue_id"] as $ndx=>$value_id){
				$fac_ue = null;
				$blDel = 0;
				$blUpd = 0;
				if ($value_id > 0){
					$blDel = isset($fil["fac_ue_del"]) && $fil["fac_ue_del"][$ndx] > 0;
					$blUpd = !$blDel;					
				}
				$blAdd = $value_id == 0;
				if ($blAdd){
					$fac_ue = new FaculteUE();
					$fac_ue->faculte_id = $la_fil->faculte_id;
					$fac_ue->filiere_id = $la_fil->id;
				} else{
					$fac_ue = FaculteUE::find($value_id);
					if ($fac_ue)
						if ($blDel){
							$fac_ue->delete();					
						} else {					
						}						
				}	
				if (!$blDel && $fac_ue){					
					$fac_ue->ue_id = $fil["ue_id"][$ndx];
					$fac_ue->semestre = $fil["semestre"][$ndx];
					$fac_ue->volume_horaire = $fil["volume_horaire"][$ndx];
					$fac_ue->save();
				}
			}			
			
			DB::commit();
			return ["status" =>$status, "get"=>$la_fil];

		} catch (Throwable $e) {
			DB::rollback();
			return ["status" => [status_bderror], "get"=>$la_fil];
		}	
			
		return ["status" =>$status, "get"=>$la_fil];	
	}	
	
	public function liste(Request $request){		
		$found = Filiere::where('id', '<>', 0)
		->when($request->with_faculte, function ($query){
			return $query->with('faculte');
		})->when($request->with_ues, function ($query){
			return $query->with('ues.ue');
		})->when($request->id, function ($query, $id) {
			return $query->where('id', $id);
		})->when($request->faculte_id, function ($query, $faculte_id) {
			return $query->where('faculte_id', $faculte_id);
		})->when($request->nom, function ($query, $nom) {
			return $query->where('nom', 'like', "%$nom%");
		})->orderBy('faculte_id', 'ASC')
		->orderBy('nom', 'ASC');
		return $found->get()->toJson();
	}	
		
	public function supprimer($id){
		$status = [];
		
		$la_fil = Filiere::find($id);
		
		if ($la_fil == null)
			$status[] = status_fil__idnotfnd;
		
		if ($this->alreadyUsed($id))
			$status[] = status_fil__idused;
		
		//SI au moins l'une des erreurs plus haut sont retrouvées
		if (count($status) > 0) return $status;
	
		try {
			DB::beginTransaction();
			
			FaculteUE::where('filiere_id', $la_fil->id)->delete();
			
			$la_fil->delete();	
			DB::commit();
			return $status;

		} catch (Throwable $e) {
			DB::rollback();
			return [status_bderror];
		}	
		
		return $status;
	}
	
	public function vw_liste($fac_id, Request $request){
		$allData = array();
		$allData['data'] = $this->liste(new Request(["with_ues"=>1, "faculte_id" => $fac_id]));
		$allData['fac_id'] = $fac_id;
		$allData['faculte'] = Faculte::find($fac_id);
		return view('filiere_all', $allData);
	}
	
	public function vw_new($fac_id, Request $request){
		$annee_id = session('annee_id', 1);
		
		$la_faculte = Faculte::find($fac_id);
		if ($la_faculte == null){				
			session()->flash('status', [
				"succes" => [],
				"erreur" => ["Vous devez d'abord choisir la faculté!"]
			]);	
			return back();
		}
		
		$allData = array();
		$allData['data'] = new Filiere();
		$allData['id'] = 0;
		$allData['ues'] = UE::get();
		$allData['faculte'] = $la_faculte;
		$allData['affectations'] = [];
		return view('filiere_edit', $allData);		
	}	
	
	public function vw_edit($id, Request $request){		
		$annee_id = session('annee_id', 1);
		
		$allData = array();
		$allData['id'] = $id;
		$allData['ues'] = UE::get();
		$la_fil = Filiere::with('ues')->find($id);
		
		if ($la_fil == null) {				
			session()->flash('status', [
				"succes" => [],
				"erreur" => ["Filière inconnue"]
			]);	
			return back();
		} 
			
		$la_faculte = Faculte::find($la_fil->faculte_id);
		$allData['faculte'] = $la_faculte;

		$allData['affectations'] = $la_fil->ues;
			
		$allData['data'] = $la_fil;		
		return view('filiere_edit', $allData);		
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
		else {			
			if ($id > 0)
				return redirect()->route('filiere.edit', ["id" => $id]);	
			else
				return redirect()->route('faculte.show');
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
			if ($s == status_fil__nomvide)
				$err[] = "Le nom n'est pas renseigné";
			if ($s == status_fil__nomdbl)
				$err[] = "Une autre filière possède déjà ce nom";
			elseif ($s == status_fil__facunkwn)
				$err[] = "La faculté est inconnue";	
			elseif ($s == status_fil__idnotfnd)
				$err[] = "Filière inconnue";	
			elseif ($s == status_fil__idused)
				$err[] = "Cette filière intervient déjà dans les séances de cours";	
			elseif ($s == status_prob_bd) 	
				$err[] = "Problème de base de données. Veuillez réessayer!";
			else $err[] = "L'erreur $s";
		}
		if (count($status) == 0)
			$suc[] = "Succès de l'opération!";
		
		$messages["succes"] = $suc;
		$messages["erreur"] = $err;
		
		return $messages;
	}	

	
	public function alreadyUsed($id){
		$bl = false;
		$s = Seance::whereHas('ues', function($query) use ($id){
			return $query->where('filiere_id', $id);
		})->first();
		$bl = $bl || ($s != null);
			
		return $bl;
	}
}