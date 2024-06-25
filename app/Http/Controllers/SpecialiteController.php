<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Specialite;
use Exception;

class SpecialiteController extends Controller
{
    public function __construct(){
        $this->middleware("auth");
    }
    /**
     * Display a listing of specialties.
     */
    public function index()
    {
        $specialites = Specialite::all();
        return view('specialites.index', compact('specialites'));
    }

    /**
     * Store a newly created specialty in storage.
     */
    public function store(Request $request)
    {
        try {
            $specialite = new Specialite();
            $specialite->code = $request->code;
            $specialite->intitule = $request->intitule;
            $specialite->created_at = now();
            $specialite->save();
            $msg = "La spécialité a bien été enregistrée";
            $error = false;
        } catch (Exception $e) {
            $msg  = "Une erreur s'est produite";
            $error = true;
        }

        return redirect()->route('specialites.index')->with(['msg' => $msg, 'error' => $error]);
    }


    /**
     * Update the specified specialty in storage.
     */
    public function update(Request $request, int $id)
    {
        try {
            $specialite = Specialite::find($id);
            $specialite->code = $request->code;
            $specialite->intitule = $request->intitule;
            $specialite->created_at = now();
            $specialite->save();
            $msg = "La spécialité a bien été enregistrée";
            $error = false;
        } catch (Exception $e) {
            $msg  = "Une erreur s'est produite";
            $error = true;
        }

        return redirect()->route('specialites.index', compact('msg'));
    }

    /**
     * Remove the specified specialty from storage.
     */
    public function destroy(int $id)
    {
        try {
            $specialite = Specialite::find($id);
            $specialite->delete();

            $msg = "La spécialité a bien été supprimée";
        } catch (Exception $e) {
            $msg = "Une erreur est survenue lorsde la suppression";
        }

        return redirect()->route("specialites.index")->with('msg', $msg);
    }
}
