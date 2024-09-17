<?php

namespace Database\Seeders;

use App\Models\Don;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Donateur;
use App\Models\TypeProduit;
use App\Models\Beneficiaire;
use App\Models\Organisation;
use Database\Seeders\DonSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Database\Seeders\DonateurSeeder;
use Database\Seeders\TypeProduitSeeder;
use Database\Seeders\BeneficiaireSeeder;
use Database\Seeders\OrganisationSeeder;
use Spatie\Permission\Models\Permission;
use Database\Seeders\RolePermissionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Désactiver la vérification des clés étrangères pour éviter les erreurs
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate des tables
        User::truncate();
        Don::truncate();
        TypeProduit::truncate();
        Donateur::truncate();
        Organisation::truncate();
        Beneficiaire::truncate();
        Role::truncate();
        Permission::truncate();

        // Réactiver la vérification des clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        // User::factory(10)->create();
        $this->call([
            RolePermissionSeeder::class,
            UserSeeder::class,
            DonSeeder::class,
            TypeProduitSeeder::class,
            DonateurSeeder::class,
            OrganisationSeeder::class,
            BeneficiaireSeeder::class,
        ]);
    }
}
