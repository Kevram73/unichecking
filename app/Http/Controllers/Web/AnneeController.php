<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use App\Models\Annee;
use App\Models\Universite;

require 'constantes.php';

class AnneeController extends Controller
{
	public function save(Request $request){
		$an = $request->all();
		$l_an = null;
		$status = [];

		$blUpdate = isset($an["id"]) && $an["id"] > 0;
		$id = $blUpdate ? $an["id"] : 0;

		//id inconnu
		if (isset($an["id"]) && $an["id"] > 0){
			$l_an = $this->ctrlField_NotFound($an["id"], $status, status_an__idnotfnd,
				function($id, &$l_an){
					$l_an = Annee::find($id);
					return $l_an == null;
				});
			//annee close donc non modifiable
			if ($l_an && ($l_an->open == 0)){
				$status[] = status_an__closupd;
			}
		} else {
			//Création d'une nouvelle année
			//Il faut vérifier si une Année est déjà ouverte
			//si oui, empêcher la création
			$opened = Annee::where('open', 1)->first();
			if ($opened)
				$status[] = status_an__opennew;

		}
		//libelle non renseigné
		$estVide = $this->ctrlField_Empty($an["val"], $status, status_an__libellevide);

		if ($estVide == 0){
			$v = intval($an["val"]);
			$an["libelle"] = $v . sep_an . ($v + 1);
			//libelle doublon
			$exists = !Annee::where("libelle", $an["libelle"])
								->where("id", '<>', $id)
								->get()->isEmpty();
			if ($exists)
					$status[] = status_an__libelledbl;
		}


		//SI au moins l'une des erreurs plus haut sont retrouvées
		if (count($status) > 0)
			return ["status" =>$status, "get"=> $l_an];


		if (!$blUpdate){
			$l_an = new Annee();
			$l_an->openable = 1;
			$l_an->open = 1;
		}

		try {
			DB::beginTransaction();

			if (!$blUpdate){
				//Anciennes années closes mais toujours ouvrables
				$oldAnnees = Annee::where('openable', 1)
				->where('open', 0)->get();

				foreach ($oldAnnees as $old) {
					$old->openable = 0;
					$old->save();
				}
			}

			$l_an->libelle = $an["libelle"];
			$l_an->save();
			DB::commit();
			return ["status" =>$status, "get"=>$l_an];

		} catch (Throwable $e) {
			DB::rollback();
			return ["status" => [status_bderror], "get"=>$l_an];
		}

		return ["status" =>$status, "get"=>$l_an];
	}

	public function liste(Request $request){
		$found = Annee::where('id', '<>', 0)
		->when($request->id, function ($query, $id) {
			return $query->where('id', $id);
		})->when($request->libelle, function ($query, $libelle) {
			return $query->where('libelle', 'like', "%$libelle%");
		})->when($request->open, function ($query, $open) {
			return $query->where('open', $open);
		})->when($request->openable, function ($query, $openable) {
			return $query->where('openable', $openable);
		})->orderBy('libelle', 'DESC');
		return $found->get()->toJson();
	}


	public function supprimer($id){
		$status = [];

		$l_an = Annee::find($id);

		if ($l_an == null)
			$status[] = status_an__idnotfnd;

		//SI au moins l'une des erreurs plus haut sont retrouvées
		if (count($status) > 0) return $status;

		$l_an->delete();

		return $status;
	}


	


	public function choose(Request $request){
		$nfo = $request->all();
		$status = [];
		//annee_id inconnue
		$l_an = $this->ctrlField_NotFound($nfo["an_id"], $status, status_an__idnotfnd,
		function($id, &$l_an){
			$l_an = Annee::find($id);
			return $l_an == null;
		});
		//universite_id inconnu
		$l_unv = $this->ctrlField_NotFound($nfo["unv_id"], $status, status_an__unvunkwn,
		function($id, &$l_unv){
			$l_unv = Universite::find($id);
			return $l_unv == null;
		});

		if (count($status) > 0)
			return $status;

		Session::put([
					'annee' => $l_an,
					'universite' => $l_unv,
					'annee_id' => $l_an->id,
					'universite_id' => $l_unv->id]);

		return $status;
	}


	public function vw_liste(Request $request){
		$allData = array();
		$allData['data'] = $this->liste(new Request([]));
        $annees = Annee::all();
		return view('annees.indexl', compact('annees', 'allData'));
	}

	public function vw_on_off($id){
		$allData = array();
		$status = $this->on_off($id);
		$status_msg = $this->statusToMessages($status);
		session()->flash('status', $status_msg);
		return redirect()->route('annee.show');
	}

	public function vw_save(Request $request){
		$resultat = null;
		$id = $request->id;

		$resultat = $this->save($request);
		if (isset($id) && $id > 0) {} else $id = 0;

		$status = $this->statusToMessages($resultat["status"]);
		session()->flash('status', $status);

		return redirect()->route('annee.show');
	}

	public function vw_delete($id){
		$l_an = Annee::find($id);
		$resultat = $this->supprimer($id);
		$status = $this->statusToMessages($resultat);
		session()->flash('status', $status);

		return redirect()->route('annee.show');
	}

	public function vw_choose(Request $request){
		$resultat = $this->choose($request);
		$status = $this->statusToMessages($resultat);
		session()->flash('status', $status);

		return back();
	}

	public function statusToMessages($status){
		$messages = [];
		$suc = []; $err = [];

		foreach ($status as $s){
			if ($s == status_an__libellevide)
				$err[] = "l'Annee n'est pas renseignée";
			elseif ($s == status_an__libelledbl)
				$err[] = "L'année existe déjà";
			elseif ($s == status_an__closupd)
				$err[] = "L'année est clôturée";
			elseif ($s == status_an__opennew)
				$err[] = "Une année est déjà ouverte. Plus de nouvelle année possible";
			elseif ($s == status_an__idnotfnd)
				$err[] = "L'année n'a pas été retrouvée";
			elseif ($s == status_an__unvunkwn)
				$err[] = "L'université choisie est inconnue";
			elseif ($s == status_an__no_onoff)
				$err[] = "L'année ne peut plus changer d'état";
			elseif ($s == status_prob_bd)
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
