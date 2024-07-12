<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    use HasFactory;
	protected $table = 'logs';

	protected $fillable = ['contenu', 'type'];
}
