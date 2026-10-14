<script setup lang="ts">
import HomeComponent from '@/components/Home/HomeComponent.vue'
import LoadView from '../components/layouts/LoadView.vue'
import { ref, onMounted } from 'vue'
const loading = ref(true)
onMounted(() => {
  // Simuler un délai avant de masquer le spinner
  setTimeout(() => {
    loading.value = false // Le spinner disparaît après 3 secondes
  }, 3000) // 3 secondes d'attente
})
</script>

<template>
  <LoadView v-if="loading" />
  <main>
    <HomeComponent />
  </main>
</template>
