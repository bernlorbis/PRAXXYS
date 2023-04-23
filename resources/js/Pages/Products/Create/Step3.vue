<script setup>
import { ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const emit = defineEmits(["next"]);

const date = ref(null);

const onNext = () => {
  emit("next", date.value);
};
</script>

<template>
  <div class="mt-10">
    <VueDatePicker v-model="date"></VueDatePicker>
    <div class="flex justify-end mt-6">
      <PrimaryButton @click="onNext" class="ml-4" :disabled="!date">
        Next
      </PrimaryButton>
    </div>
  </div>
</template>
