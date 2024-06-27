<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Scanner extends Model
{
    use HasFactory;
	protected $table = 'Scanner';
	
	protected $fillable = ['universite_id', 'num_serie'];
 
	/**
     * 
     */
    public function universite(): BelongsTo
    {
        return $this->belongsTo(Universite::class);
    }	 
}