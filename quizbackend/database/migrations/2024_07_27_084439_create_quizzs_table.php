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
        Schema::create('quizzs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(false);
            $table->integer('duration')->nullable();
            $table->string('quiz_image')->nullable(); // Champ pour l'URL de l'image, nullable si non obligatoire
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('cascade'); // Rendre nullable
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzs');
    }
};
