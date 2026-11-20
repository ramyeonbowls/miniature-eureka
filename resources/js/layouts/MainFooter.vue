<template>
    <div class="container">
        <div class="footer desktop-footer clearfix mb-0 text-muted">
            <div class="float-start">
                <p>&copy; 2026 Pustara. All rights reserved.</p>
            </div>
            <div class="float-end">
                <!-- <p>Under <a href="#">Development</a></p> -->
            </div>
        </div>

        <nav class="mobile-bottom-nav" aria-label="Navigasi utama">
            <router-link to="/" class="mobile-nav-link" active-class="is-active" exact-active-class="is-active">
                <i class="bi bi-house-door" aria-hidden="true"></i>
                <span>Beranda</span>
            </router-link>
            <router-link to="/koleksi-buku" class="mobile-nav-link" :class="{ 'is-active': $route.path.startsWith('/koleksi-buku') || $route.path.startsWith('/detail-buku') || $route.path === '/rent-book' }" active-class="is-active" exact-active-class="is-active">
                <i class="bi bi-bookshelf" aria-hidden="true"></i>
                <span>Koleksi</span>
            </router-link>
            <router-link :to="{ name: 'artikel', params: { idart: 'TU' } }" class="mobile-nav-link" :class="{ 'is-active': $route.path.startsWith('/artikel') || $route.path.startsWith('/detail-artikel') }" active-class="is-active" exact-active-class="is-active">
                <i class="bi bi-journal-richtext" aria-hidden="true"></i>
                <span>Artikel</span>
            </router-link>
            <router-link v-if="isAuthenticated" to="/history-pinjaman" class="mobile-nav-link" active-class="is-active" exact-active-class="is-active">
                <i class="bi bi-bookmark-check" aria-hidden="true"></i>
                <span>Pinjaman</span>
            </router-link>
            <router-link :to="isAuthenticated ? '/profile' : { name: 'mlogin' }" class="mobile-nav-link" active-class="is-active" exact-active-class="is-active">
                <i :class="isAuthenticated ? 'bi bi-person' : 'bi bi-box-arrow-in-right'" aria-hidden="true"></i>
                <span>{{ isAuthenticated ? 'Akun' : 'Masuk' }}</span>
            </router-link>
        </nav>
    </div>
</template>

<script>
export default {
    name: 'footerItems',

    props: {
        isAuthenticated: {
            type: Boolean,
            required: true
        }
    },

    data() {
        return {}
    },

    mounted() {},

    methods: {},

    computed: {},
}
</script>

<style scoped>
.mobile-bottom-nav {
    display: none;
}

@media (max-width: 1199.98px) {
    .desktop-footer {
        display: none;
    }

    .mobile-bottom-nav {
        display: grid;
        grid-auto-columns: minmax(0, 1fr);
        grid-auto-flow: column;
        align-items: center;
        width: 100%;
        max-width: 720px;
        min-height: 64px;
        margin: 0 auto;
        padding: .35rem .25rem;
        border: 1px solid rgba(228, 232, 226, .9);
        border-radius: 20px;
        background: rgba(255, 255, 255, .96);
        box-shadow: 0 8px 28px rgba(27, 47, 36, .14);
        -webkit-backdrop-filter: blur(18px);
        backdrop-filter: blur(18px);
    }

    .mobile-nav-link {
        display: flex;
        min-width: 0;
        min-height: 52px;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: .2rem;
        border-radius: 14px;
        color: #64716c;
        font-size: .66rem;
        font-weight: 700;
        line-height: 1;
        text-decoration: none;
        transition: color .18s ease, background-color .18s ease, transform .18s ease;
        -webkit-tap-highlight-color: transparent;
    }

    .mobile-nav-link i {
        font-size: 1.2rem;
        line-height: 1;
    }

    .mobile-nav-link.is-active {
        color: #236b58;
        background: #edf4ef;
    }
}

:global(html[data-bs-theme="dark"]) .mobile-bottom-nav {
    border-color: rgba(53, 66, 59, .95);
    background: rgba(32, 40, 36, .96);
    box-shadow: 0 8px 28px rgba(0, 0, 0, .3);
}

:global(html[data-bs-theme="dark"]) .mobile-nav-link {
    color: #aab6af;
}

:global(html[data-bs-theme="dark"]) .mobile-nav-link.is-active {
    color: #a0dbc1;
    background: #293a32;
}

@media (prefers-reduced-motion: reduce) {
    .mobile-nav-link {
        transition: none;
    }
}
</style>
