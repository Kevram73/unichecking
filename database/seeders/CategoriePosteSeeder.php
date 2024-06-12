<?php

namespace Database\Seeders;

use App\Models\CategoriePoste;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriePosteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['A', 100],
            ['B', 55],
            ['C', 35],
        ];


        foreach ($categories as $cat) {
            $category = new CategoriePoste();
            $category->libelle = $cat[0];
            $category->exoneration_horaire = $cat[1];
            $category->save();
        }
    }
}
