<template>
    <div id="app-usr">
        <div id="main" class="layout-horizontal">
            <headerItems :isAuthenticated="isAuthenticated" :name="user.name" :avatar="user.avatar" :appname="appname" :register="param.register" :additional_features="param.additional_features"></headerItems>
        
            <div class="content-wrapper container">
                <router-view :isAuthenticated="isAuthenticated" :register="param.register"  :additional_features="param.additional_features"></router-view>
            </div>

            <nav class="navbar-dark navbar-expand d-block d-xs-block d-xl-none fixed-bottom" role="navigation" style="border-radius: 10px 10px 0 0 !important;  background: rgb(21,47,74); background: linear-gradient(180deg, rgba(21,47,74,1) 0%, rgba(69,62,190,1) 100%);">
                <ul class="navbar-nav nav-justified pt-2">
                    <li class="nav-item">
                        <router-link to="/" class='menu-item'>
                            <i class="bi bi-house"></i> <small style="font-size: 11px;">Beranda</small>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <div class='menu-item' data-bs-toggle="modal" data-bs-target="#search-modal">
                            <i class="bi bi-search"></i> <small style="font-size: 11px;">Cari</small>
                        </div>
                    </li>
                    <li class="nav-item">
                        <router-link to="/koleksi-buku" class='menu-item'>
                            <i class="bi bi-book"></i> <small style="font-size: 11px;">Koleksi</small>
                        </router-link>
                    </li>
                    <template v-if="isAuthenticated">
                        <li class="nav-item">
                            <router-link to="/history-pinjaman" class='menu-item'>
                                <i class="bi bi-bookmark"></i> <small style="font-size: 11px;">Pinjaman</small>
                            </router-link>
                        </li>
                        <!-- <li class="nav-item">
                            <router-link to="/profile" class='menu-item'>
                                <i class="bi bi-person"></i> <small style="font-size: 11px;">Profil</small>
                            </router-link>
                        </li> -->
                    </template>
                    <template v-else>
                        <li class="nav-item">
                            <router-link to="/mlogin" class='menu-item'>
                                <i class="bi bi-box-arrow-in-right"></i> <small style="font-size: 11px;">Masuk</small>
                            </router-link>
                        </li>
                    </template>
                </ul>
            </nav>

            <template v-if="param.fromOffline">
                <button class="floating-btn" @click="goOffline" title="Ke Mode Offline">
                    <i class="bi bi-cloud-slash"></i>
                </button>
            </template>

            <footer class="bottom-mobile">
                <footerItems></footerItems>
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
            appnameSet: false,
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
            const route = this.$route;

            if (this.appnameSet) return;

            if (route.path.startsWith('/titikbaca/') && route.params.idt) {
                axios.get(`/check-titik-baca?idt=${route.params.idt}`)
                .then((response) => {
                    this.appname = response.data.name;
                    this.appnameSet = true;
                })
                .catch(() => {
                    this.$router.push({ name: 'NotFound' });
                });
            } else if (sessionStorage.getItem('place')){
                this.appname = sessionStorage.getItem('place');
                this.appnameSet = true;
            } else if ( route.path === '/' || route.path === '/titikbaca' || route.path === '/titikbaca/' ) {
                this.appname = '';
                this.appnameSet = true;
            } 
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

    watch: {
        '$route'(to, from) {
            if (
                to.path.startsWith('/titikbaca/') &&
                from.params.idt !== to.params.idt
            ) {
                this.appnameSet = false;
                this.getAppInfo();
            }
        }
    }
}
</script>

<style scoped>
    .content-wrapper{
        margin-top: 160px;
    }

    @media screen and (max-width: 1199px) {
        .content-wrapper{
            margin-top: 90px;
        }   
    }

    .menu-item {
        color: rgb(255, 255, 255);
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
        color: rgb(255, 255, 255);
        border-bottom: 2px solid rgb(255, 255, 255);
    }

    @media (max-width: 1200px) {
        .bottom-mobile {
            margin-bottom: 45px;
        }

        body:has(.navbar-dark.navbar-expand.d-block.d-xs-block.d-xl-none.fixed-bottom) .floating-btn {
            bottom: 70px;
        }
    }

    .floating-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 50%;
        width: 56px;
        height: 56px;
        font-size: 22px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        cursor: pointer;
        z-index: 9999;
        transition: transform 0.2s ease-in-out;
    }

    .floating-btn:hover {
        transform: scale(1.1);
        background-color: #0056b3;
    }

</style>