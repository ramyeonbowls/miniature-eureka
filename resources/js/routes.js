const routes = [
    // {
    //     path: '/:pathMatch(.*)*',
    //     name: 'NotFound',
    //     component: () => import(/* webpackChunkName: "404" */ './packages/404.vue'),
    // },
    {
        path: '/',
        name: 'home',
        component: () => import(/* webpackChunkName: "home" */ './components/ExampleComponent.vue'),
    },
]

export default routes
