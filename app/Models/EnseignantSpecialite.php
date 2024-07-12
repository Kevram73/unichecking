<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class EnseignantSpecialite extends Model
{
    use HasFactory;
	protected $table = 'enseignantspecialite';

	protected $fillable = ['enseignant_id', 'specialite_id', 'annee_id'];

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
    public function specialite(): BelongsTo
    {
        return $this->belongsTo(Specialite::class);
    }
    /**
     *
     */
    public function enseignant(): BelongsTo
    {
        return $this->belongsTo(Enseignant::class)
					->withDefault(new Enseignant());
    }


}
