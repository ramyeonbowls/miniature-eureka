<template>
    <header class="header mb-5 fixed-top">
        <div class="header-top">
            <div class="container">
                <a href="#" class="burger-btn d-block d-xl-none me-4" @click="toggleDropdown">
                    <i class="bi bi-justify fs-3"></i>
                </a>

                <div class="col-md-1 col-2 col-lg-1">
                    <div class="logo-header d-block d-sm-block d-xl-none">
                        <a href="/">
                            <img src="/images/logo/logo_small.png" height="40px" class="mobile-logo" alt="Logo">
                        </a>
                    </div>
                    <div class="logo-header d-none d-xl-block d-lg-none">
                        <a href="/">
                            <img src="/images/logo/logo.png" height="50px" class="desktop-logo" alt="Logo">
                        </a>
                    </div>
                </div>

                <div class="col-md-7 col-8 col-lg-8 d-flex justify-content-center">
                    <div class="header-title">
                        <h3 class="header-title">PERPUSTAKAAN DIGITAL GINESIA</h3>
                    </div>
                </div>

                <div class="col-md-3 col-2 col-lg-2">
                    <div class="d-none d-xl-block">
                        <div class="form-group position-relative has-icon-right">
                            <input type="text" class="form-control rounded-pill" placeholder="Cari Judul, Penulis" v-model="searchQuery" @keypress.enter="searchBooks">
                            <div class="form-control-icon">
                                <i class="bi bi-search" @click="searchBooks"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <nav class="main-navbar">
            <div class="container">
                <ul>
                    <li class="menu-item ">
                        <router-link to="/" class='menu-link'>
                            <span> Beranda</span>
                        </router-link>
                    </li>
                    <li class="menu-item ">
                        <router-link to="/koleksi-buku" class='menu-link'>
                            <span> Koleksi Buku</span>
                        </router-link>
                    </li>
                    <li class="menu-item ">
                        <template v-if="!isAuthenticated">
                            <router-link to="/mlogin" class='menu-link'>
                                <span> Masuk</span>
                            </router-link>
                        </template>
                        <template v-else>
                            <a class="dropdown-item menu-link" href="javascript:void(0);" @click.prevent="logout">
                                <span> Keluar</span>
                            </a>
                        </template>
                    </li>
                    <li class="menu-item has-sub">
                        <a href="#" class="menu-link">
                            <span> Artikel</span>
                        </a>
                        <div class="submenu ">
                            <ul class="submenu-group">
                                <li class="submenu-item">
                                    <router-link :to="{ name: 'artikel', params: { idart: 'tajuk-utama' } }" class='submenu-link'>
                                        <span> Tajuk Utama</span>
                                    </router-link>
                                </li>
                                <li class="submenu-item">
                                    <router-link :to="{ name: 'artikel', params: { idart: 'wawasan' } }" class='submenu-link'>
                                        <span> Wawasan</span>
                                    </router-link>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="theme-toogle">
                        <div class="theme-toggle d-flex gap-2 mt-2" style="color: #fab040;">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--system-uicons icon-day" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
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
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--mdi icon-night" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                <path
                                    fill="currentColor"
                                    d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z"
                                ></path>
                            </svg>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
</template>

<script>
import "~@fontsource/libre-franklin";
import "~@fontsource/libre-franklin/900.css";
import "~@fontsource/libre-franklin/800.css";

export default {
    name: 'headerItems',

    props: {
        isAuthenticated: {
            type: Boolean,
            required: true
        }
    },

    data() {
        return {
            searchQuery: ''
        }
    },

    mounted() {

    },

    methods: {
        logout() {
            window.axios.post('/logout').then((e) => {
                window.location = '/'
            })
        },

        searchBooks() {
            if(this.searchQuery!=''){
                this.$router.push({ name: 'koleksi-buku', query: { search: this.searchQuery } });
                this.searchQuery = '';
            }
        },
    },

    computed: {},
}
</script>

<style scoped>
.header-title {
    font-size: 25px;
    margin: 0px 0px 0px;
    font-family: 'Libre Franklin';
    font-weight: 800;
    color: #5271FF;
}

@media (max-width: 999px) {
    .header-title {
        font-size: 1rem;
    }
}
</style>