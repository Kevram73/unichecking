<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class UE extends Model
{
    use HasFactory;
	protected $table = 'UE';
	
	protected $fillable = ['universite_id', 'intitule', 'description', 'code', 'volume_horaire'];
}