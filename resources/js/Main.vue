<template>
    <div id="app-usr">
        <div id="main" class="layout-horizontal">
            <headerItems></headerItems>
        
            <div class="content-wrapper container">
                <router-view></router-view>
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

    mounted() {
        document.addEventListener('DOMContentLoaded', () => {
            let loader = this.$loading.show()
            setTimeout(() => {
                loader.hide()
            }, 1000)
        })
    },

    methods: {},

    computed: {},
}
</script>
