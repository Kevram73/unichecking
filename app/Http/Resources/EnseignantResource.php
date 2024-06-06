<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnseignantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prenoms' => $this->prenoms,
            'email' => $this->email,
            'grade_id' => $this->grade_id,
            'poste_id' => $this->poste_id,
            'enseignant_grade_id' => $this->enseignant_grade_id,
            'type_piece_id' => $this->type_piece_id,
            'detail_poste' => $this->detail_poste,
            'user_id' => $this->user_id,
            'nb_hr_cum' => $this->nb_hr_cum,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
