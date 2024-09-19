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
        $dons = [
            [
                'libelle' => 'Don de nourriture',
                'description' => 'Un lot de nourriture pour les familles en difficulté.',
                'categorie' => 'produit',
                'status' => 'en_attente',
                'adresse' => '12 Rue de l\'Espoir, Paris',
                'image' => 'https://example.com/images/don1.jpg',
                'created_by' => 1, // ID d'un utilisateur existant
            ],
            [
                'libelle' => 'Don monétaire pour l\'éducation',
                'description' => 'Un don en argent pour financer l\'éducation des enfants défavorisés.',
                'categorie' => 'monetaire',
                'status' => 'reservé',
                'adresse' => '5 Rue de la Paix, Lyon',
                'image' => 'https://example.com/images/don2.jpg',
                'created_by' => 2, // ID d'un utilisateur existant
            ],
            [
                'libelle' => 'Don de vêtements',
                'description' => 'Des vêtements pour les sans-abris durant l\'hiver.',
                'categorie' => 'produit',
                'status' => 'distribué',
                'adresse' => '25 Avenue de la Fraternité, Marseille',
                'image' => 'https://example.com/images/don3.jpg',
                'created_by' => 1, // ID d'un utilisateur existant
            ]
        ];

        // Insère les dons dans la table
        foreach ($dons as $don) {
            Don::create($don);
        }

    }
}
