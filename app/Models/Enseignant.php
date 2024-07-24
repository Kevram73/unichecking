<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model
{
    use HasFactory;
	protected $table = 'enseignant';

	protected $fillable = ['nom', 'prenoms', 'email', 'grade_id', 'poste_id',
	'enseignant_grade_id', 'type_piece_id', 'detail_poste',
	'user_id', 'nb_hr_cum', 'matricule'];
    /**
     *
     */

    public function fullname(){
        return $this->nom. ' '. $this->prenoms;
    }

    public function grade()
    {
        $grade = Grade::find($this->grade_id);
        if($grade != Null)
            return $grade->intitule;
        else
            return "";
    }
    /**
     *
     */

    public function poste(){
        $poste = Poste::find($this->poste_id);
        if($poste != Null)
            return $poste->libelle;
        else
            return "";
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

    public function hr_cum(){
        $nbr_hr = 0;
        $presences = ScanPresence::where("enseignant_id", $this->id)->get()->toArray();
        foreach($presences as $presence){
            $nbr_hr += $presence->nb_hr_cpt;
        }

        return $nbr_hr;
    }
}
