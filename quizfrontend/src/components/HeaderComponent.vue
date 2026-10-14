<template>
  <header class="flex justify-between lg:px-20 bg-[#2E626E] text-white p-2">
    <img src="@/assets/images/logo.svg" alt="" srcset="" />
    <div class="flex items-center">
      <ul class="flex items-center gap-8 text-md">
        <li class="">
          <router-link class="nav-link active-link" to="/">Accueil</router-link>
        </li>
        <li>
          <router-link class="nav-link" to="/">A propos</router-link>
        </li>
        <li>
          <router-link class="nav-link" to="/">Contact</router-link>
        </li>
        <li>
          <button class="px-2 py-1 text-white rounded-sm login-btn">Se connecter</button>
        </li>
        <li>
          <button class="text-white rounded-sm sign-up-btn">S'inscrire</button>
        </li>
      </ul>
      <div></div>
    </div>
  </header>
</template>

<style scoped>
.active-link,
.nav-link:hover,
.sign-up-btn:hover {
  color: #fb8501;
}

.primary-button {
  background: linear-gradient(148.13deg, #fb8501 0%, #ffb703 99.11%);
}

.login-btn {
  background: linear-gradient(148.13deg, #fb8501 0%, #ffb703 99.11%);
}

.login-btn:hover {
  /* opacity: 0.8; */
  background: linear-gradient(148.13deg, #693a03 0%, #ffb703 99.11%);
}
</style>
