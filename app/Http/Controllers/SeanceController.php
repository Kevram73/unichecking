<?php

namespace App\Http\Controllers;

use App\Models\Seance;
use App\Models\Annee;
use App\Models\Universite;
use App\Models\Enseignant;
use App\Models\UE;
use App\Models\EnseignantUE;
use Illuminate\Http\Request;

class SeanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $seances = Seance::with(['annee', 'universite', 'enseignant', 'ue', 'enseignant_ue'])->get();
        return view('seances.index', compact('seances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $annees = Annee::all();
        $universites = Universite::all();
        $enseignants = Enseignant::all();
        $ues = UE::all();
        $enseignantUes = EnseignantUE::all();
        return view('seances.create', compact('annees', 'universites', 'enseignants', 'ues', 'enseignantUes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

        Seance::create($validated);
        return redirect()->route('seances.index')->with('success', 'Session successfully created.');
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
