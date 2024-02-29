<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
        
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function login()
{
    $credentials = request(['email', 'password']);

    if (! $token = auth()->attempt($credentials)) {
        return response()->json(['error' => 'Login invalide, veuillez réessayer s\'il vous plait, mot de passe ou email incorrect.'], 401);
    }

    // Récupérer l'utilisateur connecté
    $user = auth()->user();

    // Vérifier le statut du compte pour les utilisateurs de type 'personnelsante'
    if ($user->role === 'personnelsante' && $user->statut_compte === 0) {
        // Si le statut du compte n'est pas validé, retourner un message d'erreur
        auth()->logout(); // Déconnexion immédiate
        return response()->json(['error' => 'Votre compte n\'a pas encore été validé. Veuillez réessayer plus tard.'], 401);
    }

    return $this->respondWithToken($token);
}



    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Déconnexion réussie']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            //Pour augmenter le temps d'expiration du token(durée de vie du token), on change(augmente) le *60
            'expires_in' => auth()->factory()->getTTL() * 120
        ]);
    }
}