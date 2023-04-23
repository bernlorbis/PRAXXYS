<script setup>
import { ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const emit = defineEmits(["next"]);

const previews = ref([]);
const files = ref([]);

const onInput = (event) => {
  previews.value = [];
  files.value = event.target.files;

  if (!files.value) return;

  for (let i = 0; i < files.value.length; i++) {
    const reader = new FileReader();

    reader.onload = function (event) {
      previews.value.push(event.target.result);
    };

    reader.readAsDataURL(files.value[i]);
  }
};

const onNext = () => {
  emit("next", files.value);
};
</script>

<template>
  <input
    @input="onInput"
    type="file"
    class="block mt-10 w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100 focus:outline-none focus:ring-0"
    accept="image/*"
    multiple
  />

  <div
    v-if="files.length && previews.length"
    class="grid grid-cols-2 lg:grid-cols-5 gap-3 mt-5"
  >
    <div
      v-for="(preview, index) in previews"
      :key="`preview-${index}`"
      class="border h-[200px] w-auto rounded-md"
      :style="`background-image: url(${preview}); background-position: center; background-repeat: no-repeat; background-size: cover;`"
    />
  </div>

  <div class="flex justify-end mt-6">
    <PrimaryButton @click="onNext" class="ml-4" :disabled="!files.length">
      Next
    </PrimaryButton>
  </div>
</template>
