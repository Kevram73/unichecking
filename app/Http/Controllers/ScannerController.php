<?php

namespace App\Http\Controllers;

use App\Models\Scanner;
use App\Models\Universite;
use Illuminate\Http\Request;

class ScannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $scanners = Scanner::all();
        $universites = Universite::all();
        return view('scanners.index', compact('scanners', 'universites'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'num_serie' => 'required|unique:scanner',
            'universite_id' => 'required',
        ]);

        $scanner = new Scanner();
        $scanner->num_serie = $request->input('num_serie');
        $scanner->universite_id = $request->input('universite_id');
        $scanner->save();

        return redirect()->back()->with('msg', "Scanner ajouté avec succès");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'num_serie' => "required",
            'universite_id' => "required"
        ]);

        $scanner = Scanner::find($id);
        $scanner->num_serie = $request->input('num_serie');
        $scanner->universite_id = $request->input('universite_id');
        $scanner->save();

        return redirect()->back()->with('msg', "Scanner mis à jour avec succès");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $scanner = Scanner::find($id);
        $scanner->delete();

        return redirect()->back()->with('msg', "Scanner supprimé avec succès");
    }
}
