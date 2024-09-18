<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTypeProduitRequest;
use App\Http\Requests\UpdateTypeProduitRequest;
use App\Models\TypeProduit;

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

        // Création d'une nouvelle instance de SousDomaine
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
    public function update(UpdateTypeProduitRequest $request, TypeProduit $typeProduit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeProduit $typeProduit)
    {
        //
    }
}
