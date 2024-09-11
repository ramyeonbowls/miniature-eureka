const _routes = [
    {
        path: '/:pathMatch(.*)*',
        name: 'NotFound',
        component: () => import(/* webpackChunkName: "usr/404" */ './layouts/404.vue'),
    },
    {
        path: '/',
        name: 'main',
        component: () => import(/* webpackChunkName: "/usr/home" */ './components/member/HomeMain.vue'),
        props: route => ({ isAuthenticated: route.meta.isAuthenticated})
    },
    {
        path: '/mlogin',
        name: 'mlogin',
        component: () => import(/* webpackChunkName: "usr/mlogin" */ './components/member/formLogin.vue'),
    },
    {
        path: '/buku',
        name: 'buku',
        component: () => import(/* webpackChunkName: "usr/buku" */ './components/member/formLogin.vue'),
    },
    {
        path: '/baca-buku',
        name: 'baca_buku',
        component: () => import(/* webpackChunkName: "usr/buku" */ './components/member/ReadBook.vue'),
    },
    {
        path: '/view-buku',
        name: 'view_buku',
        component: () => import(/* webpackChunkName: "usr/buku" */ './components/member/ViewBook.vue'),
    },
]

export default _routes
