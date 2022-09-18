import { createApp, h } from 'vue'
import { createInertiaApp, Link } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress';

import Layout from "./Shared/Layout";

createInertiaApp({
  // resolve: name => require(`./Pages/${name}`),
  // Default page layout
  resolve: name => {
    let page = require(`./Pages/${name}`).default;

    // ??= == OR
    page.layout ??= Layout;

    return page;
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      // Rejestracja komponentu globalnego - nie trzeba importowoać wówczas do plików vue 
      // .component("Link", Link)
      .mount(el)
  },
});

InertiaProgress.init({
    color: 'red',
    showSpinner: true
});
