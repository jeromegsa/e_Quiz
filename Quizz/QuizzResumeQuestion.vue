<template>
  <div class="flex flex-col justify-start items-center gap-4 py-5 mx-auto">
    <div class="flex text-left mt-8">
      <p class="font-bold mx-1">{{ '01' }}</p>
      <div class="w-full border-l-4 border-l-amber-600 py-3">
        <h2 class="pl-4 text-2xl font-bold">
          {{ data.question }}
        </h2>
      </div>
    </div>
    <div>
      <ul class="">
        <li v-for="(option, index) in data.options" :key="index" class="text-start">
          <div class="inline-block rounded-full bg-orange-400 h-3 w-3 m-1 mr-3"></div>
          {{ option }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'

const props = defineProps({
  data: Object,
})

onMounted(() => {
  console.log('Question component mounted')
  console.log('Question component data : ', props.data)
})
</script>
