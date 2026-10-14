<template>
  <div>
    <Navbar />
    <main>
      <div class="flex items-center mt-[5rem] justify-center min-h-screen bg-gray">
        <div
          class="flex flex-col relative rounded-[1.25rem] space-y-8 shadow-2xl max-w-4xl md:flex-row md:space-y-0"
        >
          <!-- Form Container -->
          <div
            class="flex flex-col flex-grow p-8 transition-transform duration-500 ease-in-out w-full"
            :class="isRegister ? 'translate-x-full' : 'translate-x-0'"
          >
            <div class="flex justify-end gap-5 mr-5 mt-5">
              <router-link to="/login" @click="toggleForm(false)" class="text-orange-500 font-bold"
                >Connexion</router-link
              >

              <router-link to="" @click="toggleForm(true)">Inscription</router-link>
            </div>
            <!-- Connexion Form -->
            <div v-if="!isRegister">
              <div class="flex flex-col mt-[5rem]">
                <p class="uppercase font-bold text-3xl">Se connecter</p>
                <p class="text-[1rem] w-full">Connectez-vous pour avoir accès à vos résultats</p>
              </div>
              <div class="flex flex-col justify-start mt-5 p-3 w-full">
                <form
                  @submit.prevent="handleLogin"
                  class="flex flex-col justify-start w-full space-y-6"
                >
                  <input
                    type="email"
                    v-model="email"
                    placeholder="youremail@email.com"
                    class="border-b-2 active:placeholder:text-[#fb8501] w-full outline-none border-[#FB8501] text-[#FB8501] mb-10"
                    name="email"
                    id="email"
                  />
                  <input
                    type="password"
                    v-model="password"
                    placeholder="Mot de passe"
                    class="border-b-2 mb-10 w-full outline-none"
                    name="password"
                    id="password"
                  />
                  <input
                    type="submit"
                    value="Se connecter"
                    class="bg-gradient-to-tl from-[#FB8501] to-[#FFB703] p-2 w-full rounded-lg text-white"
                  />
                </form>
                <p v-if="error">{{ error }}</p>
              </div>
            </div>
            <!-- Inscription Form -->
            <div v-if="isRegister">
              <div class="flex flex-col mt-[5rem]">
                <p class="text-3xl font-bold uppercase">S'inscrire</p>
                <p class="text-[1rem] w-full">Inscrivez-vous pour accéder à votre compte</p>
              </div>
              <div class="flex flex-col justify-start w-full p-3 mt-5">
                <Toast />
                <!-- Composant Toast -->
                <form
                  @submit.prevent="handleRegister"
                  class="flex flex-col justify-start w-full space-y-6"
                >
                  <input
                    type="email"
                    v-model="email"
                    placeholder="youremail@email.com"
                    class="w-full py-2 placeholder-orange-400 border-b-2 border-orange-500 outline-none focus:border-orange-700"
                    required
                  />
                  <input
                    type="text"
                    v-model="username"
                    placeholder="Nom"
                    class="w-full py-2 text-orange-500 border-b-2 border-gray-500 outline-none"
                  />
                  <input
                    type="password"
                    v-model="password"
                    placeholder="Mot de passe"
                    class="w-full py-2 border-b-2 border-gray-500 outline-none"
                  />
                  <input
                    type="submit"
                    value="S'inscrire"
                    class="w-full py-2 mt-4 text-white rounded-lg cursor-pointer bg-gradient-to-tl from-orange-500 to-yellow-500 hover:from-orange-600"
                  />
                </form>
                <p v-if="error">{{ error }}</p>
              </div>
            </div>
          </div>
          <!-- Side Image Section -->
          <div
            class="relative hidden md:flex flex-shrink-0 transition-transform duration-500 ease-in-out"
            :class="isRegister ? '-translate-x-full' : 'translate-x-0'"
          >
            <div
              class="w-[370px] rounded-tr-[1.25rem] rounded-[1.25rem] bg-gradient-to-tl from-[#FB8501] to-[#FFB703] flex justify-center items-center"
            >
              <div
                class="rounded-full opacity-[35%] absolute bg-[#FB8501] w-[15.625rem] h-[15.625rem]"
              ></div>
              <div
                class="rounded-full relative z-99 text-center flex items-center justify-center bg-[#FB8501] w-[12.125rem] h-[12.125rem] opacity-[25%]"
              ></div>
              <img class="z-10 absolute" src="../assets/images/logo.svg" alt="Logo" />
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue'
import { useAuthStore } from '../stores/authStore'
import { useToast } from 'primevue/usetoast'
import { useRouter } from 'vue-router' // Importer useRouter
import Navbar from '../components/layouts/Navbar.vue'


const router = useRouter() // Initialiser useRouter
const authStore = useAuthStore()

const toast = useToast() // Utilisation du service toast

// Champs du formulaire

const username = ref('')
const email = ref('')
const password = ref('')
const error = ref<string | null>(null)

// Gérer l'inscription
const handleRegister = async () => {
  const result = await authStore.dispatchCreateUser({
    username: username.value,
    email: email.value,
    password: password.value,
  })
  if (result.status !== 201) {
    error.value = result.message // Affiche l'erreur si l'inscription échoue
    // En cas d'erreur, afficher un toast d'erreur
    toast.add({
      severity: 'error',
      summary: 'Erreur',
      detail: "Échec de l'enregistrement",
      life: 3000,
    })
    // Rediriger l'utilisateur vers la page d'accueil ou une autre page
    router.push('/login')
  } else {
    username.value = ''
    email.value = ''
    password.value = ''
    // Si l'enregistrement réussit, afficher un toast de succès
    toast.add({
      severity: 'success',
      summary: 'Succès',
      detail: 'Utilisateur enregistré',
      life: 3000,
    })

    error.value = 'Utilisateur crée avec succès....' // Affiche l'erreur si l'inscription échoue
  }
  // if (!result.success) {
  //   error.value = result.message // Affiche l'erreur si l'inscription échoue
  // }
}

// const handleLogin = async () => {
//   const response = await authStore.dispatchLogin({ email: email.value, password: password.value  })
//   if (!response.success) {
//     error.value = response.message || ' une erreur est survenue'
//   } else {
//     const user = response.user
//     if (user && (user.role === 'admin' || user.role === 'super_admin')) {
//       router.push('/quiz')
//     } else {
//       router.push('/admin')
//     }
//   }
// }

const handleLogin = async () => {
  const response = await authStore.dispatchLogin({ email: email.value, password: password.value })

  if (!response.success) {
    error.value = response.message || 'Une erreur est survenue'
  } else {
    const user = response.user
    console.log('User role:', user.role) // Vérifie le rôle de l'utilisateur

    if (user) {
      if (user.role === 'admin' || user.role === 'super_admin') {
        router.push('/admin')
      } else if (user.role === 'user') {
        router.push('/quiz')
      } else {
        error.value = 'Rôle inconnu'
      }
    }
  }
}

// Gestion de l'état pour basculer entre Connexion et Inscription
const isRegister = ref(false)
const toggleForm = (register) => {
  isRegister.value = register
}
const resetForm = () => {
  username.value = ''
  email.value = ''
  password.value = ''
}
</script>

<style scoped>
/* Ajoutez ici des styles personnalisés si nécessaire */
</style>
