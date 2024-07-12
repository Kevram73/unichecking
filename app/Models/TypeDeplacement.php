<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class TypeDeplacement extends Model
{
    use HasFactory;
	protected $table = 'typedeplacement';

	protected $fillable = ['designation'];

}
