<template>
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ data.menu_label }}</h3>
                    <p class="text-subtitle text-muted">{{ data.menu_desc }}</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link :to="{ name: 'home' }">Beranda</router-link></li>
                            <li v-if="menuLabel" class="breadcrumb-item active" aria-current="page" v-text="menuLabel"></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        menuLabel: {
            type: String,
            default: '',
        },
        data: {
            type: Object,
            default: () => ({}),
        },
    },
}
</script>
