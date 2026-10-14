<?php

namespace Database\Seeders;

use App\Models\AnswerOption;
use App\Models\Question;
use Illuminate\Database\Seeder;

class AnswerOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nombre de questions à créer
        $questionCount = 10;
        // Nombre d'options de réponse par question
        $optionsPerQuestion = 4;

        // Créer des questions avec des options de réponse
        Question::factory()
            ->count($questionCount) // Créer le nombre de questions défini
            ->has(AnswerOption::factory()->count($optionsPerQuestion)) // Chaque question a un nombre défini d'options de réponse
            ->create();

        // Créer une question avec des réponses spécifiques
        Question::factory()
            ->has(AnswerOption::factory()->count(3)->correct()) // 3 réponses correctes
            ->has(AnswerOption::factory()->count(1)->incorrect()) // 1 réponse incorrecte
            ->create();
    }
}
