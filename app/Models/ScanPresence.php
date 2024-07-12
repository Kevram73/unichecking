<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class ScanPresence extends Model
{
    use HasFactory;
	protected $table = 'scanpresence';

	protected $fillable = ['seance_id', 'scanner_id', 'universite_id', 'enseignant_id', 'date_scan', 'heure_scan_deb', 'heure_scan_fin', 'type'];

	/**
     *
     */
    public function seance(): BelongsTo
    {
        return $this->belongsTo(Seance::class)
		->withDefault((new Seance())->toArray());
    }

	/**
     *
     */
    public function enseignant(): BelongsTo
    {
        return $this->belongsTo(Enseignant::class);
    }

	/**
     *
     */
    public function universite(): BelongsTo
    {
        return $this->belongsTo(Universite::class);
    }

	/**
     *
     */
    public function scanner(): BelongsTo
    {
        return $this->belongsTo(Scanner::class)
		->withDefault((new Scanner())->toArray());
    }
}
