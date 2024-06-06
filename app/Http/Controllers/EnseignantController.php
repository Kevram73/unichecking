<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\TypePieceIdentite;
use App\Models\Enseignant;
use App\Models\Grade;
use App\Models\Poste;
use App\Models\Specialite;
use App\Models\User;
use App\Models\UE;
use App\Models\Faculte;
use App\Models\EnseignantGrade;
use App\Models\EnseignantSpecialite;
use App\Models\EnseignantUE;
use Exception;

class EnseignantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $enseignants = Enseignant::with('grade')
		->with('poste')
		->with('type_piece')
		->with('identites_bio')
		->when($request->id, function ($query, $id) {
			return $query->where('id', $id);
		})->when($request->poste_id, function ($query, $poste_id) {
			return $query->where('poste_id', $poste_id);
		})->when($request->grade_id, function ($query, $grade_id) {
			return $query->where('grade_id', $grade_id);
		})->when($request->annee_id, function ($query, $annee_id) {
			return $query->whereHas('ues', function ($query) use ($annee_id){
				$query->with(['ue', 'faculte'])->where('annee_id', $annee_id);
			});
		})->when($request->nom, function ($query, $nom) {
			return $query->where('nom', 'like', "%$nom%");
		})->when($request->prenoms, function ($query, $prenoms) {
			return $query->where('prenoms', 'like', "%$prenoms%");
		})->when($request->email, function ($query, $email) {
			return $query->where('email', 'like', "%$email%");
		})->orderBy('nom', 'ASC')
		->orderBy('prenoms', 'ASC');

        return view('enseignants.index', compact('enseignants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $enseignant = new Enseignant();
        $enseignant->nom = $request->nom;
        $enseignant->prenoms = $request->prenoms;
        $enseignant->email = $request->email;
        $enseignant->grade_id = $request->grade_id;
        $enseignant->poste_id = $request->poste_id;
        $enseignant->enseignant_grade_id = $request->enseignant_grade_id;
        $enseignant->type_piece_id = $request->type_piece_id;
        $enseignant->detail_poste = $request->detail_poste;
        $enseignant->user_id = $request->user_id;
        $enseignant->nb_hr_cum = $request->nb_hr_cum;
        $enseignant->save();

        return redirect()->route('enseignants');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $enseignant = Enseignant::find($id);
        return new EnseignantResource($enseignant);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $enseignant = Enseignant::find($id);
        return view("enseignants.edit", compact('enseignant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $enseignant = Enseignant::find($id);
            $enseignant->nom = $request->nom;
            $enseignant->prenoms = $request->prenoms;
            $enseignant->email = $request->email;
            $enseignant->grade_id = $request->grade_id;
            $enseignant->poste_id = $request->poste_id;
            $enseignant->enseignant_grade_id = $request->enseignant_grade_id;
            $enseignant->type_piece_id = $request->type_piece_id;
            $enseignant->detail_poste = $request->detail_poste;
            $enseignant->user_id = $request->user_id;
            $enseignant->nb_hr_cum = $request->nb_hr_cum;
            $enseignant->save();

            $msg = "Les données de l'enseignant sont bien mises à jour.";
        } catch(Exception $e)
        {
            $msg = "Une erreur est survenue lors de la mise à jour des données de l'enseignant.";
        }

        return view('enseignants.edit', compact('msg'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $enseignant = Enseignant::find($id);
            $enseignant->delete();
            $msg = "L'enseignant a été bien supprimé";
        } catch(Exception $e){
            $msg = "Une erreur est survenue lors de la suppression de l'enseignant.";
        }

        return redirect()->route('enseignants', compact('msg'));
    }
}
