const routes = [
    {
        path: '/:pathMatch(.*)*',
        name: 'NotFound',
        component: () => import(/* webpackChunkName: "404" */ './layouts/404.vue'),
    },
    {
        path: '/admin',
        name: 'home',
        component: () => import(/* webpackChunkName: "home" */ './components/Home.vue'),
    },
    {
        path: '/setting/role-menu',
        name: 'role_menu',
        component: () => import(/* webpackChunkName: "setting/role_menu" */ './components/setting/RoleMenu.vue'),
    },
    {
        path: '/report/report-read-book',
        name: 'report_read_book',
        component: () => import(/* webpackChunkName: "report/report_read_book" */ './components/report/ReportReadBook.vue'),
    },
]

export default routes
