<script setup>
import * as yup from "yup";
import { computed } from "vue";
import { useForm } from "vee-validate";
import BaseInput from "@/Components/BaseInput.vue";
import BaseSelect from "@/Components/BaseSelect.vue";
import BaseEditor from "@/Components/BaseEditor.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

defineProps({
  categories: Object,
});

const emit = defineEmits(["next"]);

const schema = computed(() => {
  return yup.object({
    name: yup.string().required().label("Product name"),
    category: yup.number().required().label("Category"),
    description: yup.string().required().label("Product description"),
  });
});

const { handleSubmit, meta, isSubmitting } = useForm({
  validationSchema: schema,
  initialValues: {
    name: "",
    category: null,
    description: "",
  },
});

const onSubmit = handleSubmit((values) => {
  emit("next", values);
});
</script>

<template>
  <form @submit="onSubmit" class="mt-10">
    <div class="flex flex-col space-y-6">
      <div class="grid md:grid-cols-2 gap-6">
        <BaseInput name="name" label="Product Name" />
        <BaseSelect
          name="category"
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
        :disabled="isSubmitting || !meta.dirty"
      >
        Next
      </PrimaryButton>
    </div>
  </form>
</template>
