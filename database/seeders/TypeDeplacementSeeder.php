<?php

namespace Database\Seeders;

use App\Models\TypeDeplacement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeDeplacementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            "Missions",
            "Formations",
            "Colloques",
            "Voyages",
            "Séminaires"
        ];

        foreach ($types as $piece) {
            $type = new TypeDeplacement();
            $type->designation = $piece;
            $type->save();
        }
    }
}
