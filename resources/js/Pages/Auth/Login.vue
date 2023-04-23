<script setup>
import * as yup from "yup";
import { computed } from "vue";
import { useForm } from "vee-validate";
import { router } from "@inertiajs/vue3";
import Checkbox from "@/Components/Checkbox.vue";
import BaseInput from "@/Components/BaseInput.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

defineProps({
  flash: Object,
});

const schema = computed(() => {
  return yup.object({
    username: yup.string().required().label("Username"),
    password: yup.string().required().label("Password"),
    rememberMe: yup.boolean().nullable(true),
  });
});

const { handleSubmit, isSubmitting, meta, setFieldValue } = useForm({
  validationSchema: schema,
  initialValues: {
    username: "",
    password: "",
    remember: false,
  },
});

const onSubmit = handleSubmit((values) => {
  router.post(route("post.login"), values);
});
</script>

<template>
  <GuestLayout>
    <template #error>
      <div
        v-if="flash?.message"
        class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4 w-full"
        role="alert"
      >
        <p class="font-bold">Error</p>
        <p>{{ flash.message }}</p>
      </div>
    </template>
    <div class="!text-left flex justify-start mb-10">
      <small class="flex flex-col space-y-2">
        <pre>Username: (admin@admin.com) || (admin)</pre>
        <pre>Password: password</pre>
      </small>
    </div>
    <form @submit="onSubmit">
      <div class="mt-4">
        <BaseInput
          inputType="text"
          name="username"
          label="Username"
          autofocus
        />
      </div>
      <div class="mt-4">
        <BaseInput inputType="password" name="password" label="Password" />
      </div>

      <div class="block mt-4">
        <label class="flex items-center">
          <Checkbox name="remember" />
          <span class="ml-2 text-sm text-gray-600">Remember me</span>
        </label>
      </div>

      <div class="flex items-center justify-end mt-4">
        <PrimaryButton
          class="ml-4"
          :class="{ 'opacity-25': isSubmitting }"
          :disabled="isSubmitting || !meta.dirty"
        >
          Log in
        </PrimaryButton>
      </div>
    </form>
  </GuestLayout>
</template>
