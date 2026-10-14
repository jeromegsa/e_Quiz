<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;

class QuestionController extends Controller
{
    /**
     * Récupérer et afficher toutes les questions
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            // Récupérer les questions avec les relations (quizz et options de réponse)
            $questions = Question::with('quizz', 'answerOptions')->get();
            return response()->json([
                'message' => 'Liste des questions récupérée avec succès.',
                'data' => $questions
            ], 200);
        } catch (Exception $e) {
            // Gestion des erreurs
            return response()->json([
                'error' => 'Erreur lors de la récupération des questions',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Afficher les détails d'une question spécifique
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            // Récupérer une question spécifique avec ses relations
            $question = Question::with('quizz', 'answerOptions')->findOrFail($id);
            return response()->json([
                'message' => 'Détails de la question récupérés avec succès.',
                'data' => $question
            ], 200);
        } catch (ModelNotFoundException $e) {
            // Si la question n'est pas trouvée
            return response()->json([
                'error' => 'Question non trouvée'
            ], 404);
        } catch (Exception $e) {
            // Gestion des erreurs génériques
            return response()->json([
                'error' => 'Erreur lors de la récupération de la question',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Créer une nouvelle question
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            // Valider les données d'entrée
            $validatedData = $this->validateRequest($request);

            // Gérer l'upload de l'image si elle est présente
            if ($request->hasFile('image_url')) {
                $imagePath = $request->file('image_url')->store('questions_images', 'public');
                $validatedData['image_url'] = '/storage/' . $imagePath;
            }
            // dd($request->all()); // Debug : Affiche toutes les données reçues
            // Créer la nouvelle question
            $question = Question::create($validatedData);

            return response()->json([
                'message' => 'Question créée avec succès.',
                'data' => $question
            ], 201);
        } catch (ValidationException $e) {
            // Gestion des erreurs de validation
            return response()->json([
                'error' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            // Gestion des erreurs générales
            return response()->json([
                'error' => 'Erreur lors de la création de la question',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mettre à jour une question existante
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            // Valider les nouvelles données
            $validatedData = $this->validateRequest($request);

            // Récupérer la question à mettre à jour
            $question = Question::findOrFail($id);

            // Gérer l'upload d'une nouvelle image si nécessaire
            if ($request->hasFile('image_url')) {
                $imagePath = $request->file('image_url')->store( 'quiz_images', 'public');
                $validatedData['image_url'] = '/storage/' . $imagePath;
            }

            // Mise à jour de la question avec les nouvelles données
            $question->update($validatedData);

            return response()->json([
                'message' => 'Question mise à jour avec succès.',
                'data' => $question
            ], 200);
        } catch (ModelNotFoundException $e) {
            // Si la question n'est pas trouvée
            return response()->json([
                'error' => 'Question non trouvée'
            ], 404);
        } catch (ValidationException $e) {
            // Gestion des erreurs de validation
            return response()->json([
                'error' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            // Gestion des erreurs générales
            return response()->json([
                'error' => 'Erreur lors de la mise à jour de la question',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprimer une question
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            // Récupérer la question à supprimer
            $question = Question::findOrFail($id);
            $question->delete();

            return response()->json([
                'message' => 'Question supprimée avec succès.'
            ], 200);
        } catch (ModelNotFoundException $e) {
            // Si la question n'est pas trouvée
            return response()->json([
                'error' => 'Question non trouvée'
            ], 404);
        } catch (Exception $e) {
            // Gestion des erreurs générales
            return response()->json([
                'error' => 'Erreur lors de la suppression de la question',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Méthode de validation des requêtes pour créer/mettre à jour une question
     * @param Request $request
     * @return array
     */
    private function validateRequest(Request $request): array
    {
        return $request->validate([
            'quizz_id' => 'required|exists:quizzs,id', // L'ID du quiz doit exister
            'libelle' => 'required|string|max:255',   // Libellé de la question
            'content' => 'required|string',           // Contenu de la question
            'question_type' => 'required|in:multiple_choice,single_choice,text', // Type de question
            'points' => 'required|integer|min:0',     // Nombre de points
            'duration'=>'required|integer|min:1',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image optionnelle
        ]);
    }
}
