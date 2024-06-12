<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypeDeplacement;
use Exception;

class TypeDeplacementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = TypeDeplacement::all();
        return view('type_deplacements.index', compact('types'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'designation' => 'required|string|max:255|unique:TypeDeplacement,designation',
        ]);

        try {
            $type = new TypeDeplacement($validated);
            $type->save();
            return redirect()->route('type_deplacements.index')->with('success', 'Type of displacement created successfully.');
        } catch (Exception $e) {
            return back()->withErrors('An error occurred while saving the type of displacement.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TypeDeplacement $type)
    {
        $validated = $request->validate([
            'designation' => 'required|string|max:255|unique:TypeDeplacement,designation,',
        ]);

        try {
            $type->update($validated);
            return redirect()->route('type_deplacements.index')->with('success', 'Type of displacement updated successfully.');
        } catch (Exception $e) {
            return back()->withErrors('An error occurred while updating the type of displacement.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeDeplacement $type)
    {
        try {
            $type->delete();
            return redirect()->route('type_deplacements.index')->with('success', 'Type of displacement deleted successfully.');
        } catch (Exception $e) {
            return back()->withErrors('An error occurred while deleting the type of displacement.');
        }
    }
}
