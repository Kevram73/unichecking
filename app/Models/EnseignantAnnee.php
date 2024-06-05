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
	'annee_id', 'enseignant_id', 'nb_hr_cpt'];
	
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
        return $this->belongsTo(Enseignant::class)
					->withDefault((new Enseignant())->toArray());
    }
}