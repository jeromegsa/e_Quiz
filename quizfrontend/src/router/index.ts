import AddQuizzes from '@/admin/views/AddQuizzes.vue'
import AdminDashboard from '@/admin/views/AdminDashboard.vue'
import DashboardView from '@/admin/views/DashboardView.vue'
import ManageQuizzes from '@/admin/views/ManageQuizzes.vue'
import ManageUsers from '@/admin/views/ManageUsers.vue'
import QuizzStart from '@/components/Quizz/QuizzStart.vue'
import { getToken } from '@/services/auth';
import { isAdmin } from '@/services/auth'; // Assurez-vous d'importer isAdmin
import LoginView from '@/views/LoginView.vue'
import RegisterView from '@/views/RegisterView.vue'
import type { RouteRecordRaw } from 'vue-router'
import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import QuizView from '../views/QuizView.vue'
import TestView from '../views/TestView.vue'

// Définition des types de route
const routes: Array<RouteRecordRaw> = [
  {
    path: '/',
    name: 'home',
    component: HomeView,
  },
  {
    path: '/quiz',
    name: 'quiz',
    component: QuizView,
    children: [
      {
        path: ':id',
        name: 'quiz-start',
        component: QuizzStart,
        props: true,
      },
    ],
  },
  {
    path: '/login',
    name: 'login',
    component: LoginView,
  },
  {
    path: '/register',
    name: 'register',
    component: RegisterView,
  },
  {
    path: '/test',
    name: 'test',
    component: TestView,
  },
  {
    path: '/about',
    name: 'about',
    component: () => import('../views/AboutView.vue'),
  },

  // Administrateur
  {
    path: '/admin',
    component: AdminDashboard,
    children: [
      { path: '/', component: DashboardView, name: 'dashboard' },
      { path: 'users', component: ManageUsers, name: 'manage-users' },
      { path: 'quizzes', component: ManageQuizzes, name: 'manage-quizzes' },
      { path: 'addquizze', component: AddQuizzes, name: 'add-quizzes' },
    ],
    meta: { requiresAuth: true, requiresAdmin: true },
  },
]

// Création du routeur
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

// Guard de navigation globale

router.beforeEach((to, from, next) => {
  const isAuthenticated = !!getToken(); // Vérifie si le token existe

  // Redirige les utilisateurs authentifiés qui tentent d'accéder à la page de connexion
  if (isAuthenticated && (to.path === '/login' || to.path === '/register')) {
    next({ path: '/' }); // Redirige vers la page d'accueil ou le tableau de bord
  } else if (to.matched.some((record) => record.meta.requiresAuth) && !isAuthenticated) {
    next({ path: '/login' }); // Redirige vers la page de login
  } else if (to.matched.some((record) => record.meta.requiresAdmin) && !isAdmin()) {
    next({ path: '/' }); // Redirige vers la page d'accueil si l'utilisateur n'est pas admin
  } else {
    next(); // Continue la navigation
  }
});


// Protéger toutes les routes sauf les routes de connexion et d'inscription
router.beforeEach((to, from, next) => {
  const isAuthenticated = !!getToken();

  if (to.path !== '/login' && to.path !== '/register' && !isAuthenticated) {
    next({ path: '/login' }); // Redirige vers la page de login
  } else if (to.matched.some((record) => record.meta.requiresAdmin) && !isAdmin()) {
    next({ path: '/' }); // Redirige vers la page d'accueil si l'utilisateur n'est pas admin
  } else {
    next(); // Continue la navigation
  }
})

export default router;
