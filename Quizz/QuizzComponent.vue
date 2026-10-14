<template>
  <QuizzLayout>
    <QuizzLayoutTitle>Liste des quiz disponibles</QuizzLayoutTitle>
    <div class="flex flex-col  items-center w-[75%] bg-[#235763] rounded-lg mx-auto p-3">
      <RouterView></RouterView>
    </div>
    <!-- carroussel -->
    <!-- <div class="my-3 border">
            <CarrousselComponent />
        </div> -->
  </QuizzLayout>
</template>

<style scoped></style>

<script setup lang="ts">

import QuizzLayout from '../layouts/QuizzLayout.vue'
import CarrousselComponent from '../Home/CarrousselComponent.vue'

import QuizzLayoutTitle from './QuizzLayoutTitle.vue'
import { quizzes } from '@/assets/data/quizzes'

import { onMounted, ref, computed } from 'vue'

onMounted(() => {
  // quizzList.value = quizzes
})
</script>
