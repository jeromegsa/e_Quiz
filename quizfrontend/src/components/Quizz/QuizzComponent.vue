<template>
  <div class="flex flex-col items-center justify-center  relative">
    <QuizzDetails :data="receivequizz" />
  </div>
  <QuizzList @showDetails="getData" />
</template>

<script setup lang="ts">
import { ref, onMounted, watch } from 'vue'
import QuizzDetails from '@/components/Quizz/QuizzDetails.vue'
import QuizzList from '@/components/Quizz/QuizzList.vue'

// Utiliser un ref pour stocker le quizz reçu
const receivequizz = ref(null)

onMounted(() => {})
// Fonction pour recevoir les détails du quizz
console.log(receivequizz.value)

const getData = (params:any) => {
  receivequizz.value = params
}
</script>

<style></style>
