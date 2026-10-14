<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Connexion d'un utilisateur ou d'un administrateur
    public function login(Request $request): JsonResponse
    {
        // Valider les données reçues
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Récupérer l'utilisateur en fonction de l'email
        $user = User::where('email', $request->email)->first();

        // Vérifier les informations d'identification
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Informations invalides'], 401);
        }

        // Créer un jeton d'authentification
        $token = $user->createToken('auth_token')->plainTextToken;

        // Retourner la réponse avec le jeton
        return response()->json([
            'message' => 'Utilisateur connecté avec succès',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user, // Inclure l'utilisateur dans la réponse
        ], 200); // Réponse 200 OK
    }

    // Déconnexion de l'utilisateur
    public function logout(Request $request): JsonResponse
    {
        // Récupérer l'utilisateur connecté
        $user = $request->user();

        // Supprimer (révoquer) tous les jetons de l'utilisateur connecté
        $user->tokens()->delete();

        // Retourner un message de succès
        return response()->json([
            'message' => 'Déconnexion réussie',
        ], 200); // Réponse 200 OK
    }

    // Ajouter un nouvel administrateur (accessible uniquement par le super administrateur)
    public function addAdmin(Request $request): JsonResponse
    {
        // Récupérer l'utilisateur connecté
        $user = $request->user();

        // Vérifier si l'utilisateur connecté est un super administrateur
        if ($user->role !== 'super_admin') {
            return response()->json(['message' => 'Accès refusé'], 403);
        }

        // Valider les données reçues pour l'ajout d'un administrateur
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Créer le nouvel administrateur
        $admin = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin', // Attribuer le rôle 'admin'
        ]);

        return response()->json(['message' => 'Administrateur ajouté avec succès', 'admin' => $admin], 201);
    }
}
