<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Donateur;
use App\Models\Beneficiaire;
use App\Models\Organisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function registerDonateur(Request $request)
    {
        //Validation des données
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
            'adresse' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:15',
            'nomstructure' => 'required|string|max:255',
            'emailstructure' => 'required|string|email|max:255',
            'description' => 'nullable|string',
            'typestructure' => 'required|in:micro,macro',
            'siege' => 'required|string|max:255',
            'logo' => 'nullable|string',
            'date_creation' => 'required|date',
            'recepisse' => 'required|string|max:255',
        ]);


        // Vérification si la validation a échoué
        // if ($validatedData->fails()) {
        //     return response()->json([
        //         'success' => false,
        //         'errors' => $validatedData->errors(),
        //     ], 422);
        // }


        // Création de l'utilisateur
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'adresse' => $request->adresse,
            'telephone' => $request->telephone ?? null,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assignation du rôle donateur
        $user->assignRole('donateur');

        //Mise en place des infos suplementaire
        $donateur = Donateur::create([
            'nomstructure' => $request-> nomstructure,
            'emailstructure' => $request-> emailstructure,
            'description' => $request->description ?? null,
            'typestructure' => $request-> typestructure,
            'siege' => $request->siege,
            'logo' => $request->logo ?? null,
            'date_creation' => $request-> date_creation,
            'recepisse' => $request-> recepisse,
            'password' => Hash::make($request->password),
            'user_id' => $user->id,  // Lien avec la table users
        ]);

        // Obtenez les rôles de l'utilisateur
        $roles = $user->getRoleNames();

        // Réponse JSON personnalisée
        return response()->json([
            'success' => true,
            'message' => "Hello $user->prenom , Votre inscription c fait avec succès",
            'user' => [
                'id' => $user->id,
                'nom' => $user->nom,
                'prenom' => $user->prenom,
                'adresse' => $user->adresse,
                'telephone' => $user->telephone,
                'email' => $user->email,
                'roles' => $roles // Inclure les rôles dans la réponse
            ],
            'structure' => [
                'id' => $donateur->id,
                'nomstructure' => $donateur->nomstructure,
                'emailstructure' => $donateur->emailstructure,
                'description' => $donateur->description,
                'typestructure' => $donateur->typestructure,
                'siege' => $donateur->siege,
                'logo' => $donateur->logo,
                'date_creation' => $donateur->date_creation,
                'recepisse' => $donateur->recepisse,
                'password' => Hash::make($request->password)// Mot de passe non affiché pour sécurité''
            ]
        ], 201);
    }


    //Register pour les organisation
    public function registerOrganisation(Request $request)
    {
        //Validation des données
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
            'adresse' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:15',

            'nomstructure' => 'required|string|max:255',
            'emailstructure' => 'required|string|email|max:255',
            'fondateur' => 'required|string|max:100',
            'description' => 'nullable|string',
            'siege' => 'required|string|max:255',
            'logo' => 'nullable|string',
            'date_creation' => 'required|date',
            'recepisse' => 'required|string|max:255',
        ]);

        // Création de l'utilisateur
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'adresse' => $request->adresse,
            'telephone' => $request->telephone ?? null,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assignation du rôle donateur
        $user->assignRole('organisation');

        //Mise en place des infos suplementaire
        $organisation = Organisation::create([
            'nomstructure' => $request-> nomstructure,
            'emailstructure' => $request-> emailstructure,
            'fondateur' => $request-> fondateur,
            'siege' => $request->siege,
            'logo' => $request->logo ?? null,
            'date_creation' => $request-> date_creation,
            'recepisse' => $request-> recepisse,
            'description' => $request-> description,
            'password' => Hash::make($request->password),
            'user_id' => $user->id,  // Lien avec la table users
        ]);

        // Obtenez les rôles de l'utilisateur
        $roles = $user->getRoleNames();


        // Réponse JSON personnalisée
        return response()->json([
            'success' => true,
            'message' => "Hello $user->prenom , Votre inscription c fait avec succès",
            'user' => [
                'id' => $user->id,
                'nom' => $user->nom,
                'prenom' => $user->prenom,
                'adresse' => $user->adresse,
                'telephone' => $user->telephone,
                'email' => $user->email,
                'roles' => $roles // Inclure les rôles dans la réponse
            ],
            'Organisation' => [
                'id' => $organisation->id,
                'nomstructure' => $organisation->nomstructure,
                'emailstructure' => $organisation->emailstructure,
                'description' => $organisation->description,
                'typestructure' => $organisation->typestructure,
                'siege' => $organisation->siege,
                'logo' => $organisation->logo,
                'date_creation' => $organisation->date_creation,
                'recepisse' => $organisation->recepisse,
                'password' => Hash::make($request->password)// Mot de passe non affiché pour sécurité''
            ]
        ], 201);
    }

    //Register pour les Beneficiaires
    public function registerBeneficiaire(Request $request)
    {
        //Validation des données
        $validatedData = $request->validate([
            // 'nom' => 'required|string|max:255',
            // 'prenom' => 'required|string|max:255',
            // 'email' => 'required|string|email|max:255',
            // 'password' => 'required|string|min:6',
            // 'adresse' => 'nullable|string|max:255',
            // 'telephone' => 'nullable|string|max:15',

            // 'nomstructure' => 'required|string|max:255',
            // 'telstructure ' => 'nullable|string|max',
            // 'emailstructure' => 'required|string|email|max:255',
            // 'fondateur' => 'required|string|max:100',
            // 'description' => 'nullable|string',
            // 'adresse' => 'required|string|max:255',
            // 'logo' => 'nullable|string',
            // 'date_creation' => 'required|date',
            // 'recepisse' => 'required|string|max:255',
        ]);

        // Création de l'utilisateur
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'adresse' => $request->adresse,
            'telephone' => $request->telephone ?? null,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assignation du rôle donateur
        $user->assignRole('organisation');

        //Mise en place des infos suplementaire
        $beneficiaire = Beneficiaire::create([
            'nomstructure' => $request-> nomstructure,
            'emailstructure' => $request-> emailstructure,
            'fondateur' => $request-> fondateur,
            'adresse' => $request->adresse,
            'logo' => $request->logo ?? null,
            'date_creation' => $request-> date_creation,
            'recepisse' => $request-> recepisse,
            'description' => $request-> description,
            'password' => Hash::make($request->password),
            'user_id' => $user->id,  // Lien avec la table users
        ]);

        // Obtenez les rôles de l'utilisateur
        $roles = $user->getRoleNames();


        // Réponse JSON personnalisée
        return response()->json([
            'success' => true,
            'message' => "Hello $user->prenom , Votre inscription c fait avec succès",
            'user' => [
                'id' => $user->id,
                'nom' => $user->nom,
                'prenom' => $user->prenom,
                'adresse' => $user->adresse,
                'telephone' => $user->telephone,
                'email' => $user->email,
                'roles' => $roles // Inclure les rôles dans la réponse
            ],
            // 'beneficiaire' => [
            //     'id' => $beneficiaire->id,
            //     'nomstructure' => $beneficiaire->nomstructure,
            //     'emailstructure' => $beneficiaire->emailstructure,
            //     'description' => $beneficiaire->description,
            //     'telstructure' => $beneficiaire->telstructure,
            //     'fondateur' => $beneficiaire->fondateur,
            //     'typestructure' => $beneficiaire->typestructure,
            //     'adresse' => $beneficiaire->adresse,
            //     'logo' => $beneficiaire->logo,
            //     'date_creation' => $beneficiaire->date_creation,
            //     'recepisse' => $beneficiaire->recepisse,
            //     'password' => Hash::make($request->password)// Mot de passe non affiché pour sécurité''
            // ]
        ], 201);
    }

}

