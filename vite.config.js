import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { imagetools } from 'vite-imagetools';
import path from 'path';


export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/assets/css/styles.css',
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/assets/js/scripts.js',
            ],
            refresh: true,
        }),
        imagetools(),
    ],
    resolve:{
        alias:{
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap')
        }
    }
});
