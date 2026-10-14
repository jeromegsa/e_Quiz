<template>
  <div
    v-if="questions.length > 0"
    class="fixed inset-0 bg-opacity-50 flex items-center justify-center"
  >
    <div class="bg-[#2E626E] w-1/3 rounded-lg shadow-lg p-6 border border-[#8ECAE6]">
      <button @click="$emit('close')" class="text-white float-right">
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

      <h2 class="text-white mb-4">Liste des questions</h2>
      <ul>
        <li v-for="(question, index) in questions" :key="index" class="text-white">
          {{ question.content }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup lang="ts">
import { defineProps } from 'vue'

const props = defineProps({
  questions: {
    type: Array,
    default: () => [],
  },
})
</script>
