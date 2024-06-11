<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poste;
use App\Models\CategoriePoste;
use Exception;

class PosteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $postes = Poste::all();
        $categories = CategoriePoste::all();
        return view('postes.index', compact('postes', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = CategoriePoste::all();
        return view('postes.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255',
            'categorie_poste_id' => 'required|exists:categorie_postes,id'
        ]);

        try {
            $poste = new Poste($validated);
            $poste->save();
            return redirect()->route('postes.index')->with('success', 'Poste created successfully.');
        } catch (Exception $e) {
            return back()->withErrors('An error occurred while saving the poste.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Poste $poste)
    {
        return view('postes.show', compact('poste'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Poste $poste)
    {
        $categories = CategoriePoste::all();
        return view('postes.edit', compact('poste', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Poste $poste)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255',
            'categorie_poste_id' => 'required|exists:categorie_postes,id'
        ]);

        try {
            $poste->update($validated);
            return redirect()->route('postes.index')->with('success', 'Poste updated successfully.');
        } catch (Exception $e) {
            return back()->withErrors('An error occurred while updating the poste.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Poste $poste)
    {
        try {
            $poste->delete();
            return redirect()->route('postes.index')->with('success', 'Poste deleted successfully.');
        } catch (Exception $e) {
            return back()->withErrors('An error occurred while deleting the poste.');
        }
    }
}
