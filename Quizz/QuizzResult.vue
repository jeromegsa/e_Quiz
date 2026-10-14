<template>
  <div class="flex flex-col justify-start items-center gap-4 w-2/4 mx-auto">
    <div class="px-auto">
      <div class="border-l-4 border-l-amber-600 py-3">
        <h2 class="pl-4 text-3xl text-center font-bold">Resultats <br /></h2>
      </div>
    </div>
  </div>
  <div class="flex flex-col justify-center items-center">
    <p class="text-xl font-bold">score</p>
    <div class="w-36 h-36 p-0 my-2 flex justify-center items-center bg-orange-400 rounded-full">
      <div class="w-32 h-32 p-5 flex justify-center items-center bg-[#235763] rounded-full">
        <p class="text-2xl font-semibold">15/20</p>
      </div>
    </div>
    <p class="text-xl font-bold">Durée: 14 min</p>
    <div class="my-3">
      <h2 class="font-bold text-xl underline">RESPONSES</h2>
      <p>
        <span class="text-xl text-bold">Reponses corrects : </span>
        <span class="text-semibold text-orange-400">1,2,3,4,5</span>
        <span class="text-xl text-bold">Reponses incorrects : </span>
        <span class="text-semibold text-orange-400">1,2,3,4,5</span>
      </p>
    </div>
    <div class="flex gap-3 my-3">
      <button
        class="border-2 text-xl px-8 border-orange-400 bg-[#235763] py-1 rounded-md text-white"
      >
        Réessayer
      </button>
      <button class="login-btn text-xl py-1 px-10 rounded-md text-white">Fermer</button>
    </div>
  </div>
</template>

<style scoped>
.login-btn {
  background: linear-gradient(148.13deg, #fb8501 0%, #ffb703 99.11%);
}

.login-btn:hover {
  /* opacity: 0.8; */
  background: linear-gradient(148.13deg, #693a03 0%, #ffb703 99.11%);
}
</style>

<script setup>
import { onMounted } from 'vue'
import JSConfetti from 'js-confetti'

const jsConfetti = new JSConfetti()

const props = defineProps({
  data: Object,
})

onMounted(() => {
  console.log('Question component mounted')
  console.log('Question component data : ', props.data)
  jsConfetti.addConfetti({
    emojis: ['🌈', '⚡️', '💥', '✨', '💫', '🌸'],
    // emojiSize: 20,
    confettiNumber: 50,
  })
  // startTimer();
})
</script>
