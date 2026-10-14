<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\Quizz;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    protected $model = Question::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quizz_id' => Quizz::factory(), // Associe la question à un quiz
            'content' => $this->faker->sentence(), // Génère une question aléatoire
            'question_type' => $this->faker->randomElement(['multiple_choice', 'single_choice', 'text']), // Type de la question
            'points' => $this->faker->numberBetween(1, 10), // Nombre de points pour la question
            'duration'=> $this->faker->numberBetween(1,10),
        ];
    }

    /**
     * Définir une question de type "QCM".
     *
     * @return static
     */
    public function multipleChoice()
    {
        return $this->state(function (array $attributes) {
            return [
                'question_type' => 'multiple_choice',
            ];
        });
    }

    /**
     * Définir une question de type "choix unique".
     *
     * @return static
     */
    public function singleChoice()
    {
        return $this->state(function (array $attributes) {
            return [
                'question_type' => 'single_choice',
            ];
        });
    }

    /**
     * Définir une question de type "texte à saisir".
     *
     * @return static
     */
    public function text()
    {
        return $this->state(function (array $attributes) {
            return [
                'question_type' => 'text',
            ];
        });
    }
}
