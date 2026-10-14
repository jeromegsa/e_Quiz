<?php

namespace Database\Seeders;

use App\Models\AnswerOption;
use App\Models\Question;
use App\Models\Quizz;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuizzSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer 3 quizzes
        Quizz::factory()
            ->count(3)
            ->create()
            ->each(function ($quizz) {
                // Pour chaque quiz, créer 5 questions à choix multiple
                Question::factory()
                    ->count(5) // Créer 5 questions de type choix multiple
                    ->multipleChoice() // Assurez-vous que cette méthode est définie dans le modèle Question
                    ->create(['quizz_id' => $quizz->id]) // Associer les questions au quiz
                    ->each(function ($question) {
                        // Chaque question multiple_choice a 4 options, dont 2 correctes
                        AnswerOption::factory()->count(4)
                            ->state(new \Illuminate\Database\Eloquent\Factories\Sequence(
                                ['is_correct' => true],
                                ['is_correct' => true],
                                ['is_correct' => false],
                                ['is_correct' => false],
                            ))
                            ->create(['question_id' => $question->id]);
                    });

                // Créer 5 questions à choix unique
                Question::factory()
                    ->count(5) // Créer 5 questions de type choix unique
                    ->singleChoice() // Assurez-vous que cette méthode est définie dans le modèle Question
                    ->create(['quizz_id' => $quizz->id]) // Associer les questions au quiz
                    ->each(function ($question) {
                        // Chaque question single_choice a 4 options, dont 1 correcte
                        AnswerOption::factory()->count(4)
                            ->state(new \Illuminate\Database\Eloquent\Factories\Sequence(
                                ['is_correct' => true],
                                ['is_correct' => false],
                                ['is_correct' => false],
                                ['is_correct' => false],
                            ))
                            ->create(['question_id' => $question->id]);
                    });

                // Créer 5 questions avec réponse textuelle
                Question::factory()
                    ->count(5) // Créer 5 questions de type texte
                    ->text() // Assurez-vous que cette méthode est définie dans le modèle Question
                    ->create(['quizz_id' => $quizz->id]) // Associer les questions au quiz
                    ->each(function ($question) {
                        // Pour une question textuelle, créer une bonne réponse
                        AnswerOption::factory()->count(1)
                            ->state(['is_correct' => true, 'content' => 'Réponse modèle'])
                            ->create(['question_id' => $question->id]);
                    });
            });
    }
}
