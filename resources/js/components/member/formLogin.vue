<template>
    <div class="page-heading member-auth member-login-page">
            <div class="col-md-5 col-12 login-column">
            <div id="auth-left">
                    <router-link to="/" class="login-home-link">
                        <i class="bi bi-arrow-left" aria-hidden="true"></i>
                        <span>Kembali ke beranda</span>
                    </router-link>
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
                <div class="col-12 mt-3">
                    <div class="text-center text-md fs-10">
                        <p class="text-gray-600" v-if="register">
                            Belum punya akun?
                            <router-link :to="{ name: 'mregister' }" class="font-bold">Daftar</router-link>
                        </p>
						<p class="text-gray-600">
							<a class="font-bold" href="/password/reset">Lupa Kata Sandi?</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        register: {
            type: Boolean,
            required: true
        }
    },
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
            let loader = this.$loading.show()
            try {
                const response = await axios.post('/login', {
                    _token: this.csrfToken,
                    email: this.email,
                    password: this.password,
                    from: 'member'
                })
                loader.hide()
                window.location.href = response.data.redirect || '/'
            } catch (error) {
                loader.hide();
                if (error.response && error.response.status === 422) {
                    this.errors = error.response.data.errors || {}
                    this.password = ''
                } else if (error.response && error.response.status === 403) {
                    this.$swal({
                        title: "Gagal Masuk",
                        text: error.response.data.message,
                        icon: 'error',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showCloseButton: false,
                        showCancelButton: false
                    })

                    this.password = ''
                } else {
                    this.errors = 'Terjadi error, silahkan refresh halaman'
                    console.error('An unknown error occurred:', error)
                }
            }
        }
    }
};
</script>

<style scoped>
.member-login-page {
    display: grid;
    min-height: min(68vh, 700px);
    align-items: center;
    justify-items: center;
    padding: clamp(1rem, 4vw, 3rem) 0;
}

.member-login-page .login-column {
    width: min(100%, 520px);
    max-width: 520px;
}

.member-login-page #auth-left {
    position: relative;
    padding: clamp(1.4rem, 5vw, 3rem) !important;
    border-top: 4px solid var(--member-accent, #236b58);
    background: var(--member-surface, #fff);
}

.login-home-link {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    margin-bottom: 1.4rem;
    color: var(--member-accent, #236b58);
    font-size: .9rem;
    font-weight: 700;
    text-decoration: none;
}

.login-home-link:hover {
    color: var(--member-ink, #1d2b29);
    text-decoration: underline;
}

.login-home-link:focus-visible {
    border-radius: 3px;
    outline: 2px solid var(--member-accent, #236b58);
    outline-offset: 4px;
}

.member-login-page .auth-title {
    margin-bottom: .4rem;
    font-size: clamp(2rem, 5vw, 2.8rem) !important;
}

.member-login-page .auth-subtitle {
    margin-bottom: 2rem !important;
}

.member-login-page form .form-group {
    margin-bottom: 1rem !important;
}

.member-login-page form .form-control {
    min-height: 50px;
    padding-left: 3rem;
}

.member-login-page .form-control-icon {
    color: var(--member-muted, #64716c);
}

.member-login-page button[type="submit"] {
    min-height: 48px;
    margin-top: .5rem !important;
    box-shadow: none !important;
}

.member-login-page .text-center {
    margin-top: 1.25rem;
}
</style>