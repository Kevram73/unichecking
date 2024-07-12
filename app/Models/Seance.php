<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Seance extends Model
{
    use HasFactory;
	protected $table = 'seance';

	protected $fillable = ['annee_id', 'universite_id', 'enseignant_id', 'ue_id', 'enseignant_ue_id',
	'jour_semaine', 'heure_debut', 'heure_fin', 'date_debut', 'date_fin'];

	/**
     *
     */
    public function annee()
    {
        return Annee::find($this->annee_id);
    }

    public function univ(){
        return Universite::find($this->universite_id);
    }
	/**
     *
     */
    public function ues(): HasMany
    {
        return $this->hasMany(SeanceUE::class, 'seance_id');
    }
	/**
     *
     */
    public function ue(): BelongsTo
    {
        return $this->belongsTo(UE::class, 'ue_id');
    }
	/**
     *
     */
    public function enseignant()
    {
        return Enseignant::find($this->enseignant_id);
    }
	/**
     *
     */
    public function enseignant_ue(): BelongsTo
    {
        return $this->belongsTo(EnseignantUE::class);
    }
	/**
     *
     */
    public function universite(): BelongsTo
    {
        return $this->belongsTo(Universite::class);
    }

    public function debut_time()
    {
        return Carbon::parse($this->heure_debut)->format('H:m');
    }

    public function fin_time()
    {
        return Carbon::parse($this->heure_fin)->format('H:m');
    }

    public function jour() {
        switch ($this->jour_semaine) {
            case 1:
                return "Lundi";
            case 2:
                return "Mardi";
            case 3:
                return "Mercredi";
            case 4:
                return "Jeudi";
            case 5:
                return "Vendredi";
            case 6:
                return "Samedi";
            case 7:
                return "Dimanche";
            default:
                return "Jour invalide"; // You can handle invalid inputs if needed
        }
    }

}
