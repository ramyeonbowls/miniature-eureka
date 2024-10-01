<template>
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Account Profile</h3>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-center align-items-center flex-column">
                                <div class="avatar avatar-2xl">
                                    <img src="/images/faces/2.jpg" alt="Avatar">
                                </div>
                                <h3 class="mt-3">{{ user.name }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <form class="form" @submit.prevent="handleUpdateProfile">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="name-column">Nama Lengkap</label>
                                            <div class="form-group position-relative has-icon-left mb-4">
                                                <input type="text" class="form-control form-control-md" placeholder="Nama Lengkap" v-model="user.name" required/>
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
                                                <input type="text" class="form-control form-control-md" :class="{'is-invalid': errors.email}" placeholder="Email" v-model="user.email" required readonly/>
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
                                                <input type="text" id="phoneNumberInput" class="form-control form-control-md" placeholder="No. Handphone" maxlength="15" required v-model="user.phone" @input="filterInput($event, 'phone')" />
                                                <div class="form-control-icon">
                                                    <i class="bi bi-phone"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="jenis-kelamin-floating">Jenis Kelamin</label>
                                            <select class="form-select" id="gender" v-model="user.gender" required>
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
                                                <Flatpickr v-model="user.birthday" class="form-control flatpickr-range" :config="configdate" placeholder="Select date.." required></Flatpickr>
                                                <div class="form-control-icon">
                                                    <i class="bi bi-calendar3"></i>
                                                </div>
                                                <span v-if="errors.isBirthdayValid" class="text-danger">{{ errors.isBirthdayValid[0] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="nik">NIK</label>
                                            <div class="form-group position-relative has-icon-left mb-4">
                                                <input type="text" id="nikInput" class="form-control form-control-md" placeholder="Nomor Induk Kependudukan" maxlength="20" v-model="user.nik" @input="filterInput($event, 'nik')" />
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
                                                <input type="password" class="form-control form-control-md" :class="{'is-invalid': errors.password}" placeholder="Kata Sandi" v-model="user.password"/>
                                                <div class="form-control-icon">
                                                    <i class="bi bi-shield-lock"></i>
                                                </div>
                                                <p class="text-subtitle text-muted">Isi jika ingin ubah password</p>
                                                <div v-if="errors.password" class="invalid-feedback">{{ errors.password[0] }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="password-confirm-column">Ulangi Kata Sandi</label>
                                            <div class="form-group position-relative has-icon-left mb-4">
                                                <input type="password" class="form-control form-control-md" :class="{'is-invalid': errors.passwordConfirm}" placeholder="Ulangi Kata Sandi" v-model="user.passwordConfirm"/>
                                                <div class="form-control-icon">
                                                    <i class="bi bi-shield-lock"></i>
                                                </div>
                                                <div v-if="errors.passwordConfirm" class="invalid-feedback">{{ errors.passwordConfirm[0] }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </div>  
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>

export default {
    props: {
        isAuthenticated: {
            type: Boolean,
            required: true
        }
    },

    data() {
        return {
            user: {
                name: '',
                email: '',
                password: '',
                passwordConfirm: '',
                phone: '',
                gender: '',
                birthday: '',
                nik: ''
            },
            errors: {},
            csrfToken: '',
            configdate: {
                dateFormat: 'j F Y',
            },
        };
    },

    mounted() {
        this.csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
        this.getProfile();
    },

    methods: {
        getProfile() {
            this.user = {
                name: '',
                email: '',
                password: '',
                passwordConfirm: '',
                phone: '',
                gender: '',
                birthday: '',
                nik: ''
            };

            axios.get('/getProfile')
            .then((response) => {
                this.user = response.data;
            })
            .catch((e) => {
                console.error(e)
            });
        },

        filterInput(event, param) {
            if(param=='nik'){
                this.user.nik = event.target.value.replace(/\D/g, '');
            }else if(param=='phone'){
                this.user.phone = event.target.value.replace(/\D/g, '');
            }
        },
    },

    watch: {
        'user.password'(newValue, oldValue) {
            if (this.errors.password) {
                this.errors.password = null;
            }
            if (newValue !== this.user.passwordConfirm) {
                this.errors.passwordConfirm = ['Kata sandi tidak sesuai!'];
            } else {
                this.errors.passwordConfirm = null;
            }
        },
        'user.passwordConfirm'(newValue, oldValue) {
            if (this.errors.passwordConfirm) {
                this.errors.passwordConfirm = null;
            }
            if (newValue !== this.user.password) {
                this.errors.passwordConfirm = ['Kata sandi tidak sesuai!'];
            } else {
                this.errors.passwordConfirm = null;
            }
        }
    }
};
</script>