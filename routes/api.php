<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContacterController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\PersonnelSanteController;
use App\Http\Controllers\CalculPeriodeOvulationController;
use App\Http\Controllers\DossierMedicalController;
use App\Http\Controllers\RessourcePlanificationFamilialeController;
use App\Http\Controllers\InformationPlanificationFamilialeController;

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

Route::post('register_utilisateur', [UtilisateurController::class,'store']);
Route::post('/create_personnelsante', [PersonnelSanteController::class, 'store']);
Route::post('envoie_message', [ContacterController::class, 'store']);


Route::middleware(['auth:api', 'role:personnelsante'])->group(function () {
    Route::get('liste_ressource', [RessourcePlanificationFamilialeController::class, 'index']);
    Route::get('detail_ressource/{id}', [RessourcePlanificationFamilialeController::class, 'show']);
    Route::post('enregistrerDossierMedical/{id}', [DossierMedicalController::class, 'store']);
    Route::post('whatsapps.patiente/{id}', [ContacterController::class, 'redirigerWhatsApp']);
    Route::get('listetotaleDM', [DossierMedicalController::class, 'index']);
    Route::get('/DetailDM/{dossierMedical}', [DossierMedicalController::class, 'show']);
    Route::put('/updateDM/{dossier_Medical}', [DossierMedicalController::class, 'update']);
    Route::post('recherche', [DossierMedicalController::class, 'recherche']);
    Route::post('archiver', [DossierMedicalController::class, 'destroy']);
    Route::post('telechargerDM/{id}', [DossierMedicalController::class, 'telechargerDossier']);

    Route::post('calculate-ovulations', [CalculPeriodeOvulationController::class, 'calculateOvulation']);
    Route::get('liste_informations', [InformationPlanificationFamilialeController::class, 'index']);
    Route::get('detail_informations/{id}', [InformationPlanificationFamilialeController::class, 'show']);

});


Route::middleware(['auth:api', 'role:utilisateur'])->group(function () {
    Route::post('calculate-ovulation', [CalculPeriodeOvulationController::class, 'calculateOvulation']);
    Route::get('liste_information', [InformationPlanificationFamilialeController::class, 'index']);
    Route::get('detail_information/{id}', [InformationPlanificationFamilialeController::class, 'show']);
});


Route::middleware(['auth:api', 'role:patiente'])->group(function () {
    Route::post('whatsap.patiente/{id}', [ContacterController::class, 'redirigerWhatsApp']);
    
    Route::post('calculate-ovulatio', [CalculPeriodeOvulationController::class, 'calculateOvulation']);
    Route::get('liste_informatio', [InformationPlanificationFamilialeController::class, 'index']);
    Route::get('detail_informatio/{id}', [InformationPlanificationFamilialeController::class, 'show']);

});

Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::get('liste_personnelsante', [PersonnelSanteController::class, 'index'])->name('liste_invalide');
    Route::get('liste_personnelsantevalide', [PersonnelSanteController::class, 'listevalide']);
    Route::get('liste_utilisateur', [UtilisateurController::class, 'index']);
    Route::put('valider/{id}', [AdminController::class, 'validerInscription']); // Valider l'inscription
    Route::put('invalider/{id}', [AdminController::class, 'invaliderInscription']); // Invalider l'inscription
    Route::post('create-ressource', [RessourcePlanificationFamilialeController::class, 'store']);
    Route::post('create-information', [InformationPlanificationFamilialeController::class, 'store']);
    Route::put('update-ressource/{id}', [RessourcePlanificationFamilialeController::class, 'update']);
    Route::get('liste_message', [ContacterController::class, 'index']);
    Route::delete('supprimer_message/{id}', [ContacterController::class, 'destroy']);

});
