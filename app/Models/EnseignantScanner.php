<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class EnseignantScanner extends Model
{
    use HasFactory;
	protected $table = 'EnseignantScanner';
	
	protected $fillable = ['enseignant_id', 'num_serie', 'sender'];
	/**
     * 
     */
    public function scanner(): BelongsTo
    {
        return $this->belongsTo(Scanner::class, 'num_serie', 'num_serie');
    }
	
}