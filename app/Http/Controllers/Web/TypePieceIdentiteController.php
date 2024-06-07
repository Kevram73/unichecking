<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\TypePieceIdentite;

require 'constantes.php';

class TypePieceIdentiteController extends Controller
{
	public function save(Request $request){
		$tpi = $request->all();
		$le_tpi = null;
		$status = [];

		$blUpdate = isset($tpi["id"]) && $tpi["id"] > 0;
		$id = $blUpdate ? $tpi["id"] : 0;
		
		//id inconnu
		if (isset($tpi["id"]) && $tpi["id"] > 0)
		$le_tpi = $this->ctrlField_NotFound($tpi["id"], $status, status_tpi__idnotfnd, 
			function($id, &$le_tpi){ 
				$le_tpi = TypePieceIdentite::find($id);
				return $le_tpi == null;
			});				
						
		//libelle non renseigné
		$this->ctrlField_Empty($tpi["libelle"], $status, status_tpi__libellevide);
			
		//libelle doublon
		$exists = !TypePieceIdentite::where("libelle", $tpi["libelle"])
							->where("id", '<>', $id)
							->get()->isEmpty();	
		if ($exists) 
				$status[] = status_tpi__libelledbl;

		//SI au moins l'une des erreurs plus haut sont retrouvées
		if (count($status) > 0) 
			return ["status" =>$status, "get"=> $le_tpi];

		if (!$blUpdate)
			$le_tpi = new TypePieceIdentite();
		
		try {
			DB::beginTransaction();
		
			$le_tpi->fill($tpi);
			$le_tpi->save();
			
			DB::commit();
			return ["status" =>$status, "get"=>$le_tpi];

		} catch (Throwable $e) {
			DB::rollback();
			return ["status" => [status_bderror], "get"=>$le_tpi];
		}	
			
		return ["status" =>$status, "get"=>$le_tpi];	
	}	
	
	public function liste(Request $request){
		$found = TypePieceIdentite::where('id', '<>', 0)
		->when($request->id, function ($query, $id) {
			return $query->where('id', $id);
		})->when($request->libelle, function ($query, $libelle) {
			return $query->where('libelle', 'like', "%$libelle%");
		})->orderBy('libelle', 'ASC');
		return $found->get()->toJson();
	}	
	
		
	public function supprimer($id){
		$status = [];
		
		$le_tpi = TypePieceIdentite::find($id);
		
		if ($le_tpi == null)
			$status[] = status_tpi__idnotfnd;
		
		//SI au moins l'une des erreurs plus haut sont retrouvées
		if (count($status) > 0) return $status;
	
		$le_tpi->delete();
		
		return $status;
	}
	
	public function vw_liste(Request $request){				
		$allData = array();
		$allData['data'] = $this->liste(new Request([]));
		return view('type_piece_all', $allData);
	}
	
	
	public function vw_save(Request $request){
		$resultat = null;
		$id = $request->id;
		
		$resultat = $this->save($request);
		if (isset($id) && $id > 0) {} else $id = 0;

		$status = $this->statusToMessages($resultat["status"]);

		session()->flash('status', $status);

		return redirect()->route('type_piece.show');
	}

	
	public function vw_delete($id){
		$resultat = $this->supprimer($id);
		$status = $this->statusToMessages($resultat);		
		session()->flash('status', $status);
		return redirect()->route('type_piece.show');			
	}
	
	public function statusToMessages($status){		
		$messages = [];
		$suc = []; $err = [];
		foreach ($status as $s){			
			if ($s == status_tpi__libellevide)
				$err[] = "Le libelle du type non renseigné";
			if ($s == status_tpi__libelledbl) 
				$err[] = "Ce libelle du type est déjà enregistré";
			if ($s == status_tpi__idnotfnd)
				$err[] = "libelle de pièce inconnu";	
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