<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class isSuperAdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'username' => 'SuperAdmin', // Nom d'utilisateur du super admin
            'email' => 'superadmin@example.com', // Email du super admin
            'password' => Hash::make('password'), // Mot de passe sécurisé (à changer)
            'role' => 'super_admin', // Rôle du super admin
        ]);
    }
}
