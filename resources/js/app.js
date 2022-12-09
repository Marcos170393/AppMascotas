import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap/dist/js/bootstrap.js"
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue';
import { Ziggy } from './ziggy';


createInertiaApp({
  resolve: name => require(`./Pages/${name}`),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      .mixin({ methods: {
          route: (name, params, absolute, config = Ziggy) => route(name, params, absolute, config),
        }
      })
      .mount(el)
  },
})

