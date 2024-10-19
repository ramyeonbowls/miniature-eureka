<template>
    <action-bar :data="menu" :menu-label="menu.menu_label"></action-bar>

    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center flex-column">
                            <div class="avatar avatar-2xl">
                                <img src="/images/logo/logo_small.png" />
                            </div>

                            <h3 class="mt-3">{{ user.name }}</h3>
                            <p class="text-small">{{ user.email }}</p>

                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#BarcodeModal">
                                QR Code Pengunjung Offline
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Logo</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="name" class="form-label">Logo</label>
                                <br><img :src="form.field.logo.big" height="100px" v-if="form.field.logo.small" />
                                <div class="form-group mt-2">
                                    <input type="file" class="logo-big" />
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="name" class="form-label">Logo Small</label>
                                <br><img :src="form.field.logo.small" height="100px" v-if="form.field.logo.small" />
                                <div class="form-group mt-2">
                                    <input type="file" class="logo-small" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Profile Admin</h5>
                    </div>
                    <div class="card-body">
                        <form class="form" @submit.prevent="handleUpdateProfile">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Nama Aplikasi</label>
                                        <input type="text" name="name" id="name" class="form-control" v-model="form.field.info.application_name" placeholder="Nama Aplikasi" />
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="form-label">Kabupaten/Kota</label>
                                        <input type="text" name="name" id="name" class="form-control" v-model="form.field.info.kabupaten_name" placeholder="Kabupaten/Kota" readonly/>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="form-label">Nama Penandatangan MOU <small class="text-danger">*</small></label>
                                        <input type="text" name="phone" id="phone" class="form-control" v-model="form.field.info.mou_sign_name" placeholder="Nama Penandatangan MOU" readonly/>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="form-label">Nama Penanggung Jawab <small class="text-danger">*</small></label>
                                        <input type="text" name="phone" id="phone" class="form-control" v-model="form.field.info.pers_responsible" placeholder="Nama Penanggung Jawab" readonly/>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="form-label">Nama Pengelola (Admin) <small class="text-danger">*</small></label>
                                        <input type="text" name="phone" id="phone" class="form-control" v-model="form.field.info.administrator_name" placeholder="Nama Pengelola" />
                                    </div>
                                    <!-- <div class="form-group">
                                        <label for="email" class="form-label">E-Mail Pengelola (Admin) </label>
                                        <input type="text" name="email" id="email" class="form-control" v-model="user.email" placeholder="E-Mail Pengelola" readonly/>
                                    </div> -->
                                    <div class="form-group">
                                        <label for="password-column">Kata Sandi</label>
                                        <div class="form-group position-relative has-icon-left mb-4">
                                            <input type="password" class="form-control form-control-md" :class="{'is-invalid': errors.password}" placeholder="Kata Sandi" v-model="form.field.info.password"/>
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
                                        <label for="name" class="form-label">Alamat</label>
                                        <input type="text" name="name" id="name" class="form-control" v-model="form.field.info.address" placeholder="Alamat" />
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="form-label">NPWP</label>
                                        <input type="text" name="phone" id="phone" class="form-control" v-model="form.field.info.npwp" placeholder="NPWP" />
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="form-label">Jabatan Penandatangan MOU <small class="text-danger">*</small></label>
                                        <input type="text" name="phone" id="phone" class="form-control" v-model="form.field.info.pos_sign_name" placeholder="Jabatan Penandatangan MOU" readonly/>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="form-label">Jabatan Penanggung Jawab <small class="text-danger">*</small></label>
                                        <input type="text" name="phone" id="phone" class="form-control" v-model="form.field.info.kabupaten_name" placeholder="Jabatan Penanggung Jawab" readonly/>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="form-label">Nomor HP/WA (Admin) <small class="text-danger">*</small></label>
                                        <input type="text" name="phone" id="phone" class="form-control" v-model="form.field.info.administrator_phone" placeholder="Nomor HP/WA" />
                                    </div>
                                    <div class="form-group">
                                        <label for="password-confirm-column">Ulangi Kata Sandi</label>
                                        <div class="form-group position-relative has-icon-left mb-4">
                                            <input type="password" class="form-control form-control-md" :class="{'is-invalid': errors.passwordConfirm}" placeholder="Ulangi Kata Sandi" v-model="form.field.info.passwordConfirm"/>
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
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Konfirmasi</h5>
                    </div>
                    <div class="card-body">
                        <form action="#" method="get">
                            <div class="col-md-12 mb-4">
                                <div class="form-check">
                                    <div class="checkbox">
                                        <input type="checkbox" id="iaggree" class="form-check-input" />
                                        <label class="text-danger" for="iaggree">Konfirmasi Persutujuan</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="form-group mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label">Deskripsi Tentang WL</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Jumlah Maksimal Buku dipinjam</label>
                                        <input type="number" name="name" id="name" class="form-control" placeholder="1" />
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Jumlah Maksimal Hari Pinjam Buku</label>
                                        <input type="number" name="name" id="name" class="form-control" placeholder="1" />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div> -->
        </div>
    </section>

    <!-- Modal for QRcode Preview -->
    <div class="modal fade text-left" id="BarcodeModal" tabindex="-1" role="dialog" aria-labelledby="BarcodeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-full" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel20">Barcode</h4>
                </div>
                <div class="modal-body" id="modalBodyContent">
                    <div class="qr-code-body">
                        <div class="container-offline">
                            <div class="qr-code">
                                <img src="/images/logo/qrcode_offline.png" style="max-width: 200px; max-height: 200px;"/>
                            </div>
                            <div class="texth">
                                {{ form.field.info.application_name }}
                            </div>
                            <div class="textb">
                                QR Code Pengunjung Offline
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary ms-1" @click="printModalContent()">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Print</span>
                    </button>
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for QRcode Preview -->

    <div id="printableArea" style="display: none;">
        <div id="printableContent"></div>
    </div>
</template>

<script>
import * as FilePond from 'filepond'
import 'filepond/dist/filepond.min.css'
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css';
import FilePondPluginImageValidateSize from 'filepond-plugin-image-validate-size';

FilePond.registerPlugin(FilePondPluginFileValidateType);
FilePond.registerPlugin(FilePondPluginImagePreview);
FilePond.registerPlugin(FilePondPluginImageValidateSize);

export default {
    data() {
        return {
            menu: {
                menu_label: 'Profile',
                menu_desc: 'Profile Admin',
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
                    logo:{
                        small: '/images/logo/logo_small.png',
                        big: '/images/logo/logo.png',
                        newsmall: '',
                        newbig: ''
                    },
                    info: {}
                }
            },
            errors: {}
        }
    },

    mounted() {
        // this.__MENU()
        this.userinfo()
        this.getProfile()

        const pondBig = FilePond.create(document.querySelector('.logo-big'), {
            credits: null,
            allowImagePreview: true,
            allowMultiple: false,
            allowFileEncode: false,
            required: false,
            storeAsFile: true,
            acceptedFileTypes: ['image/png'],
            allowImageValidateSize: true,
            imageValidateSizeMaxWidth: 1500,
            imageValidateSizeMaxHeight: 510,
            onerror: (error) => {
                pondBig.removeFiles();

                this.$swal({
                    icon: 'error',
                    title: 'Invalid Image',
                    text: 'The image exceeds the maximum dimensions of 1500x510 pixels.'
                });
            },
            onupdatefiles: (fileItems) => {
                if (fileItems.length > 0) {
                    this.form.field.logo.newbig = fileItems[0].file; // Assign the valid file
                }
            }
        })

        const pondSmall = FilePond.create(document.querySelector('.logo-small'), {
            credits: null,
            allowImagePreview: true,
            allowMultiple: false,
            allowFileEncode: false,
            required: false,
            storeAsFile: true,
            acceptedFileTypes: ['image/png'],
            allowImageValidateSize: true,
            imageValidateSizeMaxWidth: 510,
            imageValidateSizeMaxHeight: 510,
            onerror: (error) => {
                pondSmall.removeFiles();

                this.$swal({
                    icon: 'error',
                    title: 'Invalid Image',
                    text: 'The image exceeds the maximum dimensions of 510x510 pixels.'
                });
            },
            onupdatefiles: (fileItems) => {
                if (fileItems.length > 0) {
                    this.form.field.logo.newsmall = fileItems[0].file;
                }
            }
        })
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
                .get('/setting/profile')
                .then((response) => {
                    loader.hide();
                    this.form.field.info = response.data
                })
                .catch((e) => {
                    loader.hide();
                    console.error(e)
                })
        },

        async handleUpdateProfile() {
            if(this.form.field.info.password!=''){
                if (this.form.field.info.password !== this.form.field.info.passwordConfirm) {
                    this.errors.passwordConfirm = ['Kata sandi tidak sesuai!'];
                    return;
                }
            }

            let form_data = new FormData();
            Object.keys(this.form.field.info).forEach(value => {
                form_data.append(value, this.form.field.info[value]);
            });

            if (this.form.field.logo.newsmall) {
                form_data.append('logo_small', this.form.field.logo.newsmall);
            }
            if (this.form.field.logo.newbig) {
                form_data.append('logo', this.form.field.logo.newbig);
            }

            let loader = this.$loading.show();
            await axios.post('/setting/profile', form_data)
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

        printModalContent() {
            var modalBody = document.getElementById("modalBodyContent").innerHTML;
            document.getElementById("printableContent").innerHTML = modalBody;

            var printWindow = window.open('', '', 'height=600,width=800');
            printWindow.document.write('<html><head>');

            printWindow.document.write(`
                <style>
                    @media print {
                        body {
                            -webkit-print-color-adjust: exact !important;
                            print-color-adjust: exact !important;
                        }

                        @page {
                            margin: 0;
                        }

                        .qr-code-body {
                            display: flex;
                            justify-content: center;
                            align-items: center;
                        }

                        .container-offline {
                            width: 350px;
                            height: 400px;
                            background-color: #fff;
                            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
                            position: relative;
                        }

                        .qr-code {
                            width: 200px;
                            height: 200px;
                            background-color: #000;
                            border-radius: 10px;
                            position: absolute;
                            top: 50%;
                            left: 50%;
                            transform: translate(-50%, -50%);
                        }

                        .texth {
                            position: absolute;
                            top: 10%;
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
                    }
                </style>
            `);
            printWindow.document.write('</head><body>');
            printWindow.document.write(document.getElementById("printableContent").innerHTML);
            printWindow.document.write('</body></html>');

            printWindow.document.close();

            printWindow.onload = function() {
                printWindow.print();
                printWindow.close();
            };
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
        'form.field.info.password'(newValue, oldValue) {
            if (this.errors.password) {
                this.errors.password = null;
            }
            if (newValue !== this.form.field.info.passwordConfirm) {
                this.errors.passwordConfirm = ['Kata sandi tidak sesuai!'];
            } else {
                this.errors.passwordConfirm = null;
            }
        },
        'form.field.info.passwordConfirm'(newValue, oldValue) {
            if (this.errors.passwordConfirm) {
                this.errors.passwordConfirm = null;
            }
            if (newValue !== this.form.field.info.password) {
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
    width: 350px;
    height: 400px;
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
    top: 10%;
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
