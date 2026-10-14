<?php

namespace Database\Factories;

use App\Models\AnswerOption;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AnswerOption>
 */
class AnswerOptionFactory extends Factory
{
    protected $model = AnswerOption::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question_id' => Question::factory(), // Création d'une question associée
            'content' => $this->faker->sentence(), // Génération d'une phrase aléatoire
            'is_correct' => $this->faker->boolean(), // Valeur aléatoire pour 'is_correct'
        ];
    }

    /**
     * Indicate that the answer option is correct.
     */
    public function correct(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'is_correct' => true, // Définit l'option comme correcte
            ];
        });
    }

    /**
     * Indicate that the answer option is incorrect.
     */
    public function incorrect(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'is_correct' => false, // Définit l'option comme incorrecte
            ];
        });
    }
}
