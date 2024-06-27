<?php

namespace App\Http\Controllers;

use App\Models\Faculte;
use App\Models\Filiere;
use App\Models\Seance;
use App\Models\SeanceUE;
use App\Models\Annee;
use App\Models\Universite;
use App\Models\Enseignant;
use App\Models\UE;
use Illuminate\Support\Facades\Session;
use App\Models\EnseignantUE;
use Illuminate\Http\Request;

class SeanceController extends Controller
{
    public function __construct(){
        $this->middleware("auth");
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $seances = Seance::where("universite_id", Session::get('uni_id'))->get();
        return view('seances.index', compact('seances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function choose_enseignant(Request $request)
    {
        $enseignants = Enseignant::all();

        return view('seances.choose_enseignant', compact('enseignants'));
    }

    public function choice(Request $request, $id){
        $enseignant = Enseignant::find($id);
        $facultes = Faculte::all();
        $ues = EnseignantUE::where('enseignant_id', $id)->get();
        return view('seances.create', compact('enseignant', 'facultes', 'ues'));
    }

    public function getFilieres($id)
    {
        $filieres = Filiere::where('faculte_id', $id)->pluck('nom', 'id');
        return json_encode($filieres);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $ids = explode(',', $request->ue[0]);
        $seance = new Seance();
        $seance->annee_id = Annee::where('open', 1)->get()->first()->id;
        $seance->universite_id = Session::get("uni_id");
        $seance->enseignant_id = $request->ens_id;
        $seance->enseignant_ue_id = $ids[0];  // Assign the first part as enseignant_ue_id
        $seance->ue_id = $ids[1];
        $seance->jour_semaine = $request->jour_semaine;
        $seance->heure_debut = $request->heure_debut;
        $seance->heure_fin = $request->heure_fin;
        $seance->date_debut = $request->date_debut;
        $seance->date_fin = $request->date_fin;

        $seance->save();

        $elts = json_decode($request->ens_sem, true);  // Decode JSON as an associative array
        foreach ($elts as $elt) {
            $seance_ue = new SeanceUE();
            $seance_ue->faculte_id = $elt['faculteId'];        // Use array access syntax
            $seance_ue->filiere_id = $elt['filiereId'];        // Use array access syntax
            $seance_ue->ue_id = $ids[1];                       // Assuming $ids is defined earlier correctly
            $seance_ue->seance_id = $seance->id;               // Assuming $seance->id is defined earlier
            $seance_ue->semestre = $elt['semester'];           // Use array access syntax
            $seance_ue->save();
        }


        return redirect()->route('seances.index')->with("Séance enregistrée avec succès");
    }

    /**
     * Display the specified resource.
     */
    public function show(Seance $seance)
    {
        return view('seances.show', compact('seance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Seance $seance)
    {
        $annees = Annee::all();
        $universites = Universite::all();
        $enseignants = Enseignant::all();
        $ues = UE::all();
        $enseignantUes = EnseignantUE::all();
        return view('seances.edit', compact('seance', 'annees', 'universites', 'enseignants', 'ues', 'enseignantUes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Seance $seance)
    {
        $validated = $request->validate([
            'annee_id' => 'required|exists:annees,id',
            'universite_id' => 'required|exists:universites,id',
            'enseignant_id' => 'required|exists:enseignants,id',
            'ue_id' => 'required|exists:ues,id',
            'enseignant_ue_id' => 'required|exists:enseignant_ues,id',
            'jour_semaine' => 'required|string',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut'
        ]);

        $seance->update($validated);
        return redirect()->route('seances.index')->with('success', 'Session updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Seance $seance)
    {
        $seance->delete();
        return redirect()->route('seances.index')->with('success', 'Session deleted successfully.');
    }
}
