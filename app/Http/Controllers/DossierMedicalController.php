<?php

namespace App\Http\Controllers;


use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;
use App\Models\Dossier_Medical;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\storeDossierMedicalRequest;
use App\Http\Requests\storeUpdateDossierMedicalRequest;
use Illuminate\Support\Facades\Mail;

class DossierMedicalController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // Liste des dossiers médicaux créés par un personnel de santé
    public function index()
{
  try {
    $user = Auth::user();

    // Assurez-vous que l'utilisateur est lié à un personnel de santé
    if ($user->personnelSante) {
       
      // Récupérer la liste des dossiers médicaux créés par le personnel de santé
      $listeDossiersMedicaux = $user->personnelSante
        ->dossiersMedicaux()
        ->where('archive', false)
        ->get();

      // Vérifier s'il n'y a aucun dossier médical enregistré
      if ($listeDossiersMedicaux->isEmpty()) {
        return response()->json([
          'code_valide' => 200,
          'message' => 'Vous n\'avez enregistré aucun dossier médical.',
        ]);
      }

      // Récupérer la liste des dossiers médicaux avec les détails du personnel de santé
      $dossiersWithPersonnelDetails = $listeDossiersMedicaux->map(function ($dossierMedical) use ($user) {
        return [
          'dossier_medical' => $dossierMedical,
          'personnel_sante' => [
            'nom' => $user->nom,
            'telephone' => $user->telephone,
            'email' => $user->email,
          ],
        ];
      });
      return response()->json([
        'code_valide' => 200,
        'message' => 'La liste des détails de tous les dossiers a été bien récupérée.',
        'Liste des dossiers avec les détails du personnel de santé' => $dossiersWithPersonnelDetails
      ]);
       
    } else {
      return response()->json([
        'code_valide' => 401,
        'message' => 'Vous n\'avez pas les autorisations pour accéder à cet dossier.',
      ], 401);
    }
  } catch (\Exception $e) {
    return response()->json([
      'code_valide' => 500,
      'message' => 'Une erreur s\'est produite lors de la récupération des dossiers médicaux.',
      'error' => $e->getMessage(),
    ], 500);
  }
}

    

    // Liste totale des dossiers médicaux pour l'administrateur
    public function liste_general_dossier_medical()
{
    try {
        // Récupérer la liste des dossiers médicaux avec les détails de l'utilisateur
        $listeDossiersMedicaux = Dossier_Medical::all();
        return response()->json([
            'code_valide' => 200,
            'message' => 'La liste des détails de tous les dossiers a été bien récupérée.',
            'Liste des dossiers medicaux' => $listeDossiersMedicaux,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'code_valide' => 500,
            'message' => 'Une erreur s\'est produite lors de la récupération des dossiers médicaux.',
            'error' => $e->getMessage(),
        ], 500);
    }
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
  

     public function store(storeDossierMedicalRequest $request)
     {
         try {
             // Récupérer l'utilisateur actuel
             $user = auth()->user();
     
             // Vérifier si l'utilisateur a au moins 18 ans
             if ($request->age < 18) {
                 return response()->json([
                     'code_valide' => 400,
                     'message' => 'Cet utilisateur ne peut pas avoir un dossier médical car c\'est encore un mineur. Pour avoir un dossier médical, il faut avoir au moins 18 ans.',
                 ], 400);
             }
     
             // Créer le dossier médical lié à l'utilisateur et au personnel de santé
             $dossier_Medical = new Dossier_Medical();
             $dossier_Medical->prenom = $request->prenom;
             $dossier_Medical->nom = $request->nom;
             $dossier_Medical->telephone = $request->telephone;
             $dossier_Medical->adresse = $request->adresse;
             $dossier_Medical->email = $request->email;
             $dossier_Medical->statut = $request->statut;
             $dossier_Medical->numero_Identification = $request->numero_Identification;
             $dossier_Medical->age = $request->age;
             $dossier_Medical->poste_avortement = $request->poste_avortement;
             $dossier_Medical->poste_partum = $request->poste_partum;
             $dossier_Medical->methode_en_cours = $request->methode_en_cours;
             $dossier_Medical->methode_choisie = $request->methode_choisie;
             $dossier_Medical->preciser_autres_methodes = $request->preciser_autres_methodes;
             $dossier_Medical->raison_de_la_visite = $request->raison_de_la_visite;
             $dossier_Medical->indication = $request->indication;
             $dossier_Medical->effets_indesirables_complications = $request->effets_indesirables_complications;
             $dossier_Medical->date_visite = $request->date_visite;
             $dossier_Medical->date_prochain_rv = $request->date_prochain_rv;
     
             // Vérifier si la date de prochain rendez-vous est supérieure à la date de visite
             if (strtotime($dossier_Medical->date_prochain_rv) <= strtotime($dossier_Medical->date_visite)) {
                 return response()->json([
                     'code_valide' => 400,
                     'message' => 'La date de prochain rendez-vous doit être supérieure à la date de visite.',
                 ], 400);
             }
     
             // Assurez-vous que le personnel de santé associé existe
             if ($user->role == 'personnelsante') {
                 $dossier_Medical->personnelsante_id = $user->personnelSante->id;
             } else {
                 // Gérer le cas où le personnel de santé n'est pas trouvé
                 throw new \Exception("Personnel de santé non trouvé.");
             }
             // Enregistrez le dossier médical
             $dossier_Medical->save();
             // Envoyer un courriel à l'utilisateur pour la prochaine rendez-vous.
             Mail::send('emailrendezvous', [
                 'prenom' => $dossier_Medical->prenom,
                 'nom' => $dossier_Medical->nom,
                 'date_prochain_rv' => $dossier_Medical->date_prochain_rv,
                 'nom_personnel' => $user->nom,
             ],
                 function ($message) use ($request) {
                     $message->to($request->email);
                     $message->subject('Notification de prise de rendez-vous');
                 });
     
             return response()->json([
                 "code_valide" => 200,
                 "message" => "Dossier médical créé avec succès.",
             ], 200);
         } catch (\Exception $e) {
             return response()->json([
                 "code_valide" => 500,
                 "message" => "Une erreur s'est produite lors de la création du dossier médical.",
                 "error" => $e->getMessage(),
             ], 500);
         }
     }
     

    /**
     * Display the specified dossier medical.
     */
    public function show(Dossier_Medical $dossierMedical)
{
  try {
    $dossierMedical = Dossier_Medical::findOrFail($dossierMedical->id);
    
    if ($dossierMedical->archived) {
      // Vérifier si l'utilisateur est un administrateur
      if (auth()->user()->role === 'admin') {
        return response()->json([
          'code_valide' => 200,
          'message' => 'Les détails du dossier médical ont été récupérés avec succès (accès administrateur).',
          'liste_des_details_dossier_medical' => $dossierMedical,
        ]);
      } else {
        return response()->json([
          'code_valide' => 403,
          'message' => 'Accès refusé. Ce dossier médical est archivé et ne peut pas être consulté.',
        ], 403);
      }
    } else {
      return response()->json([
        'code_valide' => 200,
        'message' => 'Les détails du dossier médical ont été récupérés avec succès.',
        'liste_des_details_dossier_medical' => $dossierMedical,
      ]);
    }
  } 
  catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
    return response()->json([
      'code_valide' => 404,
      'message' => 'Dossier médical non trouvé.',
    ], 404);
  } 
  catch (\Exception $e) {
    return response()->json([
      'code_valide' => 500,
      'message' => 'Une erreur s\'est produite lors de la récupération des détails du dossier médical.',
      'error' => $e->getMessage(),
    ]);
  }
}

    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dossier_Medical $dossier_Medical)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    /**
 * Update the specified resource in storage.
 */
public function update(storeUpdateDossierMedicalRequest $request, Dossier_Medical $dossier_Medical)
{
    try {
        // Assurez-vous que le dossier médical existe
        if (!$dossier_Medical) {
            return response()->json([
                'code_valide' => 404,
                'message' => 'Dossier médical non trouvé.',
            ], 404);
        }

        // Vérifiez les autorisations de mise à jour
        $user = auth()->user();
        if ($user->PersonnelSante->id !== $dossier_Medical->personnelsante_id) {
            return response()->json([
                'code_valide' => 401,
                'message' => 'Vous n\'avez pas les autorisations pour modifier le dossier médical.',
            ], 401);
        }

        // Mettez à jour les propriétés du dossier médical avec les nouvelles valeurs
        $dossier_Medical->update([
            'prenom' => $request->prenom,
            'nom' => $request->nom,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'email' => $request->email,
            'statut' => $request->statut,
            'numero_Identification' => $request->numero_Identification,
            'age' => $request->age,
            'poste_avortement' => $request->poste_avortement,
            'poste_partum' => $request->poste_partum,
            'methode_en_cours' => $request->methode_en_cours,
            'methode_choisie' => $request->methode_choisie,
            'preciser_autres_methodes' => $request->preciser_autres_methodes,
            'raison_de_la_visite' => $request->raison_de_la_visite,
            'indication' => $request->indication,
            'effets_indesirables_complications' => $request->effets_indesirables_complications,
            'date_visite' => $request->date_visite,
            'date_prochain_rv' => $request->date_prochain_rv,
        ]);

        // Vérifier si la date de prochain rendez-vous est supérieure à la date de visite
        if (strtotime($dossier_Medical->date_prochain_rv) <= strtotime($dossier_Medical->date_visite)) {
            return response()->json([
                'code_valide' => 400,
                'message' => 'La date de prochain rendez-vous doit être supérieure à la date de visite.',
            ], 400);
        }

        // Rechargez le modèle après la mise à jour
        $dossier_Medical->refresh();

        return response()->json([
            'code_valide' => 200,
            'message' => 'Dossier médical mis à jour avec succès.',
            'dossier_medical' => $dossier_Medical,
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'code_valide' => 500,
            'message' => 'Une erreur s\'est produite lors de la mise à jour du dossier médical.',
            'error' => $e->getMessage(),
        ], 500);
    }
}


    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dossier_Medical $dossier_Medical)
{
    // Vérifier si l'utilisateur authentifié est le créateur du dossier médical
    $user = auth()->user();

    if ($dossier_Medical->archive == true) {
        return response()->json([
            'code_valide' => 200,
            'message' => 'Le dossier médical est déjà archivé.',
        ]);
    }

    // Vérifier si l'utilisateur authentifié est le créateur du dossier médical
    if ($dossier_Medical->personnelsante_id !== $user->personnelSante->id) {
        return response()->json([
            'code_valide' => 403,
            'message' => 'Vous n\'avez pas les autorisations pour archiver ce dossier médical.',
        ], 403);
    }

    // Archiver le dossier médical
    $dossier_Medical->archive = true;
    $dossier_Medical->update();
    //$dossier_Medical->save();

    return response()->json([
        'code_valide' => 200,
        'message' => 'Le dossier médical a été archivé avec succès.',
    ]);
}


public function telechargerDossier($id)
{
    try {
        $dossierMedical = Dossier_Medical::with(['user', 'personnelSante', 'personnelSante.user'])->findOrFail($id);

        $user = auth()->user();
        if ($dossierMedical->personnelsante_id != $user->personnelSante->id) {
            return response()->json([
                'code_valide' => 403,
                'message' => 'Accès non autorisé.',
            ], 403);
        }

        $pdf = PDF::loadView('dossier_medical', compact('dossierMedical'))->setPaper('a4');
        return $pdf->download('Planification_Familiale.pdf');
    } catch (\Exception $e) {
        return response()->json([
            'code_valide' => 500,
            'message' => 'Une erreur s\'est produite lors du téléchargement du dossier médical.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

}
