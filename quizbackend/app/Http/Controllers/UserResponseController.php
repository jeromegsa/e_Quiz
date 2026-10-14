<?php

namespace App\Http\Controllers;

use App\Models\UserResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;

class UserResponseController extends Controller
{
    // Afficher toutes les réponses d'utilisateur
    public function index(): JsonResponse
    {
        try {
            $userResponses = UserResponse::with('user', 'question', 'answerOption')->get();
            return response()->json([
                'message' => 'Liste des réponses récupérées avec succès.',
                'data' => $userResponses,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la récupération des réponses',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    // Afficher une réponse spécifique
    public function show($id): JsonResponse
    {
        try {
            $userResponse = UserResponse::with('user', 'question', 'answerOption')->findOrFail($id);
            return response()->json([
                'message' => 'Détails de la réponse récupérés avec succès.',
                'data' => $userResponse,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la récupération de la réponse',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    // Créer une nouvelle réponse
    public function store(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'question_id' => 'required|exists:questions,id',
                'answer_option_id' => 'required|exists:answer_options,id',
                'is_correct' => 'required|boolean',
            ]);

            $userResponse = UserResponse::create($validatedData);

            return response()->json([
                'message' => 'Réponse créée avec succès.',
                'data' => $userResponse,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la création de la réponse',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    // Mettre à jour une réponse existante
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'is_correct' => 'required|boolean',
            ]);

            $userResponse = UserResponse::findOrFail($id);
            $userResponse->update($validatedData);

            return response()->json([
                'message' => 'Réponse mise à jour avec succès.',
                'data' => $userResponse,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la mise à jour de la réponse',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    // Supprimer une réponse
    public function destroy($id): JsonResponse
    {
        try {
            $userResponse = UserResponse::findOrFail($id);
            $userResponse->delete();

            return response()->json([
                'message' => 'Réponse supprimée avec succès.',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la suppression de la réponse',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
}
