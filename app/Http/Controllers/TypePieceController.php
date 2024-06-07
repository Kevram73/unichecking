<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypePieceIdentite;
use Exception;

class TypePieceIdentiteController extends Controller
{
    /**
     * Display a listing of identity document types.
     */
    public function index()
    {
        $types = TypePieceIdentite::all();
        return view('type_piece_identites.index', compact('types'));
    }

    /**
     * Show the form for creating a new identity document type.
     */
    public function create()
    {
        return view('type_piece_identites.create');
    }

    /**
     * Store a newly created identity document type in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255|unique:type_piece_identites,libelle',
        ]);

        try {
            $type = new TypePieceIdentite($validated);
            $type->save();
            return redirect()->route('type_piece_identites.index')->with('success', 'Type of identity document created successfully.');
        } catch (Exception $e) {
            return back()->withErrors('An error occurred while saving the type of identity document.');
        }
    }

    /**
     * Display the specified identity document type.
     */
    public function show(TypePieceIdentite $typePieceIdentite)
    {
        return view('type_piece_identites.show', compact('typePieceIdentite'));
    }

    /**
     * Show the form for editing the specified identity document type.
     */
    public function edit(TypePieceIdentite $typePieceIdentite)
    {
        return view('type_piece_identites.edit', compact('typePieceIdentite'));
    }

    /**
     * Update the specified identity document type in storage.
     */
    public function update(Request $request, TypePieceIdentite $typePieceIdentite)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255|unique:type_piece_identites,libelle,' . $typePieceIdentite->id,
        ]);

        try {
            $typePieceIdentite->update($validated);
            return redirect()->route('type_piece_identites.index')->with('success', 'Type of identity document updated successfully.');
        } catch (Exception $e) {
            return back()->withErrors('An error occurred while updating the type of identity document.');
        }
    }

    /**
     * Remove the specified identity document type from storage.
     */
    public function destroy(TypePieceIdentite $typePieceIdentite)
    {
        try {
            $typePieceIdentite->delete();
            return redirect()->route('type_piece_identites.index')->with('success', 'Type of identity document deleted successfully.');
        } catch (Exception $e) {
            return back()->withErrors('An error occurred while deleting the type of identity document.');
        }
    }
}
