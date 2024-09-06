const _routes = [
    {
        path: '/:pathMatch(.*)*',
        name: 'NotFound',
        component: () => import(/* webpackChunkName: "usr/404" */ './layouts/404.vue'),
    },
    {
        path: '/',
        name: 'main',
        component: () => import(/* webpackChunkName: "/usrhome" */ './components/member/HomeMain.vue'),
    },
    {
        path: '/mlogin',
        name: 'mlogin',
        component: () => import(/* webpackChunkName: "usr/mlogin" */ './components/member/formLogin.vue'),
    },
]

export default _routes
