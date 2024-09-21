<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Organisation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrganisationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'nom' => 'Bah',
            'prenom' => 'Fatou',
            'telephone' => '770000002',
            'email' => 'organisation1@example.com',
            'adresse' => '123 Organisation St',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // Changez le mot de passe selon vos besoins
            'remember_token' => Str::random(10),
        ]);
        $user->assignRole('organisation');

        Organisation::create([
            'nomstructure' => 'Organisation 1',
            'emailstructure' => 'organisation1@example.com',
            'siege' => '123 Siege Organisation 1',
            'fondateur' => 'Fondateur Organisation 1',
            'logo' => 'organisation-logo.png',
            'date_creation' => '2020-05-20',
            'recepisse' => 'ORG-5678',
            // 'password' => Hash::make('password'),
            'user_id' => 4,
        ]);
    }
}
