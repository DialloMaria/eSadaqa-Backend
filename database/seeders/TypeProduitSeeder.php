<?php

namespace Database\Seeders;

use App\Models\Don;
use App\Models\TypeProduit;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TypeProduitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer un don existant (par exemple le don monétaire ou produit)
        $don = Don::where('categorie', 'produit')->first();

        // Création d'un exemple de type de produit
        TypeProduit::create([
            'libelle' => 'Ordinateurs portables',
            'quantite' => 10,
            // 'montant' => 15000.00,
            // 'mode_paiement' => 'virement bancaire',
            'don_id' => 1, // Associer ce type de produit à un don existant
        ]);

        // Création d'un autre type de produit
        TypeProduit::create([
            'libelle' => 'Imprimantes',
            'quantite' => 5,
            // 'montant' => 5000.00,
            // 'mode_paiement' => 'paiement en espèces',
            'don_id' => 1, // Associer ce type de produit au même don
        ]);
    }
}
