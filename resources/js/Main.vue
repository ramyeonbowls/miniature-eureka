<template>
    <div id="app-usr">
        <div id="main" class="layout-horizontal">
            <headerItems :isAuthenticated="isAuthenticated"></headerItems>
        
            <div class="content-wrapper container">
                <router-view :isAuthenticated="isAuthenticated"></router-view>
            </div>
            <footer>
                <footerItems></footerItems>
            </footer>
        </div>
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
