<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class IdentifiantBio extends Model
{
    use HasFactory;
	protected $table = 'identifiantbio';

	protected $fillable = ['nfc', 'face', 'finger', 'enseignant_id'];

	/**
     *
     */
    public function enseignant(): BelongsTo
    {
        return $this->belongsTo(Enseignant::class);
    }
}
