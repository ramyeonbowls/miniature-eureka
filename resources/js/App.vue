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

    data() {
        return {
            form: {
                data: '',
            },
        }
    },

    mounted() {},

    methods: {},

    computed: {},
}
</script>
