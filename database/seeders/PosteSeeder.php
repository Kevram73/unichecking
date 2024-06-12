<?php

namespace Database\Seeders;

use App\Models\Poste;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PosteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $postes = [
            ['Ministre', 1],
            ['Président', 1],
            ['Doyen', 1],
            ['Directeur d\'école', 2],
            ['Directeur d\'institution', 2],
            ['CHEF SERVICE ADMINISTRATION', 2],
            ['CHEF DEPARTEMENT', 3],
        ];

        foreach ($postes as $poste) {
            $post = new Poste();
            $post->libelle = $poste[0];
            $post->categorie_poste_id = $poste[1];
            $post->save();
        }
    }
}
