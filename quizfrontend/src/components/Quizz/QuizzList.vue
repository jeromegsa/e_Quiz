<template>
  <div v-if="quizzes.length > 0">
    <div class="flex space-x-4 my-3 justify-center item-center">
      <div class="bg-[#447287] rounded-lg shadow-lg w-64" v-for="quizz in quizzes" :key="quizz.id">
        <img src="../../assets/python.svg" alt="Quiz Thumbnail" class="w-full h-48 object-cover rounded-t-lg" />
        <div class="p-4">
          <a class="text-lg text-[#FB8501] font-semibold cursor-pointer" @click="sendDetail(quizz)">
            {{ quizz.title }}
          </a>
        </div>
      </div>
    </div>

  </div>
</template>
<script setup lang="ts">
import quizzes from '@/assets/data/quizzes';
import { onMounted } from 'vue';
onMounted(() => {
  console.log(quizzes.value)
})

const emit = defineEmits(['showDetails'])
const sendDetail = (quizz: Object) => {
  emit('showDetails', quizz)
  console.log('execute', quizz);
}
</script>
