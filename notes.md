# PROJET QuizzMaster

## Analyse de la base de données

### Tables

1. users :

   ```php
   Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('username')->unique();
    $table->string('email')->unique();
    $table->string('password');
    $table->enum('role', ['user', 'admin'])->default('user');
    $table->timestamps();
   });

   ```

2. quizz : (nafiou)

```php
Schema::create('quizzes', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('description')->nullable();
    $table->boolean('is_active')->default(true);
    $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
    $table->timestamps();
});
```

3. questions : (abdoulhack)

   ```php
   Schema::create('questions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('quiz_id')->constrained('quizzes')->onDelete('cascade');
    $table->text('content');
    $table->enum('type', ['qcm', 'single_choice', 'text']);
    $table->integer('points')->default(1);
    $table->timestamps();
   });
   ```

4. answer_options : (eliette)

   ```php
   Schema::create('answer_options', function (Blueprint $table) {
   $table->id();
   $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
   $table->text('content');
   $table->boolean('is_correct')->default(false);
   $table->timestamps();
   });
   ```

5. user_responses : (abdoulhack)

   ```php
   Schema::create('user_responses', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
    $table->foreignId('answer_option_id')->nullable()->constrained('answer_options')->onDelete('cascade');
    $table->text('text_response')->nullable();
    $table->timestamps();
   });
   ```

6. quiz_results (aristide)
   ```php
   Schema::create('quiz_results', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    $table->foreignId('quiz_id')->constrained('quizzes')->onDelete('cascade');
    $table->integer('score');
    $table->timestamp('completed_at')->nullable();
    $table->timestamps();
   });
   ```

## Etapes de l'authentification

1. php artisan install:api
   Cette commande cré les fichiers /config/sactum.php et /routes/api.php (un duplicatat de web.php)
   Créer le fichier /app/Http/Kernel.php et y ajoute le code suivant

   ```php
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
        ],
    ];
   }
   ```


# Dans le frontend

   src/
│
├── assets/             # Fichiers statiques (images, styles, etc.)
├── components/         # Composants globaux
│   ├── Header.vue
│   ├── Footer.vue
│   └── ...             # Autres composants globaux
│
├── views/              # Vues pour les utilisateurs (frontend utilisateur classique)
│   ├── HomeView.vue
│   ├── QuizView.vue
│   └── ...             # Autres vues classiques
│
├── services/           # Services pour les requêtes API, authentification, etc.
│   └── api.ts
│
├── router/             # Configuration du routeur
│   └── index.ts
│
└── admin/              # Dossier dédié à l'administration
    ├── components/     # Composants spécifiques à l'administration
    │   ├── AdminHeader.vue
    │   ├── Sidebar.vue
    │   └── DashboardStats.vue
    │
    ├── views/          # Vues spécifiques pour l'administration
    │   ├── AdminDashboard.vue
    │   ├── ManageQuizzes.vue
    │   └── ManageUsers.vue
    │
    ├── services/       # Services spécifiques à l'administration
    │   └── adminApi.ts
    │
    └── router/         # Routes spécifiques pour l'administration
        └── adminRouter.ts


# Détails sur la structure :
``src/admin/components/`` : Contiendra les composants réutilisables dans l'administration, comme une barre de navigation latérale, un tableau de bord ou des widgets spécifiques.

``src/admin/views/`` : C'est ici que tu mets toutes les vues spécifiques pour l'admin, par exemple la gestion des utilisateurs, des quiz, des statistiques, etc.

``src/admin/services/ ``: Si tu as des appels API spécifiques pour l'administration, tu peux les séparer ici. Par exemple, tu pourrais avoir un fichier adminApi.ts qui contient des requêtes liées à la gestion des utilisateurs ou des quizzes côté admin.

``src/admin/router/`` : Si tu as une navigation ou des routes spécifiques pour l'admin, isole-les ici. Tu pourrais avoir un routeur spécifique qui ne charge que les pages de l'admin. Voici un exemple basique d'un fichier de routes pour l'administration (adminRouter.ts).