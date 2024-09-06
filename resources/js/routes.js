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
        path: '/profile',
        name: 'profile',
        component: () => import(/* webpackChunkName: "home" */ './components/Profile.vue'),
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
    {
        path: '/report/report-read-book-users',
        name: 'report_read_book_users',
        component: () => import(/* webpackChunkName: "report/report_read_book_users" */ './components/report/ReportReadBookUsers.vue'),
    },
    {
        path: '/report/report-read-book-contents',
        name: 'report_read_book_contents',
        component: () => import(/* webpackChunkName: "report/report_read_book_contents" */ './components/report/ReportReadBookContents.vue'),
    },
    {
        path: '/report/report-read-news',
        name: 'report_read_news',
        component: () => import(/* webpackChunkName: "report/report_read_news" */ './components/report/ReportReadNews.vue'),
    },
    {
        path: '/report/report-books',
        name: 'report_books',
        component: () => import(/* webpackChunkName: "report/report_books" */ './components/report/ReportBooks.vue'),
    },
    {
        path: '/report/report-members',
        name: 'report_members',
        component: () => import(/* webpackChunkName: "report/report_members" */ './components/report/ReportMembers.vue'),
    },
    {
        path: '/report/report-loans',
        name: 'report_loans',
        component: () => import(/* webpackChunkName: "report/report_loans" */ './components/report/ReportLoans.vue'),
    },
    {
        path: '/report/report-visitors',
        name: 'report_visitors',
        component: () => import(/* webpackChunkName: "report/report_visitors" */ './components/report/ReportVisitors.vue'),
    },
    {
        path: '/report/report-Libraryl-officers',
        name: 'report_library_officers',
        component: () => import(/* webpackChunkName: "report/report_library-officers" */ './components/report/ReportLibraryOfficers.vue'),
    },
]

export default routes
