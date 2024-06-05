<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class SeanceUE extends Model
{
    use HasFactory;
	protected $table = 'SeanceUE';
	
	protected $fillable = ['faculte_id', 'filiere_id', 'ue_id', 'seance_id', 'semestre'];
 
	/**
     * 
     */
    public function faculte(): BelongsTo
    {
        return $this->belongsTo(Faculte::class);
    }	 
	/**
     * 
     */
    public function filiere(): BelongsTo
    {
        return $this->belongsTo(Filiere::class, 'filiere_id');
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
    public function seance(): BelongsTo
    {
        return $this->belongsTo(Seance::class, 'seance_id');
    }	
}