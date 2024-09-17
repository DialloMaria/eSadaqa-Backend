<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Donateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\JWTAuth;

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
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'adresse' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:15|unique:users',
            'nomstructure' => 'required|string|max:255',
            'emailstructure' => 'required|string|email|max:255|unique:donateurs',
            'description' => 'nullable|string',
            'typestructure' => 'required|in:micro,macro',
            'siege' => 'required|string|max:255',
            'logo' => 'nullable|string',
            'date_creation' => 'required|date',
            'recepisse' => 'required|string|max:255',
        ]);


        // Vérification si la validation a échoué
        if ($validatedData->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validatedData->errors(),
            ], 422);
        }


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
            'message' => "Utilisateur créé avec succès",
            'user' => [
                'id' => $user->id,
                'nom' => $user->nom,
                'prenom' => $user->prenom,
                'adresse' => $user->adresse,
                'telephone' => $user->telephone,
                'email' => $user->email,
                'token' => JWTAuth::fromUser($user), // Génération d'un token JWT pour l'utilisateur
                'roles' => $roles // Inclure les rôles dans la réponse
            ]
            // 'structure' => [
            //     'id' => $donateur->id,
            //     'nomstructure' => $donateur->nomstructure,
            //     'emailstructure' => $donateur->emailstructure,
            //     'description' => $donateur->description,
            //     'typestructure' => $donateur->typestructure,
            //     'siege' => $donateur->siege,
            //     'logo' => $donateur->logo,
            //     'date_creation' => $donateur->date_creation,
            //     'recepisse' => $donateur->recepisse,
            //     'password' => Hash::make($request->password)// Mot de passe non affiché pour sécurité''
            // ]
        ], 201);
    }


    //Register pour l'organisation
    



}
