<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeCommentaireRequest;
use App\Models\Commentaire;
use App\Models\Forum_Communication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    try {
        // Récupérer la liste de tous les forums
        $forums = Forum_Communication::all();

        // Initialiser un tableau pour stocker les données
        $forumsData = [];

        // Boucler à travers chaque forum
        foreach ($forums as $forum) {
            // Récupérer les données du forum
            $forumData = [
                'id' => $forum->id,
                'titre' => $forum->titre,
                'texte' => $forum->texte,
                'image' => $forum->image,
            ];

            // Récupérer la liste des commentaires pour le forum spécifié avec le nom de l'utilisateur
            $commentaires = Commentaire::where('forum_communication_id', $forum->id)
                ->with('user:id,nom') // Charger uniquement l'id et le nom de l'utilisateur associé au commentaire
                ->get();

            // Ajouter les commentaires au tableau de données du forum
            $forumData['commentaires'] = $commentaires;

            // Ajouter les données du forum au tableau principal
            $forumsData[] = $forumData;
        }

        return response()->json([
            'message' => 'Liste des forums avec commentaires récupérée avec succès.',
            'forums' => $forumsData,
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Une erreur s\'est produite lors de la récupération des données des forums et des commentaires.',
            'error' => $e->getMessage(),
        ], 500);
    }
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
                'commentaire' => $commentaire,
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

        $commentaires = Commentaire::where('forum_communication_id', $forum->id)
    ->with(['user' => function($query) {
        $query->select('id', 'nom'); // Sélectionner uniquement l'ID et le nom de l'utilisateur
    }])
    ->get(['texte', 'user_id']);

        return response()->json([
            'message' => 'Liste des commentaires récupérée avec succès.',
            'forum' => [
                'titre' => $forum->titre,
                'texte' => $forum->texte,
                'image' => $forum->image,
            ],
            'commentaires' => $commentaires,
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
    public function update(Request $request, Commentaire $commentaire)
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

        // Validate the request data
        $request->validate([
            'texte' => ['required', 'string'],
        ]);

        // Update the comment text
        $commentaire->texte = $request->texte;
        $commentaire->save();

        return response()->json([
            'code_valide' => 200,
            'message' => 'Commentaire mis à jour avec succès.',
            'commentaire' => $commentaire,
        ]);
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

            // Vérifier si l'utilisateur authentifié est l'auteur du commentaire
            if ($commentaire->user_id != auth()->user()->id) {
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
