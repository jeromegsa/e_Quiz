<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserResponse;

class UserResponseSeeder extends Seeder
{
    public function run()
    {
        // Créer 20 réponses d'utilisateur dans la base de données.
        UserResponse::factory()->count(20)->create();
    }
}
