<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $users = User::all();

            if ($users->isEmpty()) {
                return response()->json([
                    'message' => 'Aucun utilisateur trouvé.'
                ], 404);
            }

            return response()->json([
                'message' => 'Liste des utilisateurs récupérée avec succès.',
                'data' => $users
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la récupération des utilisateurs.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Inscription d'un utilisateur
    public function store(Request $request): JsonResponse
    {
        // Validation des données entrantes
        $validatedData = $this->validateRequest($request);

        if ($validatedData->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validatedData->errors()
            ], 400);
        }

        try {
            // Hashage du mot de passe
            $data = $request->all();
            $data['password'] = Hash::make($data['password']);
            $user = User::create($data);

            return response()->json([
                'message' => 'Utilisateur créé avec succès.',
                'data' => $user
            ], 201); // Réponse 201 Created
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la création de l\'utilisateur',
                'message' => $e->getMessage(),
            ], 500); // Réponse 500 Internal Server Error
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);

            return response()->json([
                'message' => 'Détails de l\'utilisateur récupérés avec succès.',
                'data' => $user
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Utilisateur non trouvé.',
                'error' => $e->getMessage()
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la récupération de l\'utilisateur.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Mettre à jour un utilisateur
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);
            $validated = $this->validateUpdateRequest($request);

            $user->update($validated);

            return response()->json([
                'message' => 'Utilisateur mis à jour avec succès.',
                'data' => $user
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Utilisateur non trouvé.',
                'error' => $e->getMessage()
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la mise à jour de l\'utilisateur.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Supprimer un utilisateur
    public function destroy($id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json([
                'message' => 'Utilisateur supprimé avec succès.'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Utilisateur non trouvé.',
                'error' => $e->getMessage()
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la suppression de l\'utilisateur.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Méthode de validation pour l'inscription d'un utilisateur
    private function validateRequest(Request $request)
    {
        return Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|min:3|max:255',
            'password' => 'required|string|min:8',
            'role' => 'nullable|string'
        ]);
    }

    // Méthode de validation pour la mise à jour d'un utilisateur
    private function validateUpdateRequest(Request $request)
    {
        return $request->validate([
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|min:3|max:255',
            'password' => 'required|string|min:8',
            'role' => 'nullable|string'
        ]);
    }

    // Methode pour récuperer un utilisateur avec ses quizz associée et ses réponses

    public function getUserWithDetails($id): JsonResponse
    {
        try {
            // Chargement des relations imbriquées
            $user = User::with('quizzResults', 'userResponses')->findOrFail($id);

            return response()->json([
                'message' => 'Détails de l\'utilisateur récupérés avec succès.',
                'data' => $user
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Utilisateur non trouvé.',
                'error' => $e->getMessage()
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la récupération des détails de l\'utilisateur.',
                'error' => $e->getMessage()
            ], 500);
        }
    }



}
