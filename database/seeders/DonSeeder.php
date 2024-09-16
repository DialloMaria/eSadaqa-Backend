<?php

namespace Database\Seeders;

use App\Models\Don;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Don::create([
            'libelle' => 'Don de soutien financier',
            'description' => 'Aide financière pour le développement du projet.',
            'categorie' => 'Produit',  // Enum monetaire
            'status' => 'en_attente',  // Enum en_attente
            'adresse' => '123 Avenue des Dons',
            'image' => 'monetaire.png',
            'user_id' => 1
        ]);

    }
}
