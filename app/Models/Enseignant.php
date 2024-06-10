<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model
{
    use HasFactory;
	protected $table = 'Enseignant';
	
	protected $fillable = ['nom', 'prenoms', 'email', 'grade_id', 'poste_id', 
	'enseignant_grade_id', 'type_piece_id', 'detail_poste', 
	'user_id', 'nb_hr_cum'];	
    /**
     * 
     */

    public function fullname(){
        return $this->nom. ' '. $this->prenoms;
    }

    public function grade()
    {
        Grade::find($this->grade_id);
    }		
    /**
     * 
     */

    public function poste(){
        Poste::find($this->poste_id);
    }
    
    /**
     * 
     */
    public function ens_grade(): BelongsTo
    {
        return $this->belongsTo(EnseignantGrade::class, 'enseignant_grade_id')
					->withDefault((new EnseignantGrade())->toArray());
    }	    
	/**
     * 
     */
    public function specialites(): HasMany
    {
        return $this->hasMany(EnseignantSpecialite::class);
    }	    
	/**
     * 
     */
    public function identites_bio(): HasMany
    {
        return $this->hasMany(IdentifiantBio::class);
    }	    
	/**
     * 
     */
    public function ues(): HasMany
    {
        return $this->hasMany(EnseignantUE::class);
    }		    
	/**
     * 
     */
    public function type_piece(): BelongsTo
    {
        return $this->belongsTo(TypePieceIdentite::class, 'type_piece_id');
    }	
	/**
     * 
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)
					->withDefault((new User())->toArray());
    }	
}