<template>
  <Navbar />
  <div class="flex flex-col justify-between min-h-screen bg-[#023047] mt-10">
    <section class="pt-16 text-white">
      <div class="w-full bg-opacity-5">
        <div
          class="flex flex-col gap-2 bg-[url('@/assets/bg-grille.svg')] text-center w-[60%] mx-auto"
        >
          <h1 class="lg:text-[48px] font-bold leading-tight">
            Testez vos compétences et <br />
            devenez un meilleur développeur avec nos quiz <br />
            sur Qzz
          </h1>
          <p class="text-md w-[276px] mx-auto">
            Améliorez-vous en répondant à des questions techniques et en relevant des défis de
            programmation.
          </p>
          <div class="text-center py-8">
            <RouterLink
              to="/quiz"
              class="bg-gradient-to-tl from-[#FB8501] to-[#FFB703] p-3 rounded-sm text-white w-[18rem]"
              >Commencer maintenant</RouterLink
            >
          </div>
        </div>
      </div>
      <div class="w-full pt-20">
        <div class="flex flex-col gap-2 text-center w-[60%] mx-auto">
          <h1 class="lg:text-[48px] font-bold leading-tight">
            Évaluez vos compétences et améliorez-vous sur Qzz.
          </h1>
          <p class="text-md w-[276px] mx-auto">
            Répondez à des quiz techniques et relevez des défis pour devenir un développeur encore
            meilleur avec plusieurs langage.
          </p>
        </div>
      </div>

      <!-- carroussel -->
      <div class="mt-10 mb-14">
        <CarrousselComponent />
      </div>

      <!-- Newsletter Section start -->
      <section
        class="w-full bg-white lg:px-16 py-10 lg:h-[396px] lg:w-full bg-[url('@/assets/bg-raie.svg')]"
      >
        <div class="text-center px-auto bg-[#2E626F] p-4">
          <h2 class="font-black text-white lg:text-3xl">Abonnez vous a notre Newsletter</h2>
          <form class="flex justify-center items-center lg:gap-6 md:h-[218px] rounded-3xl">
            <input type="text" class="w-3/5 p-5 focus:outline-none" />
            <button
              class="bg-gradient-to-tl from-[#FB8501] to-[#FFB703] px-10 py-3 rounded-sm bg-gradient-to-r from-[#FB8501] to-[#FFB703] hover:from-[#633808] hover:to-[#FFB703] text-white"
            >
              Souscrire
            </button>
          </form>
        </div>
      </section>

      <!-- Newsletter Section end -->
      <footer class="w-full flex flex-col justify-end px-10 pb-8 h-[128px] bg-[#023047]">
        <small class="text-white">
          Copyright-Tout droit réservé -Design fait par Giovanni SOKENOU
        </small>
      </footer>
    </section>
  </div>
</template>

<style scoped></style>

<script setup lang="ts">
import HeaderComponent from '../HeaderComponent.vue'
// import QuizLayout from '../layouts/QuizLayout.vue';
import CarrousselComponent from './CarrousselComponent.vue'
import Navbar from '@/components/layouts/Navbar.vue'
</script>
