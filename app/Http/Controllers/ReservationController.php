<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::with('don', 'beneficiaire', 'creator', 'modifier')->get();
        return response()->json($reservations, Response::HTTP_OK);
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
    public function store(StoreReservationRequest $request)
    {
        $validated = $request->validate([
            'description' => 'required|string',
            // 'don_id' => 'required|exists:dons,id',
            // 'beneficiaire_id' => 'required|exists:beneficiaires,id',
        ]);

        $reservation = new Reservation($validated);
        $reservation->created_by = Auth::id(); // Enregistre l'utilisateur qui crée la réservation
        $reservation->save();

        return $this->customJsonResponse("Votre reservation c bien passé", $reservation);

    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'description' => 'required|string',
            // 'don_id' => 'nullable|exists:dons,id',
            // 'beneficiaire_id' => 'nullable|exists:beneficiaires,id',
        ]);

        // Remplir les données validées
        $reservation->fill($validated);

        // Enregistrer l'utilisateur qui modifie la réservation
        $reservation->modified_by = Auth::id();
        $reservation->save();

        return response()->json([
            'message' => 'Réservation mise à jour avec succès',
            'reservation' => $reservation,
        ], Response::HTTP_OK);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return response()->json([
                'message' => 'Réservation non trouvée',
            ], 404);
        }

        $reservation->delete();

        return response()->json([
            'message' => 'Réservation supprimée avec succès',
        ]);
    }

}
