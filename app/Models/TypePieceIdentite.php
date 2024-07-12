<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class TypePieceIdentite extends Model
{
    use HasFactory;
	protected $table = 'typepieceidentite';

	protected $fillable = ['libelle'];
}
