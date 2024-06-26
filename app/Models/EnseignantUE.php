<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class EnseignantUE extends Model
{
    use HasFactory;
	protected $table = 'EnseignantUE';

	protected $fillable = [
	'annee_id', 'universite_id', 'enseignant_id', 'ue_id',
	'date_affectation', 'nb_hr_cpt'];

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
    public function ue()
    {
        return UE::find($this->ue_id);
    }
    /**
     *
     */
    public function faculte(): BelongsTo
    {
        return $this->belongsTo(Faculte::class, 'faculte_id');
    }
    /**
     *
     */
    public function filiere(): BelongsTo
    {
        return $this->belongsTo(Filiere::class, 'filiere_id')
					->withDefault(["id"=>0, "nom"=>""]);
    }
    /**
     *
     */
    public function enseignant(): BelongsTo
    {
        return Enseignant::find($this->enseignant_id);
    }

    public function universite(): BelongsTo
    {
        return $this->belongsTo(Universite::class);
    }

    public function seances(): HasMany
    {
        return $this->HasMany(Seance::class, 'enseignant_ue_id');
    }
}
