<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class DateSeance extends Model
{
    use HasFactory;
	protected $table = 'dateseance';

	protected $fillable = ['seance_id', 'date_seance'];

    /**
     *
     */
    public function seance(): BelongsTo
    {
        return $this->belongsTo(Poste::class);
    }
}
