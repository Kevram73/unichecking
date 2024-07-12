<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class EnseignantAnUnv extends Model
{
    use HasFactory;
	protected $table = 'enseignantanuv';

	protected $fillable = ['annee_id', 'universite_id',
	'enseignant_id', 'nb_hr_cpteignant'];
    /**
     *
     */
    public function universite(): BelongsTo
    {
        return $this->belongsTo(Universite::class);
    }
	/**
     *
     */
    public function annee(): BelongsTo
    {
        return $this->belongsTo(Annee::class);
    }
	/**
     *
     */
    public function enseignant(): BelongsTo
    {
        return $this->belongsTo(Enseignant::class);
    }
}
