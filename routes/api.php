<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonController;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register/donateur', [AuthController::class, 'registerDonateur']);

Route::post('/register/organisation', [AuthController::class, 'registerOrganisation']);

Route::post('/register/beneficiaire', [AuthController::class, 'registerBeneficiaire']);


Route::post('/login', [AuthController::class, 'login']);


//////////////////////////////////////////////////////////////// DONS ////////////////////////////////////////////////////////////////

Route::get ('don/affichage' , [DonController::class, 'index']);

Route::post ('don/ajout' , [DonController::class, 'store']);

Route::put ('don/modification/{don}' , [DonController::class, 'update']);

Route::delete ('don/suppression/{don}' , [DonController::class, 'destroy']);
