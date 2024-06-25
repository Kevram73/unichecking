<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faculte;
use Alert;
use App\Http\Requests\FaculteRequest;

class FaculteController extends Controller
{
    public function __construct(){
        $this->middleware("auth");
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $facultes = Faculte::all();
        return view("facultes.index", compact('facultes'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(FaculteRequest $request)
    {
        try {
            $faculte = new Faculte();
            $faculte->code = $request->code;
            $faculte->libelle = $request->libelle;
            $faculte->created_at = now();
            $faculte->updated_at = now();
            $faculte->save();
            $msg = "Le faculte a bien été enregistré";
            $error = false;
        } catch(Exception $e){
            $msg = "Une erreur s'est produite";
            $error = true;
        }


        return redirect()->route('facultes.index')->with(['msg' => $msg, 'error' => $error]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $faculte = Faculte::find($id);
            $faculte->code = $request->code;
            $faculte->libelle = $request->libelle;
            $faculte->updated_at = now();
            $faculte->save();
            $msg = "Le faculté a été bien enregistré";
            $error = false;
        } catch(Exception $e){
            $error = true;
            $msg = "Un problème est survenu lors de l'enregistrement";
        }

        return redirect()->route('facultes.index', compact('msg'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $faculte = Faculte::find($id);
            $faculte->delete();

            $msg = "La faculté a bien été supprimée";
        } catch(Exception $e){
            $msg = "Une erreur est survenue lors de la suppression";
        }

        return redirect()->route('facultes.index')->with('msg', $msg);
    }
}
