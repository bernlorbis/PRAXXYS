import "./bootstrap";
import "../css/app.css";
import "vue3-easy-data-table/dist/style.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import Notifications from "@kyvg/vue3-notification";

// editor
import CKEditor from "@ckeditor/ckeditor5-vue";
// datepicker
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
// video player
import VueVideoPlayer from "@videojs-player/vue";
import "video.js/dist/video-js.css";

createInertiaApp({
  resolve: (name) => {
    const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
    return pages[`./Pages/${name}.vue`];
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(Notifications)
      .use(CKEditor)
      .use(VueVideoPlayer)
      .component("VueDatePicker", VueDatePicker)
      .mixin({ methods: { route } })
      .mount(el);
  },
});
