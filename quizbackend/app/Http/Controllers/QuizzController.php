<?php

namespace App\Http\Controllers;

use App\Models\Quizz;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Validation\ValidationException;

class QuizzController extends Controller
{
    // Afficher tous les quizzes
// Afficher tous les quizzes
public function index(): JsonResponse
{
    try {
        $perPage = 10;
        // Charger les quizzes avec leurs questions et options de réponse
        $quizzes = Quizz::with('questions.answerOptions')->get();

        if ($quizzes->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Aucun quiz trouvé.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Liste des quizzes récupérée avec succès.',
            'data' => $quizzes
        ], 200);
    } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la récupération des quizzes.',
            'error' => $e->getMessage()
        ], 500);
    }
}

    // Créer un nouveau quiz
    public function store(Request $request): JsonResponse
    {
        try {
            // Valider les données d'entrée incluant les questions
            $validated = $this->validateRequest($request);

            // Gérer l'upload de l'image du quiz si elle est présente
            if ($request->hasFile('quiz_image')) {
                $imagePath = $request->file('quiz_image')->store('quiz_images', 'public');
                $validated['quiz_image'] = '/storage/' . $imagePath;
            }

            // Créer le quizz d'abord
            $quizz = Quizz::create($validated);

            // Récupérer les questions du request
            if ($request->has('questions')) {
                $questions = $request->input('questions');

                foreach ($questions as $index => $questionData) {
                    // Gérer l'upload de l'image de la question si elle est présente
                    if (isset($questionData['image_url']) && $request->hasFile("questions.$index.image_url")) {
                        $questionImagePath = $request->file("questions.$index.image_url")->store('questions_images', 'public');
                        $questionData['image_url'] = '/storage/' . $questionImagePath;
                    } else {
                        $questionData['image_url'] = null;
                    }

                    // Créer chaque question et les lier au quizz
                    $question = $quizz->questions()->create([
                        'libelle' => $questionData['libelle'],
                        'content' => $questionData['content'],
                        'question_type' => $questionData['question_type'],
                        'points' => $questionData['points'],
                        'duration' => $questionData['duration'],
                        'image_url' => $questionData['image_url'], // Utiliser null si image_url n'est pas défini
                    ]);

                    // Si la question a des options de réponse, les créer aussi
                    if (isset($questionData['answer_options'])) {
                        foreach ($questionData['answer_options'] as $option) {
                            $question->answerOptions()->create([
                                'content' => $option['content'],
                                'is_correct' => $option['is_correct'],
                            ]);
                        }
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Quiz créé avec succès avec les questions associées.',
                'data' => $quizz->load('questions.answerOptions'), // Charger les questions et les options de réponse
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'error' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création du quiz.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Afficher un quiz spécifique
// Afficher un quiz spécifique
public function show($id): JsonResponse
{
    try {
        // Inclure les questions et les options de réponse associées
        $quizz = Quizz::with('questions.answerOptions')->findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Détails du quiz récupérés avec succès.',
            'data' => $quizz
        ], 200);
    } catch (ModelNotFoundException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Quiz non trouvé.',
            'error' => $e->getMessage()
        ], 404);
    } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la récupération du quiz.',
            'error' => $e->getMessage()
        ], 500);
    }
}


    // Mettre à jour un quiz
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $quizz = Quizz::findOrFail($id);
            // Gérer l'upload de l'image si elle est présente
            if ($request->hasFile('quiz_image')) {
                $imagePath = $request->file('quiz_image')->store('quiz_images', 'public');
                $validatedData['quiz_image'] = '/storage/' . $imagePath;
            }

            $validated = $this->validateRequest($request, true);

            $quizz->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Quiz mis à jour avec succès.',
                'data' => $quizz
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Quiz non trouvé.',
                'error' => $e->getMessage()
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'error' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du quiz.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Supprimer un quiz
    public function destroy($id): JsonResponse
    {
        try {
            $quizz = Quizz::findOrFail($id);
            $quizz->delete();

            return response()->json([
                'success' => true,
                'message' => 'Quiz supprimé avec succès.'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Quiz non trouvé.',
                'error' => $e->getMessage()
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression du quiz.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Méthode de validation pour les données d'entrée
    private function validateRequest(Request $request, bool $isUpdate = false)
    {
        return $request->validate([
            'title' => 'string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'duration' => 'integer|min:1',
            'quiz_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'created_by' => 'nullable|exists:users,id',
            'questions' => 'array|nullable',
            'questions.*.libelle' => 'nullable|string|max:255',
            'questions.*.content' => 'nullable|string',
            'questions.*.question_type' => 'nullable|in:multiple_choice,single_choice,text,vrai_faux',
            'questions.*.points' => 'nullable|integer|min:1',
            'questions.*.duration' => 'nullable|integer|min:1',
            'questions.*.image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'questions.*.answer_options' => 'array|nullable',
            'questions.*.answer_options.*.content' => 'nullable|string|max:255',
            'questions.*.answer_options.*.is_correct' => 'nullable|boolean',
        ], [
            'quiz_image.image' => 'Le fichier doit être une image.',
            'quiz_image.mimes' => 'Les formats autorisés sont : jpeg, png, jpg, gif.',
            'quiz_image.max' => 'L\'image ne doit pas dépasser 2 Mo.',
            'questions.*.image_url.image' => 'Le fichier doit être une image.',
            'questions.*.image_url.mimes' => 'Les formats autorisés sont : jpeg, png, jpg, gif.',
            'questions.*.image_url.max' => 'L\'image de la question ne doit pas dépasser 2 Mo.',
        ]);
    }
}
