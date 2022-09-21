import { createApp, h } from "vue";
import { createInertiaApp, Link, Head } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import Layout from "./Shared/Layout";

createInertiaApp({
    // kompilacja w 4 plikach
    //   resolve: name => {
    //     let page = require(`./Pages/${name}`).default;

    //     if (page.layout === undefined) {
    //       page.layout = Layout;
    //     }

    //     return page;
    //   },

    // kompilacja dla kazdego pliku zidoku z osobna użyteczne dla dużych projektów
    resolve: async name => {
        let page = (await import(`./Pages/${name}`)).default;

        if (page.layout === undefined) {
            page.layout = Layout;
        }

        return page;
    },

    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .component("Link", Link)
            .component("Head", Head)
            .mount(el);
    },

    title: title => `My App - ${title}`
});

InertiaProgress.init({
    color: "red",
    showSpinner: true,
});
