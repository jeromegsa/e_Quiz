<template>
  <div class="flex flex-col justify-between bg-[#023047] pb-24 min-h-screen">
    <Navbar />
    <section class="pt-16 text-white h-screen">
      <div class="w-full bg-opacity-5">
        <div
          class="flex flex-col gap-2 bg-[url('@/assets/bg-raie.svg')] text-center w-full mx-auto"
        >
         
          <slot></slot>
 
        </div>
      </div>
    </section>
  </div>
</template>

<style scoped></style>

<script setup lang="ts">
import Navbar from '@/components/layouts/Navbar.vue'
</script>
