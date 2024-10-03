<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TypeProduitController;
use App\Http\Controllers\NotificationController;
;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



    Route::post('/register/donateur', [AuthController::class, 'registerDonateur']);
    Route::post('/register/donateur/perso', [AuthController::class, 'registerDonateurP']);

    Route::post('/register/organisation', [AuthController::class, 'registerOrganisation']);

    Route::post('/register/beneficiaire', [AuthController::class, 'registerBeneficiaire']);


    Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:api')->group(function() {

    //////////////////////////////////////////////////////////////// DONS ////////////////////////////////////////////////////////////////

    Route::get ('don/affichage' , [DonController::class, 'index']);

    Route::get ('notification/affichage' , [NotificationController::class, 'index']);

    Route::post ('don/ajout' , [DonController::class, 'store']);

    Route::get('/don/{don}', [DonController::class, 'show']);

    Route::post ('don/modification/{don}' , [DonController::class, 'update']);

    Route::delete ('don/suppression/{don}' , [DonController::class, 'destroy']);

    Route::get('/dons/{don}/produits', [DonController::class, 'getProduitsByDon']);

    Route::get('/listbeneficiaires', [AuthController::class, 'listBeneficiaires']);


    //////////////////////////////////////////////////////////////// TYPE PRODUITS ////////////////////////////////////////////////////////////////

    Route::get ('produit/affichage' , [TypeProduitController::class, 'index']);

    Route::post ('produit/ajout/' , [TypeProduitController::class, 'store']);

    Route::get('/produit/{typeProduit}', [TypeProduitController::class, 'show']);

    Route::post ('produit/modification/{produit}' , [TypeProduitController::class, 'update']);

    Route::delete ('produit/suppression/{produit}' , [TypeProduitController::class, 'destroy']);




    //////////////////////////////////////////////////////////////// RESERVATIONS ////////////////////////////////////////////////////////////////

    Route::get ('reservation/affichage' , [ReservationController::class, 'index']);

    Route::post ('reservation/ajout' , [ReservationController::class, 'store']);

    Route::post ('reservation/modification/{reservation}' , [ReservationController::class, 'update']);

    Route::delete ('reservation/suppression/{reservation}' , [ReservationController::class, 'destroy']);

    Route::post('reservations/{id}/confirm', [ReservationController::class, 'confirmReservation']);

    Route::post('reservations/{reservationId}/complete', [ReservationController::class, 'completeReservation']);

    Route::post('/generate-rapport', [RapportController::class, 'generateReport']);


    Route::post('/generate-report', [ReportController::class, 'generate']);

    // Route::post('/rapport/generate', [RapportController::class, 'generateReport']);
} );



