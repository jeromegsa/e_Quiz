<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QuizzResult;
use App\Models\User;
use App\Models\Quiz;
use App\Models\Quizz;

class QuizzResultSeeder extends Seeder
{
    public function run()
    {
        // Créer 10 résultats de quiz dans la base de données.
        for ($i = 0; $i < 10; $i++) {
            QuizzResult::factory()->create([
                'user_id' => User::factory()->create()->id, // Crée un nouvel utilisateur pour chaque résultat
                'quizz_id' => Quizz::factory()->create()->id, // Crée un nouveau quiz pour chaque résultat
                'score' => random_int(0, 100), // Ajout d'un score aléatoire
                'completed_at' => now(), // Ajout d'une date de complétion
            ]);
        }
    }
}
