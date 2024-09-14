<template>
    <div class="page-heading">
            <div class="col-md-5 col-12">
            <div id="auth-left">
                <h1 class="auth-title">Log in.</h1>
                <p class="auth-subtitle mb-4">Log in with your data that you entered during registration.</p>

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
                            <i class="bi bi-person"></i>
                        </div>
                        <div v-if="errors.email" class="invalid-feedback">{{ errors.email[0] }}</div>
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input
                            type="password"
                            class="form-control form-control-md"
                            :class="{'is-invalid': errors.password}"
                            placeholder="Password"
                            v-model="password"
                        />
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        <div v-if="errors.password" class="invalid-feedback">{{ errors.password[0] }}</div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block btn-md shadow-md mt-3">Log in</button>
                </form>
                <div class="text-center mt-5 text-md fs-10">
                    <p class="text-gray-600">
                        Don't have an account?
                        <a href="/register" class="font-bold">Sign up</a>
                        .
                    </p>
                    <!-- <p>
                        <a class="font-bold" href="{{ route('password.request') }}">Forgot password?</a>
                        .
                    </p> -->
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
                const response = await axios.post('/login', {
                    _token: this.csrfToken,
                    email: this.email,
                    password: this.password,
                    from: 'member'
                });
                window.location.href = '/';
            } catch (error) {
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