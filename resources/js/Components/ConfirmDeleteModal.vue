<script setup>
import Modal from "@/Components/Modal.vue";
import { ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

defineProps({
  onConfirm: {
    type: Function,
  },
  message: String,
});

const modal = ref();

const openModal = () => {
  modal.value.openModal();
};

const closeModal = () => {
  modal.value.closeModal();
};

defineExpose({
  openModal,
  closeModal,
});
</script>

<template>
  <Modal ref="modal" title="Please confirm">
    <template #content>
      <p class="text-sm text-gray-500">
        {{ message }}
      </p>
    </template>

    <template #action>
      <div class="flex space-x-1">
        <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
        <PrimaryButton @click="onConfirm()">Yes</PrimaryButton>
      </div>
    </template>
  </Modal>
</template>
