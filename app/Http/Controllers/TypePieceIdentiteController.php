<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypePieceIdentite;
use Exception;

class TypePieceIdentiteController extends Controller
{
    /**
     * Display a listing of identity document types.
     */
    public function index()
    {
        $type_pieces = TypePieceIdentite::all();
        return view('type_pieces.index', compact('type_pieces'));
    }

    /**
     * Store a newly created identity document type in storage.
     */
    public function store(Request $request)
    {

        try {
            $type = new TypePieceIdentite();
            $type->libelle = $request->libelle;
            $type->save();
            $msg = "Le type de pièce a été bien enregistré";
        } catch(Exception $e){
            $msg = "Un problème est survenu lors de l'enregistrement";
        }

        return redirect()->route('type_pieces.index', compact('msg'));
    }

    /**
     * Update the specified identity document type in storage.
     */
    public function update(Request $request, int $id)
    {
        try{
            $type_piece = TypePieceIdentite::find($id);
            $type_piece->libelle = $request->libelle;
            $type_piece->updated_at = now();
            $type_piece->save();
            $msg = "Le type de pièce a été bien enregistré";
        } catch(Exception $e){
            $msg = "Un problème est survenu lors de l'enregistrement";
        }

        return redirect()->route('type_pieces.index', compact('msg'));

    }

    /**
     * Remove the specified identity document type from storage.
     */
    public function destroy(int $id)
    {
        try {
            $type_piece = TypePieceIdentite::find($id);
            $type_piece->delete();
            $msg = "Le type de pièce a bien été supprimé";
        } catch (Exception $e) {
            $msg = "Une erreur est survenue lors de la suppression";
        }

        return redirect()->route('type_pieces.index')->with('msg', $msg);
    }
}
