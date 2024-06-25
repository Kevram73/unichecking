<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filiere;
use App\Models\Faculte;
use Exception;

class FiliereController extends Controller
{
    public function __construct(){
        $this->middleware("auth");
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filieres = Filiere::all();
        return view('filieres.index', compact('filieres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $facultes = Faculte::all();
        return view('filieres.create', compact('facultes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'faculte_id' => 'required|exists:facultes,id',
        ]);

        try {
            $filiere = new Filiere($validated);
            $filiere->save();
            $msg = "La filière a bien été enregistrée";
        } catch (Exception $e) {
            $msg = "Une erreur s'est produite lors de l'enregistrement de la filière";
        }

        return redirect()->route('filieres.index')->with('msg', $msg);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $filiere = Filiere::findOrFail($id);
        return view('filieres.show', compact('filiere'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $filiere = Filiere::findOrFail($id);
        $facultes = Faculte::all();
        return view('filieres.edit', compact('filiere', 'facultes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'faculte_id' => 'required|exists:facultes,id',
        ]);

        try {
            $filiere = Filiere::findOrFail($id);
            $filiere->update($validated);
            $msg = "La filière a été mise à jour avec succès";
        } catch (Exception $e) {
            $msg = "Un problème est survenu lors de la mise à jour de la filière";
        }

        return redirect()->route('filieres.index')->with('msg', $msg);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $filiere = Filiere::findOrFail($id);
            $filiere->delete();
            $msg = "La filière a été supprimée avec succès";
        } catch (Exception $e) {
            $msg = "Une erreur est survenue lors de la suppression de la filière";
        }

        return redirect()->route('filieres.index')->with('msg', $msg);
    }
}
