import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig(({ mode }) => ({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    build: {
        sourcemap: false,
        cssCodeSplit: true,
        rollupOptions: {
            output: {
                manualChunks: (id) => {
                    if (id.includes('node_modules/alpinejs') || id.includes('node_modules/@alpinejs')) {
                        return 'alpine';
                    }

                    if (id.includes('node_modules')) {
                        return 'vendor';
                    }

                    return undefined;
                },
            },
        },
    },
}));
