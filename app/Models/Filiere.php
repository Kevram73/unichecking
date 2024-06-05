<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    use HasFactory;
	protected $table = 'Filiere';
	
	protected $fillable = ['nom', 'faculte_id'];
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
    public function ues(): HasMany
    {
        return $this->hasMany(FaculteUE::class);
    }	 
}