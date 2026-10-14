<template>
  <div class="bg-[#2E626E] h-[5rem]  w-full flex justify-between items-center px-5 z-50">
    <!-- Logo -->
    <div>
      <img src="../../assets/images/logo.svg" class="w-[2.5rem] h-[2.438rem]" alt="Logo" />
    </div>

    <!-- Bouton Toggle pour mobile (icône hamburger ou croix) -->
    <button @click="toggleMenu" class="block lg:hidden text-white focus:outline-none">
      <!-- Affichage conditionnel du burger ou de la croix selon l'état du menu -->
      <svg
        v-if="!isOpen"
        class="w-6 h-6"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M4 6h16M4 12h16m-7 6h7"
        ></path>
      </svg>
      <!-- Affichage de la croix lorsque le menu est ouvert -->
      <svg
        v-else
        class="w-6 h-6"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M6 18L18 6M6 6l12 12"
        ></path>
      </svg>
    </button>

    <!-- Menu plein écran pour mobile (caché par défaut) -->
    <div
      :class="{ flex: isOpen, hidden: !isOpen }"
      class="fixed inset-0 bg-[#2E626E] opacity-100 flex-col justify-center items-center text-white text-[1.5rem] lg:hidden transition-all duration-300 ease-in-out z-40"
    >
      <!-- Liens de navigation mobiles -->
      <router-link to="/" @click="toggleMenu" class="py-4">Acceuil</router-link>
      <router-link to="/" @click="toggleMenu" class="py-4">A propos</router-link>
      <router-link to="/" @click="toggleMenu" class="py-4">Contact</router-link>
      <router-link to="/login" @click="toggleMenu" class="py-4">
        <button
          class="bg-gradient-to-tl from-[#FB8501] to-[#FFB703] p-2 text-white text-[1rem] rounded-sm"
        >
          Se connecter
        </button>
      </router-link>
      <router-link to="/login" @click="toggleMenu" class="py-4">S'inscrire</router-link>
    </div>

    <!-- Liens de navigation visibles pour les grands écrans -->
    <div class="hidden lg:flex gap-5 text-white items-center text-[1rem]">
      <router-link to="/">Acceuil</router-link>
      <router-link to="/">A propos</router-link>
      <router-link to="/">Contact</router-link>
      <router-link to="/login" v-if="!user">
        <button
          class="bg-gradient-to-tl from-[#FB8501] to-[#FFB703] p-1 text-white text-[1rem] rounded-sm"
        >
          Se connecter
        </button>
      </router-link>
      <router-link to="/login" v-if="!user">S'inscrire</router-link>

      <div class="relative" v-if="user">
        <span @click="toggleDropdown" class="flex cursor-pointer items-center space-x-2">
          <img
            src="quizfrontend\src\assets\Ellipse 3.svg"
            alt="Avatar"
            class="w-8 h-8 rounded-full"
          />
          <span class="text-white font-bold">{{ user.username }}</span>
          <span>
            <svg
              class="w-4 h-4"
              fill="none"
              stroke="#FB8501"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
              ></path>
            </svg>
          </span>
        </span>
        <div
          v-if="isDropdownOpen"
          class="absolute right-0 mt-2 w-48 bg-[#2E626E] border border-gray-200 rounded-md shadow-lg"
        >
          <div class="py-2 px-4 hover:bg-[#FB8501] cursor-pointer">Profile</div>
          <div class="py-2 px-4 hover:bg-[#FB8501] cursor-pointer">Tableau de bord</div>
          <div class="py-2 px-4 hover:bg-[#FB8501] cursor-pointer" @click="handleLogout">
            Déconnexion
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../../stores/authStore';

const authStore = useAuthStore()
const router = useRouter()
// État pour gérer l'ouverture et la fermeture du menu
const isOpen = ref(false)
const isDropdownOpen = ref(false)

// Fonction pour basculer le menu
const toggleMenu = () => {
  isOpen.value = !isOpen.value
}

// Fonction pour basculer le dropdown
const toggleDropdown = () => {
  isDropdownOpen.value = !isDropdownOpen.value
}

// Fonction pour gérer la déconnexion
const handleLogout = async () => {
  const result = await authStore.dispatchLogout() // Appelle la méthode de déconnexion
  if (result.success) {
    router.push('/login') // Redirige vers la page de connexion
  } else {
    console.error(result.message) // Gérer l'erreur si nécessaire
  }
}

const user = authStore.user
// Initialiser les informations de l'utilisateur au montage du composant
onMounted(() => {
  const storedUser = JSON.parse(localStorage.getItem('user') || 'null')
  if (storedUser) {
    authStore.initUser(storedUser)
  }
})
</script>

<style scoped>
/* Ajoute des styles supplémentaires si nécessaire */
</style>
