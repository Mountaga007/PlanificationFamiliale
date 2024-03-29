<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeInformationPlanificationFamilialeRequest;
use App\Http\Requests\storeUpdateInformationPFRequest;
use App\Models\Information_Planification_Familiale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Annotations\GestiondescontenuesAnnotationController;

class InformationPlanificationFamilialeController extends Controller
{

    public function __construct()
    {
        /**
         * @GestiondescontenuesAnnotationController
         */
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Récupérer toutes les informations de la base de données
            $information = Information_Planification_Familiale::all();

            // Retourner la liste des informations en tant que réponse JSON
            return response()->json([
                'code_valide' => 200,
                'message' => 'Liste des informations de planification familiale a été bien récupérée, avec succès.',
                'liste_des_informations' => $information,
            ]);
        } catch (\Exception $e) {
            // Gérer les erreurs avec un message approprié
            return response()->json([
                'code_valide' => 500,
                'message' => 'Erreur lors de la récupération de la liste des informations de planification familiale.',
                'error' => $e->getMessage(),
            ]);
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
    public function store(storeInformationPlanificationFamilialeRequest $request)
    {
        try {
    
            // Récupérer l'utilisateur authentifié
            $admin = auth()->user();
    
            // Créer une instance du modèle Information_Planification_Familiale avec les données validées
            $information = new Information_Planification_Familiale([
                'titre' => $request->titre,
                'texte' => $request->texte,
            ]);
    
            // Gérer l'image s'il y en a une.
            if ($request->hasFile('image')) {
                $imageFile = $request->file('image');
                $filename = date('YmdHi') . $imageFile->getClientOriginalName();
                $imageFile->move(public_path('images'), $filename);
                $information->image = $filename;
            }
    
            // Gérer le fichier PDF s'il y en a un.
            if ($request->hasFile('document')) {
                $pdfFile = $request->file('document');
                $pdfFilename = date('YmdHi') . $pdfFile->getClientOriginalName();
                $pdfFile->move(public_path('pdf_files'), $pdfFilename);
                $information->document = $pdfFilename;
            }
    
            // Assigner l'administrateur authentifié comme créateur de l\'information
            $information->admin_id = $admin->id;
    
            // Sauvegarder l\'information
            $information->save();
    
            // Vérifier si la sauvegarde a réussi
            if ($information->id) {
                return response()->json([
                    'code_valide' => 200,
                    'message' => 'L\'information de planification familiale a été enregistrée avec succès.',
                ]);
            } else {
                return response()->json([
                    'code_valide' => 500,
                    'message' => 'Échec de l\'enregistrement de l\'information de planification familiale.',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'code_valide' => 500,
                'message' => 'Une erreur s\'est produite lors de la création de l\'information de planification familiale.',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
{
    try {
        $information = Information_Planification_Familiale::findOrFail($id);

        return response()->json([
            'code_valide' => 200,
            'message' => 'Détails de l\'information récupérés avec succès.',
            'liste_des_details_informations' => $information,
        ]);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'code_valide' => 404,
            'message' => 'Information non trouvée.',
        ], 404);
    } catch (\Exception $e) {
        return response()->json([
            'code_valide' => 500,
            'message' => 'Erreur lors de la récupération des détails de l\'information.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Information_Planification_Familiale $information_Planification_Familiale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(storeInformationPlanificationFamilialeRequest $request, $id)
{
  try {
    $information_Planification_Familiale = Information_Planification_Familiale::find($id);

    // Vérifier si l'information existe
    if (!$information_Planification_Familiale) {
      return response()->json([
        'code_valide' => 404,
        'message' => 'Information non trouvée.',
      ], 404);
    }

    // Vérifier si l'utilisateur authentifié a le rôle 'admin' et s'il est l'auteur de l'information
    if (auth()->user()->role === 'admin' && auth()->id() === $information_Planification_Familiale->admin_id) {

      // Mettre à jour les attributs de l'information
      $information_Planification_Familiale->titre = $request->input('titre');
      $information_Planification_Familiale->texte = $request->input('texte');

      // Mettre à jour l'image si elle est fournie
      if ($request->file('image')) {
        $imageFile = $request->file('image');
        $filename = date('YmdHi') . $imageFile->getClientOriginalName();
        $imageFile->move(public_path('images'), $filename);
        $information_Planification_Familiale->image = $filename;
      }

      // Mettre à jour le document si il est fourni
      if ($request->file('document')) {
        $pdfFile = $request->file('document');
        $pdfFilename = date('YmdHi') . $pdfFile->getClientOriginalName();
        $pdfFile->move(public_path('pdf_files'), $pdfFilename);
        $information_Planification_Familiale->document = $pdfFilename;
      }

      // Sauvegarder les modifications
      $information_Planification_Familiale->save();

      return response()->json([
        'code_valide' => 200,
        'message' => 'L\'information de planification familiale a été mise à jour avec succès.',
      ]);
    } else {
      // Retourner un message d'erreur si l'utilisateur n'a pas le rôle 'admin' ou n'est pas l'auteur de l'information
      return response()->json([
        'code_valide' => 403,
        'message' => 'Vous n\'avez pas les autorisations nécessaires pour mettre à jour cette information.',
      ], 403);
    }
  } catch (\Exception $e) {
    // Gérer les erreurs avec un message approprié
    return response()->json([
      'code_valide' => 500,
      'message' => 'Erreur lors de la mise à jour de l\'information de planification familiale.',
      'error' => $e->getMessage(),
    ]);
  }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    try {
        // Rechercher l'information par son identifiant
        $information = Information_Planification_Familiale::findOrFail($id);

        if (!$information) {
                        return response()->json([
                            'code_valide' => 404,
                            'message' => 'Information non trouvée.',
                        ], 404);
                    }
            
                    // Vérifier si l'utilisateur authentifié a le rôle 'admin' et s'il est l'auteur de l'information.
                    $user = auth()->user();
                    if ($user->role === 'admin' && $user->id === $information->admin_id) {
                        // Supprimer l'image associée à l'information si elle existe
                        if ($information->image) {
                            $imagePath = public_path('images') . '/' . $information->image;
                            if (file_exists($imagePath)) {
                                unlink($imagePath);
                            }
                        }

                        // Supprimer le document associé à l'information s'il existe
                        if ($information->document) {
                            $pdfPath = public_path('pdf_files') . '/' . $information->document;
                            if (file_exists($pdfPath)) {
                                unlink($pdfPath);
                            }
                        }
            
                        // Supprimer l'information de la base de données
                        $information->delete();
            
                        return response()->json([
                            'code_valide' => 200,
                            'message' => 'L\'information de la planification familiale a été supprimée avec succès.',
                        ]);
                    } else {
                        // Retourner un message d'erreur si l'utilisateur n'a pas le rôle 'admin' ou n'est pas l'auteur de la inform
                        return response()->json([
                            'code_valide' => 403,
                            'message' => 'Vous n\'avez pas les autorisations nécessaires pour supprimer cette inform.',
                        ], 403);
                    }
         } 
         catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Gérer l'erreur si la ressource n'est pas trouvée
            return response()->json([
                'code_valide' => 404,
                'message' => 'Ressource non trouvée.',
            ], 404);
    
        }
            catch (\Exception $e) {
                 // Gérer les autres erreurs avec un message approprié
            return response()->json([
            'code_valide' => 500,
            'message' => 'Erreur lors de la suppression de la inform de planification familiale.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

}