<template>
  <div class="flex items-start justify-between gap-5 mt-5 w-full">
    <Toast />
    <!-- Formulaire principal -->
    <div class="bg-[#2E626E] w-3/4 p-5 rounded-lg">
      <form @submit.prevent="addQuestion" class="grid grid-cols-2 gap-4">
        <!-- Nom du quiz -->
        <div class="col-span-1">
          <label class="block text-white text-sm font-bold mb-2">Nom du quiz</label>
          <input type="text" v-model="quizName" placeholder="Quiz HTML"
            class="border border-[#8ECAE6] bg-transparent rounded-full w-full py-2 px-5 text-white" />
        </div>

        <!-- Image -->
        <div class="col-span-1">
          <label class="block text-white text-sm font-bold mb-2">Image</label>
          <input type="file" @change="handleImageUpload"
            class="border border-[#8ECAE6] bg-transparent rounded-full w-full py-2 px-5 text-white" />
        </div>

        <!-- Durée -->
        <div class="col-span-1">
          <label class="block text-white text-sm font-bold mb-2">Durée totale (min)</label>
          <p class="border border-[#8ECAE6] bg-transparent rounded-full w-full py-2 px-5 text-white">
            {{ `${Math.ceil(duration / 60)} min` }}
          </p>
        </div>

        <!-- Statut -->
        <div class="col-span-1">
          <label class="block text-white text-sm font-bold mb-2">Statut (Active ou Inactive)</label>
          <input type="checkbox" v-model="status"
            class="border border-[#8ECAE6] bg-transparent rounded w-6 h-6 text-white" />
        </div>

        <!-- Description -->
        <div class="col-span-2">
          <label class="block text-white text-sm font-bold mb-2">Description</label>
          <textarea v-model="quizDescription"
            class="border border-[#8ECAE6] bg-transparent rounded-lg w-full py-2 px-5 text-white" rows="3"></textarea>
        </div>

        <!-- Type de question -->
        <div class="col-span-1">
          <label class="block text-white text-sm font-bold mb-2">Type de question</label>
          <select v-model="questionType"
            class="border border-[#8ECAE6] bg-transparent rounded-full w-full py-2 px-5 text-white">
            <option value="vrai_faux" class="bg-[#023047] text-white">Réponse Vrai ou Faux</option>
            <option value="text" class="bg-[#023047] text-white">Réponse en mot clé</option>
            <option value="multiple_choice" class="bg-[#023047] text-white">Choix multiple</option>
            <option value="single_choice" class="bg-[#023047] text-white">Choix unique</option>
          </select>
        </div>

        <!-- Nombre de questions -->
        <div class="col-span-1">
          <label class="block text-white text-sm font-bold mb-2">Nombre de questions</label>
          <input type="number" min="1" v-model="numberOfQuestions" placeholder=""
            class="border border-[#8ECAE6] bg-transparent rounded-full w-full py-2 px-5 text-white" />
        </div>

        <!-- Question -->
        <div class="col-span-2">
          <label class="block text-white text-sm font-bold mb-2">Question</label>
          <textarea v-model="questionText"
            class="border border-[#8ECAE6] bg-transparent rounded-lg w-full py-2 px-5 text-white" rows="2"></textarea>
        </div>

        <!-- Image de la question (optionnelle) -->
        <div class="col-span-2">
          <label class="block text-white text-sm font-bold mb-2">Image de la question (optionnelle)</label>
          <input type="file" @change="handleQuestionImageUpload"
            class="border border-[#8ECAE6] bg-transparent rounded-full w-full py-2 px-5 text-white" />
        </div>

        <!-- Durée par question -->
        <div class="col-span-1">
          <label class="block text-white text-sm font-bold mb-2">Durée de la question (sec)</label>
          <input type="number" min="1" v-model="durationPerQuestion" placeholder=""
            class="border border-[#8ECAE6] bg-transparent rounded-full w-full py-2 px-5 text-white" />
        </div>

        <!-- Points par question -->
        <div class="col-span-1">
          <label class="block text-white text-sm font-bold mb-2">Points de la question</label>
          <input type="number" v-model="pointsPerQuestion" placeholder="" min="1"
            class="border border-[#8ECAE6] bg-transparent rounded-full w-full py-2 px-5 text-white" />
        </div>

        <!-- Réponses -->
        <div>
          <div v-for="(response, index) in responses" :key="index" class="mb-4">
            <label class="block text-white text-sm font-bold mb-2">Réponse {{ index + 1 }} :</label>
            <input type="text" v-model="response.content"
              class="border border-[#8ECAE6] bg-transparent rounded-full w-full py-2 px-5 text-white" />
            <div class="mt-2">
              <label class="inline-flex items-center">
                <input type="checkbox" v-model="response.is_correct" class="form-checkbox text-[#8ECAE6] h-5 w-5" />
                <span class="ml-2 text-white">Correct</span>
              </label>
            </div>
          </div>
          <button type="button" @click="addResponseOption"
            class="mt-2 bg-[#8ECAE6] text-white py-2 px-4 rounded-full hover:bg-[#5f99a2]">
            Ajouter une option
          </button>
        </div>

        <!-- Options Vrai/Faux -->
        <div v-if="questionType === 'vrai_faux'" class="col-span-2">
          <label class="block text-white text-sm font-bold mb-2">Choisissez une option</label>
          <div class="flex gap-4">
            <div class="flex items-center">
              <input type="radio" id="vrai" name="vrai_faux" value="vrai" v-model="vrai_faux" class="mr-2" />
              <label for="vrai" class="text-white mr-2">Vrai</label>
              <input type="checkbox" v-model="vraiCorrect" class="form-checkbox text-[#8ECAE6] h-5 w-5" />
              <span class="ml-2 text-white">Correct</span>
            </div>
            <div class="flex items-center">
              <input type="radio" id="faux" name="vrai_faux" value="faux" v-model="vrai_faux" class="mr-2" />
              <label for="faux" class="text-white mr-2">Faux</label>
              <input type="checkbox" v-model="fauxCorrect" class="form-checkbox text-[#8ECAE6] h-5 w-5" />
              <span class="ml-2 text-white">Correct</span>
            </div>
          </div>
        </div>

        <!-- Réponse en mot clé -->
        <div v-if="questionType === 'text'">
          <div class="mb-4">
            <label class="block text-white text-sm font-bold mb-2">Réponse :</label>
            <input type="text" v-model="keywordAnswer"
              class="border border-[#8ECAE6] bg-transparent rounded-full w-full py-2 px-5 text-white" />
          </div>
        </div>

        <!-- Bouton Ajouter -->
        <div class="col-span-2 text-center">
          <button type="submit" class="bg-[#8ECAE6] text-white py-2 px-10 rounded-full">
            Ajouter
          </button>
        </div>
      </form>
      <button v-if="questions.length >= numberOfQuestions" @click="submitQuiz"
        class="mt-5 bg-[#448fa0] text-white py-2 px-10 rounded-full">
        Valider le Quiz
      </button>
    </div>

    <!-- Liste des questions -->
    <div class="bg-[#2E626E] w-1/4 p-5 rounded-lg">
      <h3 class="text-white text-lg font-bold mb-4">Liste des questions</h3>
      <ul class="list-disc list-inside text-white">
        <li v-for="(q, index) in questions" :key="index">
          {{ q.libelle }} - Type: {{ q.question_type }}
          <span v-if="q.duration"> - Durée: {{ q.duration }} sec</span>
          <span v-if="q.points"> - Points: {{ q.points }}</span>
          <ul class="mt-2">
            <li v-for="(option, i) in q.answer_options" :key="i" class="pl-4">
              {{ option.content }}
              <span v-if="option.is_correct" class="text-green-500"> (Correcte)</span>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useToast } from 'primevue/usetoast'
import { useQuizzStore } from '../../stores/quizz'
import type { InputCreateQuizz } from '../../services/quizzs/types'
import type { InputCreateQuestion, InputCreateAnswerOption } from '../../services/questions/types'

const toast = useToast()
const quizzStore = useQuizzStore()

// État pour le nouveau quiz
const quizz = ref<InputCreateQuizz>({
  title: '',
  description: '',
  is_active: false,
  duration: 0,
  image_url: null,
  questions: [],
})

const quizName = ref<string>('')
const quizDescription = ref<string>('')
const status = ref<boolean>(false)
const duration = ref<number>(0)
const questionType = ref<string>('')
const numberOfQuestions = ref<number>(0)
const questionText = ref<string>('')
const durationPerQuestion = ref<number>(0)
const pointsPerQuestion = ref<number>(0)
const responses = ref<InputCreateAnswerOption[]>([{ content: '', is_correct: false }])
const vrai_faux = ref<string>('')
const vraiCorrect = ref<boolean>(false)
const fauxCorrect = ref<boolean>(false)
const keywordAnswer = ref<string>('')
const questions = ref<InputCreateQuestion[]>([])
const questionImage = ref<File | null>(null)

// Pour gérer l'upload de l'image du quiz
const handleImageUpload = (event: Event) => {
  const target = event.target as HTMLInputElement
  if (target.files && target.files[0]) {
    quizz.value.image_url = target.files[0]
  }
}

// Pour gérer l'upload de l'image de chaque question (optionnelle)
const handleQuestionImageUpload = (event: Event) => {
  const target = event.target as HTMLInputElement
  if (target.files && target.files[0]) {
    questionImage.value = target.files[0]
  }
}

const addResponseOption = () => {
  responses.value.push({ content: '', is_correct: false })
}

const addQuestion = () => {
  if (questionText.value && questionType.value && durationPerQuestion.value > 0) {
    let answerOptions: InputCreateAnswerOption[] = []

    if (questionType.value === 'vrai_faux') {
      answerOptions = [
        { content: 'Vrai', is_correct: vraiCorrect.value },
        { content: 'Faux', is_correct: fauxCorrect.value },
      ]
    } else if (questionType.value === 'text') {
      answerOptions = [{ content: keywordAnswer.value, is_correct: true }]
    } else {
      answerOptions = responses.value.filter(response => response.content.trim() !== '');
    }
    // Si answerOptions est vide après le filtrage, renvoie une erreur
    if (answerOptions.length === 0) {
      toast.add({
        severity: 'error',
        summary: 'Erreur',
        detail: "Les options de réponse ne peuvent pas être vides.",
        life: 3000,
      });
      return;
    }

    questions.value.push({
      libelle: questionText.value,
      content: questionText.value,
      question_type: questionType.value,
      points: pointsPerQuestion.value,
      duration: durationPerQuestion.value,
      answer_options: answerOptions,
      image_url: questionImage.value, // Ajout de l'image de la question ici
    } as InputCreateQuestion)

    toast.add({
      severity: 'success',
      summary: 'Succès',
      detail: 'Question enregistrée',
      life: 3000,
    })

    duration.value += durationPerQuestion.value

    // Réinitialiser les champs du formulaire
    questionText.value = ''
    durationPerQuestion.value = 0
    pointsPerQuestion.value = 0
    responses.value = [{ content: '', is_correct: false }]
    vraiCorrect.value = false
    fauxCorrect.value = false
    keywordAnswer.value = '' // Réinitialiser la réponse en mot clé
    questionImage.value = null // Réinitialiser l'image de la question
  } else {
    toast.add({
      severity: 'error',
      summary: 'Erreur',
      detail: "Échec de l'enregistrement",
      life: 3000,
    })
  }
}


const submitQuiz = async () => {
  quizz.value.title = quizName.value
  quizz.value.description = quizDescription.value
  quizz.value.is_active = status.value
  quizz.value.duration = duration.value
  quizz.value.questions = questions.value

  try {
    const response = await quizzStore.dispatchCreateQuizz(quizz.value)
    if (response.success) {
      toast.add({
        severity: 'success',
        summary: 'Succès',
        detail: 'Quizz créé avec succès',
        life: 3000,
      })

      // Réinitialiser les champs du formulaire après la soumission
      quizName.value = ''
      quizDescription.value = ''
      status.value = false
      duration.value = 0
      questions.value = []
      responses.value = [{ content: '', is_correct: false }] // Réinitialiser les réponses
      questionText.value = ''
      durationPerQuestion.value = 0
      pointsPerQuestion.value = 0
      questionImage.value = null // Réinitialiser l'image de la question
    } else {
      toast.add({
        severity: 'error',
        summary: 'Erreur',
        detail: 'Erreur lors de la création du quizz',
        life: 3000,
      })
    }
  } catch (error) {
    console.error('Erreur lors de la création du quizz', error)
    toast.add({
      severity: 'error',
      summary: 'Erreur',
      detail: 'Erreur lors de la création du quizz',
      life: 3000,
    })
  }
}



</script>

<style scoped></style>
