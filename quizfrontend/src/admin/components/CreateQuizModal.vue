<template>
  <div
    v-if="isModalOpen"
    class="fixed inset-0 bg-[#2E626E] border-sm bg-opacity-50 flex items-center justify-center"
  >
    <div class="bg-[#2E626E] w-1/3 rounded-lg shadow-lg p-6 border border-[#8ECAE6]">
      <!-- Bouton de fermeture -->
      <button @click="closeModal" class="text-white float-right">
        <svg
          width="24"
          height="24"
          viewBox="0 0 24 24"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12L19 6.41Z"
            fill="white"
          />
        </svg>
      </button>

      <!-- Formulaire de création de quiz-->
      <div class="mb-4">
        <label class="block text-white text-sm font-bold mb-2">Nom du Quiz :</label>
        <input
          type="text"
          v-model="nomquiz"
          class="border border-[#8ECAE6] bg-transparent rounded-full w-full py-2 px-5 text-white"
        />
      </div>

      <div class="mb-4">
        <label class="block text-white text-sm font-bold mb-2">Durée:</label>
        <input
          v-model="duree"
          type="number"
          min="1"
          class="border border-[#8ECAE6] bg-transparent rounded-full w-full py-2 px-5 text-white"
        />
      </div>
      <div class="mb-4">
        <label class="block text-white text-sm font-bold mb-2">Statut (Activ ou désactivé):</label>
        <input type="checkbox" v-model="active" class="form-checkbox text-[#8ECAE6] h-5 w-5" />
      </div>

      <div class="mb-4">
        <label class="block text-white text-sm font-bold mb-2">Description :</label>
        <textarea
          v-model="description"
          class="border border-[#8ECAE6] bg-transparent rounded-[2rem] w-full py-5 px-5 text-white"
        ></textarea>
      </div>

      <div class="flex justify-end">
        <button class="bg-[#8ECAE6] text-black px-4 py-2 rounded-md" @click="addQuiz">Créer</button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, defineProps, defineEmits } from 'vue'
import { useQuizzStore } from '../../stores/quizz' // Assurez-vous que le chemin est correct

// Définir les props
const props = defineProps({
  isModalOpen: {
    type: Boolean,
    required: true,
  },
})

// Émettre des événements
const emit = defineEmits(['close'])

// Utiliser le store
const quizzStore = useQuizzStore()

// Définir les références
const nomquiz = ref('')
const active = ref(false)
const description = ref('')
const duree = ref(0)

// Ajout d'un quiz
const addQuiz = async () => {
  const input = {
    title: nomquiz.value,
    description: description.value,
    is_active: active.value,
    duration: duree.value,
  }

  // Appel de la méthode du store pour créer le quiz
  const response = await quizzStore.dispatchCreateQuizz(input)

  if (response.status === 201) {
    // Vérifier le statut HTTP pour la création réussie
    console.log('Quiz créé avec succès')
    // Réinitialiser les champs après la création
    nomquiz.value = ''
    description.value = ''
    active.value = false
    duree.value = 0
    closeModal() // Fermer la modal après la création
  } else {
    console.error('Erreur lors de la création du quiz')
  }
}

// Fonction pour fermer la modale
const closeModal = () => {
  emit('close')
}
</script>
