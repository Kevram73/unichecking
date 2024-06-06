<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnseignantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nom' => 'required|max:255',
            'prenoms' => 'required|max:255',
            'email' => 'required|email',
            'grade_id' => 'required|exists:grade,id',
            'poste_id' => 'required|exists:poste,id',
            'enseignant_grade_id' => 'required|exists:enseignantgrade,id',
            'type_piece_id' => 'required|exists:poste,id',
            'detail_poste' => 'required',
            'user_id' => 'required|exists:user,id',
            'nb_hr_cum' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nom.required' => 'Le nom est obligatoire',
            'prenoms.required' => 'Le prénom est obligatoire',
            'email.required' => 'L\'email est obligatoire',
            'grade_id.required' => 'Le grade est obligatoire',
            'poste_id.required' => 'Le poste est obligatoire',
            'enseignant_grade_id.required' => 'Le grade de l\'enseignant est obligatoire',
            'type_piece_id.required' => 'Le type de pièce est obligatoire',
            'detail_poste.required' => 'Le détail du poste est obligatoire',
            'user_id.required' => 'L\'utilisateur est obligatoire',
            'nb_hr_cum.required' => 'Le nombre d\'heures cumulées est obligatoire',
        ];
    }
}
