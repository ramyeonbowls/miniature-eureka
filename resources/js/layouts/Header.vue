<template>
    <nav class="navbar navbar-expand navbar-light navbar-top">
        <div class="container-fluid">
            <a href="javascript:void(0)" class="burger-btn d-block">
                <i class="bi bi-justify fs-3"></i>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-lg-0"></ul>
                <div class="dropdown">
                    <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-menu d-flex">
                            <div class="user-name text-end me-3">
                                <h6 class="mb-0 text-gray-600">{{ user.name }}</h6>
                                <p class="mb-0 text-sm text-gray-600">{{ user.email }}</p>
                            </div>
                            <div class="user-img d-flex align-items-center">
                                <div class="avatar avatar-md">
                                    <img :src="'/storage/images/logo/logo_small.png?' + Math.floor(Math.random() * (999 - 100 + 1)) + 100" />
                                </div>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton" style="min-width: 11rem">
                        <li>
                            <h6 class="dropdown-header">{{ user.name }}</h6>
                        </li>
                        <li>
							<template v-if="user.role=='teacher'">
								<router-link :to="{ name: 'teacher_account' }" class="dropdown-item"><i class="icon-mid bi bi-person me-2"></i> Profil</router-link>
							</template>
							<template v-else>
								<router-link :to="{ name: 'my_account' }" class="dropdown-item"><i class="icon-mid bi bi-person me-2"></i> Profil Perpustakaan</router-link>
							</template>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);" @click.prevent="logout"><i class="icon-mid bi bi-box-arrow-left me-2"></i> Keluar</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    name: 'headerItems',

    data() {
        return {
            user: {},
        }
    },

    mounted() {
        this.userinfo()
    },

    methods: {
        userinfo() {
            this.user = {}

            window.axios
                .get('/userinfo')
                .then((response) => {
                    this.user = response.data
                })
                .catch((e) => {
                    console.error(e)
                })
        },

        logout() {
			let loader = this.$loading.show();
            window.axios.post('/logout').then((e) => {
				loader.hide();
                window.location = '/admin'
            })
        },
    },

    computed: {},
}
</script>
