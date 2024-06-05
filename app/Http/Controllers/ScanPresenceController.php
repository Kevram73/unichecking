<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\TypePieceIdentite;
use App\Models\Enseignant;
use App\Models\Grade;
use App\Models\Poste;
use App\Models\Specialite;
use App\Models\User;
use App\Models\UE;
use App\Models\Faculte;
use App\Models\ScanPresence;

require 'constantes.php';


class ScanPresenceController extends Controller
{
	
	public function liste(Request $request){
		$annee_id = $request->annee_id;
		$universite_id = $request->universite_id;
		$found = DB::select(
		"SELECT Sp.id, Sp.enseignant_id, Sp.date_scan, 
		Sp.heure_scan_deb, Sp.heure_scan_fin, 
		Sp.nb_hr, Sp.nb_hr_cpt,
		S.`faculte`, S.`filiere`,
		S.`ue_name`,
		S.semestre,
		concat(E.nom, ' ', E.prenoms) as enseignant,
		S.heure_debut, S.heure_fin
		FROM ScanPresence Sp
		JOIN Enseignant E ON E.id = Sp.enseignant_id
		LEFT JOIN (
			SELECT S.id, Fa.code `faculte`, Fi.nom `filiere`,
				concat(UE.code, ' ', UE.intitule) `ue_name`,
				SUE.semestre,
				S.heure_debut, S.heure_fin
			from Seance S 
			JOIN SeanceUE SUE ON SUE.seance_id = S.id
			JOIN Faculte Fa ON SUE.faculte_id = Fa.id
			JOIN Filiere Fi ON SUE.filiere_id = Fi.id
			JOIN UE ON UE.id = SUE.ue_id
			WHERE ($annee_id = 0 OR S.annee_id = $annee_id)
			AND ($universite_id = 0 OR S.universite_id = $universite_id)
		) S
		ON S.id = Sp.seance_id"
		);
		return json_encode($found, true);
	}	
	
	public function vw_liste(Request $request){
		$allData = array();
		$allData['data'] = $this->liste(new Request([
		"annee_id" => session('annee_id'),
		"universite_id" => session('universite_id'),
		]
		));
		return view('rapport_scan', $allData);
	}
	
	public function vw_liste2(Request $request){
		$allData = array();
		$allData['data'] = $this->liste(new Request([
		"annee_id" => session('annee_id'),
		"universite_id" => session('universite_id'),
		]
		));
		return view('rapport_scan2', $allData);
	}
	
	public function supprimer($id){
		$status = [];
		
		$le_scan = ScanPresence::find($id);
		
		if ($le_scan == null)
			$status[] = 0;
		
		//SI au moins l'une des erreurs plus haut sont retrouvées
		if (count($status) > 0) return $status;
	
		try {
			DB::beginTransaction();			
			
			$le_scan->delete();	
			DB::commit();
			return $status;

		} catch (Throwable $e) {
			DB::rollback();
			return [status_bderror];
		}	
		
		return $status;
	}	
	
	public function vw_delete($id){
		$resultat = $this->supprimer($id);
		return redirect()->route('rapport.scan');			
	}
}