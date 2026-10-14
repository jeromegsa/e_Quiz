// // src/admin/router/adminRouter.ts
// import { createRouter, createWebHistory } from 'vue-router';
// import AdminDashboard from '@/admin/views/AdminDashboard.vue';
// import ManageUsers from '@/admin/views/ManageUsers.vue';
// import ManageQuizzes from '@/admin/views/ManageQuizzes.vue';
// import { getToken, isAdmin } from '@/services/auth';

// const adminRoutes = [
//   {
//     path: '/admin',
//     component: AdminDashboard,
//     children: [
//       { path: 'users', component: ManageUsers, name: 'manage-users' },
//       { path: 'quizzes', component: ManageQuizzes, name: 'manage-quizzes' },
//     ],
//     // meta: { requiresAdmin: false },  // Assure-toi que l'admin est connecté
//   },
// ];

// const adminRouter = createRouter({
//   history: createWebHistory(import.meta.env.BASE_URL),
//   routes: adminRoutes,
// });

// // Vérifie que l'utilisateur est admin avant de naviguer
// adminRouter.beforeEach((to, from, next) => {
//   const token = getToken();
//   const userIsAdmin = isAdmin(); // Fonction qui vérifie si l'utilisateur est admin

//   if (to.matched.some(record => record.meta.requiresAdmin)) {
//     if (!token || !userIsAdmin) {
//       return next({ path: '/login' });
//     }
//   }
//   next();
// });

// export default adminRouter;
