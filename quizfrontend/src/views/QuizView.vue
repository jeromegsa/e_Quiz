<script setup lang="ts">
import Navbar from '@/components/layouts/Navbar.vue';
import QuizzComponent from '@/components/Quizz/QuizzComponent.vue';
import { useRoute } from 'vue-router';

// Utilisation du hook pour obtenir la route active
const route = useRoute()
</script>

<template>
  <div class="bg-[url('@/assets/quizz.svg')] bg-no-repeat bg-cover h-screen w-full absolute">
    <Navbar />
    <!-- Affiche Navbar et QuizzComponent seulement si ce n'est pas une route enfant avec un id -->
    <template v-if="!route.params.id">
      <QuizzComponent />
    </template>

    <!-- Affiche le composant enfant (QuizzStart) -->
    <div  class="flex items-center justify-center h-screen text-white">
      <router-view></router-view>
    </div>
  </div>
</template>
