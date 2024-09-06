const routes = [
    {
        path: '/:pathMatch(.*)*',
        name: 'NotFound',
        component: () => import(/* webpackChunkName: "404" */ './layouts/404.vue'),
    },
    {
        path: '/home',
        name: 'home',
        component: () => import(/* webpackChunkName: "home" */ './components/Home.vue'),
    },
    {
        path: '/role-menu',
        name: 'role_menu',
        component: () => import(/* webpackChunkName: "setting/role_menu" */ './components/setting/RoleMenu.vue'),
    },
]

export default routes
