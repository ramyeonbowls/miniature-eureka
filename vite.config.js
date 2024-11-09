import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path, { resolve } from 'path'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/sass/iconly.scss',
                'resources/sass/themes/dark/app-dark.scss',
                'resources/sass/pages/auth.scss',
                'resources/sass/pages/chat.scss',
                'resources/sass/pages/datatables.scss',
                'resources/sass/pages/dripicons.scss',
                'resources/sass/pages/email.scss',
                'resources/sass/pages/error.scss',
                'resources/sass/pages/flag.scss',
                'resources/sass/pages/form-element-select.scss',
                'resources/sass/pages/simple-datatables.scss',
                'resources/sass/pages/summernote.scss',
                'resources/sass/pages/sweetalert2.scss',
                'resources/js/app.js',
                'resources/js/main.js',
                'resources/js/appreader.js',
                'resources/js/form.js',
                'resources/js/assets/js/initTheme.js',
                'resources/js/assets/js/components/dark.js',
                'resources/js/assets/js/components/sidebar.js',
                'resources/js/assets/js/pages/simple-datatables.js',
                'resources/js/assets/js/pages/horizontal-layout.js',
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
            '~bootstrap': resolve(__dirname, 'node_modules/bootstrap'),
            '~bootstrap-icons': resolve(__dirname, 'node_modules/bootstrap-icons'),
            '~perfect-scrollbar': resolve(__dirname, 'node_modules/perfect-scrollbar'),
            '~@fontsource': resolve(__dirname, 'node_modules/@fontsource'),
            '~@public': resolve(__dirname, 'public'),
			'@apexcharts': 'apexcharts'
        },
    },
    build: {
        sourcemap: true,
        chunkSizeWarningLimit: 1000
    },
    base: './'
});
