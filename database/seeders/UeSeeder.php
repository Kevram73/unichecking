<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            [
                'id' => 1,
                'universite_id' => 0,
                'intitule' => 'Probabilites Statistiques',
                'description' => NULL,
                'code' => 'M112',
                'volume_horaire' => 0,
                'created_at' => '2024-05-17 22:02:11',
                'updated_at' => '2024-05-17 22:02:11'
            ],
            [
                'id' => 2,
                'universite_id' => 0,
                'intitule' => 'Pédiatrie',
                'description' => NULL,
                'code' => 'MED-052',
                'volume_horaire' => 0,
                'created_at' => '2024-05-17 22:02:11',
                'updated_at' => '2024-05-20 20:52:18'
            ],
            [
                'id' => 3,
                'universite_id' => 0,
                'intitule' => 'Algèbre Linéaire',
                'description' => NULL,
                'code' => 'ECO203C',
                'volume_horaire' => 0,
                'created_at' => '2024-05-17 22:02:11',
                'updated_at' => '2024-05-23 16:13:42'
            ],
            // Add other courses similarly...
            [
                'id' => 28,
                'universite_id' => 0,
                'intitule' => 'Droit de la Famille',
                'description' => NULL,
                'code' => 'D015',
                'volume_horaire' => 0,
                'created_at' => '2024-05-29 10:33:01',
                'updated_at' => '2024-05-29 10:33:01'
            ]
        ];

// Example of accessing data
        echo "Course Title: " . $courses[0]['intitule']; // Outputs: Course Title: Probabilites Statistiques

    }
}
