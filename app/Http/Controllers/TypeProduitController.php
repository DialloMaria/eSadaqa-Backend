<?php

namespace App\Http\Controllers;

use App\Models\TypeProduit;
use Illuminate\Http\Response;
use App\Http\Requests\StoreTypeProduitRequest;
use App\Http\Requests\UpdateTypeProduitRequest;

class TypeProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produit = TypeProduit::all();
        // $don = TytpeProduit::with(['creator', 'modifier'])->get();
        return $this->customJsonResponse("Don retrieved successfully", $produit);
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
    public function store(StoreTypeProduitRequest $request)
    {
        $data = $request->validated();

        // Création d'une nouvelle instance de produit
        $produit = new TypeProduit();
        $produit->fill( $request->validated() );
        $produit->save();

        return $this->customJsonResponse("Type produit créé avec succès", $produit, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(TypeProduit $typeProduit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TypeProduit $typeProduit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTypeProduitRequest $request, TypeProduit $typeProduit, $id)
    {
        $typeProduit = TypeProduit::find($id);

        if (!$typeProduit) {
            return response()->json(['message' => 'Don introuvable'], Response::HTTP_NOT_FOUND);
        }

        $data = $request->validate([
            'libelle' => 'sometimes|required|string|max:255',
            'quantite' => 'nullable|integer',
            'montant' => 'nullable|numeric',
            'mode_paiement' => 'nullable|string|max:255',
            'don_id' => 'required|exists:dons,id',
        ]);

        $typeProduit->update($data);

        // return response()->json($typeProduit, Response::HTTP_OK);
        return $this->customJsonResponse("Type produit modifié avec succès", $typeProduit   , 201);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $typeProduit = TypeProduit::find($id);

            try {
                if (!$typeProduit) {
                    return response()->json(['message' => 'typeProduit non trouvé'], 404);
                }

                $typeProduit->delete();
                return $this->customJsonResponse('typeProduit supprimé avec succès', $typeProduit);

            } catch (Exception $e) {
                return response()->json([
                    'message' => 'Erreur lors de la suppression de l\'don',
                    'error' => $e->getMessage()
                ], 500);
            }
        }
}
