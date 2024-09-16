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
        component: () => import(/* webpackChunkName: "usr/book" */ './components/member/Book.vue'),
    },
    {
        path: '/baca-buku',
        name: 'baca_buku',
        component: () => import(/* webpackChunkName: "usr/readbook" */ './components/member/ReadBook.vue'),
    },
    {
        path: '/detail-buku/:idb',
        name: 'detail_buku',
        component: () => import(/* webpackChunkName: "usr/viewbook" */ './components/member/ViewBook.vue'),
    },
    {
        path: '/appreader',
        name: 'appreader',
        component: () => import(/* webpackChunkName: "usr/appreader" */ './components/member/AppReader.vue'),
    },
    {
        path: '/mregister',
        name: 'mregister',
        component: () => import(/* webpackChunkName: "usr/mregister" */ './components/member/FormRegister.vue'),
    },
]

export default _routes
