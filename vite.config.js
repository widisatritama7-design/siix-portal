import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";
import react from '@vitejs/plugin-react';
import path from 'path'; // 1. Tambahkan ini

export default defineConfig({
    // 2. Tambahkan konfigurasi resolve.alias
    resolve: {
        alias: {
            '@mingle': path.resolve(__dirname, 'vendor/ijpatricio/mingle/resources/js'),
        },
    },
    plugins: [
        laravel({
            input: 
            [
                'resources/css/app.css', 
                'resources/js/app.js', 
                'resources/js/mingle/Prod/Patrol/StandardPatrol/index.js',
                'resources/js/mingle/Prod/Patrol/CategoryPatrol/index.js',
                'resources/js/mingle/Prod/Patrol/ResultPatrol/index.js',
                'resources/js/mingle/Prod/Patrol/ResultPatrol/form.js',
                'resources/js/mingle/Inventory/FloorPlanBuilder/index.js',
                'resources/js/mingle/Uty/DailyReportUtility/index.js',
                'resources/js/mingle/Uty/DailyReportDashboard/index.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
        react(),
    ],
    server: {
        cors: true,
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});