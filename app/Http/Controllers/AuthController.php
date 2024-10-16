<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Donateur;
use App\Models\Beneficiaire;
use App\Models\Organisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function registerDonateur(Request $request)
    {
        // Validation des données
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
            'adresse' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:15',
            'nomstructure' => 'nullable|string|max:255',
            'emailstructure' => 'nullable|string|email|max:255',
            'description' => 'nullable|string',
            'typestructure' => 'nullable|in:micro,macro',
            'siege' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validation de l'image pour le logo
            'date_creation' => 'required|date',
            'recepisse' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Validation de l'image pour le récepissé
            'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048' // Validation de l'image pour la photo de profil
        ]);

        // Gestion de l'upload de la photo de profil
        $photoProfilePath = 'path/to/placeholder.jpg'; // Chemin par défaut
        if ($request->hasFile('photo_profile')) {
            $photoProfilePath = $request->file('photo_profile')->store('profiles', 'public'); // Stocke dans le dossier 'profiles' du disque public
        }

        // Gestion de l'upload du logo
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public'); // Stocke dans le dossier 'logos' du disque public
        }

        // Gestion de l'upload du récepissé
        $recepissePath = null;
        if ($request->hasFile('recepisse')) {
            $recepissePath = $request->file('recepisse')->store('recepisses', 'public'); // Stocke dans le dossier 'recepisses' du disque public
        }

        // Création de l'utilisateur
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'adresse' => $request->adresse,
            'telephone' => $request->telephone ?? null,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'photo_profile' => $photoProfilePath
        ]);

        // Assignation du rôle donateur
        $user->assignRole('donateur');

        // Mise en place des infos supplémentaires
        $donateur = Donateur::create([
            'nomstructure' => $request->nomstructure,
            'emailstructure' => $request->emailstructure,
            'description' => $request->description ?? null,
            'typestructure' => $request->typestructure,
            'siege' => $request->siege,
            'logo' => $logoPath,
            'date_creation' => $request->date_creation,
            'recepisse' => $recepissePath,
            'user_id' => $user->id,  // Lien avec la table users
        ]);

        // Obtenez les rôles de l'utilisateur
        $roles = $user->getRoleNames();

        // Réponse JSON personnalisée
        return response()->json([
            'success' => true,
            'message' => "Hello $user->prenom , Votre inscription s'est faite avec succès",
            'user' => $user,
            'roles' => $roles, // Inclure les rôles dans la réponse,
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
            ]
        ], 201);
    }


    public function registerDonateurP(Request $request)
    {
        //Validation des données
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
            'adresse' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:15',
            'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048' // Validation de l'image
        ]);

        // Gestion de l'upload de la photo de profil
        $photoProfilePath = 'path/to/placeholder.jpg'; // Chemin par défaut
        if ($request->hasFile('photo_profile')) {
            $photoProfilePath = $request->file('photo_profile')->store('profiles', 'public'); // Stocke dans le dossier 'profiles' du disque public
        }

        // Création de l'utilisateur
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'adresse' => $request->adresse,
            'telephone' => $request->telephone ?? null,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'photo_profile' => $photoProfilePath
        ]);

        // Assignation du rôle donateur
        $user->assignRole('donateur');

        //Mise en place des infos suplementaire


        // Obtenez les rôles de l'utilisateur
        $roles = $user->getRoleNames();

        // Réponse JSON personnalisée
        return response()->json([
            'success' => true,
            'message' => "Hello $user->prenom , Votre inscription c fait avec succès",
            'user' => $user,
            'roles' => $roles, // Inclure les rôles dans la réponse,

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
            'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048' // Validation de l'image
        ]);

        // Gestion de l'upload de la photo de profil
        $photoProfilePath = 'path/to/placeholder.jpg'; // Chemin par défaut
        if ($request->hasFile('photo_profile')) {
            $photoProfilePath = $request->file('photo_profile')->store('profiles', 'public'); // Stocke dans le dossier 'profiles' du disque public
        }

        // Création de l'utilisateur
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'adresse' => $request->adresse,
            'telephone' => $request->telephone ?? null,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'photo_profile' => $photoProfilePath

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
            // 'password' => Hash::make($request->password),
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
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
            'adresse' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:15',

            'nomstructure' => 'required|string|max:255',
            'telstructure ' => 'nullable|string|max',
            'emailstructure' => 'required|string|email|max:255',
            'fondateur' => 'required|string|max:100',
            'description' => 'nullable|string',
            'adresse' => 'required|string|max:255',
            'logo' => 'nullable|string',
            'date_creation' => 'required|date',
            'recepisse' => 'required|string|max:255',
            'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048' // Validation de l'image
        ]);

        // Gestion de l'upload de la photo de profil
        $photoProfilePath = 'path/to/placeholder.jpg'; // Chemin par défaut
        if ($request->hasFile('photo_profile')) {
            $photoProfilePath = $request->file('photo_profile')->store('profiles', 'public'); // Stocke dans le dossier 'profiles' du disque public
        }

        // Création de l'utilisateur
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'adresse' => $request->adresse,
            'telephone' => $request->telephone ?? null,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'photo_profile' => $photoProfilePath

        ]);

        // Assignation du rôle donateur
        $user->assignRole('beneficiaire');

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
            // 'password' => Hash::make($request->password),
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
            'beneficiaire' => [
                'id' => $beneficiaire->id,
                'nomstructure' => $beneficiaire->nomstructure,
                'emailstructure' => $beneficiaire->emailstructure,
                'description' => $beneficiaire->description,
                'telstructure' => $beneficiaire->telstructure,
                'fondateur' => $beneficiaire->fondateur,
                'typestructure' => $beneficiaire->typestructure,
                'adresse' => $beneficiaire->adresse,
                'logo' => $beneficiaire->logo,
                'date_creation' => $beneficiaire->date_creation,
                'recepisse' => $beneficiaire->recepisse,
                'password' => Hash::make($request->password)// Mot de passe non affiché pour sécurité''
            ]
        ], 201);
    }


    public function listBeneficiaires()
    {
        // Vérifiez si l'utilisateur est authentifié
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non authentifié.'
            ], 401);
        }

        // Récupérer tous les bénéficiaires et charger les informations de l'utilisateur associé
        $beneficiaires = Beneficiaire::with('user')->get();

        // Vérifiez s'il y a des bénéficiaires
        if ($beneficiaires->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Aucun bénéficiaire trouvé.',
            ], 404);
        }

        // Réponse JSON avec la liste des bénéficiaires
        return response()->json([
            'success' => true,
            'beneficiaires' => $beneficiaires
        ], 200);
    }



    // LOGIN
    // public function login(Request $request)
    // {
    //     // Validation des données
    //     $validator = validator($request->all(), [
    //         'email' => ['required', 'email', 'string'],
    //         'password' => ['required', 'string'],
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'errors' => $validator->errors(),
    //         ], 422);
    //     }

    //     $credentials = $request->only(['email', 'password']);

    //     // Tentative de connexion avec les informations d'identification
    //     if (!$token = auth()->guard('api')->attempt($credentials)) {
    //         return response()->json([
    //             'message' => 'Identifiants de connexion invalides',
    //         ], 401);
    //     }

    //     // Obtenez l'utilisateur connecté
    //     $user = auth()->guard('api')->user();

    //     // Obtenez les rôles de l'utilisateur
    //     $roles = $user->getRoleNames();

    //     // Vérifiez le rôle de l'utilisateur et retournez une réponse en fonction de son rôle
    //     if ($roles->contains('admin')) {
    //         return $this->respondWithToken($token, $user, 'admin');
    //     } elseif ($roles->contains('donateur')) {
    //         return $this->respondWithToken($token, $user, 'donateur');
    //     } elseif ($roles->contains('organisation')) {
    //         return $this->respondWithToken($token, $user, 'organisation');
    //     } elseif ($roles->contains('beneficiaire')) {
    //         return $this->respondWithToken($token, $user, 'beneficiaire');
    //     } else {
    //         return response()->json([
    //             'message' => 'Rôle non reconnu pour cet utilisateur',
    //         ], 403);
    //     }
    // }

    public function login(Request $request)
    {
        // Validation des données
        $validator = validator($request->all(), [
            'email' => ['required', 'email', 'string'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        // Vérifier si l'utilisateur existe
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'message' => 'Utilisateur non trouvé',
            ], 404); // User not found
        }

        // Vérifier si le mot de passe est correct
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Mot de passe incorrect',
            ], 401); // Incorrect password
        }

        // Authentification réussie, générer le token
        $token = auth()->guard('api')->login($user);

        // Obtenir les rôles de l'utilisateur
        $roles = $user->getRoleNames();

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'roles' => $roles,
            'user' => $user,
            'expires_in' => auth()->guard('api')->factory()->getTTL() * 60, // Expiration en secondes
        ]);
    }

    /**
     * Répondre avec un jeton et les informations de l'utilisateur
     */
    protected function respondWithToken($token, $user, $role)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'role' => $role, // Inclure le rôle dans la réponse
            'user' => $user,
            'expires_in' => auth()->guard('api')->factory()->getTTL() * 60, // Expiration du token en secondes
        ]);
    }

    // logout
      public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json(['message' => 'Déconnexion réussie.'], 200);
    }




// LA LISTES DES DE TOUS LES USERS

public function listDonateursStructures()
{
    // Récupération des donateurs qui sont des structures
    $donateursStructures = Donateur::all(); // Inclure les informations de l'utilisateur associé

    // Réponse JSON
    return response()->json([
        'success' => true,
        'donateurs_structures' => $donateursStructures,
    ], 200);
}

public function listOrganisation()
{

    // $user = Auth::user();
    // if (!$user || !$user->hasRole('admin')) {
    //     return response()->json(['message' => 'Accès refusé. Vous devez être un admin pour créer consulté la liste des organisations.'], 403);
    // }

    // Récupération des donateurs qui sont des structures
    // $listOrganisation = Organisation::all(); // Inclure les informations de l'utilisateur associé
    // Récupérer tous les bénéficiaires et charger les informations de l'utilisateur associé
    $listOrganisation = Organisation::with('user')->get();


    // Réponse JSON
    return response()->json([
        'success' => true,
        'donateurs_structures' => $listOrganisation,
    ], 200);
}


}


