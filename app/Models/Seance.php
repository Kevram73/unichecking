<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    use HasFactory;
	protected $table = 'Seance';
	
	protected $fillable = ['annee_id', 'universite_id', 'enseignant_id', 'ue_id', 'enseignant_ue_id', 
	'jour_semaine', 'heure_debut', 'heure_fin', 'date_debut', 'date_fin'];
 
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
    public function enseignant(): BelongsTo
    {
        return $this->belongsTo(Enseignant::class);
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
}