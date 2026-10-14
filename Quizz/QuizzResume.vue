<template>
  <div class="relative w-full my-auto">
    <div class="w-[75%] rounded-lg mx-auto p-3">
      <div class="flex flex-col justify-start items-center gap-4 w-2/4 mx-auto">
        <div class="px-auto">
          <div class="border-l-4 border-l-amber-600 py-3">
            <h2 class="pl-4 text-3xl font-bold">Quizz HTML</h2>
          </div>
        </div>
      </div>
      <!-- <QuizzQestion v-for="(question, index) in QuizzList" :key="index" :data="question[index]" /> -->
      <QuizzResumeQuestion
        v-for="(question, index) in questionList"
        :key="index"
        :data="question"
      />
    </div>
    <div class="absolute right-3 bottom-2">
      <button
        @click="showQuizzResult"
        class="border-2 text-xl px-8 border-orange-400 bg-[#235763] py-1 rounded-md text-white"
      >
        Valider
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import QuizzResumeQuestion from './QuizzResumeQuestion.vue'
import { questions } from '@/assets/data/questions'

const emit = defineEmits(['onNext'])

const questionList = ref(questions)
function showQuizzResult() {
  emit('showQuizzResult', true)
}
</script>
