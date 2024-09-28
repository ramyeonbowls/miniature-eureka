<template>
    <div class="page-heading">
            <div class="col-md-5 col-12">
            <div id="auth-left">
                <h1 class="auth-title">Masuk</h1>
                <p class="auth-subtitle mb-4">Masuk dengan email yang di daftarkan</p>

                <form @submit.prevent="handleLogin">
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input
                            type="text"
                            class="form-control form-control-md"
                            :class="{'is-invalid': errors.email}"
                            placeholder="Email"
                            v-model="email"
                        />
                        <div class="form-control-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div v-if="errors.email" class="invalid-feedback">{{ errors.email[0] }}</div>
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input
                            type="password"
                            class="form-control form-control-md"
                            :class="{'is-invalid': errors.password}"
                            placeholder="Kata Sandi"
                            v-model="password"
                        />
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        <div v-if="errors.password" class="invalid-feedback">{{ errors.password[0] }}</div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block btn-md shadow-md mt-3">Masuk</button>
                </form>
                <div class="col-12 d-flex justify-content-start mt-3">
                    <div class="text-center text-md fs-10">
                        <p class="text-gray-600">
                            Belum punya akun?
                            <router-link :to="{ name: 'mregister' }" class="font-bold">Daftar</router-link>
                            .
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            email: '',
            password: '',
            errors: {},
            csrfToken: '',
        };
    },
    mounted() {
        this.csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
    },

    methods: {
        async handleLogin() {
            try {
                let loader = this.$loading.show();
                const response = await axios.post('/login', {
                    _token: this.csrfToken,
                    email: this.email,
                    password: this.password,
                    from: 'member'
                });
                loader.hide();
                window.location.href = '/';
            } catch (error) {
                loader.hide();
                if (error.response && error.response.status === 422) {
                    this.errors = error.response.data.errors || {};
                } else {
                    console.error('An unknown error occurred:', error);
                }
            }
        }
    }
};
</script>