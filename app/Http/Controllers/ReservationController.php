<?php

namespace App\Http\Controllers;

use App\Models\Don;
use App\Models\User;
use App\Models\Reservation;
use App\Models\Beneficiaire;
use App\Models\Organisation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Notifications\DonDistribuer;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ReservationConfirmer;
use App\Notifications\ReservationEnAttente;
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
    // public function store(Request $request)
    // {
    //         // Vérifiez si l'utilisateur est connecté et a le rôle 'organisation'
    //         $user = Auth::user();
    //         if (!$user || !$user->hasRole('organisation')) {
    //             return response()->json(['message' => 'Accès refusé. Vous devez être connecté en tant qu\'organisation.'], 403);
    //         }

    //                 // Récupérer l'organisation associée à l'utilisateur
    //         // $organisation = Organisation::where('user_id', $user->id)->first();

    //         // if (!$organisation) {
    //         //     return response()->json(['message' => 'Aucune organisation associée à cet utilisateur.'], 404);
    //         // }


    //         $validatedData = $request->validate([
    //             'description' => 'required|string',
    //             'don_id' => 'required|exists:dons,id',
    //             'beneficiaire_id' => 'required|exists:dons,id',
    //             // 'organisation_id' => 'required|exists:organisation,id',
    //         ]);

    //         // Vérifiez si une réservation existe déjà pour ce don
    //         // $existingReservation = Reservation::where('don_id', $validatedData['don_id'])->first();
    //         // if ($existingReservation) {
    //         //     return response()->json(['message' => 'Ce don a déjà une réservation.'], 400);
    //         // }

    //         // Créer la réservation
    //         $reservation = new Reservation();


    //         $reservation->description = $validatedData['description'];
    //         $reservation->don_id = $validatedData['don_id'];
    //         $reservation->beneficiaire_id = $validatedData['beneficiaire_id'];
    //         // $reservation->organisation_id = $validatedData['organisation_id'];
    //         $reservation->created_by = Auth::id();
    //         $reservation->save();


    //         // Obtenir le don et mettre à jour le statut
    //         $don = Don::find($validatedData['don_id']);
    //         $beneficiaire = Beneficiaire::find($validatedData['beneficiaire_id']);
    //         $don->setStatusEnAttente();

    //         // Obtenir le donateur
    //         $donateur = User::find($don->created_by);

    //         // Notifier le donateur
    //         $donateur->notify(new ReservationEnAttente($don, $user->organisation, $beneficiaire));


    //         return response()->json([
    //             'message' => 'Réservation créée avec succès et notification envoyée.',
    //             'reservation' => $reservation,
    //             'organisation' => $reservation->organisation,
    //             'creator' => $reservation->creator,
    //             'don' => $don
    //         ]);
    // }

    
    public function store(Request $request)
    {
        // Vérifiez si l'utilisateur est connecté et a le rôle 'organisation'
        $user = Auth::user();
        if (!$user || !$user->hasRole('organisation')) {
            return response()->json(['message' => 'Accès refusé. Vous devez être connecté en tant qu\'organisation.'], 403);
        }

        // Récupérer l'organisation associée à l'utilisateur
        $organisation = Organisation::where('user_id', $user->id)->first();

        if (!$organisation) {
            return response()->json(['message' => 'Aucune organisation associée à cet utilisateur.'], 404);
        }

        // Valider les données de la requête
        $validatedData = $request->validate([
            'description' => 'required|string',
            'don_id' => 'required|exists:dons,id',
            'beneficiaire_id' => 'required|exists:beneficiaires,id', // correction on this line
        ]);

        // Vérifiez si une réservation existe déjà pour ce don
        $existingReservation = Reservation::where('don_id', $validatedData['don_id'])->first();
        if ($existingReservation) {
            return response()->json(['message' => 'Une réservation existe déjà pour ce don.'], 409);
        }

        // Créer la nouvelle réservation
        $reservation = new Reservation();
        $reservation->description = $validatedData['description'];
        $reservation->don_id = $validatedData['don_id'];
        $reservation->beneficiaire_id = $validatedData['beneficiaire_id'];
        $reservation->created_by = $user->id;
        $reservation->organisation_id = $organisation->id; // Assigner l'organisation associée

        // Enregistrer la réservation
        $reservation->save();

        // Mettre à jour le statut du don
        $don = Don::find($validatedData['don_id']);
        $don->setStatusEnAttente(); // Mettre à jour le statut du don

        // Obtenir le donateur
        $donateur = User::find($don->created_by);
        $beneficiaire = Beneficiaire::find($validatedData['beneficiaire_id']);


        // Notifier le donateur
        $donateur->notify(new ReservationEnAttente($don, $organisation, $beneficiaire));


        // Charger les informations de la réservation, de l'organisation et du don
        $reservation->load('creator', 'organisation');

        return response()->json([
            'message' => 'Réservation créée avec succès et notification envoyée.',
            // 'reservation' => $reservation,
            'organisation' => $reservation->organisation,
            'creator' => $reservation->creator,
            'don' => $don,
        ]);
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


    public function confirmReservation($reservationId)
    {
        // Récupérer la réservation par son ID
        $reservation = Reservation::find($reservationId);

        // Vérifier si la réservation existe
        if (!$reservation) {
            return response()->json(['message' => 'Réservation introuvable'], 404);
        }

        // Récupérer le don lié à la réservation
        $don = $reservation->don;

        if (!$don) {
            return response()->json(['message' => 'Don introuvable'], 404);
        }

        // Vérifier si l'utilisateur est autorisé à confirmer la réservation
        if (Auth::id() !== $don->created_by) {
            return response()->json(['message' => 'Vous n\'êtes pas autorisé à confirmer cette réservation'], 403);
        }

        // Mettre à jour le statut du don à 'réservé'
        $don->status = 'reservé';
        $don->save();

        // Obtenir l'organisation qui a fait la réservation
        $organisation = $reservation->organisation;

        // Vérifier si l'organisation existe
        if (!$organisation) {
            return response()->json(['message' => 'Organisation introuvable'], 404);
        }

        // Notifier l'organisation que la réservation est confirmée
        $organisation->notify(new ReservationConfirmer($don, $reservation->beneficiaire));

        return response()->json(['message' => 'Réservation confirmée avec succès, notification envoyée à l\'organisation.', 'don' => $don], 200);
    }


    public function completeReservation(Request $request, $reservationId)
    {
        $reservation = Reservation::find($reservationId);
        if (!$reservation) {
            return response()->json(['message' => 'Réservation introuvable'], 404);
        }

        $validatedData = $request->validate([
            'rapport' => 'required|string'
        ]);

        // Créer un rapport
        $request->merge(['reservation_id' => $reservationId]); // Ajoute l'ID de réservation à la requête
        $rapportResponse = $this->generateReport($request);

        if ($rapportResponse->getStatusCode() !== 200) {
            return $rapportResponse; // Retourne l'erreur si la génération du rapport échoue
        }

        $don = Don::find($reservation->don_id);
        $don->setStatusDistribue();

        // Sauvegarder le rapport
        $reservation->rapport = $validatedData['rapport'];
        $reservation->save();

        return response()->json([
            'message' => 'Don distribué et notifications envoyées.',
            'don' => $don
        ]);
    }



    }




