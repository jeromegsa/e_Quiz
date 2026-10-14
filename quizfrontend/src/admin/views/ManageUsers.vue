<template>
  <div class="my-[1.813rem] flex items-center justify-between">
    <div class="flex items-center justify-between">
      <span class="absolute ml-2">
        <svg
          width="24"
          height="24"
          viewBox="0 0 24 24"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M20.0004 20.0001L15.9504 15.9501M15.9504 15.9501C16.6004 15.3001 17.116 14.5284 17.4678 13.679C17.8196 12.8297 18.0007 11.9194 18.0007 11.0001C18.0007 10.0808 17.8196 9.17051 17.4678 8.32119C17.116 7.47187 16.6004 6.70016 15.9504 6.05011C15.3003 5.40007 14.5286 4.88443 13.6793 4.53263C12.83 4.18083 11.9197 3.99976 11.0004 3.99976C10.0811 3.99976 9.17076 4.18083 8.32144 4.53263C7.47211 4.88443 6.7004 5.40007 6.05036 6.05011C4.73754 7.36293 4 9.1435 4 11.0001C4 12.8567 4.73754 14.6373 6.05036 15.9501C7.36318 17.2629 9.14375 18.0005 11.0004 18.0005C12.857 18.0005 14.6375 17.2629 15.9504 15.9501Z"
            stroke="white"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
          />
        </svg>
      </span>
      <input
        type="text"
        placeholder="Rechercher un utilisateur..."
        v-model="searchText"
        class="border outline-none border-[#8ECAE6] bg-transparent rounded-full w-[639px] py-2 px-10 text-white"
      />
    </div>
    <div>
      <button @click="openQuizModal" class="bg-[#2E626E] w-[127px] text-white rounded-lg p-2">
        Creer un admin
      </button>
    </div>
  </div>
  <div
    v-for="(user, index) in paginatedUsers"
    :key="index"
    class="bg-[#385766] w-full flex items-center justify-between p-5 mb-5 text-white rounded-lg"
  >
    <span>{{ index + 1 }}</span>
    <span class="h-8 w-px bg-white mx-4"></span>
    <span> {{ user.username }}</span
    ><span class="h-8 w-px bg-white mx-4"></span> <span>{{ user.email }}</span
    ><span class="h-8 w-px bg-white mx-4"></span>
    <span>{{ user.score }}</span>
    <div class="flex gap-5 items-center justify-center">
      <span @click="" class="cursor-pointer"
        ><svg
          width="24"
          height="24"
          viewBox="0 0 24 24"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M12 9C11.2044 9 10.4413 9.31607 9.87868 9.87868C9.31607 10.4413 9 11.2044 9 12C9 12.7956 9.31607 13.5587 9.87868 14.1213C10.4413 14.6839 11.2044 15 12 15C12.7956 15 13.5587 14.6839 14.1213 14.1213C14.6839 13.5587 15 12.7956 15 12C15 11.2044 14.6839 10.4413 14.1213 9.87868C13.5587 9.31607 12.7956 9 12 9ZM12 17C10.6739 17 9.40215 16.4732 8.46447 15.5355C7.52678 14.5979 7 13.3261 7 12C7 10.6739 7.52678 9.40215 8.46447 8.46447C9.40215 7.52678 10.6739 7 12 7C13.3261 7 14.5979 7.52678 15.5355 8.46447C16.4732 9.40215 17 10.6739 17 12C17 13.3261 16.4732 14.5979 15.5355 15.5355C14.5979 16.4732 13.3261 17 12 17ZM12 4.5C7 4.5 2.73 7.61 1 12C2.73 16.39 7 19.5 12 19.5C17 19.5 21.27 16.39 23 12C21.27 7.61 17 4.5 12 4.5Z"
            fill="white"
          />
        </svg>
      </span>
      <span @click="" class="cursor-pointer"
        ><svg
          width="24"
          height="24"
          viewBox="0 0 24 24"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M12 2C6.477 2 2 6.477 2 12C2 17.523 6.477 22 12 22C17.523 22 22 17.523 22 12C22 6.477 17.523 2 12 2ZM17 13H13V17H11V13H7V11H11V7H13V11H17V13Z"
            fill="white"
          />
        </svg>
      </span>
      <span class="cursor-pointer"
        ><svg
          width="24"
          height="24"
          viewBox="0 0 24 24"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M8.25 8.25C8.44891 8.25 8.63968 8.32902 8.78033 8.46967C8.92098 8.61032 9 8.80109 9 9V18C9 18.1989 8.92098 18.3897 8.78033 18.5303C8.63968 18.671 8.44891 18.75 8.25 18.75C8.05109 18.75 7.86032 18.671 7.71967 18.5303C7.57902 18.3897 7.5 18.1989 7.5 18V9C7.5 8.80109 7.57902 8.61032 7.71967 8.46967C7.86032 8.32902 8.05109 8.25 8.25 8.25ZM12 8.25C12.1989 8.25 12.3897 8.32902 12.5303 8.46967C12.671 8.61032 12.75 8.80109 12.75 9V18C12.75 18.1989 12.671 18.3897 12.5303 18.5303C12.3897 18.671 12.1989 18.75 12 18.75C11.8011 18.75 11.6103 18.671 11.4697 18.5303C11.329 18.3897 11.25 18.1989 11.25 18V9C11.25 8.80109 11.329 8.61032 11.4697 8.46967C11.6103 8.32902 11.8011 8.25 12 8.25ZM16.5 9C16.5 8.80109 16.421 8.61032 16.2803 8.46967C16.1397 8.32902 15.9489 8.25 15.75 8.25C15.5511 8.25 15.3603 8.32902 15.2197 8.46967C15.079 8.61032 15 8.80109 15 9V18C15 18.1989 15.079 18.3897 15.2197 18.5303C15.3603 18.671 15.5511 18.75 15.75 18.75C15.9489 18.75 16.1397 18.671 16.2803 18.5303C16.421 18.3897 16.5 18.1989 16.5 18V9Z"
            fill="white"
          />
          <path
            d="M21.75 4.5C21.75 4.89782 21.592 5.27936 21.3107 5.56066C21.0294 5.84196 20.6478 6 20.25 6H19.5V19.5C19.5 20.2956 19.1839 21.0587 18.6213 21.6213C18.0587 22.1839 17.2956 22.5 16.5 22.5H7.5C6.70435 22.5 5.94129 22.1839 5.37868 21.6213C4.81607 21.0587 4.5 20.2956 4.5 19.5V6H3.75C3.35218 6 2.97064 5.84196 2.68934 5.56066C2.40804 5.27936 2.25 4.89782 2.25 4.5V3C2.25 2.60218 2.40804 2.22064 2.68934 1.93934C2.97064 1.65804 3.35218 1.5 3.75 1.5H9C9 1.10218 9.15804 0.720644 9.43934 0.43934C9.72064 0.158035 10.1022 0 10.5 0L13.5 0C13.8978 0 14.2794 0.158035 14.5607 0.43934C14.842 0.720644 15 1.10218 15 1.5H20.25C20.6478 1.5 21.0294 1.65804 21.3107 1.93934C21.592 2.22064 21.75 2.60218 21.75 3V4.5ZM6.177 6L6 6.0885V19.5C6 19.8978 6.15804 20.2794 6.43934 20.5607C6.72064 20.842 7.10218 21 7.5 21H16.5C16.8978 21 17.2794 20.842 17.5607 20.5607C17.842 20.2794 18 19.8978 18 19.5V6.0885L17.823 6H6.177ZM3.75 4.5H20.25V3H3.75V4.5Z"
            fill="white"
          />
        </svg>
      </span>
    </div>
  </div>

  <!-- Pagination Controls -->
  <div class="flex justify-center space-x-2">
    <span
      v-for="page in displayedPages"
      :key="page"
      @click="currentPage = page !== '...' ? page : null"
      :class="[
        'cursor-pointer px-3 py-1 rounded-lg',
        page === currentPage ? 'bg-[#2E626E] text-white' : ' text-white',
        page === '...' ? 'cursor-default' : '',
      ]"
    >
      {{ page }}
    </span>
  </div>

  <!-- Message alternatif si il y aucun user  -->
  <p v-if="userStore.users.length === 0">Aucun Utilisateur disponible.</p>
</template>
<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import { useUsertore } from '../../stores/user'

const userStore = useUsertore()
const currentPage = ref(1) //Page actuelle
const totalPages = computed(() => Math.ceil(userStore.users.length / pageSize))
const displayedPages = computed(() => {
  const pages = []

  //toujours afficher la première page
  if (totalPages.value > 1) {
    pages.push(1)
  }
  //Déterminer les pages a afficher autour de la page actuelle
  const start = Math.max(2, currentPage.value - 1)
  const end = Math.min(totalPages.value - 1, currentPage.value + 1)
  //Déterminer les pages autour de la page actuelle
  for (let i = start; i <= end; i++) {
    pages.push(i)
  }
  //Ajouter des ellipses si nécessaire
  if (currentPage.value < totalPages.value - 2) {
    pages.push('...')
  }
  //Afficher la dernière page si elle n'est pas déjà affichée
  if (totalPages.value > 1 && currentPage.value < totalPages.value) {
    pages.push(totalPages.value)
  }
  return pages
})
//Pagination
const pageSize = 5 //nombre d'élément par page
const paginatedUsers = computed(() => {
  const start = (currentPage.value - 1) * pageSize
  return userStore.users.slice(start, start + pageSize)
})

const fetchUsers = async () => {
  const result = await userStore.dispatchGetUsers()
  if (!result.success) {
    console.error('Erreur lors de la récupération des utilisateurs')
  }
}
onMounted(fetchUsers)
</script>

<style scoped></style>
