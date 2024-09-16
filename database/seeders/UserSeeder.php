<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1= User::create([
            'nom' => 'Diallo',
            'prenom' => 'Mariama',
            'telephone' => '778875322',
            'email' => 'admin1@example.com',
            'adresse' => '123 Admin St',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // Changez le mot de passe selon vos besoins
            'remember_token' => Str::random(10),
        ]);
        $user1->assignRole('admin');

        $user2= User::create([
            'nom' => 'Diallo',
            'prenom' => 'Abdu',
            'telephone' => '770000000',
            'email' => 'admin2@example.com',
            'adresse' => '123 Admin St',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // Changez le mot de passe selon vos besoins
            'remember_token' => Str::random(10),
        ]);
        $user2->assignRole('admin');
    }
}
