<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Universite;

class UniversiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $universites = Universite::all();
        return view('universites.index', compact('universites'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $universite = new Universite();
            $universite->nom = $request->nom;
            $universite->save();
            $msg = "L'enregistrement est bien passé";
        } catch(Exception $e){
            $msg = "Une erreur s'est produite lors de l'enregistrement";
        }

        return redirect()->route('universites.index')->with('msg', $msg);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $universite = Universite::find($id);
            $universite->nom = $request->nom;
            $universite->save();
            $msg = "L'enregistrement est bien passé";
        } catch(Exception $e){
            $msg = "Une erreur s'est produite lors de l'enregistrement";
        }

        return redirect()->route('universites.index')->with('msg', $msg);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $universite = Universite::find($id);
            $universite->delete();
            $msg = "La suppression a été bien effectuée";
        } catch(Exception $e){
            $msg = "Un problème est survenu lors de la suppression";
        }

        return redirect()->route('universites.index')->with('msg', $msg);
    }
}
