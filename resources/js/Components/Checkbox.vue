<script setup>
import { useField } from "vee-validate";

const props = defineProps({
  name: String,
});
const { errorMessage, value, handleChange } = useField(() => props.name);
</script>

<template>
  <input
    v-model="value"
    type="checkbox"
    :value="value"
    class="rounded-md border-gray-300 text-[#332b29] shadow-sm focus:ring-[#332b29]"
  />
</template>
