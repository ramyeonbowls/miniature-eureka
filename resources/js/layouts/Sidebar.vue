<template>
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a href="#"><img src="./../assets/static/images/logo/logo.svg" alt="Logo" srcset="" /></a>
                </div>
                <div class="theme-toggle d-flex gap-2 align-items-center mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--system-uicons" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                        <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2" opacity=".3"></path>
                            <g transform="translate(-210 -1)">
                                <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                <circle cx="220.5" cy="11.5" r="4"></circle>
                                <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"></path>
                            </g>
                        </g>
                    </svg>
                    <div class="form-check form-switch fs-6">
                        <input class="form-check-input me-0" type="checkbox" id="toggle-dark" style="cursor: pointer" />
                        <label class="form-check-label"></label>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--mdi" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                        <path
                            fill="currentColor"
                            d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z"
                        ></path>
                    </svg>
                </div>
                <div class="sidebar-toggler x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <template v-for="sidebarItem in sidebarItems">
                    <template v-if="sidebarItem.isTitle">
                        <li class="sidebar-title">{{ sidebarItem.name }}</li>
                    </template>
                    <template v-else>
                        <li :class="['sidebar-item', { active: sidebarItem.url === $route.fullPath }, { 'has-sub': sidebarItem.submenu && sidebarItem.submenu.length > 0 }]">
                            <router-link :to="sidebarItem.url !== undefined ? sidebarItem.url : '#'" class="sidebar-link">
                                <i :class="'bi bi-' + sidebarItem.icon"></i>
                                <span>{{ sidebarItem.name }}</span>
                            </router-link>
                            <template v-if="sidebarItem.submenu && sidebarItem.submenu.length > 0">
                                <ul :class="['submenu', { active: sidebarItem.url === $route.fullPath }]">
                                    <template v-for="sub in sidebarItem.submenu">
                                        <li :class="['submenu-item', { active: sub.url === $route.fullPath }, { 'has-sub': sub.submenu && sub.submenu.length > 0 }]">
                                            <router-link :to="sub.url" class="submenu-link">{{ sub.name }}</router-link>
                                            <template v-if="sub.submenu && sub.submenu.length">
                                                <ul class="submenu submenu-level-2">
                                                    <template v-for="subsub in sub.submenu">
                                                        <li :class="['submenu-item', { active: subsub.url === $route.fullPath }]">
                                                            <router-link :to="subsub.url" class="submenu-link">{{ subsub.name }}</router-link>
                                                        </li>
                                                    </template>
                                                </ul>
                                            </template>
                                        </li>
                                    </template>
                                </ul>
                            </template>
                        </li>
                    </template>
                </template>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    name: 'sidebarItems',

    data() {
        return {
            sidebarItems: [
                {
                    name: 'Menu',
                    isTitle: true,
                },
                {
                    name: 'Dashboard',
                    url: '/',
                    icon: 'grid-fill',
                },
                {
                    name: 'Components',
                    key: 'component',
                    icon: 'stack',
                    submenu: [
                        {
                            name: 'Accordion',
                            url: 'component-accordion',
                        },
                        {
                            name: 'Alert',
                            url: 'component-alert',
                        },
                        {
                            name: 'Badge',
                            url: 'component-badge',
                        },
                        {
                            name: 'Breadcrumb',
                            url: 'component-breadcrumb',
                        },
                        {
                            name: 'Button',
                            url: 'component-button',
                        },
                        {
                            name: 'Card',
                            url: 'component-card',
                        },
                        {
                            name: 'Carousel',
                            url: 'component-carousel',
                        },
                        {
                            name: 'Collapse',
                            url: 'component-collapse',
                        },
                        {
                            name: 'Dropdown',
                            url: 'component-dropdown',
                        },
                        {
                            name: 'List Group',
                            url: 'component-list-group',
                        },
                        {
                            name: 'Modal',
                            url: 'component-modal',
                        },
                        {
                            name: 'Navs',
                            url: 'component-navs',
                        },
                        {
                            name: 'Pagination',
                            url: 'component-pagination',
                        },
                        {
                            name: 'Placeholder',
                            url: 'component-placeholder',
                        },
                        {
                            name: 'Progress',
                            url: 'component-progress',
                        },
                        {
                            name: 'Spinner',
                            url: 'component-spinner',
                        },
                        {
                            name: 'Toasts',
                            url: 'component-toasts',
                        },
                        {
                            name: 'Tooltip',
                            url: 'component-tooltip',
                        },
                    ],
                },
                {
                    name: 'Extra Components',
                    key: 'extra-component',
                    icon: 'collection-fill',
                    submenu: [
                        {
                            name: 'Avatar',
                            url: 'extra-component-avatar',
                        },
                        {
                            name: 'Comment',
                            url: 'extra-component-comment',
                        },
                        {
                            name: 'Divider',
                            url: 'extra-component-divider',
                        },
                        {
                            name: 'Date Picker',
                            url: 'extra-component-date-picker',
                        },
                        {
                            name: 'Flag',
                            url: 'extra-component-flag',
                        },
                        {
                            name: 'Sweet Alert',
                            url: 'extra-component-sweetalert',
                        },
                        {
                            name: 'Toastify',
                            url: 'extra-component-toastify',
                        },
                        {
                            name: 'Rating',
                            url: 'extra-component-rating',
                        },
                    ],
                },
                {
                    name: 'Layouts',
                    key: 'layout',
                    icon: 'grid-1x2-fill',
                    submenu: [
                        {
                            name: 'Default Layout',
                            url: 'layout-default',
                        },
                        {
                            name: '1 Column',
                            url: 'layout-vertical-1-column',
                        },
                        {
                            name: 'Vertical Navbar',
                            url: 'layout-vertical-navbar',
                        },
                        {
                            name: 'RTL Layout',
                            url: 'layout-rtl',
                        },
                        {
                            name: 'Horizontal Menu',
                            url: 'layout-horizontal',
                        },
                    ],
                },
                {
                    name: 'Forms & Tables',
                    isTitle: true,
                },
                {
                    name: 'Form Elements',
                    key: 'form-element',
                    icon: 'hexagon-fill',
                    submenu: [
                        {
                            name: 'Input',
                            url: 'form-element-input',
                        },
                        {
                            name: 'Input Group',
                            url: 'form-element-input-group',
                        },
                        {
                            name: 'Select',
                            url: 'form-element-select',
                        },
                        {
                            name: 'Radio',
                            url: 'form-element-radio',
                        },
                        {
                            name: 'Checkbox',
                            url: 'form-element-checkbox',
                        },
                        {
                            name: 'Textarea',
                            url: 'form-element-textarea',
                        },
                    ],
                },
                {
                    name: 'Form Layout',
                    url: 'form-layout',
                    icon: 'file-earmark-medical-fill',
                },
                {
                    name: 'Form Validation',
                    icon: 'journal-check',
                    key: 'form-validation',
                    submenu: [
                        {
                            name: 'Parsley',
                            url: 'form-validation-parsley',
                        },
                    ],
                },
                {
                    name: 'Form Editor',
                    icon: 'pen-fill',
                    key: 'form-editor',
                    submenu: [
                        {
                            name: 'Quill',
                            url: 'form-editor-quill',
                        },
                        {
                            name: 'CKEditor',
                            url: 'form-editor-ckeditor',
                        },
                        {
                            name: 'Summernote',
                            url: 'form-editor-summernote',
                        },
                        {
                            name: 'TinyMCE',
                            url: 'form-editor-tinymce',
                        },
                    ],
                },
                {
                    name: 'Table',
                    url: 'table',
                    icon: 'grid-1x2-fill',
                },
                {
                    name: 'Datatables',
                    key: 'table-datatable',
                    icon: 'file-earmark-spreadsheet-fill',
                    submenu: [
                        {
                            name: 'Datatable',
                            url: 'table-datatable',
                        },
                        {
                            name: 'Datatable (jQuery)',
                            url: 'table-datatable-jquery',
                        },
                    ],
                },
                {
                    name: 'Extra UI',
                    isTitle: true,
                },
                {
                    name: 'Widgets',
                    key: 'ui-widgets',
                    icon: 'pentagon-fill',
                    submenu: [
                        {
                            name: 'Chatbox',
                            url: 'ui-widgets-chatbox',
                        },
                        {
                            name: 'Pricing',
                            url: 'ui-widgets-pricing',
                        },
                        {
                            name: 'To-do List',
                            url: 'ui-widgets-todolist',
                        },
                    ],
                },
                {
                    name: 'Icons',
                    key: 'ui-icons',
                    icon: 'egg-fill',
                    submenu: [
                        {
                            name: 'Bootstrap Icons ',
                            url: 'ui-icons-bootstrap-icons',
                        },
                        {
                            name: 'Fontawesome',
                            url: 'ui-icons-fontawesome',
                        },
                        {
                            name: 'Dripicons',
                            url: 'ui-icons-dripicons',
                        },
                    ],
                },
                {
                    name: 'Charts',
                    key: 'ui-chart',
                    icon: 'bar-chart-fill',
                    submenu: [
                        {
                            name: 'ChartJS',
                            url: 'ui-chart-chartjs',
                        },
                        {
                            name: 'Apexcharts',
                            url: 'ui-chart-apexcharts',
                        },
                    ],
                },
                {
                    name: 'File Uploader',
                    key: 'ui-file',
                    icon: 'cloud-arrow-up-fill',
                    url: 'ui-file-uploader',
                },
                {
                    name: 'Maps',
                    key: 'ui-map',
                    icon: 'map-fill',
                    submenu: [
                        {
                            name: 'Google Map',
                            url: 'ui-map-google-map',
                        },
                        {
                            name: 'JS Vector Map',
                            url: 'ui-map-jsvectormap',
                        },
                        {
                            name: 'Leaflet Map',
                            url: 'ui-map-leaflet',
                        },
                        {
                            name: 'OpenLayers Map',
                            url: 'ui-map-openlayers',
                        },
                    ],
                },
                {
                    name: 'Multi-level Menu',
                    key: 'ui-multi-level-menu',
                    icon: 'three-dots',
                    submenu: [
                        {
                            name: 'First Level',
                            key: 'ui-multi-level-menu',
                            url: '#',
                            submenu: [
                                {
                                    name: 'Second Level',
                                    url: 'ui-multi-level-menu',
                                },
                                {
                                    name: 'Second Level Menu',
                                    url: '#',
                                },
                            ],
                        },
                        {
                            name: 'Another Menu',
                            url: '#',
                            submenu: [
                                {
                                    name: 'Second Level Menu',
                                    url: '#',
                                },
                            ],
                        },
                    ],
                },
                {
                    name: 'Pages',
                    isTitle: true,
                },
                {
                    name: 'Email Application',
                    key: 'application-email',
                    icon: 'envelope-fill',
                    url: 'application-email',
                },
                {
                    name: 'Chat Application',
                    key: 'application-chat',
                    icon: 'chat-dots-fill',
                    url: 'application-chat',
                },
                {
                    name: 'Photo Gallery',
                    key: 'application-gallery',
                    icon: 'image-fill',
                    url: 'application-gallery',
                },
                {
                    name: 'Checkout Page',
                    key: 'application-checkout',
                    icon: 'basket-fill',
                    url: 'application-checkout',
                },
                {
                    name: 'Account',
                    key: 'account',
                    icon: 'person-circle',
                    submenu: [
                        {
                            name: 'Profile',
                            url: 'account-profile',
                        },
                        {
                            name: 'Security',
                            url: 'account-security',
                        },
                    ],
                },
                {
                    name: 'Authentication',
                    key: 'auth',
                    icon: 'person-badge-fill',
                    submenu: [
                        {
                            name: 'Login',
                            url: 'auth-login',
                        },
                        {
                            name: 'Register',
                            url: 'auth-register',
                        },
                        {
                            name: 'Forgot Password',
                            url: 'auth-forgot-password',
                        },
                    ],
                },
                {
                    name: 'Errors',
                    key: 'error',
                    icon: 'x-octagon-fill',
                    submenu: [
                        {
                            name: '403',
                            url: 'error-403',
                        },
                        {
                            name: '404',
                            url: 'error-404',
                        },
                        {
                            name: '500',
                            url: 'error-500',
                        },
                    ],
                },
                {
                    name: 'Raise Support',
                    isTitle: true,
                },
                {
                    name: 'Documentation',
                    key: 'error',
                    icon: 'life-preserver',
                    url: 'https://zuramai.github.io/mazer/docs',
                },
                {
                    name: 'Contribute',
                    key: 'error',
                    url: 'https://github.com/zuramai/mazer/blob/main/CONTRIBUTING.md',
                    icon: 'puzzle',
                },
                {
                    name: 'Donate',
                    key: 'error',
                    url: 'https://github.com/zuramai/mazer#donation',
                    icon: 'cash',
                },
            ],
        }
    },

    mounted() {},

    methods: {},

    computed: {},
}
</script>
