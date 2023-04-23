<script setup>
import * as yup from "yup";
import { computed } from "vue";
import { useForm } from "vee-validate";
import { router } from "@inertiajs/vue3";
import BaseInput from "@/Components/BaseInput.vue";
import BaseSelect from "@/Components/BaseSelect.vue";
import BaseEditor from "@/Components/BaseEditor.vue";
import { useNotification } from "@kyvg/vue3-notification";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
  categories: Object,
  product: Object,
});

const emit = defineEmits(["reRender"]);

const { notify } = useNotification();

const schema = computed(() => {
  return yup.object({
    name: yup.string().required().label("Product name"),
    category_id: yup.number().required().label("Category"),
    description: yup.string().required().label("Product description"),
  });
});

const { handleSubmit, meta, isSubmitting } = useForm({
  validationSchema: schema,
  initialValues: {
    name: props.product.name,
    category_id: props.product.category_id,
    description: props.product.description,
  },
});

const onSubmit = handleSubmit((values) => {
  router.put(
    route("products.update", { product: props.product.id }),
    { ...values, step: 1 },
    {
      onSuccess: async () => {
        notify({
          title: "Product Successfuly Updated",
          type: "success",
        });

        emit("reRender");
      },
      onError: (errors) => {
        let errorMessage = "<ul class='list-disc ml-3'>";
        Object.values(errors).forEach((value) => {
          errorMessage += `<li>${value}</li>`;
        });
        errorMessage += "</ul>";

        notify({
          type: "error",
          title: "Something wen`t wrong",
          text: errorMessage,
        });
      },
    }
  );
});
</script>

<template>
  <form @submit="onSubmit" class="mt-10">
    <div class="flex flex-col space-y-6">
      <div class="grid md:grid-cols-2 gap-6">
        <BaseInput name="name" label="Product Name" />
        <BaseSelect
          name="category_id"
          label="Product Category"
          :options="categories"
        />
      </div>
      <div>
        <BaseEditor name="description" />
      </div>
    </div>
    <div class="flex justify-end mt-6">
      <PrimaryButton
        class="ml-4"
        :class="{ 'opacity-25': isSubmitting }"
        :disabled="isSubmitting || !meta.dirty || !meta.valid"
      >
        Save Changes
      </PrimaryButton>
    </div>
  </form>
</template>
