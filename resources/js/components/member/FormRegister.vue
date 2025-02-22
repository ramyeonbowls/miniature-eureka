<template>
    <div class="page-heading">
        <div class="row">
            <h1 style="color: #1995ad;" class="auth-title">Daftar Member</h1>
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
                                <input type="text" id="phoneNumberInput" class="form-control form-control-md" placeholder="No. Handphone" maxlength="15" required v-model="phone" @input="filterInput($event, 'phone')" />
                                <div class="form-control-icon">
                                    <i class="bi bi-phone"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="jenis-kelamin-floating">Jenis Kelamin</label>
                            <select class="form-select" id="gender" v-model="gender" required>
                                <option value="">--</option>
                                <option value="L">Laki - Laki</option>
                                <option value="P">Perempuan</option>
                            </select>
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
                let err = (error.response.data.message ? error.response.data.message : (error.response.data) ? error.response.data : error.message);
                loader.hide();
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
