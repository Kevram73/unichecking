<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Faculte extends Model
{
    use HasFactory;
	protected $table = 'faculte';

	protected $fillable = ['code', 'libelle'];

	/**
     *
     */
    public function ues(): HasMany
    {
        return $this->hasMany(FaculteUE::class);
    }
	/**
     *
     */
    public function filieres(): HasMany
    {
        return $this->hasMany(Filiere::class);
    }
}
