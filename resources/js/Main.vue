<template>
    <div id="app-usr">
        <div id="main" class="member-layout" :class="{ 'auth-layout': ['mlogin', 'mregister'].includes($route.name) }">
            <headerItems :isAuthenticated="isAuthenticated" :name="user.name" :avatar="user.avatar" :appname="appname" :register="param.register" :additional_features="param.additional_features"></headerItems>
        
            <main class="content-wrapper">
                <router-view :isAuthenticated="isAuthenticated" :register="param.register"  :additional_features="param.additional_features"></router-view>
            </main>

            <template v-if="param.fromOffline">
                <button class="floating-btn" @click="goOffline" title="Ke Mode Offline">
                    <i class="bi bi-cloud-slash"></i>
                </button>
            </template>

            <footer class="bottom-mobile">
                <footerItems :isAuthenticated="isAuthenticated"></footerItems>
            </footer>
        </div>

        <!-- search modal -->
        <div class="modal fade" id="search-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Cari</h4>
                        <button type="button" id="close-search" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group position-relative has-icon-right">
                            <input type="text" class="form-control rounded-pill" placeholder="Cari Judul, Penulis, ISBN" v-model="searchQuery" @keypress.enter="searchBooks">
                            <div class="form-control-icon">
                                <i class="bi bi-search" @click="searchBooks"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- search modal -->
    </div>
</template>

<script>
import headerItems from './layouts/MainHeader.vue'
import footerItems from './layouts/MainFooter.vue'

export default {
    components: {
        headerItems,
        footerItems,
    },

    created() {
        const fromOffline = sessionStorage.getItem("fromOffline");
        if (fromOffline === "Y") {
            this.param.fromOffline = true;
        }
    },

    data() {
        return {
            user: {
                name: '',
                avatar: ''
            },
            param: {
                register: true,
				additional_features: 0,
                fromOffline: false
            },
            appname: '',
            searchQuery: '',
            isAuthenticated: false,
        }
    },

    mounted() {
        this.getInfo();
        this.getAppInfo();
        this.getParam();
        this.initializeSubMenu();
        
        document.addEventListener('DOMContentLoaded', () => {
            let loader = this.$loading.show()
            setTimeout(() => {
                loader.hide()
            }, 1000)
        });

        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        }, false);
        // console.log(sessionStorage.getItem("fromOffline"));
    },

    methods: {
        getInfo() {
            this.user = {
                name: '',
                avatar: ''
            };

            axios.get('/getInfo')
            .then((response) => {
                this.user = response.data;

                if(response.data.name!=''){
                    this.isAuthenticated = true;
                }
            })
            .catch((e) => {
                console.error(e)
            });
        },

        getAppInfo() {
            this.appname = '';

            axios.get('/getAppInfo')
            .then((response) => {
                this.appname = response.data[0].application_name;
            })
            .catch((e) => {
                console.error(e)
            });
        },

        getParam() {
            this.param.register = '';

            axios.get('/getParam')
            .then((response) => {
                this.param.register = (response.data.reg_member==1) ? true : false;
                this.param.additional_features = parseInt(response.data.additional_features);
            })
            .catch((e) => {
                console.error(e)
            });
        },

        searchBooks() {
            if(this.searchQuery!=''){
                this.$router.push({ name: 'koleksi-buku', query: { search: this.searchQuery } });
                this.searchQuery = '';
                const closeButton = document.getElementById('close-search');
                closeButton.click();
            }
        },

        initializeSubMenu() {
            let submenus = document.querySelectorAll('.submenu-item')
    
            submenus.forEach((submenu) => {
                submenu.querySelector('.submenu-link').addEventListener('click', (e) => {
                    let navbar = document.querySelector('.main-navbar');
                    if (navbar.classList.contains('active')) {
                        navbar.classList.remove('active');
                    }
                    e.preventDefault()
                })
            })
        },

        goOffline() {
            sessionStorage.removeItem("fromOffline");

            const url_offline = import.meta.env.VITE_URL_OFFLINE
            window.location.replace(url_offline);

            setTimeout(() => {
                history.pushState(null, '', window.location.href);
                window.onpopstate = () => history.go(1);
            }, 500);
        }
    },

    computed: {},
}
</script>

<style scoped>
    #app-usr {
        --member-ink: #202a27;
        --member-muted: #64716c;
        --member-paper: #f7f7f3;
        --member-surface: #ffffff;
        --member-line: #e4e8e2;
        --member-accent: #236b58;
        --member-accent-dark: #174b3d;
        --member-button: #236b58;
        --member-button-hover: #174b3d;
        --member-soft: #edf4ef;
        --member-panel: #174b3d;
        --member-editorial-orange: #e7a348;
        --member-quote-bg: #e5eee6;
        --member-quote-card: rgba(255, 255, 255, .64);
        --member-review-bg: #f2f4ef;
        --member-review-line: #d4ddd5;
        --member-cover-bg: #e4e9e1;
        --member-humoria-bg: #fff4e8;
        --member-humoria-line: #ecd8c0;
        --member-humoria-card-line: #f1dfca;
        --member-humoria-ink: #372b20;
        --member-humoria-muted: #756453;
        --member-humoria-link: #81501f;
        --member-humoria-number: #cf7730;
        --member-humoria-image: #f6e2ca;
        --member-humoria-sticker: #ffe09b;
        --member-humoria-sticker-ink: #8a4a19;
        --member-humoria-sticker-line: #fff;
        min-height: 100vh;
        min-height: 100dvh;
        color: var(--member-ink);
        background: var(--member-paper);
        font-family: 'Nunito', sans-serif;
        -webkit-font-smoothing: antialiased;
    }

    :global(html[data-bs-theme="dark"] #app-usr) {
        --member-ink: #e9eee9;
        --member-muted: #aab6af;
        --member-paper: #171d1a;
        --member-surface: #202824;
        --member-line: #35423b;
        --member-accent: #83c8aa;
        --member-accent-dark: #a0dbc1;
        --member-button: #236b58;
        --member-button-hover: #174b3d;
        --member-soft: #293a32;
        --member-panel: #26372e;
        --member-editorial-orange: #f2ba6e;
        --member-quote-bg: #24352c;
        --member-quote-card: rgba(13, 20, 16, .55);
        --member-review-bg: #202824;
        --member-review-line: #3c4942;
        --member-cover-bg: #293a32;
        --member-humoria-bg: #2e281f;
        --member-humoria-line: #57432f;
        --member-humoria-card-line: #57432f;
        --member-humoria-ink: #eddfd0;
        --member-humoria-muted: #c4b29e;
        --member-humoria-link: #e5b983;
        --member-humoria-number: #81501f;
        --member-humoria-image: #24231f;
        --member-humoria-sticker: #574329;
        --member-humoria-sticker-ink: #f0c77e;
        --member-humoria-sticker-line: #2e281f;
        color-scheme: dark;
    }

    :global(html[data-bs-theme="dark"] #app-usr .bg-white),
    :global(html[data-bs-theme="dark"] #app-usr .bg-light),
    :global(html[data-bs-theme="dark"] #app-usr .bg-body) {
        color: var(--member-ink);
        background-color: var(--member-surface) !important;
    }

    :global(html[data-bs-theme="dark"] #app-usr .bg-white .text-white),
    :global(html[data-bs-theme="dark"] #app-usr .bg-light .text-white),
    :global(html[data-bs-theme="dark"] #app-usr .card .text-white) {
        color: var(--member-ink) !important;
    }

    :global(html[data-bs-theme="dark"] #app-usr .text-dark),
    :global(html[data-bs-theme="dark"] #app-usr .card .text-dark) {
        color: var(--member-ink) !important;
    }

    :global(html[data-bs-theme="dark"] #app-usr .text-secondary),
    :global(html[data-bs-theme="dark"] #app-usr .text-body-secondary) {
        color: var(--member-muted) !important;
    }

    :global(html[data-bs-theme="dark"] #app-usr .text-primary),
    :global(html[data-bs-theme="dark"] #app-usr .link-primary) {
        color: var(--member-accent) !important;
    }

    :global(html[data-bs-theme="dark"] #app-usr .form-control),
    :global(html[data-bs-theme="dark"] #app-usr .form-select),
    :global(html[data-bs-theme="dark"] #app-usr .input-group-text) {
        color: var(--member-ink);
        background-color: var(--member-surface);
        border-color: var(--member-line);
    }

    :global(html[data-bs-theme="dark"] #app-usr .form-control:disabled),
    :global(html[data-bs-theme="dark"] #app-usr .form-select:disabled) {
        color: var(--member-muted);
        background-color: var(--member-soft);
    }

    :global(html[data-bs-theme="dark"] #app-usr .form-control::placeholder) {
        color: var(--member-muted);
        opacity: 1;
    }

    :global(html[data-bs-theme="dark"] #app-usr .table-light) {
        --bs-table-color: var(--member-ink);
        --bs-table-bg: var(--member-surface);
        --bs-table-border-color: var(--member-line);
        --bs-table-striped-bg: var(--member-soft);
        --bs-table-striped-color: var(--member-ink);
        --bs-table-active-bg: var(--member-soft);
        --bs-table-active-color: var(--member-ink);
        --bs-table-hover-bg: var(--member-soft);
        --bs-table-hover-color: var(--member-ink);
    }

    :global(html[data-bs-theme="dark"] #app-usr .list-group-item),
    :global(html[data-bs-theme="dark"] #app-usr .accordion-item),
    :global(html[data-bs-theme="dark"] #app-usr .accordion-button) {
        color: var(--member-ink);
        background-color: var(--member-surface);
        border-color: var(--member-line);
    }

    :global(html[data-bs-theme="dark"] #app-usr .accordion-button:not(.collapsed)) {
        color: var(--member-accent);
        background-color: var(--member-soft);
    }

    :global(html[data-bs-theme="dark"] #app-usr .modal-content),
    :global(html[data-bs-theme="dark"] #app-usr .popover) {
        color: var(--member-ink);
        background-color: var(--member-surface);
        border-color: var(--member-line);
    }

    :global(html[data-bs-theme="dark"] #app-usr .modal-header),
    :global(html[data-bs-theme="dark"] #app-usr .modal-footer),
    :global(html[data-bs-theme="dark"] #app-usr .popover-header) {
        color: var(--member-ink);
        background-color: var(--member-surface);
        border-color: var(--member-line);
    }

    :global(html[data-bs-theme="dark"] #app-usr .product-card),
    :global(html[data-bs-theme="dark"] #app-usr #modalContent),
    :global(html[data-bs-theme="dark"] #app-usr .captcha-container) {
        color: var(--member-ink);
        background-color: var(--member-surface);
        border-color: var(--member-line);
    }

    :global(html[data-bs-theme="dark"] #app-usr .team) {
        background-color: #1f4b65;
    }

    :global(html[data-bs-theme="dark"] #app-usr .button-quiz) {
        color: #fff;
        background-color: var(--member-button);
    }

    :global(html[data-bs-theme="dark"] #app-usr .page-content .product-image) {
        background-color: var(--member-paper);
    }

    :global(html[data-bs-theme="dark"] #app-usr #AvatarFileUpload) {
        background-color: var(--member-paper);
        border-color: var(--member-line);
    }

    .member-layout {
        min-height: 100vh;
        min-height: 100dvh;
        overflow-x: clip;
    }

    #main.member-layout {
        display: flex;
        flex-direction: column;
        margin-left: 0;
        padding: 0;
    }

    #app-usr :deep(.content-wrapper) {
        width: auto;
        max-width: 1500px;
        min-height: 0;
        flex: 1 0 auto;
        margin: 76px 0 0 256px;
        padding: 2rem clamp(1.25rem, 3vw, 3rem) 4rem;
    }

    #app-usr :deep(.bottom-mobile) {
        flex: 0 0 auto;
        margin-left: 256px;
        padding: 0 clamp(1.25rem, 3vw, 3rem) max(1rem, env(safe-area-inset-bottom));
    }

    #app-usr :deep(.bottom-mobile .container) {
        width: 100%;
        max-width: 1500px;
    }

    #main.auth-layout :deep(.member-sidebar) {
        display: none !important;
    }

    #main.auth-layout :deep(.bottom-mobile) {
        margin-left: 0;
    }

    #main.auth-layout :deep(.member-topbar) {
        left: 0;
        margin-left: 0;
    }

    #main.auth-layout :deep(.content-wrapper) {
        max-width: 960px;
        margin-right: auto;
        margin-left: auto;
    }

    #main.auth-layout :deep(.topbar-start .sidebar-toggle),
    #main.auth-layout :deep(.mobile-brand) {
        display: none !important;
    }

    :global(html[data-bs-theme="dark"] .member-layout) {
        background: var(--member-paper);
    }

    #app-usr :deep(.page-heading),
    #app-usr :deep(.page-content),
    #app-usr :deep(.section) {
        color: var(--member-ink);
    }

    #app-usr :deep(.page-content > section),
    #app-usr :deep(.page-heading > section),
    #app-usr :deep(.section) {
        margin-bottom: 2rem;
    }

    #app-usr :deep(h1),
    #app-usr :deep(h2),
    #app-usr :deep(h3),
    #app-usr :deep(h4),
    #app-usr :deep(h5),
    #app-usr :deep(h6) {
        color: var(--member-ink);
        font-family: 'Libre Franklin', 'Nunito', sans-serif;
        font-weight: 700;
        letter-spacing: -0.025em;
    }

    #app-usr :deep(.page-heading h3),
    #app-usr :deep(.page-title h3) {
        font-size: clamp(1.65rem, 3vw, 2.3rem);
        margin-bottom: 1.25rem;
    }

    #app-usr :deep(.divider-left-center) {
        margin: 1rem 0 1.25rem;
    }

    #app-usr :deep(.divider-left-center h2),
    #app-usr :deep(.divider-text) {
        color: var(--member-ink);
        font-size: 1.05rem;
        font-weight: 800;
        letter-spacing: .08em;
    }

    #app-usr :deep(.card) {
        overflow: hidden;
        color: var(--member-ink);
        background: var(--member-surface);
        border: 1px solid var(--member-line);
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(31, 48, 38, .035);
    }

    #app-usr :deep(.card-header),
    #app-usr :deep(.card-footer) {
        color: var(--member-ink);
        background: var(--member-surface);
        border-color: var(--member-line);
    }

    #app-usr :deep(.card-body) {
        color: var(--member-ink);
    }

    #app-usr :deep(.card-title),
    #app-usr :deep(.card a:not(.btn)) {
        color: var(--member-ink);
        text-decoration: none;
    }

    #app-usr :deep(.card a:not(.btn):hover),
    #app-usr :deep(.page-content a:not(.btn):hover) {
        color: var(--member-accent);
    }

    #app-usr :deep(.text-muted),
    #app-usr :deep(.text-subtitle) {
        color: var(--member-muted) !important;
    }

    #app-usr :deep(.btn-primary) {
        --bs-btn-bg: var(--member-button);
        --bs-btn-border-color: var(--member-button);
        --bs-btn-hover-bg: var(--member-button-hover);
        --bs-btn-hover-border-color: var(--member-button-hover);
        --bs-btn-active-bg: var(--member-button-hover);
        --bs-btn-active-border-color: var(--member-button-hover);
        --bs-btn-disabled-bg: var(--member-button);
        --bs-btn-disabled-border-color: var(--member-button);
        color: #fff;
        border-radius: 7px;
        box-shadow: none;
        font-weight: 700;
    }

    #app-usr :deep(.btn-secondary),
    #app-usr :deep(.btn-light-secondary) {
        border-radius: 7px;
        font-weight: 700;
    }

    #app-usr :deep(.form-control),
    #app-usr :deep(.form-select) {
        min-height: 44px;
        color: var(--member-ink);
        background-color: var(--member-surface);
        border: 1px solid var(--member-line);
        border-radius: 8px;
        box-shadow: none;
    }

    #app-usr :deep(.form-control::placeholder) {
        color: var(--member-muted);
        opacity: .85;
    }

    #app-usr :deep(.form-control:focus),
    #app-usr :deep(.form-select:focus) {
        border-color: var(--member-accent);
        box-shadow: 0 0 0 3px color-mix(in srgb, var(--member-accent) 16%, transparent);
    }

    #app-usr :deep(.form-group label),
    #app-usr :deep(.form-label) {
        color: var(--member-ink);
        font-weight: 700;
    }

    #app-usr :deep(.form-check-input:checked) {
        background-color: var(--member-button);
        border-color: var(--member-button);
    }

    #app-usr :deep(.nav-tabs) {
        gap: .4rem;
        padding: 0 1.25rem;
        border-bottom-color: var(--member-line);
    }

    #app-usr :deep(.nav-tabs .nav-link) {
        color: var(--member-muted);
        border: 0;
        border-bottom: 2px solid transparent;
        padding: .85rem .9rem;
        font-weight: 700;
    }

    #app-usr :deep(.nav-tabs .nav-link.active) {
        color: var(--member-accent);
        background: transparent;
        border-bottom-color: var(--member-accent);
    }

    #app-usr :deep(.page-content .product-image) {
        min-height: 220px;
        max-height: none;
        padding: 1rem;
        background: #f3f4ef;
    }

    #app-usr :deep(.page-content .product-image img) {
        width: auto !important;
        height: auto !important;
        max-width: 100%;
        max-height: 205px;
        object-fit: contain;
        border-radius: 4px;
        transition: transform .2s ease;
    }

    #app-usr :deep(.page-content .product-image:hover img) {
        transform: translateY(-3px);
    }

    #app-usr :deep(.page-content .row-cols-2 > .col .card),
    #app-usr :deep(.page-content .row-cols-md-6 > .col .card) {
        height: 100%;
    }

    #app-usr :deep(.page-content .card-body .card-title),
    #app-usr :deep(.page-content .card-body h6) {
        line-height: 1.4;
    }

    #app-usr :deep(.page-content .pagination) {
        flex-wrap: wrap;
        gap: .3rem;
    }

    #app-usr :deep(.page-content .page-link) {
        min-width: 40px;
        color: var(--member-ink);
        background: var(--member-surface);
        border-color: var(--member-line);
        border-radius: 7px;
        text-align: center;
    }

    #app-usr :deep(.page-content .page-item.active .page-link) {
        color: #fff;
        background: var(--member-button);
        border-color: var(--member-button);
    }

    #app-usr :deep(.dropdown-menu) {
        max-width: min(92vw, 360px);
        color: var(--member-ink);
        background: var(--member-surface);
        border: 1px solid var(--member-line);
        border-radius: 10px;
        box-shadow: 0 12px 28px rgba(31, 48, 38, .1);
    }

    #app-usr :deep(.dropdown-item) {
        color: var(--member-ink);
        white-space: normal;
    }

    #app-usr :deep(.dropdown-item:hover),
    #app-usr :deep(.dropdown-item:focus) {
        color: var(--member-ink);
        background: var(--member-soft);
    }

    #app-usr :deep(.table) {
        --bs-table-color: var(--member-ink);
        --bs-table-bg: var(--member-surface);
        --bs-table-striped-bg: var(--member-soft);
        --bs-table-hover-bg: var(--member-soft);
        border-color: var(--member-line);
        vertical-align: middle;
    }

    #app-usr :deep(.dataTables_wrapper) {
        overflow-x: auto;
    }

    #app-usr :deep(.modal-content) {
        color: var(--member-ink);
        background: var(--member-surface);
        border: 1px solid var(--member-line);
        border-radius: 14px;
    }

    #app-usr :deep(.modal-header),
    #app-usr :deep(.modal-footer) {
        border-color: var(--member-line);
    }

    #app-usr :deep(.page-heading .auth-title) {
        color: var(--member-ink);
        font-size: clamp(2rem, 5vw, 3rem);
        font-weight: 800;
    }

    #app-usr :deep(.page-heading .auth-subtitle) {
        color: var(--member-muted);
        font-size: 1rem;
    }

    #app-usr :deep(.page-heading #auth-left),
    #app-usr :deep(.page-heading form.form) {
        padding: clamp(1.25rem, 4vw, 2.5rem);
        background: var(--member-surface);
        border: 1px solid var(--member-line);
        border-radius: 14px;
    }

    #app-usr :deep(.card-cover .card) {
        padding: .75rem;
    }

    #app-usr :deep(.card-cover .img-detail) {
        width: auto !important;
        max-width: min(100%, 320px);
        max-height: 480px;
        object-fit: contain;
        border-radius: 4px !important;
    }

    #app-usr :deep(.card-cover .buttons) {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: .5rem;
    }

    #app-usr :deep(.details .comment-body) {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        padding: .75rem 0;
        border-bottom: 1px solid var(--member-line);
    }

    #app-usr :deep(.details .comment-profileName) {
        color: var(--member-muted);
        font-weight: 600;
    }

    #app-usr :deep(.details .comment-time) {
        color: var(--member-ink);
        text-align: right;
        font-weight: 700;
    }

    #app-usr :deep(.page-content article img),
    #app-usr :deep(.page-content > .col-12 img.img-fluid) {
        max-width: 100%;
        height: auto;
    }

    #app-usr :deep(.testimonial-slider) {
        background: var(--member-soft);
        border: 1px solid var(--member-line);
        border-radius: 12px;
        box-shadow: none !important;
    }

    #app-usr :deep(.testimonial-title),
    #app-usr :deep(.testimonial-title h2) {
        color: var(--member-accent-dark);
    }

    #app-usr :deep(.carousel img) {
        max-width: 100%;
        object-fit: cover;
    }

    #app-usr :deep(iframe),
    #app-usr :deep(video),
    #app-usr :deep(audio),
    #app-usr :deep(canvas) {
        max-width: 100%;
    }

    #app-usr :deep(.footer) {
        color: var(--member-muted);
        padding: .75rem 0;
    }

    :global(html[data-bs-theme="dark"] #app-usr .reader-experience),
    :global(html[data-bs-theme="dark"] #app-usr .reader-stage),
    :global(html[data-bs-theme="dark"] #app-usr #pdf-container) {
        color: var(--member-ink);
        background: var(--member-paper);
    }

    :global(html[data-bs-theme="dark"] #app-usr .reader-note) {
        color: var(--member-muted);
    }

    :global(html[data-bs-theme="dark"] #app-usr .reader-stage canvas) {
        border-color: var(--member-line);
    }

    :global(html[data-bs-theme="dark"] #app-usr .pagination-float) {
        background: rgba(32, 40, 36, .97);
        border-color: var(--member-line);
    }

    :global(html[data-bs-theme="dark"] #app-usr .pagination-float .page-link) {
        color: var(--member-ink) !important;
        background: var(--member-surface) !important;
        border-color: var(--member-line) !important;
    }

    :global(html[data-bs-theme="dark"] #app-usr .pagination-float .page-link:not(.disabled):hover) {
        color: var(--member-accent) !important;
        background: var(--member-soft) !important;
    }

    #main.member-layout:has(.pagination-float) :deep(.bottom-mobile) {
        padding-bottom: max(4.5rem, calc(env(safe-area-inset-bottom) + 3.5rem));
    }

    #main.member-layout:has(.pagination-float) :deep(.mobile-bottom-nav) {
        display: none;
    }

    .menu-item {
        color: var(--member-muted);
        text-decoration: none;
        padding: 0.3rem;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .menu-item i {
        font-size: 1.1rem;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        -webkit-text-stroke: 1px;
    }

    .menu-item.active {
        color: var(--member-accent);
        border-bottom: 2px solid var(--member-accent);
    }

    .floating-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: var(--member-button);
        color: white;
        border: none;
        border-radius: 50%;
        width: 56px;
        height: 56px;
        font-size: 22px;
        box-shadow: 0 4px 12px rgba(25, 54, 43, .18);
        cursor: pointer;
        z-index: 9999;
        transition: transform 0.2s ease-in-out;
    }

    .floating-btn:hover {
        background-color: var(--member-button-hover);
    }

    @media (max-width: 1199.98px) {
        #app-usr :deep(.content-wrapper) {
            min-height: 0;
            margin: 68px 0 0;
            padding: 1.5rem clamp(1rem, 4vw, 2rem) calc(6rem + env(safe-area-inset-bottom));
        }

        #app-usr :deep(.bottom-mobile) {
            position: fixed;
            z-index: 1030;
            right: 0;
            bottom: 0;
            left: 0;
            margin-left: 0;
            padding: 0 clamp(.5rem, 2vw, 1rem) max(.5rem, env(safe-area-inset-bottom));
            pointer-events: none;
        }

        #app-usr :deep(.bottom-mobile .container) {
            pointer-events: auto;
        }
    }

    @media (max-width: 575px) {
        #app-usr :deep(.content-wrapper) {
            padding: 1rem .875rem calc(6rem + env(safe-area-inset-bottom));
        }

        #app-usr :deep(.page-content > section),
        #app-usr :deep(.page-heading > section),
        #app-usr :deep(.section) {
            margin-bottom: 1.25rem;
        }

        #app-usr :deep(.card-body) {
            padding: 1rem;
        }

        #app-usr :deep(.page-content .product-image) {
            min-height: 160px;
            padding: .65rem;
        }

        #app-usr :deep(.page-content .product-image img) {
            max-height: 150px;
        }

        #app-usr :deep(.page-content .pagination .page-link) {
            min-width: 34px;
            padding: .45rem .55rem;
            font-size: .85rem;
        }

        #app-usr :deep(.page-heading form.form) {
            padding: 1rem;
        }
    }

</style>