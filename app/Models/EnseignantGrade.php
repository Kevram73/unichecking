<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class EnseignantGrade extends Model
{
    use HasFactory;
	protected $table = 'enseignantgrade';

	protected $fillable = ['grade_id', 'enseignant_id', 'poste_id', 'annee_id', 'vol_hor_tot'];

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
    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }
    /**
     *
     */
    public function poste(): BelongsTo
    {
        return $this->belongsTo(Poste::class)
					->withDefault(new Poste());
    }
    /**
     *
     */
    public function enseignant(): BelongsTo
    {
        return $this->belongsTo(Enseignant::class);
    }
}
