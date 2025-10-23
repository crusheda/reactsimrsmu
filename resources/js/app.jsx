// import '../css/app.css';
import './bootstrap';

// Plugin JS tambahan dari layout lama
// import 'jquery';
// import 'moment';
// import 'moment/locale/id';
// import 'datatables.net-bs5';
// import 'sweetalert2';
// import 'feather-icons';
// import 'notifier-js';
// import 'flatpickr';
// import 'cropperjs';

import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createRoot } from 'react-dom/client';

const appName = import.meta.env.VITE_APP_NAME || 'Simrsmu v.4';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.jsx`,
            import.meta.glob('./Pages/**/*.jsx'),
        ),
    setup({ el, App, props }) {
        // 🔹 HTML sudah diatur di app.blade.php
        // Tidak perlu lagi set attribute data-theme-mode / data-menu-styles

        const root = createRoot(el);
        root.render(<App {...props} />);
    },
    progress: {
        color: '#4B5563',
    },
});
