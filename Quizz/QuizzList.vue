<template>
  <CardTemplate v-if="quizChoosed !== undefined">
    <QuizzDetails :data="quizChoosed"></QuizzDetails>
  </CardTemplate>
  <div class="flex justify-between w-full mt-4 p-5">
    <button @click="onPrev" class="p-5"><img src="@/assets/arrow-left.svg" alt="" /></button>


    <button @click="onNext" class="p-5"><img src="@/assets/arrow-right.svg" alt="" /></button>
  </div>
 
</template>

<style scoped></style>

<script setup lang="ts">
import { onMounted, ref, computed } from 'vue'
import QuizzLayout from '../layouts/QuizzLayout.vue'
import CarrousselComponent from '../Home/CarrousselComponent.vue'
import CardTemplate from './CardTemplate.vue'
import QuizzDetails from './QuizzDetails.vue'
import QuizzLayoutTitle from './QuizzLayoutTitle.vue'
import QuizzLoader from './QuizzLoader.vue'
import quizzes from '@/assets/data/quizzes'



const currentQuizzIndex = ref(0)
const quizzList = ref(quizzes)
const isQuizzesAvailable = computed(() => quizzes.value.length !== 0)
const isLoading = ref(true)
let quizChoosed = ref({})

const sendData = (quizz: Object) => {
  quizChoosed.value = quizz
}
onMounted(() => {
  console.log('quiz list monté')
  // quizzList.value = quizzes,
  console.log('quizz list', quizzes.value)
})

const quizzesRef = ref([]);
async function fetchQuizzes() {
  try {

    // Assigne uniquement les données nécessaires à quizzesRef
    quizzesRef.value = quizzes.value // Assurez-vous que 'data.data' correspond à la structure de votre réponse

    // Vérifie les données récupérées
    console.log("quizzesRef", quizzesRef.value);
  } catch (error) {
    // Gère les erreurs
    console.error('Error fetching quizzes:', error);
  }
}

// Appeler la fonction pour récupérer les quizzes au chargement
fetchQuizzes();







const hideLoader = () => (isLoading.value = false)

const onPrev = () => {
  if (quizzesRef.value.length) {
    currentQuizzIndex.value =
      currentQuizzIndex.value > 0 ? --currentQuizzIndex.value : currentQuizzIndex.value
  }
}

const onNext = () => {
  if (quizzesRef.value.length) {
    currentQuizzIndex.value =
      currentQuizzIndex.value < quizzList.value.length - 1
        ? ++currentQuizzIndex.value
        : currentQuizzIndex.value
  }
}
</script>
