<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Annee extends Model
{
    use HasFactory;
	protected $table = 'Annee';
	
	protected $fillable = ['libelle', 'date_debut', 'date_fin', 'open', 'openable'];
}
