<script setup>
import axios from "axios";
import { ref, watch } from "vue";
import {
  MagnifyingGlassIcon,
  TrashIcon,
  PencilSquareIcon,
} from "@heroicons/vue/24/outline";
import debounce from "lodash/debounce";
import { Link, router } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Vue3EasyDataTable from "vue3-easy-data-table";
import { useNotification } from "@kyvg/vue3-notification";
import ConfirmDeleteModal from "@/Components/ConfirmDeleteModal.vue";

defineProps({
  categories: Object,
});

const notification = useNotification();
const selectedProductId = ref(null);
const confirmModal = ref();
const search = ref(null);
const category = ref("");

const items = ref([]);
const loading = ref(false);
const serverItemsLength = ref(0);
const serverOptions = ref({
  page: 1,
  rowsPerPage: 10,
  sortBy: null,
  sortType: null,
});

const headers = [
  { text: "IMAGES", value: "images" },
  { text: "NAME", value: "name", sortable: true },
  { text: "CATEGORY", value: "category", sortable: true },
  { text: "DESCRIPTION", value: "description", sortable: true },
  { text: ":::", value: "action" },
];

const loadProducts = async () => {
  loading.value = true;
  const { data: results } = await axios.get(route("products.index"), {
    params: {
      ...serverOptions.value,
      q: search.value,
      category: category.value,
    },
  });
  items.value = results.data;
  serverItemsLength.value = results.total;
  await new Promise((resolve) => setTimeout(resolve, 1000));
  loading.value = false;
};

const onDelete = (item) => {
  selectedProductId.value = item.id;
  confirmModal.value.openModal();
};

const deleteProduct = () => {
  if (selectedProductId.value) {
    router.delete(
      route("products.destroy", { product: selectedProductId.value }),
      {
        onSuccess: () => {
          loadProducts();
          confirmModal.value.closeModal();
          notification.notify({
            title: "Product Successfuly Deleted 🚮",
            type: "success",
          });
        },
      }
    );
  }
};

loadProducts();

watch(
  serverOptions,
  () => {
    loadProducts();
  },
  { deep: true }
);

watch(
  [search, category],
  debounce(function ([searchValue, categoryValue]) {
    loadProducts();
  }, 500)
);
</script>

<template>
  <AppLayout title="Products">
    <ConfirmDeleteModal
      ref="confirmModal"
      :on-confirm="deleteProduct"
      message="Are you sure to delete this product?"
    />
    <template #action>
      <Link
        :href="route('products.create')"
        class="inline-flex items-center px-4 py-2 bg-[#332b29] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-[#332b29] focus:outline-none focus:ring-2 focus:ring-[#332b29] focus:ring-offset-2 transition ease-in-out duration-150"
      >
        Create
      </Link>
    </template>
    <div>
      <div class="flex space-x-2 py-2">
        <select
          v-model="category"
          class="rounded-md focus:ring-0 focus:ring-gray-500 focus:border-gray-500 focus:outline-none border-gray-300"
          placeholder="asd"
        >
          <option value="" disabled>Select Category</option>
          <option
            v-for="(category, index) in categories"
            :value="index"
            :key="index"
          >
            {{ category }}
          </option>
        </select>
        <div
          class="flex relative items-center text-gray-400 focus-within:text-gray-500 w-full"
        >
          <MagnifyingGlassIcon
            class="absolute ml-3 w-5 h-5 pointer-events-none"
          />
          <input
            v-model="search"
            type="text"
            name="search"
            placeholder="Search product"
            autocomplete="off"
            aria-label="Search product"
            class="py-2 pr-3 pl-10 w-full lg:w-[350px] placeholder-gray-500 text-black rounded-md border-none ring-1 ring-gray-300 focus:ring-gray-500 focus:ring-1"
          />
        </div>
      </div>
      <Vue3EasyDataTable
        v-model:server-options="serverOptions"
        :server-items-length="serverItemsLength"
        :headers="headers"
        :items="items"
        :rows-items="[5, 10, 15, 25, 50, 100]"
        :rows-per-page="10"
        show-index
        :loading="loading"
        theme-color="#332b29"
        :table-min-height="10"
        :buttons-pagination="true"
      >
        <template #loading>
          <img
            src="https://i.pinimg.com/originals/94/fd/2b/94fd2bf50097ade743220761f41693d5.gif"
            style="width: 100px; height: 80px"
          />
        </template>

        <template #item-images="{ images }">
          <div class="flex">
            <div v-for="(image, key) in images" :key="`image-${key}`">
              <img
                :src="`/storage/${image.path}`"
                class="w-10 h-10 rounded-full"
              />
            </div>
          </div>
        </template>

        <template #item-description="{ description }">
          <span v-html="description"></span>
        </template>

        <template #item-action="item">
          <div class="flex space-x-1">
            <Link :href="route('products.edit', { product: item.id })">
              <PencilSquareIcon class="h-5 w-5 text-gray-500" />
            </Link>
            <button @click="onDelete(item)" type="button">
              <TrashIcon class="h-5 w-5 text-gray-500" />
            </button>
          </div>
        </template>
      </Vue3EasyDataTable>
    </div>
  </AppLayout>
</template>
