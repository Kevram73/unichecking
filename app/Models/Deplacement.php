<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Deplacement extends Model
{
    use HasFactory;
	protected $table = 'Deplacement';

	protected $fillable = ['annee_id', 'universite_id', 'type_deplacement_id', 'enseignant_id',
	'description', 'date_debut', 'date_fin',
	'nb_jours', 'nb_jours_ouvres', 'details'];

    /**
     *
     */
    public function enseignant(): BelongsTo
    {
        return Enseignant::find($this->enseignant->id);
    }

    /**
     *
     */
    public function type()
    {
        return TypeDeplacement::find($this->type_deplacement_id);
    }

	public function annee() : BelongsTo
	{
		return $this->belongsTo(Annee::class)
					->withDefault(['id' => 0]);
	}


    public function universite(): BelongsTo
    {
        return $this->belongsTo(Universite::class);
    }
}
