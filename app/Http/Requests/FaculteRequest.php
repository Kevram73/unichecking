<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaculteRequest extends FormRequest
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
            'code' => 'required|max:255|unique:faculte,code',
            'libelle' => 'required|max:255|unique:faculte,libelle',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Le code est obligatoire',
            'libelle.required' => 'Le libelle est obligatoire',
            'libelle.unique' => 'Le libelle existe déjà',
            'code.unique' => 'Le code existe déjà',

        ];
    }
}
