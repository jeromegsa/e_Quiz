<template>
  <div v-if="currentQuestionIndex < questions.length">
    <div class="flex text-left">
      <p class="font-bold mx-1">{{ currentQuestionIndex + 1 }}</p>
      <div class="w-full border-l-4 border-l-amber-600 py-3">
        <h2 class="pl-4 text-2xl font-bold">
          {{ questions[currentQuestionIndex].content }}
        </h2>
      </div>
    </div>

    <div class="w-full my-3 py-5 text-center" v-if="questions[currentQuestionIndex].question_type == 'text'">
      <input type="text" placeholder="Votre réponse"
        class="w-64 border-b-2 pb-1 bg-inherit focus:outline-none focus:border-b-2 border-b-white text-center text-2xl uppercase" />
    </div>
    <ul v-else class="">
      <li v-for="(option, index) in questions[currentQuestionIndex].options" :key="index" class="text-start">
        <div class="inline-block rounded-full bg-orange-400 h-3 w-3 m-1 mr-3"></div>
        {{ option }}
      </li>
    </ul>

    <div class="w-16 h-16 absolute left-4 bottom-6 flex justify-center items-center bg-orange-400 rounded-full">
      <div class="w-14 h-14 flex justify-center items-center bg-[#235763] rounded-full">
        <p class="font-semibold">{{ timer }} s</p>
      </div>
    </div>

    <div class="absolute right-3 bottom-2">
      <button @click="next" class="border-2 text-xl px-8 border-orange-400 bg-[#235763] py-1 rounded-md text-white">
        Valider
      </button>
    </div>

  </div>
</template>

<style></style>
<script setup>
import quizzes from '@/assets/data/quizzes';
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute()

const questions = ref([])
const currentQuestionIndex = ref(0) // Index de la question courante

// fonction pour récupérer les questions d'un quiz en fonction du paramètre de la route
const fetchQuestionByQuiz = () => {
  for (let quiz of quizzes.value) {
    if (quiz.id == route.params.id) {
      questions.value = quiz.questions
      console.log('questions', questions.value)
    }
  }
}

// Initialisation du timer et autres propriétés
const timer = ref(0)
const intervalId = ref()

onMounted(() => {
  fetchQuestionByQuiz()
  startTimer()
})

// Timer logic
const startTimer = () => {
  timer.value = questions.value[currentQuestionIndex.value].duree
  const timerInterval = setInterval(() => {
    if (timer.value !== 0) {
      timer.value--
    } else {
      clearInterval(timerInterval)
      next() // Passer à la question suivante si le timer atteint 0
    }
  }, 1000)
  intervalId.value = timerInterval
}

function stopTimer() {
  clearInterval(intervalId.value)
}

// Fonction pour passer à la question suivante
function next() {
  stopTimer() // Stopper le timer actuel
  if (currentQuestionIndex.value < questions.value.length - 1) {
    currentQuestionIndex.value++ // Incrémenter l'index pour la prochaine question
    startTimer() // Recommencer le timer pour la nouvelle question
  } else {
    console.log('Fin du quiz') // Toutes les questions ont été répondues
  }
}
</script>
