<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeDossierMedicalRequest;
use App\Http\Requests\storeRechercheRequest;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Dossier_Medical;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\Foreach_;
use TCPDF;


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
            $listeDossiersMedicaux = $user->personnelSante->dossiersMedicaux;

             // Récupérer les détails de l'utilisateur avec la liste des dossiers médicaux associées
            $information=[];
            foreach ($listeDossiersMedicaux as $listeDossiersMedical) {
                $utilisateur = User::where('id', $listeDossiersMedical->user_id)->first();
                $information[] = [
                    'information_du_dossier_medical' => $listeDossiersMedical,
                    'information_de_utilisateur' => $utilisateur
                ];
            }

            return response()->json([
                'code_valide' => 200,
                'message' => 'La liste des détails de tous les dossiers a été bien récupérée.',
                'Liste des dossiers medicaux' => $information,
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

    // Liste totale des dossiers médicaux
    public function liste_general_dossier_medical()
{
    try {
        // Récupérer la liste des dossiers médicaux avec les détails de l'utilisateur
        $listeDossiersMedicaux = Dossier_Medical::all();
        $information=[];
        foreach ($listeDossiersMedicaux as $listeDossiersMedical) {
            $utilisateur=User::where('id', $listeDossiersMedical->user_id)->first();
            $information[]=[
                'information_du_dossier_medical'=> $listeDossiersMedical,
                'information_de_utilisateur'=> $utilisateur
            ];
            
        }
        return response()->json([
            'code_valide' => 200,
            'message' => 'La liste des détails de tous les dossiers a été bien récupérée.',
            'Liste des dossiers medicaux' => $information,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'code_valide' => 500,
            'message' => 'Une erreur s\'est produite lors de la récupération des dossiers médicaux.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

    // Liste des utilisateurs avec un dossier médical
public function liste_utilisateur_dossier_medical()
{
    try {
        // Récupérer la liste des utilisateurs avec leurs informations pertinentes
        $listeUtilisateurs = User::whereHas('dossierMedical') // Vérifier si l'utilisateur a un dossier médical associé
            ->where('role', 'utilisateur')
            ->select('id', 'nom', 'email', 'telephone', 'role')
            ->get();

        if ($listeUtilisateurs->isEmpty()) {
            // Si la liste est vide, renvoyer un message approprié
            return response()->json([
                'code_valide' => 200,
                'message' => "Il n'y a pas d'utilisateur avec un dossier médical pour le moment. Liste des utilisateurs est vide.",
                'liste_utilisateurs' => [],
            ]);
        }

        return response()->json([
            'code_valide' => 200,
            'message' => 'La liste des utilisateurs avec un dossier médical a été bien récupérée.',
            'liste_utilisateurs' => $listeUtilisateurs,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'code_valide' => 500,
            'message' => 'Une erreur s\'est produite lors de la récupération de la liste des utilisateurs.',
            'error' => $e->getMessage(),
        ], 500);
    }
}





// public function recherche(Request $request)
// {
//     try {
//         $user = User::where('telephone', $request->telephone)->first();

//         if ($user) {

//             // Vérifier si l'utilisateur a déjà un dossier médical
//             $dossier_Medical = Dossier_Medical::all();
//             foreach ($dossier_Medical as $dossier) {
//                 if ($user->id === $dossier->user_id) {
//                     return response()->json([
//                         'code_valide' => 409,
//                         'message' => 'L\'utilisateur a déjà un dossier médical.',
//                         'dossier_medical_id' => $user->dossierMedical->id,
//                     ], 409);
//                 }
//             }
        
            
//                 return response()->json([
//                     'code_valide' => 200,
//                     'message' => 'Utilisateur trouvé. Veuillez compléter le formulaire pour créer un dossier médical.',
//                     'user' => $user,
//                 ], 200);
            
//              } else {
//              // Rediriger vers le formulaire d'inscription
//              return redirect()->to(urlinscription);
//             // return response()->json([
                
//             //     'code_valide' => 404,
//             //     'message' => 'Aucun utilisateur trouvé avec le numéro de téléphone fourni. Veuillez vous inscrire.',
//             // ], 404);
//         }
//     } catch (ModelNotFoundException $e) {
//             return redirect()->route('recherche');
//         }
    
//     catch (\Exception $e) {
//         // Une erreur s'est produite
//         return response()->json([
//             'code_valide' => 500,
//             'message' => 'Erreur lors de la recherche d\'utilisateur.',
//             'error' => $e->getMessage(),
//         ], 500);
//     }
// }

public function recherche(storeRechercheRequest $request)
{
    try {
        
        $user = User::where('telephone', $request->telephone)->first();

        if ($user) {
            // Vérifier si l'utilisateur a déjà un dossier médical
            if ($user->dossierMedical()->exists()) {
                return response()->json([
                    'code_valide' => 409,
                    'message' => 'L\'utilisateur a déjà un dossier médical.',
                    'dossier_medical_id' => $user->dossierMedical->id,
                ], 409);
            }

            return response()->json([
                'code_valide' => 200,
                'message' => 'Utilisateur trouvé. Veuillez compléter le formulaire pour créer un dossier médical.',
                'user' => $user,
            ], 200);
        } else {
            // Rediriger vers le formulaire d'inscription
            //return redirect()->route('nom_de_la_route_du_formulaire_inscription');
        }
    } catch (ModelNotFoundException $e) {
        // L'utilisateur n'a pas été trouvé
        return response()->json([
            'code_valide' => 404,
            'message' => 'Utilisateur non trouvé.',
        ], 404);
    } catch (\Exception $e) {
        // Une erreur s'est produite
        return response()->json([
            'code_valide' => 500,
            'message' => 'Erreur lors de la recherche d\'utilisateur.',
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

            // Créer le dossier médical lié à l'utilisateur et au personnel de santé
            $dossier_Medical = new Dossier_Medical();
            $dossier_Medical->user_id = $request->id;
            $dossier_Medical->statut = $request->statut;
            $dossier_Medical->numero_Identification = $request->numero_Identification;
            $dossier_Medical->age = $request->age;
            $dossier_Medical->poste_avortement = $request->poste_avortement; 
            $dossier_Medical->poste_partum = $request->poste_partum;
            $dossier_Medical->methode_en_cours = $request->methode_en_cours;
            $dossier_Medical->methode = $request->methode;
            $dossier_Medical->methode_choisie = $request->methode_choisie;
            $dossier_Medical->preciser_autres_methodes = $request->preciser_autres_methodes;
            $dossier_Medical->raison_de_la_visite = $request->raison_de_la_visite;
            $dossier_Medical->indication = $request->indication;  
            $dossier_Medical->effets_indesirables_complications = $request->effets_indesirables_complications;
            $dossier_Medical->date_visite = $request->date_visite;
            $dossier_Medical->date_prochain_rv = $request->date_prochain_rv;
    
            // Assurez-vous que le personnel de santé associé existe
            if ($user->role=='personnelsante') {
                $dossier_Medical->personnelsante_id = $user->PersonnelSante->id;
            } else {
                // Gérer le cas où le personnel de santé n'est pas trouvé
                throw new \Exception("Personnel de santé non trouvé.");
            }
    
            // Enregistrez le dossier médical
            $dossier_Medical->save();
    
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
       
        $user = User::where('id',$dossierMedical->user_id)->first();
    
        if ($user) {
            // Retourner les détails du dossier médical en tant que réponse JSON
            return response()->json([
                'code_valide' => 200,
                'message' => 'Les détails du dossier médical récupérés avec succès.',
                'liste_des_details_dossier_medical' => $dossierMedical,
                'liste_des_details_patiente' => $user,
            ]);
        } else {
            // Gérer le cas où l'utilisateur associé n'est pas trouvé
            return response()->json([
                'code_valide' => 404,
                'message' => 'Utilisateur (patiente) associé au dossier médical non trouvé.',
            ], 404);
        }
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        // Gérer l'erreur si la dossier médical n'est pas trouvée
        return response()->json([
            'code_valide' => 404,
            'message' => 'Dossier médical non trouvée.',
        ], 404);
    } catch (\Exception $e) {
        // Gérer les autres erreurs avec un message approprié
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
public function update(Request $request, Dossier_Medical $dossier_Medical)
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
            'statut' => $request->statut,
            'numero_Identification' => $request->numero_Identification,
            'age' => $request->age,
            'poste_avortement' => $request->poste_avortement,
            'poste_partum' => $request->poste_partum,
            'methode_en_cours' => $request->methode_en_cours,
            'methode' => $request->methode,
            'methode_choisie' => $request->methode_choisie,
            'preciser_autres_methodes' => $request->preciser_autres_methodes,
            'raison_de_la_visite' => $request->raison_de_la_visite,
            'indication' => $request->indication,
            'effets_indesirables_complications' => $request->effets_indesirables_complications,
            'date_visite' => $request->date_visite,
            'date_prochain_rv' => $request->date_prochain_rv,
        ]);

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



// public function telechargerDossier($id)
// {
//     try {
//         // Récupérer le dossier médical en fonction de l'ID avec les relations user et personnelSante
//         $dossierMedical = Dossier_Medical::with(['user', 'personnelSante', 'personnelSante.user'])->findOrFail($id);

//         // Vérifier si le dossier médical appartient au personnel de santé authentifié
//         $user = auth()->user();
//         if ($dossierMedical->personnelsante_id != $user->personnelSante->id) {
//             return response()->json([
//                 'code_valide' => 403,
//                 'message' => 'Accès non autorisé.',
//             ], 403);
//         }

//         // Retourner le résultat avec les relations sans répéter les informations
//         return response()->json([
//             'message' => 'Les détails du dossier médical sont enregistrés avec succès.',
//             'dossier_medical' => [
//                 'id' => $dossierMedical->id, // id de l'utilisateur
//                 'statut' => $dossierMedical->statut,
//                 'numero_Identification' => $dossierMedical->numero_Identification,
//                 'age' => $dossierMedical->age,
//                 'poste_avortement' => $dossierMedical->poste_avortement,
//                 'poste_partum' => $dossierMedical->poste_partum,
//                 'methode_en_cours' => $dossierMedical->methode_en_cours,
//                 'methode' => $dossierMedical->methode,
//                 'methode_choisie' => $dossierMedical->methode_choisie,
//                 'preciser_autres_methodes' => $dossierMedical->preciser_autres_methodes,
//                 'raison_de_la_visite' => $dossierMedical->raison_de_la_visite,
//                 'indication' => $dossierMedical->indication,
//                 'effets_indesirables_complications' => $dossierMedical->effets_indesirables_complications,
//                 'date_visite' => $dossierMedical->date_visite,
//                 'date_prochain_rv' => $dossierMedical->date_prochain_rv,

//                 'user' => [
//                     'id' => $dossierMedical->user->id,
//                     'nom' => $dossierMedical->user->nom,
//                     'email' => $dossierMedical->user->email,
//                     'telephone' => $dossierMedical->user->telephone,
//                     'image' => $dossierMedical->user->image,
//                     'role' => $dossierMedical->user->role,
//                 ],

//                 'personnel_sante' => [
//                     'id' => $dossierMedical->personnelSante->id,
//                     'matricule' => $dossierMedical->personnelSante->matricule,
//                     'structure' => $dossierMedical->personnelSante->structure,
//                     'service' => $dossierMedical->personnelSante->service,
//                     'Personnel_Sante' => [
//                         'nom' => $dossierMedical->personnelSante->user->nom,
//                         'email' => $dossierMedical->personnelSante->user->email,
//                         'telephone' => $dossierMedical->personnelSante->user->telephone,
//                     ],
//                 ],
//             ],
//         ]);
//     } catch (\Exception $e) {
//         return response()->json([
//             'code_valide' => 500,
//             'message' => 'Une erreur s\'est produite lors du téléchargement du dossier médical.',
//             'error' => $e->getMessage(),
//         ], 500);
//     }
// }


public function telechargerDossier($id)
{
    try {
        // Récupérer le dossier médical avec les relations user et personnelSante
        $dossierMedical = Dossier_Medical::with(['user', 'personnelSante', 'personnelSante.user'])->findOrFail($id);

        // Vérifier l'autorisation de l'utilisateur authentifié pour accès au dossier médical
        $user = auth()->user();
        if ($dossierMedical->personnelsante_id != $user->personnelSante->id) {
            return response()->json([
                'code_valide' => 403,
                'message' => 'Accès non autorisé.',
            ], 403);
        }

        // Charger la vue avec les données du dossier médical
        $view = view('dossier_medical', compact('dossierMedical'))->render();

        // Créer une instance de TCPDF
        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->writeHTML($view, true, false, true, false, '');

        // Définir le nom du fichier PDF à télécharger
        $filename = 'dossier_medical_' . $dossierMedical->id . '.pdf';

        // Envoyer le PDF en tant que réponse de téléchargement
        $pdf->Output($filename, 'D');
    } catch (\Exception $e) {
        return response()->json([
            'code_valide' => 500,
            'message' => 'Une erreur s\'est produite lors du téléchargement du dossier médical.',
            'error' => $e->getMessage(),
        ], 500);
    }
}



}
