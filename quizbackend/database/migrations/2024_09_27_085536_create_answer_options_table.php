<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('answer_options', function (Blueprint $table) {
            $table->id();
            // Crée une clé étrangère vers la table 'questions' qui se supprime en cascade
            $table->foreignId('question_id')
                  ->constrained('questions')
                  ->onDelete('cascade')
                  ->comment('Identifiant de la question associée');

            $table->text('content')
                  ->comment('Le contenu de l\'option de réponse');

            $table->boolean('is_correct')
                  ->default(false)
                  ->comment('Indique si l\'option est correcte');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answer_options');
    }
};
