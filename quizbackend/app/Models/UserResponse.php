<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'question_id',
        'answer_option_id',
        'is_correct', // Indique si la réponse est correcte
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function answerOption()
    {
        return $this->belongsTo(AnswerOption::class);
    }
}
