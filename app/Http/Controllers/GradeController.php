<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;
use Exception;

class GradeController extends Controller
{
    public function __construct(){
        $this->middleware("auth");
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grades = Grade::all();
        return view('grades.index', compact('grades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('grades.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'intitule' => 'required|string|max:255',
            'volume_horaire' => 'required|numeric'
        ]);

        try {
            $grade = new Grade($validated);
            $grade->save();
            return redirect()->route('grades.index')->with('success', 'Grade has been successfully created.');
        } catch (Exception $e) {
            return back()->withErrors('An error occurred while saving the grade.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Grade $grade)
    {
        return view('grades.show', compact('grade'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Grade $grade)
    {
        return view('grades.edit', compact('grade'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Grade $grade)
    {
        $validated = $request->validate([
            'intitule' => 'required|string|max:255',
            'volume_horaire' => 'required|numeric'
        ]);

        try {
            $grade->update($validated);
            return redirect()->route('grades.index')->with('success', 'Grade has been successfully updated.');
        } catch (Exception $e) {
            return back()->withErrors('An error occurred while updating the grade.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grade $grade)
    {
        try {
            $grade->delete();
            return redirect()->route('grades.index')->with('success', 'Grade has been successfully deleted.');
        } catch (Exception $e) {
            return back()->withErrors('An error occurred while deleting the grade.');
        }
    }
}
