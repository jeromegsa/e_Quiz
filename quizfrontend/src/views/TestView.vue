<template>
  <div class="test">
    <h1>Tester vos vues ici : {{ test }}</h1>
  </div>
</template>

<style scoped>
/* mobile */
.test {
  min-height: 100vh;
  background-color: red;
}

/* Tablette (min-width: 768px) */
@media (min-width: 768px) {
  .test {
    background-color: pink;
    min-height: 50vh;
    display: flex;
    justify-content: center;
    align-items: center;
  }
}

/* Laptop (min-width: 1024px) */
@media (min-width: 1024px) {
  .test {
    background-color: blue;

    min-height: 100vh;
  }
}

/* Desktop (min-width: 1440px) */
@media (min-width: 1440px) {
  .test {
    background-color: yellow;
    min-height: 100vh;
    padding: 40px;
  }
}
</style>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useQuestionStore } from '../stores/questions'

const schoolStore = useQuestionStore()

onMounted(async () => {
  const { success, status } = await schoolStore.dispatchGetQuestions()

  if (!success) {
    alert('Ups, something happened 🙂')
    console.log('Api status ->', status)
  }
})

const test = ref<string>('Test')
</script>
