<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeCommentaireRequest;
use App\Http\Requests\storeUpdateCommentaireRequest;
use App\Models\Commentaire;
use App\Models\Forum_Communication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Annotations\GestiondescommentairesAnnotationController;

class CommentaireController extends Controller
{
    public function __construct(){

        
        /**
         * @GestiondescommentairesAnnotationController
         */
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
{
   //
}




    public function participerForum(storeCommentaireRequest $request, $forumId)
    {
        try {
            // Vérifier si l'utilisateur est authentifié
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'message' => 'Utilisateur non authentifié.',
                ], 401);
            }

            // Vérifier si le forum existe
            $forum = Forum_Communication::findOrFail($forumId);

            // Créer un nouveau commentaire
            $commentaire = new Commentaire();
            $commentaire->texte = $request->texte;

            // Associer le commentaire au forum et à l'utilisateur
            $commentaire->forum_communication_id = $forum->id;
            $commentaire->user_id = $user->id;

            // Enregistrer le commentaire
            $commentaire->save();

            return response()->json([
                'message' => 'Commentaire ajouté avec succès.',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Une erreur s\'est produite lors de la participation au forum.',
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($forumId)
    {
        try {
            // Vérifier si le forum existe
            $forum = Forum_Communication::findOrFail($forumId);
    
            // Récupérer les commentaires avec les noms des utilisateurs
            $commentaires = Commentaire::where('forum_communication_id', $forum->id)
                ->with(['user:id,nom']) // Sélectionner uniquement l'ID et le nom de l'utilisateur
                ->get(['id','texte', 'user_id']);
    
            // Formater les données pour la réponse
            $formattedCommentaires = $commentaires->map(function ($commentaire) {
                return [
                    'id' => $commentaire->id,
                    'texte' => $commentaire->texte,
                    'nom' => $commentaire->user->nom,
                ];
            });
    
            return response()->json([
                'message' => 'Liste des commentaires récupérée avec succès.',
                'forum' => [
                    'titre' => $forum->titre,
                    'texte' => $forum->texte,
                    'image' => $forum->image,
                ],
                'commentaires' => $formattedCommentaires,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Une erreur s\'est produite lors de la récupération des données du forum et des commentaires.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    

    




    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Commentaire $commentaire)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(storeUpdateCommentaireRequest $request, Commentaire $commentaire)
{
    try {
        // Vérifiez si l'utilisateur authentifié est le propriétaire du commentaire
        $user = auth()->user();
        if ($commentaire->user_id !== $user->id) {
            return response()->json([
                'code_valide' => 403,
                'message' => 'Accès non autorisé. Vous n\'êtes pas autorisé à mettre à jour ce commentaire.',
            ], 403);
        }

        // Update the comment text
        $commentaire->texte = $request->texte;
        $commentaire->save();

        return response()->json([
            'code_valide' => 200,
            'message' => 'Commentaire mis à jour avec succès.',
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'code_valide' => 500,
            'message' => 'Erreur lors de la mise à jour du commentaire.',
            'error' => $e->getMessage(),
        ], 500);
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commentaire $commentaire, $id)
    {
        try {
            // Vérifier si le commentaire existe
            $commentaire = Commentaire::findOrFail($id);

            // Vérifier si l'utilisateur authentifié est l'auteur du commentaire ou s'il a le rôle d'administrateur
            if (!($commentaire->user_id == auth()->user()->id || auth()->user()->role == 'admin')) {
                return response()->json([
                    'message' => 'Vous n\'êtes pas autorisé à supprimer ce commentaire.',
                ], 403);
            }

            // Supprimer le commentaire
            $commentaire->delete();

            return response()->json([
                'message' => 'Le commentaire a été supprimé avec succès.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Une erreur s\'est produite lors de la suppression du commentaire.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
