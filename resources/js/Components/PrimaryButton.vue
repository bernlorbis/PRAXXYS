<script setup>
defineProps({
  type: {
    type: String,
    default: "submit",
  },
});
</script>

<template>
  <button
    :type="type"
    :class="[
      'inline-flex items-center px-4 py-2 bg-[#332b29] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-[#332b29] focus:outline-none focus:ring-2 focus:ring-[#332b29] focus:ring-offset-2 transition ease-in-out duration-150',
      'disabled:bg-gray-100 disabled:text-gray-500 disabled:cursor-not-allowed',
    ]"
  >
    <slot />
  </button>
</template>
