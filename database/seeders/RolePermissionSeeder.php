<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Création des permissions pour chaque entité
        $permissions = [
            //User permissions
            'create user',
            'view user',
            'edit user',
            'delete user',

            // Don permissions
            'create don',
            'view don',
            'edit don',
            'delete don',

            // Organisation permissions
            'create organisation',
            'view organisation',
            'edit organisation',
            'delete organisation',

            // Beneficiaire permissions
            'view beneficiaire',
            'create beneficiaire',
            'edit beneficiaire',
            'delete beneficiaire',

            // Produit permissions
            'create produit',
            'view produit',
            'edit produit',
            'delete produit',

            // // Notification permissions
            'view notification',
            'delete notification',
        ];

        // Création des permissions dans la base de données
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }


        // Créer les rôles et leur assigner des permissions
        $adminRole = Role::create(['name' => 'admin']);
        $organisationRole = Role::create(['name' => 'organisation']);
        $donateurRole = Role::create(['name' => 'donateur']);
        $beneficiaireRole = Role::create(['name' => 'beneficiaire']);
        $userRole = Role::create(['name' => 'user']);

        // Assigner toutes les permissions au super_admin
        $adminRole->givePermissionTo(Permission::all());

             // Permissions pour le bénéficiaire
             $beneficiaireRole->givePermissionTo([
                'view don',
                'create don',
                'edit don',
                'create produit',
                'view produit',
                'edit produit',
                'view organisation',
                'view notification',
            ]);

            // Permissions pour le donateur
            $donateurRole->givePermissionTo([
                'create don',
                'view don',
                'edit don',
                'create produit',
                'view produit',
                'edit produit',
                'delete produit',
                'view organisation',
                'view beneficiaire',
                'view notification',
            ]);

            // Permissions pour l'organisation
            $organisationRole->givePermissionTo([
                'create produit',
                'view produit',
                'edit produit',
                'delete produit',
                'create don',
                'view don',
                'edit don',
                'view notification',
            ]);

            // Permissions pour l'utilisateur standard
            $userRole->givePermissionTo([
                'view produit',
                'view don',
            ]);

    }
}
