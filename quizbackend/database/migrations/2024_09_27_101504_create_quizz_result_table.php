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
        Schema::create('quizz_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('quizz_id')->constrained('quizzs')->onDelete('cascade');
            $table->integer('score');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            // Optionnel : Ajout d'index
            $table->index('user_id'); // Index sur user_id
            $table->index('quizz_id'); // Index sur quizz_id
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizz_results'); // Correction ici
    }
};
