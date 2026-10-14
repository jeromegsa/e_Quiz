<?php

namespace Database\Factories;

use App\Models\UserResponse;
use App\Models\User;
use App\Models\Question;
use App\Models\AnswerOption;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserResponseFactory extends Factory
{
    protected $model = UserResponse::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'question_id' => Question::factory(),
            'answer_option_id' => AnswerOption::factory(),
            'is_correct' => $this->faker->boolean(),
        ];
    }
}
