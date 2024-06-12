<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TypePieceIdentite;
use Mockery\Matcher\Type;

class TypePieceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pieces = [
            "Carte nationale d\'identité",
            "Passeport",
            "Carte d'électeur",
            "Permis de conduire"
        ];

        foreach ($pieces as $piece) {
            $type = new TypePieceIdentite();
            $type->libelle = $piece;
            $type->save();
        }

    }
}
