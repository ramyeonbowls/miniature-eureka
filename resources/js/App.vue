<template>
    <router-view></router-view>
    <div id="sidebar">
        <sidebarItems></sidebarItems>
    </div>
</template>

<script>
import sidebarItems from './layouts/Sidebar.vue'

export default {
    components: {
        sidebarItems,
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
