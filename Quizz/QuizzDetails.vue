<template>
  <div class="flex flex-col justify-start items-center gap-4 w-2/4 mx-auto">
    <div class="px-auto" v-if="props.data !== undefined">
      <h2 class="pl-4 font-semibold text-xl">{{ props.data.title }}</h2>
      <div class="border-l-4 border-l-amber-600 py-3"></div>
      <ul class="text-sm">
        <li><strong>OBJECTIF : </strong>{{ props.data.description }}</li>
        <li>
          <strong>DETAILS : </strong>
          <span class="text-3xl text-orange-500 font-semibold">{{ props.data.description }}</span>
          Durée :
          <span class="text-3xl text-orange-500 font-semibold">{{ props.data.duration }}</span> min
        </li>
      </ul>
      <div>
        <h2 class="px-0 text-left text-sm my-3 font-semibold underline">INSTRUCTIONS</h2>
        <ul>
          <li v-for="(instruction, idx) in props.data.instructions" :key="idx" class="list-disc">
            {{ instruction }}
          </li>
        </ul>
      </div>
      <RouterLink :to="`/quiz/${props.data.id}`">
        <primaryButton>Commencer</primaryButton>
      </RouterLink>
    </div>
  </div>
</template>

<script setup lang="ts">
import { onMounted, ref } from 'vue'
import primaryButton from '../Buttons/primary-button.vue'
import QuizzQuestion from './QuizzQuestion.vue'
const sendingData = ref()
const props = defineProps({
  data: Object, // Définissez le type selon la structure de votre quizz
})

const sendData = (quizz: Object) => {
  sendingData.value = quizz
}
</script>
