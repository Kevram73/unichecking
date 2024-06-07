<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deplacement;
use App\Models\Annee;
use App\Models\Universite;
use App\Models\TypeDeplacement;
use App\Models\Enseignant;
use Exception;

class DeplacementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deplacements = Deplacement::all();
        return view("deplacements.index", compact('deplacements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $annees = Annee::all();
        $universites = Universite::all();
        $type_deplacements = TypeDeplacement::all();
        $enseignants = Enseignant::all();

        return view("deplacements.create", compact('annees', 'universites', 'type_deplacements', 'enseignants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DeplacementRequest $request)
    {
        try {
            $deplacement = new Deplacement();
            $deplacement->annee_id = $request->annee_id;
            $deplacement->universite_id = $request->universite_id;
            $deplacement->type_deplacement_id = $request->type_deplacement_id;
            $deplacement->enseignant_id = $request->enseignant_id;
            $deplacement->description = $request->description;
            $deplacement->date_debut = $request->date_debut;
            $deplacement->date_fin = $request->date_fin;
            $deplacement->nb_jours = $request->nb_jours;
            $deplacement->nb_jours_ouvres = $request->nb_jours_ouvres;
            $deplacement->details = $request->details;
            $deplacement->save();
            $msg = "Le deplacement a bien été enregistré";
        } catch(Exception $e){
            $msg = "Une erreur s'est produite";
        }


        return redirect()->route('deplacements.index')->with('msg', $msg);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $deplacement = Deplacement::find($id);
        return view('deplacements.show', compact('deplacement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $deplacement = Deplacement::find($id);
        return view('deplacements.edit', compact('deplacement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $deplacement = Deplacement::find($id);
            $deplacement->annee_id = $request->annee_id;
            $deplacement->universite_id = $request->universite_id;
            $deplacement->type_deplacement_id = $request->type_deplacement_id;
            $deplacement->enseignant_id = $request->enseignant_id;
            $deplacement->description = $request->description;
            $deplacement->date_debut = $request->date_debut;
            $deplacement->date_fin = $request->date_fin;
            $deplacement->nb_jours = $request->nb_jours;
            $deplacement->nb_jours_ouvres = $request->nb_jours_ouvres;
            $deplacement->details = $request->details;
            $deplacement->save();
            $msg = "Le déplacement a été bien enregistré";
        } catch(Exception $e){
            $msg = "Un problème est survenu lors de l'enregistrement";
        }

        return redirect()->route('deplacements.index', compact('msg'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $deplacement = Deplacement::find($id);
            $deplacement->destroy();

            $msg = "Le deplacement a bien été supprimé";
        } catch(Exception $e){
            $msg = "Une erreur est survenue lors de la suppression";
        }

        return redirect()->route('deplacements.index')->with('msg', $msg);
    }
}
