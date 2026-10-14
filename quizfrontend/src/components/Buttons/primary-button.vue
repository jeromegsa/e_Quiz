<template>
  <button class="primary-button px-10 py-3 rounded-sm text-white" style="">
    <slot></slot>
  </button>
</template>

<style scoped>
.primary-button {
  background: linear-gradient(148.13deg, #fb8501 0%, #ffb703 99.11%);
}

.primary-button:hover {
  background: linear-gradient(148.13deg, #633808 0%, #ffb703 99.11%);
}
</style>
