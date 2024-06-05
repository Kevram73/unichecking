<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Logs;
use App\Models\IdentifiantBio;
use App\Models\ScanPresence;
use App\Models\Scanner;
use App\Models\EnseignantScanner;
use App\Models\Enseignant;
use App\Models\Seance;
use App\Models\Deplacement;

use App\Events\ProcessDataEvent;

require 'constantes.php';


class CallbackController extends Controller
{
	public function show(Request $request){
		$allData = array();
		$allData['data'] = Logs::get();
		return view('log_all', $allData);		
	}
	
	public function check_enseignant($id, Request $request){
		return (Enseignant::find($id)) ? 1 : 0;
	}
	
	
	public function register(Request $request){
		/*
		$json = file_get_contents('php://input');
		$nfo = json_decode($json, true);
		*/
		$nfo = $request->all();
		$l = new Logs();	
		$l->contenu = file_get_contents('php://input');	
		$l->type = "identity";		
		$l->save();
		$ens_id = $request->id;
		$ns = (isset($nfo["num_serie"])) ? $nfo["num_serie"] : "";
		if ($ns) {} else $ns = "";
		$le_scanner = Scanner::where('num_serie', $ns)->first();
		if ($le_scanner) {} else
			return 0;

		try {
			DB::beginTransaction();
			/**/
			$idb = IdentifiantBio::where('enseignant_id', $ens_id)
			->first();
			if ($idb){} else 
				$idb = new IdentifiantBio();
			$idb->nfc = (isset($nfo["nfc"])) ? $nfo["nfc"] : "";
			$idb->face = (isset($nfo["face"])) ? $nfo["face"] : "";
			$idb->finger = (isset($nfo["finger"])) ? $nfo["finger"] : "";
			$idb->enseignant_id = $ens_id;

			$idb->save();
			/**/
			$ens_sc = EnseignantScanner::where('enseignant_id',$ens_id)
			->where('num_serie', $ns)
			->first();
			if ($ens_sc){} else 
				$ens_sc = new EnseignantScanner();
				
			$ens_sc->enseignant_id = $ens_id;
			$ens_sc->num_serie = $ns;
			$ens_sc->sender = 1;
			$ens_sc->save();
			
			DB::commit();
		} catch(Throwable $e){
			DB::rollback();			
			return 0;
		}
		
		return 1;		
	}
	
	public function identity(Request $request){
		$l = new Logs();		
		$l->contenu = file_get_contents('php://input');		
		$l->type = "identity";		
		$l->save();
		$nfo = $request->all();
		$ns = (isset($nfo["num_serie"])) ? $nfo["num_serie"] : "";
		$le_scanner = Scanner::where('num_serie', $ns)->first();
		if ($le_scanner) {} else
			return 0;
			
		$universite_id = $le_scanner->universite_id;
		$ens_id = (isset($nfo["identifiant"])) ? $nfo["identifiant"] : "";
		
		$this->saveScan($universite_id, $ens_id, date_format(date_create(), 'Y-m-d H:i:s'));
		
		return 1;		
	}
	
	public function getback(Request $request){
		$ns = $request->num_serie;
		$query = "SELECT  I.enseignant_id as `id`, I.nfc, I.face, I.finger
				FROM IdentifiantBio I 
				WHERE enseignant_id not in (select enseignant_id
											from EnseignantScanner
											where num_serie = '$ns')";
		$rslt = DB::select($query);

		return json_encode($rslt, true);		
	}
	
	public function heartbeat(Request $request){
		$l = new Logs();
		
		$l->contenu = file_get_contents('php://input');
		$l->type = "heartbeat";
		
		$last = ScanPresence::get()->last();
		if ($last == null ){
		$s = new ScanPresence();
		$s->seance_id = 9;
		$s->type=1;
		$s->heure_scan = date_format(now(), 'Y-m-d H-i-s');
		$s->save();
	
		}
		return $l->save() ? json_encode(["result"=>1,"success"=>true], true) : "";		
	}
	
	
	public function testSaveScan(Request $rq){
		return $this->saveScan($rq->universite_id, $rq->enseignant_id, $rq->dthr);
	}
	
	function saveScan($universite_id, $ens_id, $dthr){
		$minutes = 5;
		$ens = Enseignant::find($ens_id);
		if ($ens == null)
			return new ScanPresence();
		$dthr_php = date_create_from_format('Y-m-d H:i:s', $dthr);
		
		$dt = date_format($dthr_php, 'Y-m-d');
		$hr = date_format($dthr_php, 'H:i:s');
		$hr_avt = date_format(date_sub(date_create_from_format('H:i:s', $hr), 
					date_interval_create_from_date_string("$minutes minutes")), 'H:i:s');
		$hr_apr = date_format(date_add(date_create_from_format('H:i:s', $hr), 
					date_interval_create_from_date_string("$minutes minutes")), 'H:i:s');
		
		$sce = null;
		
		$dpl = Deplacement::where('date_debut', '>=', $dt)
		->where('date_fin', '<=', $dt)
		->where('enseignant_id', $ens_id)
		->where('universite_id', $universite_id);
		
		if ($dpl->count() == 0){
			$sce = DB::table('Seance')->where("enseignant_id", "$ens_id")
			->where('universite_id', $universite_id)
			->where('date_debut', '<=', $dt)
			->where('date_fin', '>=', $dt)
			->where('heure_debut', '<=', $hr_apr)
			->where('heure_fin', '>=', $hr_avt)
			->where('jour_semaine', date_format($dthr_php, "N"))
			->whereNotIn('id', function($query) use($dt){
				return $query->select('seance_id')->from('ScanPresence')
				->where('date_scan', $dt)
				->whereNotNull('heure_scan_fin');
			})
			->first();	
		}
		
		$sp = ScanPresence::when($sce, function($query) use ($sce){
			return $query->where('seance_id', $sce->id);
		})->where('enseignant_id', $ens_id)
		->where('date_scan', $dt)
		->where('heure_scan_deb', '<', $dthr)
		->whereNull('heure_scan_fin')
		->orderBy('heure_scan_deb', 'DESC')
		->first();
		
		try {
			DB::beginTransaction();
			if ($sp){
				$old_seance_id = $sp->seance_id;
				$new_seance_id = ($sce) ? $sce->id : 0;
				if ($old_seance_id == 0){
					$sp->seance_id = $new_seance_id;				
				}
				$sp->heure_scan_fin = $dthr;
				$db = date_create($sp->heure_scan_deb);
				// $diff = date_diff($db, $dthr_php);
				// $nbHr = $diff->format("%H:%i");
				// $sp->nb_hr = $nbHr;
				$diff_in_seconds = $dthr_php->getTimestamp() - $db->getTimestamp();
				$h = floor($diff_in_seconds / 36) / 100;
				$sp->nb_hr = $h;
				
				
				if ($old_seance_id == 0)
					$sp->nb_hr_cpt = 0;
				else {
					if ($new_seance_id == 0){
						$sp->nb_hr_cpt = 0;
					} else {
						$db = date_create($sp->heure_scan_deb);
						$df = date_create_from_format("Y-m-d H:i:s", "{$dt} {$sce->heure_fin}");
						if ($df > $dthr_php)
							$df = $dthr_php;
						// $diff = date_diff($db, $df);
						// $nbHr = $diff->format("%H:%i");		
						// $sp->nb_hr_cpt = $nbHr;			
						$diff_in_seconds = $df->getTimestamp() - $db->getTimestamp();
						$h = floor($diff_in_seconds / 36) / 100;
						$sp->nb_hr_cpt = $h;
					}				
				}
			} else {
				$sp = new ScanPresence();
				$sp->seance_id = ($sce) ? $sce->id : 0;
				$sp->universite_id = $universite_id;
				$sp->enseignant_id = $ens_id;
				$sp->date_scan = $dt;
				$sp->heure_scan_deb = $dthr;
			}
			
			$sp->save();
			/**/
			
			
			
			
			/**/
			DB::commit();
		} catch (Throwable $e){
			DB::rollback();
			return 0;
		}
		
		return $sp;
	}
	
}