import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.jsx',
                'resources/css/app.css',
            ],
            refresh: true,
        }),
        react(),
    ],
    resolve: {
        alias: {
            jquery: 'jquery/dist/jquery.min.js',
            '@': path.resolve(__dirname, 'resources/js'),
            '~public': path.resolve(__dirname, 'public'),
        },
    },
    define: {
        'window.global': {},
    },
});
