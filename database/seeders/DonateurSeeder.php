<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Donateur;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DonateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                // Création d'un utilisateur associé au rôle Donateur
                $user = User::create([
                    'nom' => 'Diallo',
                    'prenom' => 'Boubacar',
                    'telephone' => '770000001',
                    'email' => 'donateur1@example.com',
                    'adresse' => '123 Donateur St',
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'),
                    'remember_token' => Str::random(10),
                ]);

                // Assignation du rôle donateur
                $user->assignRole('donateur');

                // Création de la structure donateur associée à cet utilisateur
                Donateur::create([
                    'nomstructure' => 'Structure Donateur 1',
                    'emailstructure' => 'structure1@example.com',
                    'description' => 'Description de la structure donateur 1',
                    'typestructure' => 'macro',
                    'siege' => 'Siege structure 1',
                    'logo' => 'logo1.png',
                    'date_creation' => '2022-01-01',
                    'recepisse' => 'REC-1234',
                    // 'password' => Hash::make('password'),
                    'user_id' => 3,
                ]);
    }
}
