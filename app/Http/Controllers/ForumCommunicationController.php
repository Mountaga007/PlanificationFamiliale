<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeForumCommunicationRequest;
use App\Models\Forum_Communication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumCommunicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $forums = Forum_Communication::all();

            return response()->json([
                'message' => 'Liste des forums récupérée avec succès.',
                'forums' => $forums,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Une erreur s\'est produite lors de la récupération des forums.',
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
    public function store(storeForumCommunicationRequest $request)
{
    try {

        // Créer une instance du modèle Forum_Communication avec les données validées
        $forum = new Forum_Communication([
            'titre' => $request->titre,
            'texte' => $request->texte,
        ]);

        // Gérer l'image s'il y en a une
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $filename = date('YmdHi') . $imageFile->getClientOriginalName();
            $imageFile->move(public_path('images'), $filename);
            $forum->image = $filename;
        }
            $forum->user_id = Auth()->user()->id;
        // Sauvegarder le forum
        $forum->save();

        // Vérifier si la sauvegarde a réussi
        if ($forum->id) {
            return response()->json([
                'code_valide' => 200,
                'message' => 'Forum de communication créé avec succès.',
            ]);
        } else {
            return response()->json([
                'code_valide' => 500,
                'message' => 'Echec de la création du forum de communication.',
            ]);
        }
    } catch (\Exception $e) {
        return response()->json([
            'code_valide' => 500,
            'message' => 'Une erreur s\'est produite lors de la création du forum de communication.',
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
        $forum = Forum_Communication::findOrFail($id);

        return response()->json([
            'message' => 'Détails du forum récupérés avec succès.',
            'forum' => $forum,
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Une erreur s\'est produite lors de la récupération du forum.',
            'error' => $e->getMessage(),
        ], 500);
    }
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Forum_Communication $forum_Communication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $forum_Communication)
    {
        try {
            // $request->validate([
            //     'titre' => ['required', 'string'],
            //     'texte' => ['required', 'string'],
            //     'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif'],
            // ]);
    
            $forum = Forum_Communication::findOrFail($forum_Communication);
            // Vérifier si l'utilisateur actuel est l'auteur du forum
            if ($forum->user_id !== auth()->id()) {

                return response()->json([
                    'code_valide' => 403,
                    'message' => 'Vous n\'avez pas la permission de modifier ce forum.',
                ], 403);
            }

            // Mettre à jour les attributs du forum
            $forum->titre = $request->titre;
            $forum->texte = $request->texte;
    
            // Gérer l'image s'il y en a une
            if ($request->hasFile('image')) {
                $imageFile = $request->file('image');
                $filename = date('YmdHi') . $imageFile->getClientOriginalName();
                $imageFile->move(public_path('images'), $filename);
                $forum->image = $filename;
            }
    
            // Sauvegarder les modifications
            $forum->save();
    
            return response()->json([
                'code_valide' => 200,
                'message' => 'Le forum de communication a été mis à jour avec succès.',
                'forum' => $forum,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'code_valide' => 500,
                'message' => 'Une erreur s\'est produite lors de la mise à jour du forum de communication.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

    try {
        // Récupérer le forum
        $forum = Forum_Communication::findOrFail($id);

        //Vérifier si l'utilisateur actuel est l'auteur du forum ou s'il a le rôle d'administrateur
        if (!($forum->user_id == auth()->user()->id || auth()->user()->role == 'admin')) {
            return response()->json([
                'code_valide' => 403, // Statut HTTP 403: Accès interdit
                'message' => 'Vous n\'avez pas la permission de supprimer ce forum.',
            ], 403);
        }

        //Supprimer le forum
        $forum->delete();

        return response()->json([
            'code_valide' => 200,
            'message' => 'Le forum de communication a été supprimé avec succès.',
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'code_valide' => 500,
            'message' => 'Une erreur s\'est produite lors de la suppression du forum de communication.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

     }
