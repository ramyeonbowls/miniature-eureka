<template>
    <div id="app">
        <div id="sidebar">
            <sidebarItems></sidebarItems>
        </div>
        <div id="main" class="layout-navbar navbar-fixed">
            <header>
                <headerItems></headerItems>
            </header>
            <div id="main-content">
                <router-view></router-view>
            </div>
            <footer>
                <footerItems></footerItems>
            </footer>
        </div>
    </div>
</template>

<script>
import sidebarItems from './layouts/Sidebar.vue'
import headerItems from './layouts/Header.vue'
import footerItems from './layouts/Footer.vue'

export default {
    components: {
        sidebarItems,
        headerItems,
        footerItems,
    },

    created() {
        window.addEventListener('blur', this.handleAppBlur)
    },

    mounted() {
        document.addEventListener('DOMContentLoaded', () => {
            let loader = this.$loading.show()
            setTimeout(() => {
                loader.hide()
            }, 1000)
        })
    },

    beforeUnmount() {
        window.removeEventListener('blur', this.handleAppBlur)
    },

    methods: {
        handleAppBlur() {
            // console.log('App lost focus, user may have switched apps.')
            this.$swal.fire({
                icon: "warning",
                title: "Warning",
                text: 'Alert: Screenshot attempt detected!'
            })
        },
    },

    computed: {},
}
</script>
