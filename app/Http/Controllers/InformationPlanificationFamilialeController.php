<?php

namespace App\Http\Controllers;

use App\Models\Information_Planification_Familiale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InformationPlanificationFamilialeController extends Controller
{
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
    public function store(Request $request)
    {
        $request->validate([
            'titre' => ['required', 'string'],
            'texte' => ['required', 'string'],
            'image' => ['nullable','image', 'mimes:jpeg,png,jpg,gif'],
        ]);

    $information = new Information_Planification_Familiale();
        $information->titre = $request->titre;
        $information->texte = $request->texte;

        if ($request->file('image')) {
            $imageFile = $request->file('image');
            $filename = date('YmdHi') . $imageFile->getClientOriginalName();
            $imageFile->move(public_path('images'), $filename);
            $information->image = $filename;
        }

        $information->admin_id = Auth::id(); 

        $information->save();

        if ($information->id) {
            return response()->json([
                
    
                'code_valide' => 200,
                'message' => 'Les informations sur la planification familiale a été enregistrée avec succès.',
            ]);
        } else {
            
  
            return response()->json([
                'code_valide' => 500,
                'message' => 'Échec de l\'enregistrement de la information$information de planification familiale.',
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
    public function update(Request $request, Information_Planification_Familiale $id)
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
           
            // Vérifier si l'utilisateur authentifié a le rôle 'admin' et s'il est l'auteur de l'information'
            if (Auth::user()->role === 'admin' && Auth::id() === $information_Planification_Familiale[0]->admin_id) {
                // Valider les données du formulaire
                
                $request->validate([
                    'titre' => ['required', 'string'],
                    'texte' => ['required', 'string'],
                    'image' => ['image', 'mimes:jpeg,png,jpg,gif'],
                ]);

                // Mettre à jour les attributs de l'information
                $information_Planification_Familiale[0]->titre = $request->titre;
                $information_Planification_Familiale[0]->texte = $request->texte;
            
                // Mettre à jour l'image si elle est fournie
                if ($request->file('image')) {
                    $imageFile = $request->file('image');
                    $filename = date('YmdHi') . $imageFile->getClientOriginalName();
                    $imageFile->move(public_path('images'), $filename);
                    $information_Planification_Familiale[0]->image = $filename;
                }

                // Sauvegarder les modifications
                $information_Planification_Familiale[0]->save();

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
        // Rechercher l'nformation par son identifiant
        $information = Information_Planification_Familiale::findOrFail($id);

        if (!$information) {
                        return response()->json([
                            'code_valide' => 404,
                            'message' => 'Information non trouvée.',
                        ], 404);
                    }
            
                    // Vérifier si l'utilisateur authentifié a le rôle 'admin' et s'il est l'auteur de la inform
                    $user = auth()->user();
                    if ($user->role === 'admin' && $user->id === $information->admin_id) {
                        // Supprimer l'image associée à la inform si elle existe
                        if ($information->image) {
                            $imagePath = public_path('images') . '/' . $information->image;
                            if (file_exists($imagePath)) {
                                unlink($imagePath);
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
