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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quizz_id')->constrained('quizzs')->onDelete('cascade'); // Corrige le nom de la table si nécessaire
            $table->string('libelle')->default('Question sans titre'); // Ajoute une valeur par défaut
            $table->text('content');
            $table->integer('duration')->nullable();
            $table->enum('question_type', ['multiple_choice', 'single_choice', 'text', 'vrai_faux']);
            $table->integer('points')->default(1);
            $table->string('image_url')->nullable(); // Champ pour l'URL de l'image, nullable si non obligatoire
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
