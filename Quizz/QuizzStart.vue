<template>
  <!-- <div class="flex flex-col items-center w-[75%] min-h-96 bg-[#235763] rounded-lg mx-auto p-3"> -->
  <div v-if="isLoading" class="h-[100%] min-h-96 flex items-center my-auto">
    <QuizzLoader @hideLoader="hideLoader" />
  </div>
  <!-- </div> -->

  <!--  -->
  <div v-if="!isLoading && !isQuizzEnd" class="w-full relative">
    <div class="flex justify-between w-full h-full">
      <button class="p-5"><img src="@/assets/retour.svg" alt="" /></button>
      <button @click="skip" class="p-5 text-[#FB8501] font-semibold">Passer</button>
    </div>
    <div>
      <!-- Quizz title start -->
      <div class="flex flex-col justify-start items-center gap-4 w-2/4 mx-auto">
        <div class="px-auto">
          <div class="border-l-4 border-l-amber-600 py-3">
            <h2 class="pl-4 text-3xl font-bold">{{ quizName }}</h2>
          </div>
        </div>
      </div>
      <!-- Quizz title end -->

      <!-- stepper start -->
      <div class="my-5 flex justify-center flex-wrap">
        <div
          v-for="(step, index) in [1, 2, 3, 4, 5]"
          :key="index"
          class="flex justify-start items-center"
        >
          <div class="rounded-full p-1">
            <div class="rounded-full bg-orange-400 h-5 w-5 m-1"></div>
          </div>
          <div v-show="step != 5" class="w-10 mx-3 bg-white" style="height: 1px"></div>
        </div>
      </div>
      <!-- stepper end -->

      <!-- Quizz questions start -->
      <div
        v-if="isQuizzesAvailable"
        class="flex flex-col justify-start items-center gap-4 py-5 mx-auto"
      >
        <QuizzQestion :data="currentQuestion" @onNext="skip" />
      </div>
      <h1 v-else>Aucune question disponible</h1>
      <!-- Quizz questions end -->
    </div>
  </div>

  <!-- Quizz Resume -->
  <QuizzResume v-if="isQuizzEnd && !isResultVisible" @showQuizzResult="isResultVisible = true" />

  <!-- Quizz Result -->
  <div v-if="isQuizzEnd && isResultVisible" class="w-full my-auto">
    <div>
      <QuizzResult />
    </div>
  </div>
</template>

<style scoped></style>

<script setup lang="ts">
import QuizzLoader from './QuizzLoader.vue'
import QuizzQestion from './QuizzQuestion.vue'
import QuizzResult from './QuizzResult.vue'
import QuizzResume from './QuizzResume.vue'

import { useRoute } from 'vue-router'
const route = useRoute()
const quizName = ref()
const findQuizName = () => {
  for (let quizz of quizzes.value) {
    route.params.id == quizz.id ? (quizName.value = quizz.title) : 'Pas de quizz trouvé'
  }
}

import { onMounted, ref, computed } from 'vue'
import { questions } from '@/assets/data/questions'
import quizzes from '@/assets/data/quizzes'

const isQuizzesAvailable = computed(() => questionList.value.length !== 0)
const isLoading = ref(true)
const isQuizzEnd = ref(false)
const isResultVisible = ref(false)

const hideLoader = () => (isLoading.value = false)
const questionList = ref(questions)
const currentQuestionIndex = ref<number>(0)
const currentQuestion = computed(() => questionList.value[currentQuestionIndex.value])
console.log('questionList : ', currentQuestion)

onMounted(() => {
  // questionList.value = questions
  findQuizName()
})

const skip = () => {
  if (questionList.value.length && currentQuestionIndex.value < questionList.value.length - 1) {
    currentQuestionIndex.value =
      currentQuestionIndex.value < questionList.value.length - 1
        ? ++currentQuestionIndex.value
        : currentQuestionIndex.value
    console.log('skip : ', currentQuestionIndex.value, questionList.value.length)
  } else {
    isQuizzEnd.value = true
  }
}
</script>
