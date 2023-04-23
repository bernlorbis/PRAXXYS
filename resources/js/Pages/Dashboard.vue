<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

defineProps({
  auth: Object,
});
</script>

<template>
  <AppLayout title="Dashboard">
    <div class="p-6 shadow rounded-lg">
      <h1 class="font-black text-2xl">Welcome {{ auth.user.username }}</h1>
      <small class="text-gray-500">{{ auth.user.email }}</small>
    </div>
  </AppLayout>
</template>
