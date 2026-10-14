<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizzResultController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuizzController;
use App\Http\Controllers\AnswerOptionController;
use App\Http\Controllers\UserResponseController; // Ajout du UserResponseController
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// Routes API pour les différentes ressources
Route::apiResource('users', UserController::class);
Route::apiResource('quizzes', QuizzController::class);
Route::apiResource('questions', QuestionController::class);
Route::apiResource('quizz-results', QuizzResultController::class);
Route::apiResource('answer-options', AnswerOptionController::class); // Routes pour AnswerOption
Route::apiResource('user-responses', UserResponseController::class); // Routes pour UserResponse


// Route pour récupérer un utilisateur avec ses quiz et réponses
Route::get('/users/{id}/details', [UserController::class, 'getUserWithDetails']);

// Route pour ajouter un admin
Route::middleware('auth:sanctum', 'isSuperAdmin')->post('/add-admin', [AdminController::class, 'addAdmin']);
