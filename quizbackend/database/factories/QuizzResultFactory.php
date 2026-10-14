<?php

namespace Database\Factories;

use App\Models\QuizzResult;
use App\Models\User;
use App\Models\Quiz;
use App\Models\Quizz;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class QuizzResultFactory extends Factory
{
    protected $model = QuizzResult::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'quizz_id' => Quizz::factory(), // Correction ici
            'score' => $this->faker->numberBetween(0, 100),
            'completed_at' => $this->faker->dateTimeBetween('-1 month', 'now'), // Varie la date de completion
        ];
    }
}
