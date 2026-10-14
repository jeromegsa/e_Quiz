<template>
  <div class="about">
    <h1>This is an about page</h1>
    <button @click="handleLogout">Déconnexion</button>
  </div>
</template>
<script setup>
import { useAuthStore } from '@/stores/authStore' // Assurez-vous d'importer votre store
import { useRouter } from 'vue-router'

const authStore = useAuthStore()
const router = useRouter()

// Fonction pour gérer la déconnexion
const handleLogout = async () => {
  const result = await authStore.dispatchLogout() // Appelle la méthode de déconnexion
  if (result.success) {
    router.push('/login') // Redirige vers la page de connexion
  } else {
    console.error(result.message) // Gérer l'erreur si nécessaire
  }
}
</script>

<style>
@media (min-width: 1024px) {
  .about {
    min-height: 100vh;
    display: flex;
    align-items: center;
  }
}
</style>
