<template>
    <action-bar :data="menu" :menu-label="menu.menu_label"></action-bar>

    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Profil Guru</h5>
                    </div>
                    <div class="card-body">
                        <form class="form" @submit.prevent="handleUpdateProfile">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
										<label for="name-column">Nama Lengkap</label>
										<div class="form-group position-relative has-icon-left mb-4">
											<input type="text" class="form-control form-control-md" placeholder="Nama Lengkap" v-model="form.field.name" required disabled>
											<div class="form-control-icon">
												<i class="bi bi-person"></i>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="no-hp-column">No. HP</label>
										<div class="form-group position-relative has-icon-left mb-4">
											<input type="text" id="phoneNumberInput" class="form-control form-control-md" placeholder="No. Handphone" maxlength="15" required  disabled v-model="form.field.phone" @input="filterInput($event, 'phone')" />
											<div class="form-control-icon">
												<i class="bi bi-phone"></i>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="tanggal-lahir">Tanggal Lahir</label>
										<div class="form-group position-relative has-icon-left mb-4">
											<Flatpickr v-model="form.field.birthday" class="form-control flatpickr-range" :config="configdate" placeholder="Select date.." required disabled></Flatpickr>
											<div class="form-control-icon">
												<i class="bi bi-calendar3"></i>
											</div>
											<span v-if="errors.isBirthdayValid" class="text-danger">{{ errors.isBirthdayValid[0] }}</span>
										</div>
									</div>
                                    <div class="form-group">
                                        <label for="password-column">Kata Sandi</label>
                                        <div class="form-group position-relative has-icon-left mb-4">
                                            <input type="password" class="form-control form-control-md" :class="{'is-invalid': errors.password}" placeholder="Kata Sandi" v-model="form.field.password"/>
                                            <div class="form-control-icon">
                                                <i class="bi bi-shield-lock"></i>
                                            </div>
                                            <p class="text-subtitle text-muted">Isi jika ingin ubah kata sandi</p>
                                            <div v-if="errors.password" class="invalid-feedback">{{ errors.password[0] }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
									<div class="form-group">
										<label for="email-column">Email</label>
										<div class="form-group position-relative has-icon-left mb-4">
											<input type="text" class="form-control form-control-md" :class="{'is-invalid': errors.email}" placeholder="Email" v-model="form.field.email" required  disabled/>
											<div class="form-control-icon">
												<i class="bi bi-envelope"></i>
											</div>
											<div v-if="errors.email" class="invalid-feedback">{{ errors.email[0] }}</div>
										</div>
									</div>
									<div class="form-group mb-4">
										<label for="jenis-kelamin-floating">Jenis Kelamin</label>
										<select class="form-select" id="gender" v-model="form.field.gender" required disabled>
											<option value="">--</option>
											<option value="L">Laki - Laki</option>
											<option value="P">Perempuan</option>
										</select>
									</div>
									<div class="form-group">
										<label for="nik">NIP</label>
										<div class="form-group position-relative has-icon-left mb-4">
											<input type="text" id="nikInput" class="form-control form-control-md" placeholder="Nomor Induk Kependudukan" maxlength="20" v-model="form.field.nik" @input="filterInput($event, 'nik')"  disabled/>
											<div class="form-control-icon">
												<i class="bi bi-credit-card"></i>
											</div>
										</div>
									</div>
                                    <div class="form-group">
                                        <label for="password-confirm-column">Ulangi Kata Sandi</label>
                                        <div class="form-group position-relative has-icon-left mb-4">
                                            <input type="password" class="form-control form-control-md" :class="{'is-invalid': errors.passwordConfirm}" placeholder="Ulangi Kata Sandi" v-model="form.field.passwordConfirm"/>
                                            <div class="form-control-icon">
                                                <i class="bi bi-shield-lock"></i>
                                            </div>
                                            <div v-if="errors.passwordConfirm" class="invalid-feedback">{{ errors.passwordConfirm[0] }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="form-group my-2 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</template>

<script>

export default {
    data() {
        return {
            menu: {
                menu_label: 'Profil',
                menu_desc: 'Profil Guru',
                permission: {
                    create: false,
                    read: false,
                    update: false,
                    delete: false,
                    print: false,
                    approve: false,
                },
            },

            user: {},
            form:{
                field:{
                    name: '',
					email: '',
					password: '',
					passwordConfirm: '',
					phone: '',
					gender: '',
					birthday: '',
					nik: '',
					avatar: ''
                }
            },
            errors: {},

			configdate: {
                dateFormat: 'Y-m-d',
                mode: 'range',
            },
        }
    },

    mounted() {
        // this.__MENU()
        this.userinfo()
        this.getProfile()
    },

    methods: {
        __MENU() {
            let loader = this.$loading.show()
            window.axios
                .get('/web-access-log/' + this.$route.name)
                .then((response) => {
                    loader.hide()

                    this.menu.menu_label = response.data.menu_label
                    this.menu.menu_desc = response.data.menu_desc
                    this.menu.permission = response.data.permission
                })
                .catch((e) => {
                    loader.hide()

                    console.error(e)
                })
        },

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

        getProfile() {
            let loader = this.$loading.show();
            window.axios
                .get('/setting/profile-teacher')
                .then((response) => {
                    loader.hide();
                    this.form.field.info 		= response.data
					this.form.field.name		= response.data.name
					this.form.field.email		= response.data.email
					this.form.field.phone		= response.data.phone
					this.form.field.gender		= response.data.gender
					this.form.field.birthday	= response.data.birthday
					this.form.field.nik			= response.data.nik
                })
                .catch((e) => {
                    loader.hide();
                    console.error(e)
                })
        },

        async handleUpdateProfile() {
            if(this.form.field.password!=''){
                if (this.form.field.password !== this.form.field.passwordConfirm) {
                    this.errors.passwordConfirm = ['Kata sandi tidak sesuai!'];
                    return;
                }
            }

			if(this.form.field.password!=''){
				let loader = this.$loading.show();
				await axios.post('/setting/profile-teacher', this.form.field)
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
			}
        }
    },

    computed: {
        cPermitted() {
            return this.menu.permission.create
        },

        rPermitted() {
            return this.menu.permission.read
        },

        uPermitted() {
            return this.menu.permission.update
        },

        dPermitted() {
            return this.menu.permission.delete
        },

        pPermitted() {
            return this.menu.permission.print
        },

        aPermitted() {
            return this.menu.permission.approve
        },
    },

    watch: {
        'form.field.password'(newValue, oldValue) {
            if (this.errors.password) {
                this.errors.password = null;
            }
            if (newValue !== this.form.field.passwordConfirm) {
                this.errors.passwordConfirm = ['Kata sandi tidak sesuai!'];
            } else {
                this.errors.passwordConfirm = null;
            }
        },
        'form.field.passwordConfirm'(newValue, oldValue) {
            if (this.errors.passwordConfirm) {
                this.errors.passwordConfirm = null;
            }
            if (newValue !== this.form.field.password) {
                this.errors.passwordConfirm = ['Kata sandi tidak sesuai!'];
            } else {
                this.errors.passwordConfirm = null;
            }
        }
    }
}
</script>

<style scoped>
.qr-code-body {
    display: flex;
    justify-content: center;
    align-items: center;
}

.container-offline {
    width: 450px;
    height: 550px;
    background-color: #fff;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
    position: relative;
}

.qr-code {
    width: 200px;
    height: 200px;
    background-color: #fff;
    border-radius: 10px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.texth {
    position: absolute;
    top: 20%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: #fff;
    font-size: 20px;
    font-weight: bold;
    width: calc(100% - 20px);
    text-align: center;
    padding: 0 10px;
    word-wrap: break-word;
}

.textb {
    position: absolute;
    bottom: 10%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: #ffc107;
    font-size: 20px;
    font-weight: bold;
    width: calc(100% - 20px);
    text-align: center;
    padding: 0 10px;
    word-wrap: break-word;
}

.container-offline::before {
    content: "";
    position: absolute;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 50%;
    background-color: #ffc107;
    clip-path: polygon(0 0, 100% 0, 100% 50%, 0 100%);
}
</style>
