/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap.js'
import { createApp } from 'vue'
import featherIcons from 'feather-icons'
import PerfectScrollbar from 'perfect-scrollbar'
import Main from './Main.vue'
import _routes from './_routes'
import { createRouter, createWebHistory } from 'vue-router'
import { LoadingPlugin } from 'vue-loading-overlay'
import 'vue-loading-overlay/dist/css/index.css'
import VueSweetalert2 from 'vue-sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css'
import 'flatpickr/dist/flatpickr.css'
import Flatpickr from 'vue-flatpickr-component'
import 'datatables.net-bs5/css/dataTables.bootstrap5.css'
import 'datatables.net-bs5'

const router = createRouter({
    history: createWebHistory(),
    linkActiveClass: 'active',
    routes: _routes
})

const gloading = {
    enforceFocus: false,
    canCancel: false,
    loader: 'spinner',
    color: '#8080ff',
    backgroundColor: '#111111',
    width: 110,
    height: 110,
    opacity: 0.4,
    zIndex: 1999,
}

const gSwal = {
    buttonsStyling: false,
    customClass: {
        htmlContainer: 'mx-2 fs-sm',
        confirmButton: 'btn btn-sm btn-primary me-2',
        cancelButton: 'btn btn-sm btn-secondary',
    },
}

const token = document.head.querySelector('meta[name="csrf-token"]').content;

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
}
axios.defaults.withCredentials = true;

featherIcons.replace()

function logAccess() {
    axios.post('/api/visit', {
        url: window.location.href
    });
}

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const appUser = createApp(Main)

appUser.component('Flatpickr', Flatpickr)

logAccess();
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

appUser.use(VueSweetalert2)
appUser.use(LoadingPlugin, gloading)
appUser.use(router)
appUser.mount('#usr-page-container')
