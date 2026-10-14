<template>
  <div class="container mx-auto p-6">
    <!-- Vérifier si le quiz est défini -->
    <div v-if="quiz" class="bg-[#235763] p-6 rounded-lg text-white flex flex-col items-center">
      <h2 class="text-lg font-bold border-l-4 border-l-[#FB8501] p-5 mb-5">{{ quiz.title }}</h2>
      <p class="text-sm mt-2">
        <span class="font-bold underline text-center text-wrap text-2xl">Description:</span>
        {{ quiz.description }}
      </p>
      <div class="mt-4 flex space-x-8 text-lg">
        <p>
          <span class="font-bold underline text-2xl">DETAILS:</span>
          <span class="text-orange-400 text-5xl">{{ quiz.questions.length }}</span> questions
        </p>
        <p>
          <span class="font-bold">Durée:</span>
          <span class="text-orange-400 text-5xl">{{ quiz.duration }}</span> min
        </p>
      </div>

      <!-- Start Button -->
      <RouterLink :to="`/quiz/${quiz.id}`">
        <button
          class="mt-6 bg-gradient-to-tl from-[#FB8501] to-[#FFB703] text-black px-6 py-2 rounded-sm hover:bg-orange-200 transition duration-300">
          Commencer
        </button>
      </RouterLink>
    </div>
  </div>
</template>

<script setup lang="ts">
import { watch, ref } from 'vue'
const quiz = ref()

const props = defineProps({
  data: Object, // Définissez le type selon la structure de votre quizz
})

watch(props, (newData) => {
  quiz.value = newData.data
})
</script>
