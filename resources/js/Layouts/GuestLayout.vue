<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
</script>

<template>
  <div
    class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100"
  >
    <div class="mb-3">
      <ApplicationLogo class="h-12" />
      <slot name="logo" />
    </div>

    <div class="w-full sm:max-w-md">
      <slot name="error" />
    </div>

    <div
      class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
    >
      <slot />
    </div>
  </div>
</template>
