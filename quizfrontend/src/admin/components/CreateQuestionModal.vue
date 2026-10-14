<template>
  <div
    v-if="isModalOpen"
    class="fixed inset-0 bg-[#2E626E] border-sm bg-opacity-50 flex items-center justify-center"
  >
    <div class="bg-[#2E626E] w-1/3 rounded-lg shadow-lg p-6 border border-[#8ECAE6]">
      <!-- Bouton de fermeture -->
      <button @click="closeModal" class="float-right text-white">
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

      <!-- Formulaire de création de question -->
      <div class="mb-4">
        <label class="block mb-2 text-sm font-bold text-white">Type de question :</label>
        <select
          v-model="questionType"
          class="border border-[#8ECAE6] bg-transparent rounded-full w-[300px] py-2 px-5 text-white"
        >
          <option value="text" class="bg-[#023047] text-white">Réponse en mot clé</option>
          <option value="multiple_choice" class="bg-[#023047] text-white">Choix multiple</option>
          <option value="single_choice" class="bg-[#023047] text-white">Choix unique</option>
        </select>
      </div>

      <div class="mb-4">
        <label class="block mb-2 text-sm font-bold text-white">Question :</label>
        <input
          type="text"
          v-model="questionText"
          class="border border-[#8ECAE6] bg-transparent rounded-full w-full py-2 px-5 text-white"
        />
      </div>

      <div class="mb-4">
        <label class="block mb-2 text-sm font-bold text-white">Image (Optionnel):</label>
        <input
          type="file"
          name="imageUrl"
          class="border border-[#8ECAE6] bg-transparent rounded-full w-full py-2 px-5 text-white"
        />
      </div>

      <div class="mb-4">
        <label class="block mb-2 text-sm font-bold text-white">Points :</label>
        <input
          type="number"
          v-model.number="questionPoint"
          class="border border-[#8ECAE6] bg-transparent rounded-full w-full py-2 px-5 text-white"
        />
      </div>

      <!-- Réponses basées sur le type de question -->
      <div
        v-if="questionType === 'multiple_choice' || questionType === 'single_choice'"
        class="grid grid-cols-2 gap-4"
      >
        <div v-for="(response, index) in responses" :key="index" class="mb-4">
          <label class="block mb-2 text-sm font-bold text-white">Réponse {{ index + 1 }} :</label>
          <input
            type="text"
            v-model="response.content"
            class="border border-[#8ECAE6] bg-transparent rounded-full w-full py-2 px-5 text-white"
          />
          <div class="mt-2">
            <label class="inline-flex items-center">
              <input
                type="checkbox"
                v-model="response.is_correct"
                class="form-checkbox text-[#8ECAE6] h-5 w-5"
              />
              <span class="ml-2 text-white">Correct</span>
            </label>
          </div>
        </div>
      </div>

      <div v-if="questionType === 'text'">
        <div class="mb-4">
          <label class="block mb-2 text-sm font-bold text-white">Réponse :</label>
          <input
            type="text"
            v-model="keywordAnswer"
            class="border border-[#8ECAE6] bg-transparent rounded-full w-full py-2 px-5 text-white"
          />
        </div>
      </div>

      <div class="flex justify-end">
        <button class="bg-[#8ECAE6] text-black px-4 py-2 rounded-md" @click="addQuestion">
          Ajouter
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, defineProps, defineEmits } from 'vue'
import { useQuestionStore } from '../../stores/questions'
import type { InputCreateQuestion, InputCreateAnswerOption } from '../../services/questions/types'

// Définir les props
const props = defineProps({
  isModalOpen: {
    type: Boolean,
    required: true,
  },
  quizId: {
    type: Number,
    required: true,
  },
})

// Émettre des événements
const emit = defineEmits(['close'])

// Initialiser le store
const questionStore = useQuestionStore()

// Références pour le formulaire
const questionType = ref<'multiple_choice' | 'single_choice' | 'text'>('multiple_choice')
const questionText = ref<string>('')
const questionPoint = ref<number>(0)
const keywordAnswer = ref<string>('') // Pour les questions de type 'text'
const imageUrl = ref< string >('') // Stocker le fichier image

// Réponses multiples pour QCM ou QCU
const responses = ref<InputCreateAnswerOption[]>([
  { content: '', is_correct: false },
]
)

// Gestion de l'upload de l'image
// const handleImageUpload = (event: Event) => {
//   const file = (event.target as HTMLInputElement)?.files?.[0]
//   if (file) {
//     imageUrl.value = file // Stocker le fichier image dans `imageUrl`
//   }
// }

// Ajout d'une question avec FormData pour gérer les fichiers
const addQuestion = async () => {
  const validResponses = responses.value
    .filter(response => response.content.trim() !== '')
    .map(response => ({
      content: response.content,
      is_correct: response.is_correct,
    }));

  const input: InputCreateQuestion = {
    libelle: questionText.value,
    quizz_id: props.quizId,
    content: questionText.value,
    question_type: questionType.value,
    points: questionPoint.value,
    answer_options: validResponses,
  };

  const formData = createFormData(input, imageUrl.value:string);

  formData.forEach((value, key) => {
    console.log(`${key}: ${value}`);
  });

  const result = await questionStore.dispatchCreateQuestion(formData);
  console.log(result);
};

// Créer FormData avec image
function createFormData(input: InputCreateQuestion, file?: File): FormData {
  const formData = new FormData();

  // Ajouter les autres champs
  formData.append('libelle', input.libelle);
  formData.append('quizz_id', input.quizz_id.toString());
  formData.append('content', input.content);
  formData.append('question_type', input.question_type);
  formData.append('points', input.points.toString());

  // Ajouter l'image sous le bon nom 'image_url'
  if (file) {
    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
    if (allowedTypes.includes(file.type)) {
      formData.append('image_url', file, file.name);
    } else {
      console.error('Le fichier doit être une image de type jpeg, png, jpg ou gif.');
    }
  }


  // Ajouter les réponses
  formData.append('answer_options', JSON.stringify(input.answer_options));

  return formData;
}



// Fonction pour fermer la modale
const closeModal = () => {
  emit('close')
}
</script>

<style scoped>
/* Ajoutez votre style ici */
</style>
