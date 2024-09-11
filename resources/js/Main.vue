<template>
    <div id="app-usr">
        <div id="main" class="layout-horizontal">
            <headerItems :isAuthenticated="isAuthenticated"></headerItems>
        
            <div class="content-wrapper container">
                <router-view :isAuthenticated="isAuthenticated"></router-view>
            </div>

            <nav class="navbar-dark bg-secondary navbar-expand d-md-none d-lg-none d-xl-none fixed-bottom" role="navigation">
                <ul class="navbar-nav nav-justified">
                    <li class="nav-item">
                        <router-link to="/" class='menu-item'>
                            <i class="bi bi-house"></i>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/search" class='menu-item'>
                            <i class="bi bi-search"></i>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/book" class='menu-item'>
                            <i class="bi bi-book"></i>
                        </router-link>
                    </li>
                    <template v-if="isAuthenticated">
                        <li class="nav-item">
                            <router-link to="/" class='menu-item'>
                                <i class="bi bi-bookmark"></i>
                            </router-link>
                        </li>
                    </template>
                    <li class="nav-item">
                        <router-link to="/mlogin" class='menu-item'>
                            <i class="bi bi-person"></i>
                        </router-link>
                    </li>
                </ul>
            </nav>
            <footer>
                <footerItems></footerItems>
            </footer>
        </div>
    </div>
</template>

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
        color: white;
        text-decoration: none;
        padding: 1rem 0;
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
        color: white;
        border-bottom: 2px solid rgb(255, 255, 255); /* Underline biru untuk item aktif */
    }

</style>

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

            window.axios
            .get('/getInfo')
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
    },

    computed: {},
}
</script>
