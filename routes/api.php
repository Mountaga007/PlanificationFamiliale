<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\CalculPeriodeOvulation;
use App\Http\Controllers\InformationPlanificationFamilialeController;
use App\Http\Controllers\PersonnelSanteController;
use App\Http\Controllers\RessourcePlanificationFamilialeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class ,'me']);

});

Route::post('create_utilisateur', [UtilisateurController::class,'store']);
Route::post('/create-personnelsante', [PersonnelSanteController::class, 'store'])->name('store');
Route::get('liste_ressource', [RessourcePlanificationFamilialeController::class, 'index']);
Route::get('liste_information', [InformationPlanificationFamilialeController::class, 'index']);





Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::get('liste_personnelsante', [PersonnelSanteController::class, 'index'])->name('liste_invalide');
    Route::get('liste_personnelsantevalide', [PersonnelSanteController::class, 'listevalide']);
    Route::get('liste_utilisateur', [UtilisateurController::class, 'index']);
    Route::put('valider/{id}', [AdminController::class, 'validerInscription']); // Valider l'inscription
    Route::put('invalider/{id}', [AdminController::class, 'invaliderInscription']); // Invalider l'inscription
    Route::post('create-ressource', [RessourcePlanificationFamilialeController::class, 'store']);
    Route::post('create-information', [InformationPlanificationFamilialeController::class, 'store']);

});
