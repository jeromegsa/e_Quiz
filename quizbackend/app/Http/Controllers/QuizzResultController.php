<?php

namespace App\Http\Controllers;

use App\Models\QuizzResult;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class QuizzResultController extends Controller
{
    // Afficher tous les résultats de quiz
    public function index()
    {
        try {
            $results = QuizzResult::with('user', 'quiz')->get();
            return response()->json($results, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la récupération des résultats de quiz'], 500);
        }
    }

    // Afficher un résultat de quiz spécifique
    public function show($id)
    {
        try {
            $result = QuizzResult::with('user', 'quiz')->findOrFail($id);
            return response()->json($result, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => "Résultat de quiz non trouvé"], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la récupération du résultat de quiz'], 500);
        }
    }

    // Créer un nouveau résultat de quiz
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'quiz_id' => 'required|exists:quizzes,id',
                'score' => 'required|integer',
                'completed_at' => 'nullable|date',
            ]);

            $result = QuizzResult::create($validatedData);
            return response()->json($result, 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la création du résultat de quiz'], 500);
        }
    }

    // Mettre à jour un résultat de quiz existant
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'quiz_id' => 'required|exists:quizzes,id',
                'score' => 'required|integer',
                'completed_at' => 'nullable|date',
            ]);

            $result = QuizzResult::findOrFail($id);
            $result->update($validatedData);
            return response()->json($result, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Résultat de quiz non trouvé'], 404);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la mise à jour du résultat de quiz'], 500);
        }
    }

    // Supprimer un résultat de quiz
    public function destroy($id)
    {
        try {
            $result = QuizzResult::findOrFail($id);
            $result->delete();
            return response()->json(['message' => 'Résultat de quiz supprimé avec succès'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Résultat de quiz non trouvé'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la suppression du résultat de quiz'], 500);
        }
    }
}
