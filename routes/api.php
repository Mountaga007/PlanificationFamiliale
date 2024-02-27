<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContacterController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\PersonnelSanteController;
use App\Http\Controllers\CalculPeriodeOvulationController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\DossierMedicalController;
use App\Http\Controllers\ForumCommunicationController;
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

], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class ,'me']);

});

Route::post('/create_personnelsante', [PersonnelSanteController::class, 'store']);
Route::post('register_utilisateur', [UtilisateurController::class,'store']);
Route::post('envoie_message', [ContacterController::class, 'store']);

Route::get('liste_information', [InformationPlanificationFamilialeController::class, 'index']);
Route::get('detail_information/{id}', [InformationPlanificationFamilialeController::class, 'show']);


Route::middleware(['auth:api', 'role:personnelsante'])->group(function () {
    Route::post('enregistrer_Dossier_Medical', [DossierMedicalController::class, 'store']);
    Route::put('/update_DM/{dossier_Medical}', [DossierMedicalController::class, 'update']);
    //Route::post('recherche_DM', [DossierMedicalController::class, 'recherche']);
    Route::delete('archiver_DM/{dossier_Medical}', [DossierMedicalController::class, 'destroy']);

    Route::get('listes_ressource', [RessourcePlanificationFamilialeController::class, 'index']);
    Route::get('details_ressource/{id}', [RessourcePlanificationFamilialeController::class, 'show']);
    Route::get('listes_information', [InformationPlanificationFamilialeController::class, 'index']);
    Route::get('details_information/{id}', [InformationPlanificationFamilialeController::class, 'show']);
    Route::get('listes_totale_DM', [DossierMedicalController::class, 'index']);
    Route::get('/Details_DM/{dossierMedical}', [DossierMedicalController::class, 'show']);
    Route::post('telechargers_DM/{id}', [DossierMedicalController::class, 'telechargerDossier']);

    Route::post('whatsapp.user/{id}', [ContacterController::class, 'redirigerWhatsApp']);

});

Route::middleware(['auth:api'])->group(function () {
    Route::post('create_forum', [ForumCommunicationController::class, 'store']);
    Route::get('liste_forum', [ForumCommunicationController::class, 'index']);
    Route::get('detail_forum/{id}', [ForumCommunicationController::class, 'show']);
    Route::post('update_forum/{forum_Communication}', [ForumCommunicationController::class, 'update']);
    Route::delete('supprimer_forum/{id}', [ForumCommunicationController::class, 'destroy']);
    Route::get('Detail_commentaire_un_forum/{forumId}', [CommentaireController::class, 'show']);
    Route::delete('supprimer_commentaire/{id}', [CommentaireController::class, 'destroy']);

    Route::post('creer_commentaire_forum/{forumId}', [CommentaireController::class, 'participerForum']);
    Route::put('update_commentaire/{commentaire}', [CommentaireController::class, 'update']);
    Route::post('calculer_periode_ovulation', [CalculPeriodeOvulationController::class, 'calculateOvulation']);
});

Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::get('liste_personnelsante', [PersonnelSanteController::class, 'index']);
    Route::get('liste_personnelsante_valide', [PersonnelSanteController::class, 'listevalide']);
    Route::get('liste_utilisateur', [UtilisateurController::class, 'index']);
    //Route::get('liste_utilisateur_DM', [DossierMedicalController::class, 'liste_utilisateur_dossier_medical']);
    Route::put('valider/{id}', [AdminController::class, 'validerInscription']);
    Route::put('invalider/{id}', [AdminController::class, 'invaliderInscription']);
    Route::post('create_ressource', [RessourcePlanificationFamilialeController::class, 'store']);
    Route::post('create_information', [InformationPlanificationFamilialeController::class, 'store']);
    Route::put('update_ressource/{id}', [RessourcePlanificationFamilialeController::class, 'update']);
    Route::put('update_information/{id}', [InformationPlanificationFamilialeController::class, 'update']);
    Route::delete('supprimer_information/{id}', [InformationPlanificationFamilialeController::class, 'destroy']);
    Route::delete('supprimer_ressource/{id}', [RessourcePlanificationFamilialeController::class, 'destroy']);
    Route::get('liste_message', [ContacterController::class, 'index']);
    Route::delete('supprimer_message/{contacter}', [ContacterController::class, 'destroy']);

    Route::get('liste_ressource', [RessourcePlanificationFamilialeController::class, 'index']);
    Route::get('detail_ressource/{id}', [RessourcePlanificationFamilialeController::class, 'show']);
    Route::get('liste_information', [InformationPlanificationFamilialeController::class, 'index']);
    Route::get('detail_information/{id}', [InformationPlanificationFamilialeController::class, 'show']);
    Route::get('listes_generale_DM', [DossierMedicalController::class, 'liste_general_dossier_medical']);
    Route::get('/Detail_DM/{dossierMedical}', [DossierMedicalController::class, 'show']);
    Route::post('telecharger_DM/{id}', [DossierMedicalController::class, 'telechargerDossier']);
    
   Route::delete('supprimer_commentaire_admin/{id}', [CommentaireController::class, 'destroy']);

});