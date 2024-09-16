<template>
    <div class="page-heading">
        <div class="row">
            <h1 class="auth-title">Daftar Member</h1>
            <p class="auth-subtitle mb-4">Masukkan data untuk jadi member perpustakaan</p>
            <form class="form" @submit.prevent="handleRegister">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="name-column">Nama Lengkap</label>
                            <div class="form-group position-relative has-icon-left mb-4">
                                <input type="text" class="form-control form-control-md" placeholder="Nama Lengkap" v-model="name" required/>
                                <div class="form-control-icon">
                                    <i class="bi bi-person"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="email-column">Email</label>
                            <div class="form-group position-relative has-icon-left mb-4">
                                <input type="text" class="form-control form-control-md" :class="{'is-invalid': errors.email}" placeholder="Email" v-model="email" required/>
                                <div class="form-control-icon">
                                    <i class="bi bi-envelope"></i>
                                </div>
                                <div v-if="errors.email" class="invalid-feedback">{{ errors.email[0] }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="no-hp-column">No. HP</label>
                            <div class="form-group position-relative has-icon-left mb-4">
                                <input type="text" id="phoneNumberInput" class="form-control form-control-md" placeholder="No. Handphone" maxlength="15" required v-model="phone" />
                                <div class="form-control-icon">
                                    <i class="bi bi-phone"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="jenis-kelamin-floating">Jenis Kelamin</label>
                            <select class="form-select" id="jenkel" v-model="jenkel" required>
                                <option value="">--</option>
                                <option value="L">Laki - Laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="password-column">Kata Sandi</label>
                            <div class="form-group position-relative has-icon-left mb-4">
                                <input type="password" class="form-control form-control-md" :class="{'is-invalid': errors.password}" placeholder="Kata Sandi" v-model="password" required/>
                                <div class="form-control-icon">
                                    <i class="bi bi-shield-lock"></i>
                                </div>
                                <div v-if="errors.password" class="invalid-feedback">{{ errors.password[0] }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="password-confirm-column">Ulangi Kata Sandi</label>
                            <div class="form-group position-relative has-icon-left mb-4">
                                <input type="password" class="form-control form-control-md" :class="{'is-invalid': errors.passwordConfirm}" placeholder="Ulangi Kata Sandi" v-model="passwordConfirm"
                                />
                                <div class="form-control-icon">
                                    <i class="bi bi-shield-lock"></i>
                                </div>
                                <div v-if="errors.passwordConfirm" class="invalid-feedback">{{ errors.passwordConfirm[0] }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-12">
                        <button type="submit" class="btn btn-primary btn-block btn-md shadow-md mt-3">Daftar</button>
                    </div>
                    <div class="col-12 d-flex justify-content-start mt-3">
                        <div class="text-center text-md fs-10">
                            <p class="text-gray-600">
                                Sudah punya akun?
                                <router-link :to="{ name: 'mlogin' }" class="font-bold">Masuk</router-link>
                                .
                            </p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            name: '',
            email: '',
            password: '',
            passwordConfirm: '',
            phone: '',
            jenkel: '',
            errors: {},
            csrfToken: '',
        };
    },
    mounted() {
        this.csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
        $(document).ready(function () {
            $('#phoneNumberInput').on('input', function() {
                this.value = this.value.replace(/\D/g, '');
            });
        });
    },
    watch: {
        password(newValue, oldValue) {
            if (this.errors.password) {
                this.errors.password = null;
            }
            if (newValue !== this.passwordConfirm) {
                this.errors.passwordConfirm = ['Kata sandi tidak sesuai!'];
            } else {
                this.errors.passwordConfirm = null;
            }
        },
        passwordConfirm(newValue, oldValue) {
            if (this.errors.passwordConfirm) {
                this.errors.passwordConfirm = null;
            }
            if (newValue !== this.password) {
                this.errors.passwordConfirm = ['Kata sandi tidak sesuai!'];
            } else {
                this.errors.passwordConfirm = null;
            }
        }
    },
    methods: {
        async handleRegister() {
            if (this.password !== this.passwordConfirm) {
                this.errors.passwordConfirm = ['Kata sandi tidak sesuai!'];
                return;
            }

            try {
                const response = await axios.post('/register', {
                    _token: this.csrfToken,
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    phone: this.phone,
                    jenkel: this.jenkel,
                    'password_confirmation': this.passwordConfirm,
                    role: 'member'
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
