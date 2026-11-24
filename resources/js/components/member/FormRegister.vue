<template>
    <div class="page-heading member-auth member-register-page">
        <div class="row register-layout">
            <div class="register-intro">
                <router-link to="/" class="register-home-link">
                    <i class="bi bi-arrow-left" aria-hidden="true"></i>
                    <span>Kembali ke beranda</span>
                </router-link>
                <h1 class="auth-title">Daftar Member</h1>
                <p class="auth-subtitle mb-4">Masukkan data untuk jadi member perpustakaan</p>
            </div>
            <form class="form register-form" @submit.prevent="handleRegister">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="name-column">Nama Lengkap</label>
                            <div class="form-group position-relative has-icon-left mb-4">
                                <input type="text" class="form-control form-control-md" :class="{'is-invalid': errors.name}" placeholder="Nama Lengkap" v-model="name" required/>
                                <div class="form-control-icon">
                                    <i class="bi bi-person"></i>
                                </div>
                                <div v-if="errors.name" class="invalid-feedback">{{ errors.name[0] }}</div>
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
                            <p class="email-note">Gunakan email yang valid dan aktif. Kami akan mengirim tautan verifikasi ke email ini, dan akun baru dapat digunakan setelah email dikonfirmasi. Periksa juga folder Spam jika email belum masuk.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="no-hp-column">No. HP</label>
                            <div class="form-group position-relative has-icon-left mb-4">
                                <input type="text" id="phoneNumberInput" class="form-control form-control-md" :class="{'is-invalid': errors.phone}" placeholder="No. Handphone" maxlength="15" required v-model="phone" @input="filterInput($event, 'phone')" />
                                <div class="form-control-icon">
                                    <i class="bi bi-phone"></i>
                                </div>
                                <div v-if="errors.phone" class="invalid-feedback">{{ errors.phone[0] }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="jenis-kelamin-floating">Jenis Kelamin</label>
                            <select class="form-select" :class="{'is-invalid': errors.gender}" id="gender" v-model="gender" required>
                                <option value="">--</option>
                                <option value="L">Laki - Laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                            <div v-if="errors.gender" class="invalid-feedback">{{ errors.gender[0] }}</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="tanggal-lahir">Tanggal Lahir</label>
                            <div class="form-group position-relative has-icon-left mb-4">
                                <Flatpickr v-model="birthday" class="form-control flatpickr-range" :config="configdate" placeholder="Select date.." required></Flatpickr>
                                <div class="form-control-icon">
                                    <i class="bi bi-calendar3"></i>
                                </div>
                                <span v-if="errors.isBirthdayValid" class="text-danger">{{ errors.isBirthdayValid[0] }}</span>
                                <span v-if="errors.birthday" class="text-danger">{{ errors.birthday[0] }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="nik">Nomor Identitas</label>
                            <div class="form-group position-relative has-icon-left mb-4">
                                <input type="text" id="nikInput" class="form-control form-control-md" placeholder="Nomor Induk Kependudukan" maxlength="20" v-model="nik" @input="filterInput($event, 'nik')" />
                                <div class="form-control-icon">
                                    <i class="bi bi-credit-card"></i>
                                </div>
                                <div v-if="errors.nik" class="text-danger">{{ errors.nik[0] }}</div>
                            </div>
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
            gender: '',
            birthday: '',
            nik: '',
            errors: {},
            csrfToken: '',
            configdate: {
                dateFormat: 'Y-m-d',
                disableMobile: true
            },
        };
    },
    mounted() {
        this.csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
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
        filterInput(event, param) {
            if(param=='nik'){
                this.nik = event.target.value.replace(/\D/g, '');
            }else if(param=='phone'){
                this.phone = event.target.value.replace(/\D/g, '');
            }
        },

        async handleRegister() {
            this.errors = {};
            if (this.password !== this.passwordConfirm) {
                this.errors.passwordConfirm = ['Kata sandi tidak sesuai!'];
                return;
            }
            
            if (this.birthday == '') {
                this.errors.isBirthdayValid = ['Pilih Tanggal Lahir'];
                return;
            }

            let loader = this.$loading.show();
            await axios.post('/mregist', {
                _token: this.csrfToken,
                name: this.name,
                email: this.email,
                password: this.password,
                phone: this.phone,
                gender: this.gender,
                nik: this.nik,
                birthday: this.birthday,
                'password_confirmation': this.passwordConfirm,
                role: 'member'
            })
            .then((response) => {
                loader.hide();
                this.$swal({
                    title: "Pendaftaran",
                    text: response.data,
                    icon: response.status === 201 ? 'success' : 'error',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showCloseButton: false,
                    showCancelButton: false
                }).then((result) => {
                    window.location = '/mlogin'
                });
            })
            .catch(error => {
                loader.hide();
                if (error.response && error.response.status === 422) {
                    this.errors = error.response.data.errors || {};
                    return;
                }
                let err = error.response?.data?.message || error.response?.data || error.message;
                this.$swal({
                    title: "Pendaftaran",
                    text: err,
                    icon: 'error',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showCloseButton: false,
                    showCancelButton: false
                });
            });
        }
    }
};
</script>

<style scoped>
.member-register-page {
    padding: clamp(.5rem, 2vw, 1.5rem) 0 2rem;
}

.register-layout {
    max-width: 920px;
    margin: 0 auto;
}

.register-intro {
    padding: clamp(1.25rem, 4vw, 2rem) clamp(1.25rem, 4vw, 2rem) 1rem;
    border-top: 4px solid var(--member-accent, #236b58);
    background: var(--member-soft, #edf4ef);
}

.register-home-link {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    margin-bottom: 1.2rem;
    color: var(--member-accent, #236b58);
    font-size: .9rem;
    font-weight: 700;
    text-decoration: none;
}

.register-home-link:hover {
    color: var(--member-ink, #1d2b29);
    text-decoration: underline;
}

.register-home-link:focus-visible {
    border-radius: 3px;
    outline: 2px solid var(--member-accent, #236b58);
    outline-offset: 4px;
}

.register-intro .auth-title {
    margin-bottom: .35rem;
    font-size: clamp(1.9rem, 4vw, 2.6rem) !important;
}

.register-intro .auth-subtitle {
    margin: 0 !important;
}

.register-form {
    padding: clamp(1rem, 4vw, 2rem);
    background: var(--member-surface, #fff);
    border: 1px solid var(--member-line, #e4e8e2);
    border-top: 0;
}

.register-form > .row {
    --bs-gutter-x: 1.2rem;
    --bs-gutter-y: .2rem;
}

.register-form .form-group {
    margin-bottom: .75rem;
}

.register-form .form-group label {
    display: block;
    margin-bottom: .4rem;
    font-size: .88rem;
    font-weight: 700;
}

.register-form .form-control,
.register-form .form-select {
    min-height: 48px;
}

.register-form .form-control-icon {
    color: var(--member-muted, #64716c);
}

.email-note {
    padding: .65rem .8rem;
    border-left: 3px solid var(--member-accent, #236b58);
    background: var(--member-soft, #edf4ef);
    font-size: .85rem;
}

.register-form button[type="submit"] {
    min-width: 170px;
    min-height: 46px;
    box-shadow: none !important;
}

.register-form .col-12.d-flex {
    align-items: center;
}

@media (max-width: 575px) {
    .register-layout {
        margin-right: 0;
        margin-left: 0;
    }

    .register-form {
        padding: 1rem;
    }
}
</style>
