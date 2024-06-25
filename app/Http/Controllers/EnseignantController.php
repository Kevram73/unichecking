<?php

namespace App\Http\Controllers;

use App\Models\Faculte;
use App\Models\Specialite;
use App\Models\TypePieceIdentite;
use Illuminate\Http\Request;

use App\Models\Enseignant;
use App\Models\Grade;
use App\Models\Poste;
use App\Models\User;
use App\Models\EnseignantGrade;
use Exception;

class EnseignantController extends Controller
{

    public function __construct(){
        $this->middleware("auth");
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $enseignants = Enseignant::all();

        return view('enseignants.index', compact('enseignants'));
    }


    public function create(){
        $grades = Grade::all();
        $enseignant_grades = EnseignantGrade::all();
        $postes = Poste::all();
        $type_pieces = TypePieceIdentite::all();
        $specialites = Specialite::all();
        $facultes = Faculte::all();
        $users = User::all();

        return view("enseignants.create", compact('facultes','grades', 'enseignant_grades', 'postes', 'type_pieces', 'users', 'specialites'));

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
        $enseignant->grade_id = $request->grade;
        $enseignant->poste_id = $request->poste;
        $enseignant->type_piece_id = $request->type_piece;
        $enseignant->detail_poste = $request->details_poste;
        $enseignant->save();

        $enseignant_grade = new EnseignantGrade();
        $enseignant_grade->grade_id = $request->grade_id;
        $enseignant_grade->enseignant_id = $enseignant->id;
        $enseignant_grade->poste_id = $request->poste_id;
        $enseignant_grade->annee_id = 6;
        $enseignant_grade->vol_hor_tot = 0;
        $enseignant_grade->save();



        return redirect()->route('enseignants.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $enseignant = Enseignant::find($id);
        return view("enseignants.index", compact('enseignant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $grades = Grade::all();
        $enseignant_grades = EnseignantGrade::all();
        $postes = Poste::all();
        $type_pieces = TypePiece::all();
        $users = User::all();
        $enseignant = Enseignant::find($id);
        return view("enseignants.edit", compact('enseignant', 'grades', 'enseignant_grades', 'postes', 'users', 'type_pieces'));
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
