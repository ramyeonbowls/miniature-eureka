<template>
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Profil Saya</h3>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-center align-items-center flex-column">
                                <div id="AvatarFileUpload">
                                    <div class="selected-image-holder">
                                        <img :src="user.avatar + '?'+ Math.floor(Math.random() * (999 - 100 + 1)) + 100">
                                    </div>

                                    <div class="avatar-selector">
                                        <a href="#" class="avatar-selector-btn">
                                            <i class="bi bi-camera-fill"></i>
                                        </a>
                                        <input type="file" accept=".jpg" name="avatar">
                                    </div>
                                </div>
                                <h3 class="mt-3">{{ user.name }}</h3>
                                <button  v-if="!user.verified" class="btn btn-primary" @click="SendVerification">Kirim Email Verifikasi</button>
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
                                                <input type="text" class="form-control form-control-md" :class="{'is-invalid': errors.email}" placeholder="Email" v-model="user.email" required :readonly="user.verified"/>
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
                nik: '',
                avatar: ''
            },
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
        this.getProfile();
        this.uploadImage();
        this.initializeSubMenu();
    },

    methods: {
        async SendVerification(){
            let loader = this.$loading.show();
            try {
                const response = await window.axios.post('/email/resend');
                this.$swal({
                    title: 'Email Terkirim!',
                    text: response.data.message,
                    icon: 'success'
                });
                loader.hide();
            } catch (error) {
                loader.hide();
                this.$swal({
                    title: 'Gagal!',
                    text: error.response.data.message || 'Terjadi kesalahan saat mengirim email.',
                    icon: 'error'
                });
            }
        },

        async handleUpdateProfile() {
            if(this.user.password!=''){
                if (this.user.password !== this.user.passwordConfirm) {
                    this.errors.passwordConfirm = ['Kata sandi tidak sesuai!'];
                    return;
                }
            }
            
            if (this.user.birthday == '') {
                this.errors.isBirthdayValid = ['Pilih Tanggal Lahir'];
                return;
            }

            let form_data = new FormData();
            Object.keys(this.user).forEach(value => {
                form_data.append(value, this.user[value]);
            });

            if (this.user.avatar) {
                form_data.append('avatar', this.user.avatar);
            }

            let loader = this.$loading.show();
            await axios.post('/UpdateProfile', form_data)
            .then((response) => {
                loader.hide();
                this.$swal({
                    title: "Update Profile",
                    text: response.data,
                    icon: response.status === 201 ? 'success' : 'error',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showCloseButton: false,
                    showCancelButton: false
                }).then((result) => {
                    location.reload();
                });
            })
            .catch(error => {
                loader.hide();
                if (error.response && error.response.status === 400) {
                    this.errors = error.response.data.errors;
                    let errorMessages = '';

                    for (let key in this.errors) {
                        if (this.errors.hasOwnProperty(key)) {
                            errorMessages += `${this.errors[key][0]}\n`;
                        }
                    }

                    this.$swal({
                        icon: 'error',
                        title: 'Kesalahan',
                        text: errorMessages,
                    });
                } else {
                    this.$swal({
                        icon: 'error',
                        title: 'Kesalahan',
                        text: 'Terjadi kesalahan, silakan coba lagi nanti.',
                    });
                }
            });
        },

        getProfile() {
            this.user = {
                name: '',
                email: '',
                password: '',
                passwordConfirm: '',
                phone: '',
                gender: '',
                birthday: '',
                nik: '',
                avatar: ''
            };

            let loader = this.$loading.show();
            axios.get('/getProfile')
            .then((response) => {
                this.user = response.data;
                this.user.password = '';
                this.user.passwordConfirm = '';
                loader.hide();
            })
            .catch((e) => {
                loader.hide();
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

        uploadImage(){
            const avatarFileUpload = document.getElementById('AvatarFileUpload')
            const imageViewer = avatarFileUpload.querySelector('.selected-image-holder>img')
            const imageSelector = avatarFileUpload.querySelector('.avatar-selector-btn')
            const imageInput = avatarFileUpload.querySelector('input[name="avatar"]')

            imageSelector.addEventListener('click', e => {
                e.preventDefault()
                imageInput.click()
            })

            imageInput.addEventListener('change', e => {
                const file = e.target.files[0];

                if (file.type !== 'image/jpeg') {
                    this.$swal({
                        icon: 'error',
                        title: 'File Tidak Valid',
                        text: 'Hanya file JPG yang diperbolehkan.',
                    });
                    e.target.value = '';
                    return;
                }

                if (file.size > 1048576) {
                    this.$swal({
                        title: 'Gagal!',
                        text: 'Ukuran file tidak boleh lebih dari 1MB.',
                        icon: 'error'
                    });

                    e.target.value = '';
                    return;
                }

                var reader = new FileReader();
                reader.onload = function(){
                    imageViewer.src = reader.result;
                };

                this.user.avatar = file;
                reader.readAsDataURL(file);
            });
        },

        initializeSubMenu() {
            let submenus = document.querySelectorAll('.submenu-item')
    
            submenus.forEach((submenu) => {
                submenu.querySelector('.submenu-link').addEventListener('click', (e) => {
                    let navbar = document.querySelector('.main-navbar');
                    if (navbar.classList.contains('active')) {
                        navbar.classList.remove('active');
                    }
                    e.preventDefault()
                })
            })
        }
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
<style>
div#AvatarFileUpload {
    position: relative;
    width: 150px;
    height: 150px;
    background: #f9f9f9;
    border: 3px solid #bbb;
    border-radius: 50% 50%;
    margin: auto;
}
/* Image Preview Wrapper and Container */
div#AvatarFileUpload > .selected-image-holder{
    width: 100%;
    height: 100%;
    border-radius: 50% 50%;
 
}
div#AvatarFileUpload > .selected-image-holder{
    width: 100%;
    overflow: hidden;
}
div#AvatarFileUpload > .selected-image-holder>img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-fit: center center;
}
 
/* Image Selector to Browse Image to Upload */
div#AvatarFileUpload > .avatar-selector{
    position: absolute;
    bottom: 8px;
    right: 19%;
    width: 20px;
    height: 20px;
}
div#AvatarFileUpload > .avatar-selector input[type="file"]{
    display: none;
}
div#AvatarFileUpload > .avatar-selector > .avatar-selector-btn{
    width: 100%;
    height: 100%;
    background: #f5f5f59e;
    padding: 5px 7px;
    border-radius: 50% 50%;
}
div#AvatarFileUpload > .avatar-selector > .avatar-selector-btn>img{
    width: 100%;
    height: 100%;
    object-fit: scale-down;
    object-position: center center;
    z-index: 2;
}
</style>