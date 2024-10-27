<template>
    <header class="header mb-5 fixed-top">
        <div class="header-top">
            <div class="container">
                <a href="#" class="burger-btn d-block d-xl-none me-4">
                    <i class="bi bi-justify fs-3"></i>
                </a>

                <div class="col-md-1 col-2 col-lg-1">
                    <div class="logo-header d-block d-sm-block d-xl-none">
                        <a href="/">
                            <img :src="'/images/logo/logo_small.png?' + Math.floor(Math.random() * (999 - 100 + 1)) + 100" height="40px" class="mobile-logo" alt="Logo">
                        </a>
                    </div>
                    <div class="logo-header d-none d-xl-block d-lg-none">
                        <a href="/">
                            <img :src="'/images/logo/logo.png?' + Math.floor(Math.random() * (999 - 100 + 1)) + 100" height="50px" class="desktop-logo" alt="Logo">
                        </a>
                    </div>
                </div>

                <div class="col-md-7 col-8 col-lg-8 d-flex justify-content-center mx-2">
                    <div class="header-title">
                        <h4 class="header-title">{{ appname }}</h4>
                    </div>
                </div>

                <div class="col-md-3 col-2 col-lg-2 d-block d-xl-none">
                </div>

                <div class="header-top-right d-none d-xl-block">
                    <div class="dropdown">
                        <template v-if="isAuthenticated">
                            <a href="#" id="topbarUserDropdown" class="user-dropdown d-flex align-items-center dropend dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="avatar avatar-md2">
                                        <img :src="avatar">
                                    </div>
                                    <div class="text">
                                        <h6 class="user-dropdown-name">{{ name }}</h6>
                                        <p class="user-dropdown-status text-sm text-muted">Member</p>
                                    </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="topbarUserDropdown" style="">
                                <li><a class="dropdown-item" href="/profile">Profil Saya</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" @click.prevent="logout">Keluar</a>
                                </li>
                            </ul>
                        </template>
                        <template v-else>
                            <div class="user-dropdown d-flex align-items-center dropend">
                                <router-link :to="{ name: 'mlogin' }" class="font-bold">
                                    <button class="custom-button log me-1">Masuk</button>
                                </router-link>
                                <div v-if="register">
                                    <router-link :to="{ name: 'mregister' }" class="font-bold">
                                        <button class="custom-button reg me-1">Daftar</button>
                                    </router-link>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
        <nav class="main-navbar pt-3 pb-3">
            <div class="container">
                <ul style="font-weight: bold;">
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
                    <li class="menu-item has-sub">
                        <a href="#" class="menu-link">
                            <span> Artikel</span>
                        </a>
                        <div class="submenu">
                            <div class="submenu-group-wrapper">
                                <ul class="submenu-group">
                                    <li class="submenu-item">
                                        <router-link :to="{ name: 'artikel', params: { idart: 'TU' } }" class='submenu-link'>
                                            <span> Tajuk Utama</span>
                                        </router-link>
                                    </li>
                                    <li class="submenu-item">
                                        <router-link :to="{ name: 'artikel', params: { idart: 'WA' } }" class='submenu-link'>
                                            <span> Wawasan</span>
                                        </router-link>
                                    </li>
                                    <li class="submenu-item">
                                        <router-link :to="{ name: 'artikel', params: { idart: 'RB' } }" class='submenu-link'>
                                            <span> Review Buku</span>
                                        </router-link>
                                    </li>
                                    <li class="submenu-item">
                                        <router-link :to="{ name: 'artikel', params: { idart: 'LP' } }" class='submenu-link'>
                                            <span> Layar Penulis</span>
                                        </router-link>
                                    </li>
                                    <li class="submenu-item">
                                        <router-link :to="{ name: 'artikel', params: { idart: 'TF' } }" class='submenu-link'>
                                            <span> Titik Fokus</span>
                                        </router-link>
                                    </li>
                                    <li class="submenu-item">
                                        <router-link :to="{ name: 'artikel', params: { idart: 'HU' } }" class='submenu-link'>
                                            <span> Humoria</span>
                                        </router-link>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <template v-if="isAuthenticated">
						<li class="menu-item ">
							<router-link to="/quiz" class='menu-link'>
								<span> Quiz</span>
							</router-link>
						</li>
                        <li class="menu-item ">
                            <router-link to="/history-pinjaman" class='menu-link'>
                                <span> Riwayat Pinjaman</span>
                            </router-link>
                        </li>
                        <li class="menu-item d-block d-xs-block d-xl-none">
                            <a class="dropdown-item menu-link" href="javascript:void(0);" @click.prevent="logout" style="font-weight: bold;">
                                <span> Keluar</span>
                            </a>
                        </li>
                    </template>
                    <div class="d-none d-xl-block" style="position: fixed; right: 8%;">
                        <div class="form-group position-relative has-icon-right">
                            <input type="text" class="form-control rounded-pill" placeholder="Cari Judul, Penulis, ISBN" v-model="searchQuery" @keypress.enter="searchBooks">
                            <div class="form-control-icon">
                                <i class="bi bi-search" @click="searchBooks"></i>
                            </div>
                        </div>
                    </div>
                    <li class="theme-toogle">
                        <div class="theme-toggle d-flex gap-2 mt-2 svg-color">
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
import { register } from "swiper/element";

export default {
    name: 'headerItems',

    props: {
        isAuthenticated: {
            type: Boolean,
            required: true
        },
        name: {
            type: String,
            required: true
        },
        avatar: {
            type: String,
            required: true
        },
        appname: {
            type: String,
            required: true
        },
        register: {
            type: Boolean,
            required: true
        }
    },

    data() {
        return {
            user: {},
            searchQuery: ''
        }
    },

    mounted() {

    },

    methods: {
        logout() {
            let loader = this.$loading.show();
            window.axios.post('/logout').then((e) => {
                loader.hide();
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
.custom-button {
  cursor: pointer;
  border: 0;
  border-radius: 4px;
  font-weight: 600;
  margin: 0 10px;
  width: 100px;
  padding: 10px 0;
  box-shadow: 0 0 20px rgba(104, 85, 224, 0.2);
  transition: 0.4s;
}
.reg {
  color: white;
  background-color: #435ebe;
}

.log {
  color: rgb(104, 85, 224);
  background-color: rgba(255, 255, 255, 1);
  border: 1px solid #435ebe;
}

.log:hover {
  color: white;
  box-shadow: 0 0 20px rgba(104, 85, 224, 0.6);
  background-color: #435ebe;
}
.reg:hover {
  color: #ffffff;
  box-shadow: 0 0 20px #dec7a3;
  background-color: #fab040;
}
.header-title {
    font-size: 23px;
    margin: 0px 0px 0px;
    font-family: 'Libre Franklin';
    font-weight: 800;
    color: #5271FF;
}
.svg-color {
    color: #ffffff;
}

@media (max-width: 1200px) {
    .header-title {
        font-size: 1rem;
    }

    .svg-color {
        color: rgb(152, 153, 172);
    }
}
</style>