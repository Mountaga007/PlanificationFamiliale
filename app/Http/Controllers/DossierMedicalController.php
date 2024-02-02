<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Dossier_Medical;
use PhpParser\Node\Stmt\Foreach_;

class DossierMedicalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    try {
        // Récupérer la liste des dossiers médicaux avec les détails du patient
        $listeDossiersMedicaux = Dossier_Medical::all();
        $information=[];
        foreach ($listeDossiersMedicaux as $listeDossiersMedical) {
            $patiente=User::where('id', $listeDossiersMedical->patiente_id)->first();
            $information[]=[
                'information_du_dossier_medical'=> $listeDossiersMedical,
                'information_de_la_patiente'=> $patiente
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


    public function recherche(Request $request)
{
    try {
        $users = User::all();

        foreach ($users as $user) {
            if ($user->telephone === $request->telephone) {
                $user->role = 'patiente';
                $user -> update();
                return response()->json(compact('user'), 200);
            }
        }

        // message du recherche
        return response()->json([
            'code_valide' => 404,
            'message' => 'Aucun utilisateur trouvé avec le numéro de téléphone fourni.',
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
    public function store(Request $request, $id)
    {
        try {
            // Récupérer l'utilisateur actuel
            $user = auth()->user();
            $patiente = User::find($id);
            
            if ($patiente->role === 'patiente') {
            // Créer le dossier médical lié à l'utilisateur et au personnel de santé
            $dossier_Medical = new Dossier_Medical();
            $dossier_Medical->patiente_id = $id;
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
                $dossier_Medical->personnelsante_id = $user->personnelSante->id;
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
            }else {
                return response()->json([
                    "code_valide" => 404,
                    "message" => "Patiente non trouvé.",
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                "code_valide" => 500,
                "message" => "Une erreur s'est produite lors de la création du dossier médical.",
                "error" => $e->getMessage(),
            ], 500);
        }
        
    }
    

    

    /**
     * Display the specified resource.
     */
    public function show(Dossier_Medical $dossierMedical)
{
    try {
       
        $user = User::where('id',$dossierMedical->patiente_id)->first();
    
        if ($user) {
            // Retourner les détails de la ressource en tant que réponse JSON
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
            // Ajoutez d'autres colonnes à mettre à jour ici...
        ]);

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
        //
    }
}
