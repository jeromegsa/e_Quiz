<?php

namespace Database\Factories;

use App\Models\Quizz;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quizz>
 */
class QuizzFactory extends Factory
{
    protected $model = Quizz::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'is_active' => $this->faker->boolean(false),
            'duration'=> $this->faker->numberBetween(1,10),
            'created_by' => User::factory(), // Associe à un utilisateur existant
        ];
    }
}
