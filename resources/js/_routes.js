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
        name: 'koleksi-buku',
        component: () => import(/* webpackChunkName: "usr/book" */ './components/member/Book.vue'),
    },
    {
        path: '/baca-buku',
        name: 'baca-buku',
        component: () => import(/* webpackChunkName: "usr/readbook" */ './components/member/ReadBook.vue'),
    },
    {
        path: '/detail-buku/:idb',
        name: 'detail-buku',
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
    {
        path: '/rent-book',
        name: 'rent-book',
        component: () => import(/* webpackChunkName: "usr/book" */ './components/member/Book.vue'),
    },
    {
        path: '/artikel/:idart',
        name: 'artikel',
        component: () => import(/* webpackChunkName: "usr/artikel" */ './components/member/Artikel.vue'),
    },
    {
        path: '/detail-artikel/:idart/:detail',
        name: 'detail-artikel',
        component: () => import(/* webpackChunkName: "usr/detailartikel" */ './components/member/DetailArtikel.vue'),
    },
]

export default _routes
