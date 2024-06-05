<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Annee;
use App\Models\Universite;

require 'constantes.php';

class UserController extends Controller
{
	public function save(Request $request){
		$usr = $request->all();
		$l_usr = null;
		$status = [];

		$blUpdate = isset($usr["id"]) && $usr["id"] > 0;
		$id = $blUpdate ? $usr["id"] : 0;

		//id inconnu
		if (isset($usr["id"]) && $usr["id"] > 0)
		$l_usr = $this->ctrlField_NotFound($usr["id"], $status, status_usr__idnotfnd,
			function($id, &$l_usr){
				$l_usr = User::find($id);
				return $l_usr == null;
			});

		//nom non renseigné
		$this->ctrlField_Empty($usr["nom"], $status, status_usr__nomvide);

		//prenoms non renseigné
		$this->ctrlField_Empty($usr["prenoms"], $status, status_usr__prenvide);

		//email non renseigné
		$this->ctrlField_Empty($usr["email"], $status, status_usr__emailvide);

		//email doublon
		$exists = !User::where("email", $usr["email"])
							->where("id", '<>', $id)
							->get()->isEmpty();
		if ($exists)
				$status[] = status_usr__emaildbl;

		//SI au moins l'une des erreurs plus haut sont retrouvées
		if (count($status) > 0)
			return ["status" =>$status, "get"=> $l_usr];

		if (!$blUpdate)
			$l_usr = new User();

		try {
			DB::beginTransaction();

			$l_usr->fill($usr);
			$l_usr->save();

			DB::commit();
			return ["status" =>$status, "get"=>$l_usr];

		} catch (Throwable $e) {
			DB::rollback();
			return ["status" => [status_bderror], "get"=>$l_usr];
		}

		return ["status" =>$status, "get"=>$l_usr];
	}

	public function liste(Request $request){
		$found = User::where('id', '<>', 0)
		->when($request->id, function ($query, $id) {
			return $query->where('id', $id);
		})->when($request->nom, function ($query, $nom) {
			return $query->where('nom', 'like', "%$nom%");
		})->when($request->prenoms, function ($query, $prenoms) {
			return $query->where('prenoms', 'like', "%$prenoms%");
		})->when($request->email, function ($query, $email) {
			return $query->where('email', 'like', "%$email%");
		})->when($request->sans_enseignant, function ($query) {
			return $query->where('role_id', '<>', user_role__enseignant);
		})->orderBy('nom', 'ASC')
		->orderBy('prenoms', 'ASC');
		return $found->get()->toJson();
	}


	public function supprimer($id){
		$status = [];

		$l_usr = User::find($id);

		if ($l_usr == null)
			$status[] = status_usr__idnotfnd;

		//SI au moins l'une des erreurs plus haut sont retrouvées
		if (count($status) > 0) return $status;

		$l_usr->delete();

		return $status;
	}

	public function vw_liste(Request $request){
		$allData = array();
		$allData['data'] = $this->liste(new Request(["sans_enseignant" => 1]));
		return view('user_all', $allData);
	}


	public function vw_save(Request $request){
		$resultat = null;
		$id = $request->id;

		$resultat = $this->save($request);
		if (isset($id) && $id > 0) {} else $id = 0;

		$status = $this->statusToMessages($resultat["status"]);

		session()->flash('status', $status);

		return redirect()->route('user.show');
	}


	public function vw_delete($id){
		$resultat = $this->supprimer($id);
		$status = $this->statusToMessages($resultat);
		session()->flash('status', $status);
		return redirect()->route('user.show');
	}

	public function vw_pg_login(){
		return view('login.index');
	}

	public function vw_pg_password(){
		return view('user_password');
	}

	public function login(Request $request){
		$usr = $request->all();
		$l_usr = null;
		$status = [];

		//email non renseigné
		$this->ctrlField_Empty($usr["email"], $status, status_usr__emailvide);

		if (count($status) > 0)
			return ["status" =>$status, "get"=> new User()];

		$l_usr = User::where('email', $usr["email"])
		->where('password', $usr["password"])->first();

		if ($l_usr){} else {
			$status[] = status_usr__badlogin;
		}
		return ["status" =>$status, "get"=> $l_usr];
	}

	public function setpassword(Request $request){
		$nfo = $request->all();
		$l_usr = null;
		$status = [];

		$id = (isset($nfo["id"]) && $nfo["id"] > 0) ? $nfo["id"] : 0;

		//id inconnu
		$l_usr = $this->ctrlField_NotFound($nfo["id"], $status, status_usr__idnotfnd,
			function($id, &$l_usr){
				$l_usr = User::find($id);
				return $l_usr == null;
			});

		//old_password non définie
		if (!isset($nfo["old_password"])) $status[] = status_usr__oldpwdnotset;

		//new_password non renseigné
		$this->ctrlField_Empty($nfo["new_password"], $status, status_usr__nwpwdvide);

		if (!isset($nfo["conf_password"])) $nfo["conf_password"] = "";

		//new_password <> conf_password
		if ($nfo["conf_password"] != $nfo["new_password"]) $status[] = status_usr__badconfpwd;

		if ($l_usr){
			if ($l_usr->password <> $nfo["old_password"])
				$status[] = status_usr__badpwd;
		}


		if (count($status) > 0)
			return $status;

		$l_usr->password = $nfo["new_password"];
		$l_usr->save();

		return $status;
	}

	public function vw_login(Request $request){
		$resultat = null;

		$resultat = $this->login($request);
		$status = $this->statusToMessages($resultat["status"]);
		session()->flash('status', $status);

		if (count($resultat["status"]) > 0)
			return back();
		$l_usr = $resultat["get"];


		if ($l_usr){
			session(['user' => $l_usr]);
			$an = Annee::orderBy('libelle', 'DESC')->first();
			if ($an == null)
				return redirect()->route('annee.show');
			else {
				session(['annee_id' => $an->id,
				'annee' => $an,
				'universite_id' => 1,
				'universite' => Universite::find(1)]);
				return redirect()->route('enseignant.show');
			}
		}

		return redirect()->route('user.pg_login');
	}

	public function vw_logout(Request $request){
		session()->forget('user');
		return redirect()->route('user.pg_login');
	}

	public function vw_password(Request $request){
		$resultat = $this->setpassword($request);
		$status = $this->statusToMessages($resultat);
		session()->flash('status', $status);
		return back();
	}

	public function statusToMessages($status){
		$messages = [];
		$suc = []; $err = [];
		foreach ($status as $s){
			if ($s == status_usr__nomvide)
				$err[] = "Le nom de l'utilisateur n'est pas renseigné";
			if ($s == status_usr__prenvide)
				$err[] = "Les prénoms de l'utilisateur ne sont pas renseignés";
			if ($s == status_usr__emailvide)
				$err[] = "L'adresse e-mail de l'utilisateur n'est pas renseignée";
			if ($s == status_usr__emaildbl)
				$err[] = "L'adresse e-mail est déjà enregistrée";
			if ($s == status_usr__idnotfnd)
				$err[] = "Utilisateur inconnu";
			if ($s == status_usr__badlogin)
				$err[] = "Mauvais compte";
			if ($s == status_usr__oldpwdnotset)
				$err[] = "Le mot de passe à remplacer n'est pas envoyé";
			if ($s == status_usr__badpwd)
				$err[] = "Mauvais mot de passe";
			if ($s == status_usr__nwpwdvide)
				$err[] = "Le nouveau mot de passe n'est pas renseigné";
			if ($s == status_usr__badconfpwd)
				$err[] = "Le mot de passe de confirmation est différent du nouveau";
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
