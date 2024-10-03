<?php

namespace App\Http\Controllers;

use App\Models\Don;
use App\Models\TypeProduit;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreDonRequest;
use App\Http\Requests\UpdateDonRequest;

class DonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        \Log::info('Authentication check', ['user' => auth()->user()]);

        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $don = Don::with(['creator', 'modifier'])->get();
        return $this->customJsonResponse("Dons retrieved successfully", $don);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDonRequest $request)
    {

        // Vérifiez si l'utilisateur est connecté et a le rôle de 'donateur'
        $user = Auth::user();
        if (!$user || !$user->hasRole('donateur')) {
            return response()->json(['message' => 'Accès refusé. Vous devez être un donateur pour créer un don.'], 403);
        }
        $data = $request->validated();
        // dd($request);
        // Création d'une nouvelle instance de SousDomaine
        $don = new Don();
        $don->fill( $request->validated() );
        if ( $request->hasFile( 'image' ) ) {
            $image = $request->file( 'image' );
            $don->image = $image->store( 'images', 'public' );
        }
        $don->created_by = Auth::id();
        $don->save();

        return $this->customJsonResponse("Don créé avec succès", $don, Response::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Récupérer le don par son ID et échouer si introuvable
        $don = Don::with(['creator', 'modifier'])->findOrFail($id);

        // Retourner les détails complets du don
        return $this->customJsonResponse("Détails du don récupérés avec succès", [
            'id' => $don->id,
            'libelle' => $don->libelle,
            'description' => $don->description,
            'categorie' => $don->categorie->nom ?? 'Aucune catégorie',
            'adresse' => $don->adresse,
            'status' => $don->status,
            'image' => $don->image ? asset('storage/' . $don->image) : null,
            'created_by' => $don->creator ? $don->creator->name : 'Inconnu',
            'modified_by' => $don->modifier ? $don->modifier->name : 'Non modifié',
            'created_at' => $don->created_at,
            'updated_at' => $don->updated_at,
        ]);
    }




    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Don $don)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDonRequest $request, Don $don)
    {
        // Valider les données
        $data = $request->validated();

        // Vérifier si une nouvelle image est téléchargée
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $don->image = $image->store('images', 'public');
        }

        // Mettre à jour les autres champs
        $don->fill($data);

        // Mettre à jour le champ modified_by
        $don->modified_by = Auth::id();

        // Enregistrer les modifications
        $don->save();

        // Réponse de succès
        return $this->customJsonResponse("Don mis à jour avec succès", $don);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $don = don::find($id);

            try {
                if (!$don) {
                    return response()->json(['message' => 'don non trouvé'], 404);
                }

                $don->delete();
                return $this->customJsonResponse('don supprimé avec succès', $don);

            } catch (Exception $e) {
                return response()->json([
                    'message' => 'Erreur lors de la suppression de l\'don',
                    'error' => $e->getMessage()
                ], 500);
            }
        }

    // Dans DonController.php
    public function getProduitsByDon($donId)
    {
        // Vérifier que le don existe
        $don = Don::find($donId);
        if (!$don) {
            return response()->json(['message' => 'Don not found'], 404);
        }

        // Récupérer les produits associés au don
        $produits = TypeProduit::where('don_id', $donId)->get();

        // Si aucun produit n'est associé au don
        if ($produits->isEmpty()) {
            return response()->json(['message' => 'Aucun produit trouvé pour ce don'], 404);
        }

        // Retourner les produits dans un format JSON structuré
        return response()->json([
            'message' => 'Les produits pour ce don sont :',
            'data' => $produits
        ], 200);
    }


}
