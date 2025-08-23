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
		props: route => ({ user: route.meta.user })
    },
    {
        path: '/my-account',
        name: 'my_account',
        component: () => import(/* webpackChunkName: "home" */ './components/Profile.vue'),
    },
    {
        path: '/setting/role-menu',
        name: 'role_menu',
        component: () => import(/* webpackChunkName: "setting/role_menu" */ './components/setting/RoleMenu.vue'),
    },
    {
        path: '/setting/banner',
        name: 'banner',
        component: () => import(/* webpackChunkName: "setting/banner" */ './components/setting/Banner.vue'),
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
        component: () => import(/* webpackChunkName: "report/report_library_officers" */ './components/report/ReportLibraryOfficers.vue'),
    },
    {
        path: '/master/master-books',
        name: 'master_books',
        component: () => import(/* webpackChunkName: "report/master_books" */ './components/master/MasterBooks.vue'),
    },
    {
        path: '/master/master-members',
        name: 'master_members',
        component: () => import(/* webpackChunkName: "report/master_members" */ './components/master/MasterMembers.vue'),
    },
    {
        path: '/report/report-po',
        name: 'report_po',
        component: () => import(/* webpackChunkName: "report/report_po" */ './components/report/ReportPO.vue'),
    },
    {
        path: '/master/master-library-officers',
        name: 'master_library_officers',
        component: () => import(/* webpackChunkName: "report/master_library_officers" */ './components/master/MasterLibraryOfficers.vue'),
    },
    {
        path: '/setting/tajuk-utama',
        name: 'tajuk_utama',
        component: () => import(/* webpackChunkName: "setting/tajuk_utama" */ './components/setting/TajukUtama.vue'),
    },
    {
        path: '/setting/wawasan',
        name: 'wawasan',
        component: () => import(/* webpackChunkName: "setting/wawasan" */ './components/setting/Wawasan.vue'),
    },
    {
        path: '/setting/review-buku',
        name: 'review_buku',
        component: () => import(/* webpackChunkName: "setting/review_buku" */ './components/setting/ReviewBuku.vue'),
    },
    {
        path: '/setting/titik-fokus',
        name: 'titik_fokus',
        component: () => import(/* webpackChunkName: "setting/titik_fokus" */ './components/setting/TitikFokus.vue'),
    },
    {
        path: '/setting/humoria',
        name: 'humoria',
        component: () => import(/* webpackChunkName: "setting/humoria" */ './components/setting/Humoria.vue'),
    },
    {
        path: '/setting/layar-penulis',
        name: 'layar_penulis',
        component: () => import(/* webpackChunkName: "setting/layar_penulis" */ './components/setting/LayarPenulis.vue'),
    },
    {
        path: '/setting/frasa',
        name: 'frasa',
        component: () => import(/* webpackChunkName: "setting/frasa" */ './components/setting/Frasa.vue'),
    },
    {
        path: '/report/report-offline-visitors',
        name: 'report_offline_visitors',
        component: () => import(/* webpackChunkName: "report/report_offline_visitors" */ './components/report/ReportOfflineVisitors.vue'),
    },
    {
        path: '/parameter',
        name: 'parameter',
        component: () => import(/* webpackChunkName: "report/parameter" */ './components/setting/Parameter.vue'),
    },
    {
        path: '/setting/quiz',
        name: 'quiz',
        component: () => import(/* webpackChunkName: "setting/quiz" */ './components/setting/Quiz.vue'),
    },
    {
        path: '/master/master-teachers',
        name: 'master_teachers',
        component: () => import(/* webpackChunkName: "setting/master_teachers" */ './components/master/MasterTeachers.vue'),
    },
	{
        path: '/teacher-account',
        name: 'teacher_account',
        component: () => import(/* webpackChunkName: "home/teacher_account" */ './components/ProfileTeacher.vue'),
    },
    {
        path: '/report/report-quiz',
        name: 'report_quiz',
        component: () => import(/* webpackChunkName: "report/report_quiz" */ './components/report/ReportQuiz.vue'),
    },
	{
        path: '/setting/video',
        name: 'video',
        component: () => import(/* webpackChunkName: "setting/video" */ './components/setting/Video.vue'),
    },
    {
        path: '/approval/appr-users',
        name: 'appr_users',
        component: () => import(/* webpackChunkName: "transaction/appr_users" */ './components/transaction/ApprUsers.vue'),
    },
    {
        path: '/transaction/input-po',
        name: 'input_po',
        component: () => import(/* webpackChunkName: "transaction/input_po" */ './components/transaction/InputPO.vue'),
    },
    {
        path: '/pusat-literasi/master-pusat-literasi',
        name: 'master_pusat_literasi',
        component: () => import(/* webpackChunkName: "pusat_literasi/master_pusat_literasi" */ './components/master/MasterPusatLiterasi.vue'),
    },
    {
        path: '/pusat-literasi/aktivitas-pusat-literasi',
        name: 'aktivitas_pusat_literasi',
        component: () => import(/* webpackChunkName: "pusat_literasi/aktivitas_pusat_literasi" */ './components/report/ReportPusatLiterasi.vue'),
    },
]

export default routes
