import '../css/app.css'

import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import type { DefineComponent } from 'vue'
import { createApp, h } from 'vue'
import { ZiggyVue } from 'ziggy-js'
import { initializeTheme } from './composables/useAppearance'

import echarts from './plugins/echarts'

import ECharts from 'vue-echarts'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

createInertiaApp({
    title: (title) => `${title} - ${appName}`,

    resolve: (name) =>
        resolvePageComponent(
            `./pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./pages/**/*.vue')
        ),

    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })

        app.directive('click-outside', {
            mounted(el: any, binding: any) {
                el.clickOutsideEvent = (event: MouseEvent) => {
                    if (!(el === event.target || el.contains(event.target))) {
                        binding.value(event)
                    }
                }

                document.addEventListener('click', el.clickOutsideEvent)
            },

            unmounted(el: any) {
                document.removeEventListener('click', el.clickOutsideEvent)
            },
        })

        app.use(plugin)
            .use(ZiggyVue)

        app.component('VChart', ECharts)

        app.config.globalProperties.$echarts = echarts

        app.mount(el)
    },

    progress: {
        color: '#4B5563',
    },
})

initializeTheme()