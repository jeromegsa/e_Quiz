<template>
  <p v-if="counter > 0" class="text-7xl font-bold">{{ counter }}</p>
  <p v-else class="text-7xl font-bold">GO</p>
</template>

<script setup>
import { onMounted, ref } from 'vue'
const counter = ref(3)

const emits = defineEmits(['hideLoader'])

onMounted(() => {
  const counterinterval = setInterval(() => {
    if (counter.value > 0) {
      --counter.value
    } else {
      clearInterval(counterinterval)
      emits('hideLoader', true)
    }
  }, 1000)
})
</script>
