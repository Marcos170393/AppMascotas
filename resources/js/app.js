import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap/dist/js/bootstrap.js"

createInertiaApp({
  resolve: name => require(`./Pages/${name}`),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .mixin({methods: {route}})
      .mount(el)
  },
})
