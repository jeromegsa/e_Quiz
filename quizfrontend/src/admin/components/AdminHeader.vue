<template>
  <div id="app" class="flex h-screen">
    <!-- Sidebar -->
    <div
      v-if="showSidebar"
      class="bg-gray-800 text-white w-64 p-4 transition-transform duration-300 ease-in-out"
    >
      <!-- Sidebar content -->
      <p class="text-2xl font-bold">Sidebar</p>
      <ul>
        <li class="mt-4">Dashboard</li>
        <li class="mt-4">Settings</li>
        <li class="mt-4">Profile</li>
      </ul>
    </div>

    <!-- Main content -->
    <div class="flex-1 bg-gray-100 p-4">
      <!-- Toggle button -->
      <button @click="toggleSidebar" class="bg-blue-500 text-white px-4 py-2 rounded-md">
        Toggle Sidebar
      </button>

      <div class="mt-4">
        <!-- Main content goes here -->
        <h1 class="text-3xl font-bold">Main Content</h1>
        <p class="mt-2">This is the main content of the page.</p>
      </div>
    </div>
  </div>
</template>
<script setup lang="ts"></script>
<style scoped></style>
