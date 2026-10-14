<template>
  <QuizzLayout>
    <Title>Liste des quiz disponibles</Title>
    <div class="w-[75%] bg-[#235763] h-auto rounded-lg mx-auto p-3">
      <slot></slot>
    </div>
  </QuizzLayout>
</template>

<style scoped></style>

<script setup lang="ts">
import QuizzLayout from '../layouts/QuizzLayout.vue'
import Title from './Title.vue'
</script>
