<script setup>
import { useField } from "vee-validate";
import Multiselect from "@vueform/multiselect";

const props = defineProps({
  name: String,
  label: String,
  options: [Array, Object],
});

const { errorMessage, value } = useField(() => props.name);
</script>

<template>
  <div>
    <div class="relative">
      <Multiselect
        v-model="value"
        :options="options"
        :classes="{
          container:
            'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded-lg bg-white text-sm leading-snug outline-none py-px peer',
          optionSelected: 'text-white bg-[#332b29]',
          optionSelectedPointed: 'text-white bg-[#332b29] opacity-90',
        }"
        placeholder=" "
      />
      <label
        :for="`floating_outlined_${name}`"
        class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-gray-700 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
      >
        {{ label }}
      </label>
    </div>
    <small v-if="errorMessage" class="text-red-500 text-xs">
      {{ errorMessage }}
    </small>
  </div>
</template>
