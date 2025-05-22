import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { template } from 'lodash';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js','resources/js/site.js'],
            refresh: true,
        }),
        vue({
            template: {
                tranformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
    // other settings
  server: {
    fs: {
      allow: ['node_modules/@fortawesome/fontawesome-free'],
    },
  },
});
