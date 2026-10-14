<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{

    protected $middlewareGroups = [
        'api' => [
            // Ajout du middleware Sanctum pour l'authentification d'API
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api', // Limitation du nombre de requêtes API
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            'isSuperAdmin' => \App\Http\Middleware\IsSuperAdmin::class,

        ],
    ];
}