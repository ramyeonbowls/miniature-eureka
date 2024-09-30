<template>
    <div id="app-usr">
        <div id="main" class="layout-horizontal">
            <headerItems :isAuthenticated="isAuthenticated"></headerItems>
        
            <div class="content-wrapper container">
                <router-view :isAuthenticated="isAuthenticated"></router-view>
            </div>

            <nav class="navbar-dark navbar-expand d-block d-xs-block d-xl-none fixed-bottom" role="navigation" style="border-radius: 10px 10px 0 0 !important; background-color: #fab040;">
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
                            <router-link to="/rent-book" class='menu-item'>
                                <i class="bi bi-bookmark"></i> <small style="font-size: 11px;">Pinjaman</small>
                            </router-link>
                        </li>
                    </template>
                    <li class="nav-item">
                        <router-link to="/mlogin" class='menu-item'>
                            <i class="bi bi-person"></i> <small style="font-size: 11px;">Profil</small>
                        </router-link>
                    </li>
                </ul>
            </nav>
            <footer class="bottom-mobile">
                <footerItems></footerItems>
            </footer>
        </div>

        <!-- search modal -->
        <div class="modal fade" id="search-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Cari </h4>
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

    data() {
        return {
            user: {},
            searchQuery: '',
            isAuthenticated: false,
        }
    },

    mounted() {
        this.getInfo();
        
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
            this.user = {};

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

        searchBooks() {
            if(this.searchQuery!=''){
                this.$router.push({ name: 'koleksi-buku', query: { search: this.searchQuery } });
                this.searchQuery = '';
                const closeButton = document.getElementById('close-search');
                closeButton.click();
            }
        },
    },

    computed: {},
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
    }

</style>