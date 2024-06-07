<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Specialite;
use Exception;

class SpecialiteController extends Controller
{
    /**
     * Display a listing of specialties.
     */
    public function index()
    {
        $specialites = Specialite::all();
        return view('specialites.index', compact('specialites'));
    }

    /**
     * Show the form for creating a new specialty.
     */
    public function create()
    {
        return view('specialites.create');
    }

    /**
     * Store a newly created specialty in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:specialites,code',
            'intitule' => 'required|string|max:255'
        ]);

        try {
            $specialite = new Specialite($validated);
            $specialite->save();
            return redirect()->route('specialites.index')->with('success', 'Specialty created successfully.');
        } catch (Exception $e) {
            return back()->withErrors('An error occurred while saving the specialty.');
        }
    }

    /**
     * Display the specified specialty.
     */
    public function show(Specialite $specialite)
    {
        return view('specialites.show', compact('specialite'));
    }

    /**
     * Show the form for editing the specified specialty.
     */
    public function edit(Specialite $specialite)
    {
        return view('specialites.edit', compact('specialite'));
    }

    /**
     * Update the specified specialty in storage.
     */
    public function update(Request $request, Specialite $specialite)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:specialites,code,' . $specialite->id,
            'intitule' => 'required|string|max:255'
        ]);

        try {
            $specialite->update($validated);
            return redirect()->route('specialites.index')->with('success', 'Specialty updated successfully.');
        } catch (Exception $e) {
            return back()->withErrors('An error occurred while updating the specialty.');
        }
    }

    /**
     * Remove the specified specialty from storage.
     */
    public function destroy(Specialite $specialite)
    {
        try {
            $specialite->delete();
            return redirect()->route('specialites.index')->with('success', 'Specialty deleted successfully.');
        } catch (Exception $e) {
            return back()->withErrors('An error occurred while deleting the specialty.');
        }
    }
}
