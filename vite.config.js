import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import BrowserSync from 'vite-plugin-browser-sync';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
        }),
        BrowserSync({
            proxy: 'http://127.0.0.1:8000',  // pastikan URL sesuai
            files: ['resources/views/**/*.blade.php', 'public/js/*.js', 'public/css/*.css'],
            reloadDelay: 1000,
        }),
    ],
});
