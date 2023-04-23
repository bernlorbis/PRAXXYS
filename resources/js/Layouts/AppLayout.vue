<script setup>
import {
  Dialog,
  DialogOverlay,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
import {
  AdjustmentsHorizontalIcon,
  ClipboardDocumentListIcon,
  Bars3Icon,
  MagnifyingGlassIcon,
  XMarkIcon,
  VideoCameraIcon,
} from "@heroicons/vue/24/outline";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { ref } from "vue";
import { Link, Head } from "@inertiajs/vue3";

defineProps({
  title: String,
});

const sidebarOpened = ref(false);

const productNavigation = [
  {
    href: route("products.index"),
    name: "products.index",
    label: "Product List",
    icon: ClipboardDocumentListIcon,
  },
  {
    href: route("products.create"),
    name: "products.create",
    label: "Create Product",
    icon: AdjustmentsHorizontalIcon,
  },
];
</script>

<template>
  <Head :title="title" />
  <notifications position="top right" />
  <div class="flex min-h-screen">
    <TransitionRoot :show="sidebarOpened">
      <Dialog
        as="div"
        @close="sidebarOpened = false"
        class="fixed inset-0 z-40 md:hidden"
      >
        <TransitionChild
          enter="transition ease-in-out duration-200 transform"
          enter-from="-translate-x-full"
          enter-to="translate-x-0"
          leave="transition ease-in-out duration-200 transform"
          leave-from="translate-x-0"
          leave-to="-translate-x-full"
          as="template"
        >
          <div
            class="flex relative z-10 flex-col w-72 h-full bg-gray-50 border-r border-gray-200 md:hidden"
          >
            <button
              @click="sidebarOpened = false"
              class="hover:ring-2 hover:ring-gray-300 flex absolute top-2 right-2 justify-center items-center w-10 h-10 rounded-full focus:outline-none focus:ring-2 focus:ring-gray-600"
              type="button"
              value="Close sidebar"
            >
              <XMarkIcon class="w-5 h-5" />
            </button>
            <div class="px-6 pt-8 pb-4">
              <Link href="/">
                <ApplicationLogo class="w-48 h-9" />
              </Link>
            </div>

            <div
              v-if="$page.props.auth.user.is_admin"
              class="overflow-y-auto flex-1"
            >
              <div class="mb-10">
                <h3
                  class="mx-6 mb-2 text-xs tracking-widest text-gray-400 uppercase"
                >
                  Products
                </h3>

                <Link
                  v-for="(item, index) in productNavigation"
                  :href="item.href"
                  :key="index"
                  :class="[
                    'flex items-center px-6 py-2.5 hover:text-gray-800 group',
                    route().current(item.name)
                      ? 'text-gray-800'
                      : 'text-gray-500',
                  ]"
                >
                  <component
                    :is="item.icon"
                    :class="[
                      'mr-2 w-5 h-5  group-hover:text-gray-700',
                      route().current(item.name)
                        ? 'text-gray-700'
                        : 'text-gray-400',
                    ]"
                  />

                  {{ item.label }}
                </Link>
              </div>

              <div class="mb-10">
                <h3
                  class="mx-6 mb-2 text-xs tracking-widest text-gray-400 uppercase"
                >
                  Videos
                </h3>
                <Link
                  href="/video-player"
                  :class="[
                    'flex items-center px-6 py-2.5 hover:text-gray-800 group',
                    route().current('video-player')
                      ? 'text-gray-800'
                      : 'text-gray-500',
                  ]"
                >
                  <VideoCameraIcon
                    :class="[
                      'mr-2 w-5 h-5  group-hover:text-gray-700',
                      route().current('video-player')
                        ? 'text-gray-700'
                        : 'text-gray-400',
                    ]"
                  />
                  Video Player
                </Link>
              </div>
            </div>
          </div>
        </TransitionChild>
        <TransitionChild
          enter="transition-opacity ease-linear duration-200"
          enter-from="opacity-0"
          enter-to="opacity-100"
          leave="transition-opacity ease-linear duration-200"
          leave-from="opacity-100"
          leave-to="opacity-0"
          as="template"
        >
          <DialogOverlay
            class="fixed inset-0 bg-gray-600 bg-opacity-50"
          ></DialogOverlay>
        </TransitionChild>
      </Dialog>
    </TransitionRoot>

    <div class="hidden w-64 bg-gray-50 border-r border-gray-200 md:block">
      <div class="py-4 px-6 flex items-center justify-center">
        <Link href="/">
          <ApplicationLogo class="w-48 h-9" />
        </Link>
      </div>

      <div v-if="$page.props.auth.user.is_admin">
        <div class="mb-10">
          <h3 class="mx-6 mb-2 text-xs tracking-widest text-gray-400 uppercase">
            Products
          </h3>

          <Link
            v-for="(item, index) in productNavigation"
            :href="item.href"
            :key="index"
            :class="[
              'flex items-center px-6 py-2.5 hover:text-gray-800 group',
              route().current(item.name) ? 'text-gray-800' : 'text-gray-500',
            ]"
          >
            <component
              :is="item.icon"
              :class="[
                'mr-2 w-5 h-5  group-hover:text-gray-700',
                route().current(item.name) ? 'text-gray-700' : 'text-gray-400',
              ]"
            />
            {{ item.label }}
          </Link>
        </div>

        <div class="mb-10">
          <h3 class="mx-6 mb-2 text-xs tracking-widest text-gray-400 uppercase">
            Videos
          </h3>
          <Link
            href="/video-player"
            :class="[
              'flex items-center px-6 py-2.5 hover:text-gray-800 group',
              route().current('video-player')
                ? 'text-gray-800'
                : 'text-gray-500',
            ]"
          >
            <VideoCameraIcon
              :class="[
                'mr-2 w-5 h-5  group-hover:text-gray-700',
                route().current('video-player')
                  ? 'text-gray-700'
                  : 'text-gray-400',
              ]"
            />
            Video Player
          </Link>
        </div>
      </div>
    </div>

    <div class="flex-1">
      <div
        class="flex justify-between py-3 px-3 md:px-6 space-x-3 md:space-x-6 bg-gray-50 border-b"
      >
        <div class="flex items-center flex-1">
          <button
            @click="sidebarOpened = true"
            class="mr-3 md:hidden flex-shrink-0 flex items-center justify-center w-10 h-10 rounded-full text-gray-600 hover:ring-2 hover:ring-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-600"
            type="button"
            value="Open sidebar"
          >
            <Bars3Icon class="h-6 w-6" />
          </button>
          <!-- <form action="" class="w-full max-w-md">
            <div
              class="flex relative items-center text-gray-400 focus-within:text-gray-600"
            >
              <MagnifyingGlassIcon
                class="absolute ml-3 w-5 h-5 pointer-events-none"
              />
              <input
                type="text"
                name="search"
                placeholder="Search talk"
                autocomplete="off"
                aria-label="Search talk"
                class="py-2 pr-3 pl-10 w-full font-semibold placeholder-gray-500 text-black rounded-2xl border-none ring-2 ring-gray-300 focus:ring-gray-500 focus:ring-2"
              />
            </div>
          </form> -->
        </div>
        <Menu as="div" class="relative flex-shrink-0">
          <MenuButton
            class="rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black"
          >
            <img
              class="inline w-10 h-10 rounded-full"
              src="/storage/img/avatar.png"
              alt="avatar"
            />
          </MenuButton>

          <transition
            enter-active-class="transition duration-100 ease-out transform"
            enter-from-class="opacity-0 scale-90"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition duration-100 ease-in transform"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-90"
          >
            <MenuItems
              class="overflow-hidden absolute right-0 mt-2 w-48 bg-white rounded-md border shadow-lg origin-top-right focus:outline-none"
            >
              <!-- <MenuItem v-slot="{ active }">
                <a
                  href="#"
                  :class="{ 'bg-gray-100': active }"
                  class="block py-2 px-4 text-sm text-gray-700"
                  >My Profile</a
                >
              </MenuItem>
              <MenuItem v-slot="{ active, disabled }" disabled>
                <a
                  href="#"
                  :class="{ 'bg-gray-100': active, 'opacity-40': disabled }"
                  class="block py-2 px-4 text-sm text-gray-700"
                  >Settings</a
                >
              </MenuItem>
              <MenuItem v-slot="{ active }">
                <a
                  href="#"
                  :class="{ 'bg-gray-100': active }"
                  class="block py-2 px-4 text-sm text-gray-700"
                  >Help</a
                >
              </MenuItem> -->
              <MenuItem v-slot="{ active }">
                <Link
                  :href="route('logout')"
                  method="post"
                  as="button"
                  :class="{ 'bg-gray-100': active }"
                  class="block py-2 px-4 text-sm text-gray-700 w-full text-left"
                >
                  Log out
                </Link>
              </MenuItem>
            </MenuItems>
          </transition>
        </Menu>
      </div>

      <main class="pb-10">
        <div class="px-6">
          <div class="flex justify-between items-center">
            <h1 class="font-semibold text-lg mt-4 mb-10">{{ title }}</h1>
            <div>
              <slot name="action" />
            </div>
          </div>
          <slot />
        </div>
      </main>
    </div>
  </div>
</template>
