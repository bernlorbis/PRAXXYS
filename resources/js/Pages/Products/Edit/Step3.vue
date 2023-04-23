<script setup>
import { ref } from "vue";
import moment from "moment";
import { router } from "@inertiajs/vue3";
import { useNotification } from "@kyvg/vue3-notification";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
  product: Object,
});

const emit = defineEmits(["reRender"]);

const { notify } = useNotification();

const date = ref(props.product.date_and_time);

const onSubmit = () => {
  router.put(
    route("products.update", { product: props.product.id }),
    {
      date_and_time: moment(date).format("YYYY-MM-D h:mm:ss"),
      step: 3,
    },
    {
      onSuccess: () => {
        emit("reRender");
        notify({
          type: "success",
          title: "Date & Time Successfully Updated!",
        });
      },
    }
  );
};
</script>

<template>
  <div class="mt-10">
    <VueDatePicker v-model="date"></VueDatePicker>
    <div class="flex justify-end mt-6">
      <PrimaryButton
        @click="onSubmit"
        class="ml-4"
        :disabled="!date || date == props.product.date_and_time"
      >
        Next
      </PrimaryButton>
    </div>
  </div>
</template>
