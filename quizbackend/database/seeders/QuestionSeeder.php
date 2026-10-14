<?php

namespace Database\Seeders;

use App\Models\AnswerOption;
use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // // 1. Créer des questions à choix multiple (Multiple Choice)
        // Question::factory()
        //     ->count(5) // Créer 5 questions de type choix multiple
        //     ->multipleChoice()
        //     ->create()
        //     ->each(function ($question) {
        //         // Chaque question multiple_choice a 4 options, dont 2 correctes
        //         AnswerOption::factory()->count(4)
        //             ->state(new \Illuminate\Database\Eloquent\Factories\Sequence(
        //                 ['is_correct' => true],
        //                 ['is_correct' => true],
        //                 ['is_correct' => false],
        //                 ['is_correct' => false],
        //             ))
        //             ->create(['question_id' => $question->id]);
        //     });

        // // 2. Créer des questions à choix unique (Single Choice)
        // Question::factory()
        //     ->count(5) // Créer 5 questions de type choix unique
        //     ->singleChoice()
        //     ->create()
        //     ->each(function ($question) {
        //         // Chaque question single_choice a 4 options, dont 1 correcte
        //         AnswerOption::factory()->count(4)
        //             ->state(new \Illuminate\Database\Eloquent\Factories\Sequence(
        //                 ['is_correct' => true],
        //                 ['is_correct' => false],
        //                 ['is_correct' => false],
        //                 ['is_correct' => false],
        //             ))
        //             ->create(['question_id' => $question->id]);
        //     });

        // // 3. Créer des questions avec réponse textuelle (Text)
        // Question::factory()
        //     ->count(5) // Créer 5 questions de type texte
        //     ->text()
        //     ->create()
        //     ->each(function ($question) {
        //         // Pour une question textuelle, on pourrait ne pas créer d'options de réponse
        //         // ou éventuellement créer une seule bonne réponse (ex: une réponse modèle).
        //         AnswerOption::factory()->count(1)
        //             ->state(['is_correct' => true, 'content' => 'Réponse modèle'])
        //             ->create(['question_id' => $question->id]);
        //     });
    }
}
