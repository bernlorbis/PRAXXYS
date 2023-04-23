<script setup>
import moment from "moment";
import axios from "axios";
import {
  InformationCircleIcon,
  PhotoIcon,
  CalendarIcon,
} from "@heroicons/vue/24/solid";
import { ref, computed } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Step1 from "@/Pages/Products/Create/Step1.vue";
import Step2 from "@/Pages/Products/Create/Step2.vue";
import Step3 from "@/Pages/Products/Create/Step3.vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
  categories: Object,
});

const step = ref(1);

const formSteps = [
  { label: "Step 1", step: 1, icon: InformationCircleIcon },
  { label: "Step 2", step: 2, icon: PhotoIcon },
  { label: "Step 3", step: 3, icon: CalendarIcon },
];

const currentStep = computed(() => {
  return {
    1: Step1,
    2: Step2,
    3: Step3,
  }[step.value];
});

const currentProps = computed(() => {
  return {
    1: { categories: props.categories },
    2: null,
    3: null,
  }[step.value];
});

const productNameIsAvailable = ref(true);

const form = ref({
  name: "",
  category_id: "",
  description: "",
  files: [],
  date_and_time: "",
});

const onNext = async (values) => {
  if (step.value === 1) {
    const { data: isValid } = await axios.post(route("validate.product.name"), {
      name: values.name,
    });

    productNameIsAvailable.value = await isValid;

    if (productNameIsAvailable.value) {
      form.value.name = values.name;
      form.value.category_id = values.category;
      form.value.description = values.description;
      step.value = 2;
    }

    return;
  }

  if (step.value === 2) {
    form.value.files = values;

    step.value = 3;
    return;
  }

  if (step.value === 3) {
    form.value.date_and_time = moment(values).format("YYYY-MM-D h:mm:ss");
    submitForm();
  }
};

const submitForm = async () => {
  router.post(route("products.store"), form.value, {
    forceFormData: true,
    onSuccess: () => {},
  });
};
</script>

<template>
  <AppLayout title="Create Product">
    <div class="border-b border-gray-200 dark:border-gray-700">
      <ul
        class="flex flex-wrap -mb-px text-sm text-center text-gray-500 dark:text-gray-400"
      >
        <li class="mr-2" v-for="(formStep, index) in formSteps" :key="index">
          <a
            href="#"
            :class="[
              'inline-flex p-4 border-b-2 rounded-t-lg group',
              formStep.step == step
                ? 'text-[#cead37] border-[#cead37] font-bold'
                : 'border-transparent hover:text-gray-600 hover:border-gray-300 font-medium',
            ]"
          >
            <component
              :is="formStep.icon"
              :class="['w-5 h-5 mr-2', { 'font-bold': formStep.step == step }]"
            />
            {{ formStep.label }}
          </a>
        </li>
      </ul>
    </div>
    <div
      v-if="!productNameIsAvailable"
      class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4 w-full mt-4"
      role="alert"
    >
      <p class="font-bold">Error</p>
      <p>Product name is already been taken.</p>
    </div>

    <Component :is="currentStep" @next="onNext" v-bind="currentProps" />
  </AppLayout>
</template>

<style src="@vueform/multiselect/themes/default.css"></style>
