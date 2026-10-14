<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'libelle',
        'quizz_id',
        'content',
        'question_type',
        'points',
        'duration',
        'image_url', // Nouveau champ pour stocker l'URL de l'image
    ];

    public function quizz()
    {
        return $this->belongsTo(Quizz::class);
    }

    public function answerOptions()
    {
        return $this->hasMany(AnswerOption::class);
    }

    public function userResponses()
    {
        return $this->hasMany(UserResponse::class);
    }
}
