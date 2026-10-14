<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quizz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'is_active',
        'duration',
        'quiz_image',
        'created_by'
    ];

    // Relation avec l'utilisateur (admin qui a créé le quiz)
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relation avec les questions
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
