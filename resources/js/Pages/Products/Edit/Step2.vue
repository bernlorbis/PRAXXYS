<script setup>
import { ref, computed } from "vue";
import { router } from "@inertiajs/vue3";
import { TrashIcon } from "@heroicons/vue/24/outline";
import { useNotification } from "@kyvg/vue3-notification";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ConfirmDeleteModal from "@/Components/ConfirmDeleteModal.vue";

const props = defineProps({
  product: Object,
});

const emit = defineEmits(["reRender"]);

const { notify } = useNotification();

const confirmDelete = ref();
const selectedId = ref(null);

const uploadedPreviews = computed(() => {
  return props.product.images.map((image) => {
    return { id: image.id, path: image.path };
  });
});
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

const deleteImage = () => {
  router.delete(
    route("product-images.destroy", { product_image: selectedId.value }),
    {
      onSuccess: () => {
        emit("reRender");
        notify({
          type: "success",
          title: "Image Deleted",
        });
      },
    }
  );
};

const confirmDeleteImage = (id) => {
  selectedId.value = id;
  confirmDelete.value.openModal();
};

const onSubmit = () => {
  router.post(
    route("product-images.store"),
    { files: files.value, product: props.product.id },
    {
      forceFormData: true,
      onSuccess: () => {
        notify({
          title: "Image Successfuly Uploaded!",
          type: "success",
        });

        emit("reRender");
      },
      onError: (error) => {
        notify({
          title: "Something wen`t wrong!",
          text: error,
          type: "error",
        });
      },
    }
  );
};
</script>

<template>
  <ConfirmDeleteModal
    ref="confirmDelete"
    :on-confirm="deleteImage"
    message="Are you sure to delete this image?"
  />
  <input
    @input="onInput"
    type="file"
    class="block mt-10 w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100 focus:outline-none focus:ring-0"
    accept="image/*"
    multiple
  />

  <div
    :class="[
      'grid gap-4 mt-4',
      uploadedPreviews.length > 0 ? 'lg:grid-cols-2' : '',
    ]"
  >
    <!-- uploaded -->
    <div v-if="uploadedPreviews.length" class="border p-3">
      <div class="grid grid-cols-2 gap-3">
        <div
          v-for="(uploadedPreview, index) in uploadedPreviews"
          :key="`uploadedPreview-${index}`"
          class="border h-[200px] w-auto rounded-md flex items-center justify-center relative group"
          :style="`background-image: url(/storage/${uploadedPreview.path}); background-position: center; background-repeat: no-repeat; background-size: cover;`"
        >
          <div
            class="absolute hidden group-hover:block inset-0 bg-black/50 rounded-md"
          ></div>
          <button
            @click="confirmDeleteImage(uploadedPreview.id)"
            type="button"
            class="hidden z-20 group-hover:block bg-white/50 p-3 rounded-md text-red-600"
          >
            <TrashIcon class="w-5 h-5" />
          </button>
        </div>
      </div>
    </div>
    <!-- new -->
    <div class="border p-3">
      <div
        v-if="files.length && previews.length"
        class="grid grid-cols-2 lg:grid-cols-3 gap-3 mt-5"
      >
        <div
          v-for="(preview, index) in previews"
          :key="`preview-${index}`"
          class="border h-[200px] w-auto rounded-md"
          :style="`background-image: url(${preview}); background-position: center; background-repeat: no-repeat; background-size: cover;`"
        />
      </div>
    </div>
  </div>

  <div class="flex justify-end mt-6">
    <PrimaryButton @click="onSubmit" class="ml-4" :disabled="!files.length">
      Upload
    </PrimaryButton>
  </div>
</template>
