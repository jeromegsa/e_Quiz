<template>
  <div class="bg-[#235763] p-6 rounded-lg text-white flex flex-col items-center">

    <div v-if="currentQuestionIndex < questions.length && !isQuizCompleted">
      <div class="flex text-left">
        <p class="font-bold mx-1">{{ currentQuestionIndex + 1 }}</p>
        <div class="w-full border-l-4 border-l-amber-600 py-3">
          <h2 class="pl-4 text-2xl font-bold">
            {{ questions[currentQuestionIndex].content }}
          </h2>
        </div>
      </div>


      <div class="w-full my-3 py-5 text-center"
        v-if="questions[currentQuestionIndex].question_type == 'text' && !isQuizCompleted">
        <input type="text" placeholder="Votre réponse " v-model="textAnswer"
          class="w-64 border-b-2 pb-1 bg-inherit focus:outline-none focus:border-b-2 border-b-white text-center text-2xl uppercase" />
      </div>
      <ul v-else class="">
        <li v-for="(option, index) in questions[currentQuestionIndex].answer_options" :key="index"
          class="text-start my-2">
          <label class="inline-flex items-center">
            <!-- Bouton radio -->
            <input type="radio" :name="'question' + currentQuestionIndex" :value="option.id" v-model="selectedAnswer"
              class="form-radio h-5 w-5 text-orange-500" />
            <span class="ml-2">{{ option.content }}</span>
          </label>
        </li>
      </ul>

      <div class="flex justify-between">

        <div class="w-16 h-16  left-4 bottom-6 flex justify-center items-center bg-orange-400 rounded-full">
          <div class="w-14 h-14 flex justify-center items-center bg-[#235763] rounded-full">
            <p class="font-semibold">{{ timer }} s</p>
          </div>
        </div>

        <div class="flex justify-end items-end">
          <button @click="next" class="border-2 text-xl px-8 border-orange-400 bg-[#235763] py-1 rounded-md text-white">
            Valider
          </button>
        </div>

      </div>
    </div>

    <!-- Affichage du composant QuizResultat uniquement si le quiz est terminé -->

    <QuizResult v-if="isQuizCompleted" :score="score" :totalDuration="totalDuration" @restart="restartQuiz" />
  </div>
</template>

<script setup>
import quizzes from '@/assets/data/quizzes';
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import QuizResult from '@/components/Quizz/QuizzResult.vue'

const route = useRoute();
const totalDuration = ref(0); // Nouvelle variable pour la durée totale

const questions = ref([]);
const currentQuestionIndex = ref(0); // Index de la question courante
const score = ref(0); // Score total
const selectedAnswer = ref(null); // Réponse sélectionnée pour les questions à choix multiple
const textAnswer = ref(''); // Réponse textuelle pour les questions de type input
let isQuizCompleted = ref(false); // Variable pour gérer l'état du quiz
// Fonction pour récupérer les questions d'un quiz en fonction du paramètre de la route
const fetchQuestionByQuiz = () => {
  for (let quiz of quizzes.value) {
    if (quiz.id == route.params.id) {
      questions.value = quiz.questions;
      console.log('questions', questions.value);
    }
  }
}

// Initialisation du timer et autres propriétés
const timer = ref(0);
const intervalId = ref();

onMounted(() => {
  fetchQuestionByQuiz();
  startTimer();
});

// Timer logic
const startTimer = () => {
  timer.value = questions.value[currentQuestionIndex.value].duration;
  // totalDuration.value = 0; // Réinitialiser la durée totale au démarrage du quiz

  const timerInterval = setInterval(() => {
    if (timer.value !== 0) {
      timer.value--;
      totalDuration.value++

    } else {
      clearInterval(timerInterval);
      next(); // Passer à la question suivante si le timer atteint 0
    }
  }, 1000);
  intervalId.value = timerInterval;
}

function stopTimer() {
  clearInterval(intervalId.value);
}

// Fonction pour passer à la question suivante
function next() {
  // Calcul des points
  const currentQuestion = questions.value[currentQuestionIndex.value];

  // Vérification du type de question
  if (currentQuestion.question_type === 'multiple_choice') {
    const selectedOption = currentQuestion.answer_options.find(option => option.id === selectedAnswer.value);
    if (selectedOption && selectedOption.is_correct === 1) {
      score.value += currentQuestion.points; // Ajoute les points si la réponse est correcte
    }
  } else if (currentQuestion.question_type === 'text') {
    const correctAnswer = currentQuestion.answer_options[0].content.toLowerCase(); // Supposons que la bonne réponse est toujours à l'index 0
    if (textAnswer.value.toLowerCase() === correctAnswer) {
      score.value += currentQuestion.points; // Ajoute les points si la réponse est correcte
    }
  }

  console.log('Score total:', score.value); // Affiche le score total dans la console

  // Réinitialisation des réponses pour la prochaine question
  stopTimer(); // Stopper le timer actuel
  if (currentQuestionIndex.value < questions.value.length - 1) {
    currentQuestionIndex.value++; // Incrémenter l'index pour la prochaine question
    selectedAnswer.value = null; // Réinitialiser la réponse sélectionnée
    textAnswer.value = ''; // Réinitialiser la réponse textuelle
    startTimer(); // Recommencer le timer pour la nouvelle question
  } else {
    isQuizCompleted.value = true; // Marquer le quiz comme terminé
    totalDuration.value=totalDuration.value/60
    console.log("duree en minutes", totalDuration.value);

    console.log('Fin du quiz, score final:', score.value); // Toutes les questions ont été répondues
  }
}


// Fonction pour redémarrer le quiz
function restartQuiz() {
  totalDuration.value = 0
  isQuizCompleted.value = false
  currentQuestionIndex.value = 0;
  score.value = 0;
  selectedAnswer.value = null;
  textAnswer.value = '';
  fetchQuestionByQuiz(); // Récupérer à nouveau les questions
  startTimer();
}
</script>
