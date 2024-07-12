<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class CategoriePoste extends Model
{
    use HasFactory;
	protected $table = 'categorieposte';

	protected $fillable = ['libelle', 'exoneration_horaire'];

    /**
     *
     */
    public function postes(): HasMany
    {
        return $this->hasMany(Poste::class);
    }
}
