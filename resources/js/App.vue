<template>
    <div id="app">
        <div id="sidebar">
            <sidebarItems></sidebarItems>
        </div>
        <div id="main" class="layout-navbar navbar-fixed">
            <header>
                <headerItems :user="user"></headerItems>
            </header>
            <div id="main-content">
                <router-view :user="user"></router-view>
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
            user: {
                role: ''
            }
        }
    },

    mounted() {
		this.userinfo()

        document.addEventListener('DOMContentLoaded', () => {
            let loader = this.$loading.show()
            setTimeout(() => {
                loader.hide()
            }, 1000)
        })
    },

    methods: {
		userinfo() {
            this.user = {}

            window.axios
                .get('/userinfo')
                .then((response) => {
                    this.user = response.data
                })
                .catch((e) => {
                    console.error(e)
                })
        },
	},

    computed: {},
}
</script>
