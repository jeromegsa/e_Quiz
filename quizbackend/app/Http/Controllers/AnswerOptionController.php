<?php

namespace App\Http\Controllers;

use App\Models\AnswerOption;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;

class AnswerOptionController extends Controller
{
    // Afficher toutes les options de réponse
    public function index(): JsonResponse
    {
        try {
            $answerOptions = AnswerOption::with('question')->get(); // Récupérer avec la relation
            return response()->json([
                'message' => 'Options de réponse récupérées avec succès.',
                'data' => $answerOptions
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la récupération des options de réponse',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    // Afficher une option de réponse spécifique
    public function show($id): JsonResponse
    {
        try {
            $answerOption = AnswerOption::with('question')->findOrFail($id);
            return response()->json([
                'message' => 'Détails de l\'option de réponse récupérés avec succès.',
                'data' => $answerOption
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([ 
                'error' => 'Option de réponse non trouvée'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la récupération de l\'option de réponse',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    // Créer une nouvelle option de réponse
    public function store(Request $request): JsonResponse
    {
        try {
            $validatedData = $this->validateRequest($request);
            $answerOption = AnswerOption::create($validatedData);

            return response()->json([
                'message' => 'Option de réponse créée avec succès.',
                'data' => $answerOption
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la création de l\'option de réponse',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    // Mettre à jour une option de réponse existante
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $validatedData = $this->validateRequest($request);
            $answerOption = AnswerOption::findOrFail($id);
            $answerOption->update($validatedData);

            return response()->json([
                'message' => 'Option de réponse mise à jour avec succès.',
                'data' => $answerOption
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Option de réponse non trouvée'
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la mise à jour de l\'option de réponse',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    // Supprimer une option de réponse
    public function destroy($id): JsonResponse
    {
        try {
            $answerOption = AnswerOption::findOrFail($id);
            $answerOption->delete();

            return response()->json([
                'message' => 'Option de réponse supprimée avec succès.'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Option de réponse non trouvée'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la suppression de l\'option de réponse',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    // Méthode de validation pour les données d'entrée
    private function validateRequest(Request $request): array
    {
        return $request->validate([
            'question_id' => 'required|exists:questions,id',
            'content' => 'required|string',
            'is_correct' => 'required|boolean'
        ]);
    }
}
