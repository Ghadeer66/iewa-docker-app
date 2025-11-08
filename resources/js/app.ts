import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { initializeTheme } from './composables/useAppearance';
import { createPinia } from 'pinia';
// We'll add a global watcher (mixin) after mount to react to auth changes

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) =>
        resolvePageComponent(`./pages/${name}.vue`, import.meta.glob('./pages/**/*.vue') as Record<string, any>),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
        app.use(plugin)
        const pinia = createPinia()
        app.use(pinia)
        app.mount(el)

        // Load server cart for authenticated users after app is mounted
        const userId = props.initialPage?.props?.auth?.user?.id
        if (userId) {
            import('./stores/cart').then(({ useCartStore }) => {
                const cart = useCartStore(pinia)
                cart.loadCart().catch((e) => {
                    // eslint-disable-next-line no-console
                    console.error('Failed to load server cart on startup', e)
                })
            }).catch((e) => {
                // eslint-disable-next-line no-console
                console.error('Failed to import cart store', e)
            })
        }

        // Add a global mixin to watch Inertia auth changes and keep the cart store in sync.
        // This will react to login/logout events without requiring a full page refresh.
        app.mixin({
            created() {
                // use this.$watch so we run in the component context where $page is available
                try {
                    this.$watch(
                        () => this.$page.props?.auth?.user,
                        async (user: any, prev: any) => {
                            try {
                                const { useCartStore } = await import('./stores/cart')
                                const cart = useCartStore()
                                if (user) {
                                    await cart.loadCart()
                                } else {
                                    // clear client-side cart when user logs out
                                    cart.initialize([])
                                }
                            } catch (e) {
                                // eslint-disable-next-line no-console
                                console.error('Failed to sync cart on auth change', e)
                            }
                        },
                        { immediate: false }
                    )
                } catch (e) {
                    // eslint-disable-next-line no-console
                    console.error('Auth watcher setup failed', e)
                }
            }
        })
    },
    progress: {
        color: '#4B5563',
    },
});

// This will set light / dark mode on page load...
initializeTheme();
