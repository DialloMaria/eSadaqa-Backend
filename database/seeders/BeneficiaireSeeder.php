<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Beneficiaire;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BeneficiaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'nom' => 'Sow',
            'prenom' => 'Aminata',
            'telephone' => '770000003',
            'email' => 'beneficiaire1@example.com',
            'adresse' => '123 Beneficiaire St',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // Changez le mot de passe selon vos besoins
            'remember_token' => Str::random(10),
        ]);
        $user->assignRole('beneficiaire');

        Beneficiaire::create([
            'nomstructure' => 'Beneficiaire 1',
            'telstructure' => '778888888',
            'emailstructure' => 'beneficiaire1@example.com',
            'description' => 'Description du bénéficiaire 1',
            'logo' => 'beneficiaire-logo.png',
            'fondateur' => 'Fondateur Beneficiaire 1',
            'date_creation' => '2021-09-15',
            'recepisse' => 'BEN-4321',
            'user_id' => 5,
        ]);
    }
}
