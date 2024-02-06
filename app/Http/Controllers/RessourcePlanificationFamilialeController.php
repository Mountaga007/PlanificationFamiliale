<?php

namespace App\Http\Controllers;

use App\Models\Ressource_Planification_familiale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RessourcePlanificationFamilialeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Récupérer toutes les ressources de la base de données
            $ressources = Ressource_Planification_familiale::all();

            // Retourner la liste des ressources en tant que réponse JSON
            return response()->json([
                'code_valide' => 200,
                'message' => 'Liste des ressources de planification familiale a été bien récupérée, avec succès.',
                'liste_des_ressources' => $ressources,
            ]);
        } catch (\Exception $e) {
            // Gérer les erreurs avec un message approprié
            return response()->json([
                'code_valide' => 500,
                'message' => 'Erreur lors de la récupération de la liste des ressources de planification familiale.',
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

    $ressource = new Ressource_Planification_familiale();
        $ressource->titre = $request->titre;
        $ressource->texte = $request->texte;

        if ($request->file('image')) {
            $imageFile = $request->file('image');
            $filename = date('YmdHi') . $imageFile->getClientOriginalName();
            $imageFile->move(public_path('images'), $filename);
            $ressource->image = $filename;
        }

        $ressource->admin_id = Auth::id(); 

        $ressource->save();

        if ($ressource->id) {
            return response()->json([
                'code_valide' => 200,
                'message' => 'La ressource de planification familiale a été enregistrée avec succès.',
            ]);
        } else {
            return response()->json([
                'code_valide' => 500,
                'message' => 'Échec de l\'enregistrement de la ressource de planification familiale.',
            ]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
{
    try {
        // Récupérer la ressource par son ID
        $ressource = Ressource_Planification_familiale::findOrFail($id);

        // Retourner les détails de la ressource en tant que réponse JSON
        return response()->json([
            'code_valide' => 200,
            'message' => 'Détails de la ressource récupérés avec succès.',
            'liste_des_details_ressources' => $ressource,
        ]);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        // Gérer l'erreur si la ressource n'est pas trouvée
        return response()->json([
            'code_valide' => 404,
            'message' => 'Ressource non trouvée.',
        ], 404);
    } catch (\Exception $e) {
        // Gérer les autres erreurs avec un message approprié
        return response()->json([
            'code_valide' => 500,
            'message' => 'Erreur lors de la récupération des détails de la ressource.',
            'error' => $e->getMessage(),
        ]);
    }
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ressource_Planification_familiale $ressource_Planification_familiale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    try {
        $ressource_Planification_familiale = Ressource_Planification_familiale::find($id);

        // Vérifier si la ressource existe
        if (!$ressource_Planification_familiale) {
            return response()->json([
                'code_valide' => 404,
                'message' => 'Ressource non trouvée.',
            ], 404);
        }

        // Vérifier si l'utilisateur authentifié a le rôle 'admin' et s'il est l'auteur de la ressource
        if (Auth::user()->role === 'admin' && Auth::id() === $ressource_Planification_familiale->admin_id) {
            // Valider les données du formulaire
            // $request->validate([
            //     'titre' => ['required', 'string'],
            //     'texte' => ['required', 'string'],
            //     'image' => ['image', 'mimes:jpeg,png,jpg,gif'],
            // ]);

            // Mettre à jour les attributs de la ressource
            $ressource_Planification_familiale->titre = $request->titre;
            $ressource_Planification_familiale->texte = $request->texte;

            // Mettre à jour l'image si elle est fournie
            if ($request->file('image')) {
                $imageFile = $request->file('image');
                $filename = date('YmdHi') . $imageFile->getClientOriginalName();
                $imageFile->move(public_path('images'), $filename);
                $ressource_Planification_familiale->image = $filename;
            }

            // Sauvegarder les modifications
            $ressource_Planification_familiale->save();

            return response()->json([
                'code_valide' => 200,
                'message' => 'La ressource de planification familiale a été mise à jour avec succès.',
            ]);
        } else {
            // Retourner un message d'erreur si l'utilisateur n'a pas le rôle 'admin' ou n'est pas l'auteur de la ressource
            return response()->json([
                'code_valide' => 403,
                'message' => 'Vous n\'avez pas les autorisations nécessaires pour mettre à jour cette ressource.',
            ], 403);
        }
    } catch (\Exception $e) {
        // Gérer les erreurs avec un message approprié
        return response()->json([
            'code_valide' => 500,
            'message' => 'Erreur lors de la mise à jour de la ressource de planification familiale.',
            'error' => $e->getMessage(),
        ]);
    }
}


    /**
     * Remove the specified resource from storage.
     */
    // Vérifier si la ressource existe
    
    public function destroy($id)
{
    try {
        // Rechercher la ressource par son identifiant
        $ressource = Ressource_Planification_Familiale::findOrFail($id);
        if (!$ressource) {
            return response()->json([
                'code_valide' => 404,
                'message' => 'Ressource non trouvée.',
            ], 404);
        }

        // Vérifier si l'utilisateur authentifié a le rôle 'admin' et s'il est l'auteur de la ressource
        $user = auth()->user();
        if ($user->role === 'admin' && $user->id === $ressource->admin_id) {
            // Supprimer l'image associée à la ressource si elle existe
            if ($ressource->image) {
                $imagePath = public_path('images') . '/' . $ressource->image;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            // Supprimer la ressource de la base de données
            $ressource->delete();

            return response()->json([
                'code_valide' => 200,
                'message' => 'La ressource de planification familiale a été supprimée avec succès.',
            ]);
        } else {
            // Retourner un message d'erreur si l'utilisateur n'a pas le rôle 'admin' ou n'est pas l'auteur de la ressource
            return response()->json([
                'code_valide' => 403,
                'message' => 'Vous n\'avez pas les autorisations nécessaires pour supprimer cette ressource.',
            ], 403);
        }

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        // Gérer l'erreur si la ressource n'est pas trouvée
        return response()->json([
            'code_valide' => 404,
            'message' => 'Ressource non trouvée.',
        ], 404);

    } catch (\Exception $e) {
        // Gérer les autres erreurs avec un message approprié
        return response()->json([
            'code_valide' => 500,
            'message' => 'Erreur lors de la suppression de la ressource de planification familiale.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

}
