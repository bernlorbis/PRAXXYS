<script setup>
import { useField } from "vee-validate";
import { ref, onMounted } from "vue";

const props = defineProps({
  name: String,
  label: String,
  inputType: {
    type: String,
    default: "text",
  },
});

const { errorMessage, value, handleChange } = useField(() => props.name);

const input = ref();

onMounted(() => {
  if (input.value.hasAttribute("autofocus")) {
    input.value.focus();
  }
});
</script>

<template>
  <div>
    <div class="relative">
      <input
        ref="input"
        v-model="value"
        :type="inputType"
        :id="`floating_outlined_${name}`"
        class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-gray-700 peer"
        @blur="handleChange"
        v-bind="$attrs"
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
