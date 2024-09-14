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
        path: '/koleksi-buku',
        name: 'koleksi_buku',
        component: () => import(/* webpackChunkName: "usr/buku" */ './components/member/Book.vue'),
    },
    {
        path: '/baca-buku',
        name: 'baca_buku',
        component: () => import(/* webpackChunkName: "usr/buku" */ './components/member/ReadBook.vue'),
    },
    {
        path: '/detail-buku/:idb',
        name: 'detail_buku',
        component: () => import(/* webpackChunkName: "usr/buku" */ './components/member/ViewBook.vue'),
    },
    {
        path: '/appreader',
        name: 'appreader',
        component: () => import(/* webpackChunkName: "usr/buku" */ './components/member/AppReader.vue'),
        props: route => ({ pdfToken: route.query.pdfToken })
    },
]

export default _routes
