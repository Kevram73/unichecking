<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AnneeRequest;
use App\Http\Resources\AnneeResource;
use App\Models\Annee;

class AnneeController extends Controller
{

    public function __construct(){
        $this->middleware("auth");
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $annees = Annee::all();
        return view('annees.index', compact('annees'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(AnneeRequest $request)
    {

        $isExistingYear = Annee::where('open', true)->get();
        if(count($isExistingYear) > 0){
            return back()->with('msg', 'Une année est déjà en cours, veuillez fermer avant de continuer');
        }
        $isOpenable = Annee::where('openable', true)->get();
        if(count($isOpenable) > 0){
            return back()->with('msg', 'Une année ouvrable existe déjà');
        }

        $annee = new Annee();
        $annee->date_debut = $request->date_debut;
        $annee->date_fin = $request->date_fin;
        $annee->libelle = "$request->date_debut" . " - " . "$request->date_fin";
        $annee->open = true;
        $annee->openable = true;
        $annee->save();

        return redirect()->route( 'annees.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $annee = Annee::find($id);
        return new AnneeResource($annee);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $annee = Annee::findOrFail($id);
        $annee->date_debut = $request->date_debut;
        $annee->date_fin = $request->date_fin;
        $annee->libelle = $request->date_debut + " - " + $request->date_fin;
        $annee->save();

        return redirect()->route('annees.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $annee = Annee::findOrFail($id);
        $annee->delete();
        return redirect()->route('annees.index');
    }

    public function on_off($id){
		$status = [];

		$l_an = Annee::find($id);

		if ($l_an == null)
			$status[] = status_an__idnotfnd;
		else {
			if (($l_an->open == 0) && ($l_an->openable == 0))
				$status[] = status_an__no_onoff;
		}

		//SI au moins l'une des erreurs plus haut sont retrouvées
		if (count($status) > 0) return $status;

		$l_an->open = 1 - $l_an->open;

		$l_an->save();

		return $status;
	}

    public function view_on_off($id){
        $allData = array();
		$status = $this->on_off($id);
		$status_msg = $this->statusToMessages($status);
		session()->flash('status', $status_msg);
		return redirect()->route('annee.show');
    }
}
