<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Enseignant;
use App\Models\EnseignantUE;

require 'constantes.php';


class EnseignantUEController extends Controller
{
	
	public function save(Request $request){
		$ens_ue = $request->all();
		$l_ens_ue = null;
		$status = [];
		
		$blUpdate = isset($ens_ue["id"]) && $ens_ue["id"] > 0;
		$id = $blUpdate ? $ens_ue["id"] : 0;
		
		//id inconnu
		if (isset($ens_ue["id"]) && $ens_ue["id"] > 0)
		$l_ens_ue = $this->ctrlField_NotFound($ens_ue["id"], $status, status_ens_ue__idnotfnd, 
			function($id, &$l_ens_ue){ 
				$l_ens_ue = EnseignantUE::find($id);
				return $l_ens_ue == null;
			});
			
		//date_affectation non renseignée
		$this->ctrlField_Empty($ens_ue["date_affectation"], $status, status_ens_ue__dtvide);
		
		//ue doublon
		if ($ens_ue["enseignant_id"] && $ens_ue["ue_id"]){
			$exists = !EnseignantUE::where("enseignant_id", $ens_ue["enseignant_id"])
								->where("ue_id", $ens_ue["ue_id"])
								->where("annee_id", session('annee_id'))
								->where("universite_id", session('universite_id'))
								->where("id", '<>', $id)
								->get()->isEmpty();	
			if ($exists) 
					$status[] = status_ens_ue__dbl;	
		}

		//enseignant_id inconnu
		$ens = null;
		$ens = $this->ctrlField_NotFound($ens["enseignant_id"], $status, status_ens_ue__ensunkwn, 
			function($id, &$ens){ 
				$ens = Enseignant::find($id);
				return $ens == null;
			});
		
		//SI au moins l'une des erreurs plus haut sont retrouvées
		if (count($status) > 0) 
			return ["status" =>$status, "get"=> $l_ens];
//dd($ens_ue);
		if (!$blUpdate)
			$l_ens_ue = new EnseignantUE();
		try {
			DB::beginTransaction();
			$l_ens_ue->fill($ens_ue);
			if ($blUpdate){} else {
				$l_ens_ue->annee_id = session('annee_id');
				$l_ens_ue->universite_id = session('universite_id');
			}
			$l_ens_ue->save();
			
			DB::commit();
			return ["status" =>$status, "get"=>$l_ens_ue];

		} catch (Throwable $e) {
			DB::rollback();
			return ["status" => [status_bderror], "get"=>$l_ens_ue];
		}	
			
		return ["status" =>$status, "get"=>$l_ens_ue];	
	}	

		
	public function supprimer($id){
		$status = [];
		
		$l_ens_ue = EnseignantUE::find($id);
		
		if ($l_ens_ue == null)
			$status[] = status_ens_ue__idnotfnd;
		
		//SI au moins l'une des erreurs plus haut sont retrouvées
		if (count($status) > 0) return $status;
	
		try {
			DB::beginTransaction();			
			
			$l_ens_ue->delete();	
			DB::commit();
			return $status;

		} catch (Throwable $e) {
			DB::rollback();
			return [status_bderror];
		}	
		
		return $status;
	}

	
	public function vw_save(Request $request){
		$resultat = null;
		$id = $request->id;
		
		$resultat = $this->save($request);
		if (isset($id) && $id > 0) {} else $id = 0;

		$status = $this->statusToMessages($resultat["status"]);

		session()->flash('status', $status);
		
		return redirect()->route('seance.show');
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
			if ($s == status_ens_ue__dtvide)
				$err[] = "La date d'affectation n'est pas renseignée";
			elseif ($s == status_ens_ue__dbl)
				$err[] = "Cette affectation d'UE est effectuée";
			elseif ($s == status_ens_ue__ensunkwn)
				$err[] = "Enseignant inconnu";	
			elseif ($s == status_ens_ue__ensunkwn)
				$err[] = "Unité d'Enseignement inconnue";	
			elseif ($s == status_ens_ue__idnotfnd)
				$err[] = "Information non retrouvée";	
			elseif ($s == status_ens_ue__idused)
				$err[] = "Cette affectation d'UE est liée à d'autres opérations";	
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
		return 0;
	}
}