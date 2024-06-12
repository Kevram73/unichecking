<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Specialite;

class SpecialiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialites = [
            ["MED-215", "Cardiologie"],
            ["MED-051", "Pédiatrie"],
            ["MED-371", "Chirurgie"],
            ["MED-183", "Neurologie"],
            ["PHY-222", "Physique Théorique"],
            ["ECO-145", "Comptabilité Financière"],
            ["ECO-146", "Ressources Humaines"],
            ["ECO1", "Economie"],
            ["DOC", "Chirurgie vasculaire"],
            ["100G", "Chirurgie pédiatrique"],
            ["CH100", "Chirurgie viscérale"],
            ["MED-100", "Médécine légale et expertise"],
            ["MED-101", "Neurochirurgie"],
            ["MED-102", "Orthopédie"],
            ["MED-103", "Urologie"],
            ["MED-104", "Hépato-gastro-anthérologie"],
            ["MED-105", "Oncologie"],
        ];


        foreach ($specialites as $spec) {
            $specialite = new Specialite();
            $specialite->code = $spec[0];
            $specialite->intitule = $spec[1];
            $specialite->save();
        }
    }
}
