<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Poste extends Model
{
    use HasFactory;
	protected $table = 'Poste';

	protected $fillable = ['libelle', 'categorie_poste_id'];

	/**
     *
     */
    public function categorie()
    {
        $categorie = CategoriePoste::find($this->categorie_poste_id);
        if($categorie == null)
            return "";
        return $categorie->libelle;
    }
}
