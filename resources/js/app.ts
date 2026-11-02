import { createInertiaApp } from '@inertiajs/vue3';
import { createPinia } from 'pinia';
import { AppLayout } from './layouts';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
const pinia = createPinia();

void createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    withApp: (app) => {
        app.directive('focus', {
            mounted: (el: HTMLElement, shouldFocus) => {
                if (shouldFocus.value !== false) {
                    el.focus();
                }
            },
        });
        app.use(pinia);
    },
    progress: {
        color: '#4B5563',
    },
    layout: () => {
        return AppLayout;
    },
});
