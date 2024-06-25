<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UE;
use App\Models\Universite;
use Exception;

class UEController extends Controller
{
    public function __construct(){
        $this->middleware("auth");
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ues = UE::all();
        return view('ues.index', compact('ues'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $ue = new UE();
            $ue->universite_id = $request->universite_id;
            $ue->intitule = $request->intitule;
            $ue->description = $request->description;
            $ue->code = $request->code;
            $ue->volume_horaire = $request->volume_horaire;
            $ue->save();
            $msg = "L'enregistrement est bien passé";
        } catch(Exception $e){
            $msg = "Une erreur s'est produite lors de l'enregistrement";
        }

        return redirect()->route('ues.index')->with('msg', $msg);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $ue = UE::find($id);
            $ue->universite_id = $request->universite_id;
            $ue->intitule = $request->intitule;
            $ue->description = $request->description;
            $ue->code = $request->code;
            $ue->volume_horaire = $request->volume_horaire;
            $ue->save();
            $msg = "L'enregistrement est bien passé";
        } catch(Exception $e){
            $msg = "Une erreur s'est produite lors de l'enregistrement";
        }

        return redirect()->route('ues.index')->with('msg', $msg);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $ue = UE::find($id);
            $ue->delete();
            $msg = "La suppression a été bien effectuée";
        } catch(Exception $e){
            $msg = "Un problème est survenu lors de la suppression";
        }

        return redirect()->route('ues.index')->with('msg', $msg);
    }
}
