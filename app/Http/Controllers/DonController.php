<?php

namespace App\Http\Controllers;

use App\Models\Don;
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
        // $dons = Don::all();
        // return response()->json($dons);

        $don = Don::with(['creator', 'modifier'])->get();
        return $this->customJsonResponse("Don retrieved successfully", $don);
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
        $data = $request->validated();

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
    public function show(Don $don)
    {
        //
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

    
}
