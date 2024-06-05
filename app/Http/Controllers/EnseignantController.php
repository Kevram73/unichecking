<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Models\TypePieceIdentite;
use App\Models\Enseignant;
use App\Models\Grade;
use App\Models\Poste;
use App\Models\Specialite;
use App\Models\User;
use App\Models\UE;
use App\Models\Faculte;
use App\Models\EnseignantGrade;
use App\Models\EnseignantSpecialite;
use App\Models\EnseignantUE;

require 'constantes.php';


class EnseignantController extends Controller
{
	
	function upload($file){
		$imageName = time().'.'.$file->getClientOriginalExtension();
		$file->move(public_path('/img/ens'), $imageName);
		
		return $imageName;
	}
	
	public function save(Request $request){
		$ens = $request->all();
		$l_ens = null;
		$the_year_id = session('annee_id', 1);

		$status = [];
		
		$blUpdate = isset($ens["id"]) && $ens["id"] > 0;
		$id = $blUpdate ? $ens["id"] : 0;
		
		//id inconnu
		if (isset($ens["id"]) && $ens["id"] > 0)
		$l_ens = $this->ctrlField_NotFound($ens["id"], $status, status_ens__idnotfnd, 
			function($id, &$l_ens){ 
				$l_ens = Enseignant::find($id);
				return $l_ens == null;
			});
			
		//nom non renseigné
		$this->ctrlField_Empty($ens["nom"], $status, status_ens__nomvide);

		//prenoms non renseigné
		$this->ctrlField_Empty($ens["prenoms"], $status, status_ens__prenvide);
		
		//email doublon
		if ($ens["email"] && (!empty($ens["email"]))){
			$exists = !Enseignant::where("email", $ens["email"])
								->where("id", '<>', $id)
								->get()->isEmpty();	
			if ($exists) 
					$status[] = status_ens__emaildbl;	
		}

		//type_piece_id inconnu
		$this->ctrlField_NotFound($ens["piece_id"], $status, status_ens__tpiunkwn, 
			function($id){ 
				return TypePieceIdentite::find($id) == null;
			});		
		//grade_id inconnu
		$grd = $this->ctrlField_NotFound($ens["grade_id"], $status, status_ens__grdunkwn, 
			function($id, &$grd){ 
				$grd = Grade::find($id);
				return $grd == null;
			});		
		//poste_id inconnu
		$pst = null;
		if (isset($ens["poste_id"]) && $ens["poste_id"] > 0)
		$pst = $this->ctrlField_NotFound($ens["poste_id"], $status, status_ens__pstunkwn, 
			function($id, &$pst){ 
				$pst = Poste::with('categorie')->where('id', $id)->first();
				return $pst == null;
			});
		
		//SI au moins l'une des erreurs plus haut sont retrouvées
		if (count($status) > 0) 
			return ["status" =>$status, "get"=> $l_ens];

		if (!$blUpdate)
			$l_ens = new Enseignant();
		try {
			DB::beginTransaction();
			$the_file = $request->file("file-upload");
			if ($the_file)
				$l_ens->piece = $this->upload($the_file);
			$l_ens->fill($ens);
			$l_ens->save();
			
			$ens_grd = EnseignantGrade::find($ens["ens_grade_id"]);
			if ($ens_grd){
			} else {
				$ens_grd = new EnseignantGrade();
				$ens_grd->annee_id = $the_year_id;
				$ens_grd->enseignant_id = $l_ens->id;
			}
			$ens_grd->grade_id = $ens["grade_id"];
			$ens_grd->poste_id = $ens["poste_id"];
			$ens_grd->vol_hor_tot = $grd->volume_horaire - (($pst) ? $pst->categorie->exoneration_horaire : 0);
			$ens_grd->save();		
			if (isset($ens["ens_spec_id"]))
			foreach($ens["ens_spec_id"] as $ndx=>$value_id){
				$ens_spec = null;
				$blDel = 0;
				$blUpd = 0;
				if ($value_id > 0){
					$blDel = isset($ens["ens_spec_del"][$ndx]) && $ens["ens_spec_del"][$ndx] > 0;
					$blUpd = !$blDel;					
				}
				$blAdd = $value_id == 0;
				
				if ($blAdd){
					$ens_spec = new EnseignantSpecialite();
					$ens_spec->annee_id = $the_year_id;
					$ens_spec->enseignant_id = $l_ens->id;
				} else{
					$ens_spec = EnseignantSpecialite::find($value_id);
					if ($ens_spec)
						if ($blDel){
							$ens_spec->delete();					
						} else {				
						}					
				}	
				if (!$blDel && $ens_spec){
					$ens_spec->specialite_id = $ens["spec_id"][$ndx];
					$ens_spec->save();					
				}	
			}
			if (isset($ens["ens_ue_id"]))
			foreach($ens["ens_ue_id"] as $ndx=>$value_id){
				$ens_ue = null;
				$blDel = 0;
				$blUpd = 0;
				if ($value_id > 0){
					$blDel = isset($ens["ens_ue_del"]) && $ens["ens_ue_del"][$ndx] > 0;
					$blUpd = !$blDel;					
				}
				$blAdd = $value_id == 0;
				if ($blAdd){
					$ens_ue = new EnseignantUE();
					$ens_ue->annee_id = $the_year_id;
					$ens_ue->enseignant_id = $l_ens->id;
				} else{
					$ens_ue = EnseignantUE::find($value_id);
					if ($ens_ue)
						if ($blDel){
							$ens_ue->delete();					
						} else {					
						}						
				}	
				if (!$blDel && $ens_ue){					
					$ens_ue->ue_id = $ens["ue_id"][$ndx];
					$ens_ue->date_affectation = $ens["date_affectation"][$ndx];
					$ens_ue->save();
				}
			}

			
			$l_ens->enseignant_grade_id = $ens_grd->id;
			$l_ens->save();
			
			DB::commit();
			return ["status" =>$status, "get"=>$l_ens];

		} catch (Throwable $e) {
			DB::rollback();
			return ["status" => [status_bderror], "get"=>$l_ens];
		}	
			
		return ["status" =>$status, "get"=>$l_ens];	
	}	
	
	public function liste(Request $request){
		
		$found = Enseignant::with('grade')
		->with('poste')
		->with('type_piece')
		->with('identites_bio')
		->when($request->id, function ($query, $id) {
			return $query->where('id', $id);
		})->when($request->poste_id, function ($query, $poste_id) {
			return $query->where('poste_id', $poste_id);
		})->when($request->grade_id, function ($query, $grade_id) {
			return $query->where('grade_id', $grade_id);
		})->when($request->annee_id, function ($query, $annee_id) {
			return $query->whereHas('ues', function ($query) use ($annee_id){
				$query->with(['ue', 'faculte'])->where('annee_id', $annee_id);
			});
		})->when($request->nom, function ($query, $nom) {
			return $query->where('nom', 'like', "%$nom%");
		})->when($request->prenoms, function ($query, $prenoms) {
			return $query->where('prenoms', 'like', "%$prenoms%");
		})->when($request->email, function ($query, $email) {
			return $query->where('email', 'like', "%$email%");
		})->orderBy('nom', 'ASC')
		->orderBy('prenoms', 'ASC');
		return $found->get()->toJson();
	}	
	
	public function activer($id){
		$status = [];
		
		$l_ens = Enseignant::find($id);
		
		if ($l_ens == null)
			$status[] = status_ens__idnotfnd;		

		//SI au moins l'une des erreurs plus haut sont retrouvées
		if (count($status) > 0) return $status;
		
		$l_ens->active = !($l_ens->active);
		$l_ens->save();
		
		return $status;
	}
		
	public function supprimer($id){
		$status = [];
		
		$l_ens = Enseignant::find($id);
		
		if ($l_ens == null)
			$status[] = status_ens__idnotfnd;
		
		//SI au moins l'une des erreurs plus haut sont retrouvées
		if (count($status) > 0) return $status;
	
		try {
			DB::beginTransaction();
			User::where('id', $l_ens->user_id)->delete();
			
			EnseignantGrade::where('enseignant_id', $l_ens->id)->delete();
			EnseignantSpecialite::where('enseignant_id', $l_ens->id)->delete();
			
			
			$l_ens->delete();	
			DB::commit();
			return $status;

		} catch (Throwable $e) {
			DB::rollback();
			return [status_bderror];
		}	
		
		return $status;
	}
	
	public function vw_liste(Request $request){
		$allData = array();
		$allData['data'] = $this->liste(new Request([]));
		return view('enseignant_all', $allData);
	}
	
	public function vw_new(Request $request){
		$annee_id = session('annee_id', 1);
		$allData = array();
		$allData['data'] = new Enseignant();
		$allData['id'] = 0;
		$allData['ens_grade_id'] = 0;
		$allData['types'] = TypePieceIdentite::get();
		$allData['postes'] = Poste::get();
		$allData['grades'] = Grade::get();
		$allData['specs'] = Specialite::get();
		$allData['ues'] = UE::get();
		$allData['specialites'] = [];
		$allData['affectations'] = [];
		$allData['user'] = new User();
		$allData['piece'] = "";
		return view('enseignant_edit', $allData);		
	}	
	
	public function vw_edit($id, Request $request){		
		$annee_id = session('annee_id', 1);
		
		$allData = array();
		$allData['id'] = $id;
		$ens_grade = EnseignantGrade::where('enseignant_id', $id)
		->where('annee_id', $annee_id)->first();
		$allData['ens_grade_id'] = ($ens_grade)? $ens_grade->id : 0;
		$allData['types'] = TypePieceIdentite::get();
		$allData['postes'] = Poste::get();
		$allData['grades'] = Grade::get();
		$allData['specs'] = Specialite::get();
		$allData['ues'] = UE::get();
		$l_ens = Enseignant::find($id);

		if ($l_ens == null) {
			$l_ens = new Enseignant();
			$allData['specialites'] = [];
			$allData['affectations'] = [];
			$allData['piece'] = "";
		}else {
			$l_ens = Enseignant::with(['specialites.specialite',
			'identites_bio',
			'ues' => function ($query)  use ($annee_id){
			return $query->with(['ue'])->where('annee_id', $annee_id);
			},
			'user',
			])->find($id);

			$allData['specialites'] = $l_ens->specialites;
			$allData['affectations'] = $l_ens->ues;
			$allData['piece'] = asset('/img/ens/' . $l_ens->piece);
		}
		$allData['data'] = $l_ens;		
		return view('enseignant_edit', $allData);		
	}
	
	public function vw_save(Request $request){
		$resultat = null;
		$id = $request->id;
		
		$resultat = $this->save($request);
		if (isset($id) && $id > 0) {} else $id = 0;

		$status = $this->statusToMessages($resultat["status"]);

		session()->flash('status', $status);
		if (count($resultat["status"]) == 0)
			return redirect()->route('enseignant.show');		
		else{			
			if ($id > 0)
				return redirect()->route('enseignant.edit', ["id" => $id]);	
			else
				return redirect()->route('enseignant.new');
		}	
	}
	
	public function vw_activate($id){
		$resultat = $this->activer($id);
		//$resultat = json_decode($resultat, true);
		$status = $this->statusToMessages($resultat);	
		session()->flash('status', $status);	
		return redirect()->route('enseignant.show');			
	}
	
	public function vw_delete($id){
		$resultat = $this->supprimer($id);
		$status = $this->statusToMessages($resultat);		
		session()->flash('status', $status);
		return redirect()->route('enseignant.show');			
	}
	
	public function statusToMessages($status){		
		$messages = [];
		$suc = []; $err = [];
		foreach ($status as $s){			
			if ($s == status_ens__nomvide)
				$err[] = "Le nom n'est pas renseigné";
			elseif ($s == status_ens__prenvide)
				$err[] = "Les prénoms ne sont pas renseignés";
			elseif ($s == status_ens__emailvide)
				$err[] = "L'adresse email n'est pas renseignée";
			elseif ($s == status_ens__emaildbl)
				$err[] = "L'adresse email est déjà utilisé par un autre enseignant";
			elseif ($s == status_ens__pstunkwn)
				$err[] = "Le poste choisi est inconnu";	
			elseif ($s == status_ens__grdunkwn)
				$err[] = "Fonction inconnue";	
			elseif ($s == status_ens__tpiunkwn)
				$err[] = "Type de pièce d'identité inconnu";	
			elseif ($s == status_ens__idnotfnd)
				$err[] = "Enseignant inconnu";	
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