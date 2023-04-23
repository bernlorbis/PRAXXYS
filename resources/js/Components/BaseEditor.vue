<script setup>
import { onMounted } from "vue";
import { useField } from "vee-validate";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

const props = defineProps({
  name: String,
});

const editor = ClassicEditor;

const { errorMessage, value } = useField(() => props.name);
</script>

<template>
  <Ckeditor :editor="editor" v-model="value" :config="{}" />
  <small v-if="errorMessage" class="text-red-500 text-xs">
    {{ errorMessage }}
  </small>
</template>
