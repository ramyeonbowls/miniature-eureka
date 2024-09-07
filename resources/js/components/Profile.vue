<template>
    <action-bar :data="menu" :menu-label="menu.menu_label"></action-bar>

    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center flex-column">
                            <div class="avatar avatar-2xl">
                                <img src="./../assets/static/images/faces/2.jpg" alt="Avatar" />
                            </div>

                            <h3 class="mt-3">{{ user.name }}</h3>
                            <p class="text-small">{{ user.email }}</p>
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
                        <form action="#" method="get">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Nama Aplikasi</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Nama Aplikasi" />
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="form-label">Alamat</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Alamat" />
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="form-label">Kabupaten/Kota</label>
                                        <select name="name" id="name" class="choices form-select">
                                            <option value="square">Jakarta Pusat</option>
                                            <option value="rectangle">Jakarta Utara</option>
                                            <option value="rombo">Jakarta Selatan</option>
                                            <option value="romboid">Jakarta Timur</option>
                                            <option value="trapeze">Jakarta Barat Daya</option>
                                            <option value="traible">Jakarta Timur ke Barat</option>
                                            <option value="polygon">Jakarta Selatan ke Utara</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="form-label">NPWP</label>
                                        <input type="text" name="phone" id="phone" class="form-control" placeholder="NPWP" />
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="form-label">Nama Penanggung Jawab <small class="text-danger">*</small></label>
                                        <input type="text" name="phone" id="phone" class="form-control" placeholder="Nama Penanggung Jawab" />
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="form-label">Jabatan Penanggung Jawab <small class="text-danger">*</small></label>
                                        <input type="text" name="phone" id="phone" class="form-control" placeholder="Jabatan Penanggung Jawab" />
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="form-label">Nama Penandatangan MOU <small class="text-danger">*</small></label>
                                        <input type="text" name="phone" id="phone" class="form-control" placeholder="Nama Penandatangan MOU" />
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label for="phone" class="form-label">Jabatan Penandatangan MOU <small class="text-danger">*</small></label>
                                        <input type="text" name="phone" id="phone" class="form-control" placeholder="Jabatan Penandatangan MOU" />
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="form-label">Nama Pengelola (Admin) <small class="text-danger">*</small></label>
                                        <input type="text" name="phone" id="phone" class="form-control" placeholder="Nama Pengelola" />
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="form-label">Nomor HP/WA (Admin) <small class="text-danger">*</small></label>
                                        <input type="text" name="phone" id="phone" class="form-control" placeholder="Nomor HP/WA" />
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="form-label">E-Mail Pengelola (Admin) </label>
                                        <input type="text" name="email" id="email" class="form-control" placeholder="E-Mail Pengelola" />
                                    </div>
                                    <div class="form-group">
                                        <label for="gender" class="form-label">Aktifkan Fitur Daftar Member</label>
                                        <select name="gender" id="gender" class="form-control">
                                            <option value="">--</option>
                                            <option value="Y">Ya</option>
                                            <option value="N">Tidak</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="gender" class="form-label">Metode Konfirmasi Pendaftaraan User </label>
                                        <select name="gender" id="gender" class="form-control">
                                            <option value="1">Auto</option>
                                            <option value="2">Manual</option>
                                            <option value="3">Verifiaksi Email</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="form-label">Password </label>
                                        <input type="password" name="email" id="email" class="form-control" placeholder="Password" />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12">
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
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Upload</h5>
                    </div>
                    <div class="card-body">
                        <form action="#" method="get">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Logo</label>
                                        <input type="file" class="basic-filepond1" />
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Header</label>
                                        <input type="file" class="basic-filepond2" />
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Banner Desktop</label>
                                        <input type="file" class="basic-filepond3" />
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Banner Mobile</label>
                                        <input type="file" class="basic-filepond4" />
                                    </div>
                                </div>
                                <div class="col-md-12 mb-4">
                                    <div class="form-group my-2 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
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
import { Form as VeeForm, Field, ErrorMessage } from 'vee-validate'
import Choices from 'choices.js'
import 'choices.js/public/assets/styles/choices.min.css'
import * as FilePond from 'filepond'
import 'filepond/dist/filepond.min.css'

export default {
    components: {
        VeeForm,
        Field,
        ErrorMessage,
    },

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
        }
    },

    mounted() {
        this.__MENU()
        this.userinfo()

        let choices = document.querySelectorAll('.choices')
        let initChoice
        for (let i = 0; i < choices.length; i++) {
            if (choices[i].classList.contains('multiple-remove')) {
                initChoice = new Choices(choices[i], {
                    delimiter: ',',
                    editItems: true,
                    maxItemCount: -1,
                    removeItemButton: true,
                })
            } else {
                initChoice = new Choices(choices[i])
            }
        }

        FilePond.create(document.querySelector('.basic-filepond1'), {
            credits: null,
            allowImagePreview: false,
            allowMultiple: false,
            allowFileEncode: false,
            required: false,
            storeAsFile: true,
        })
        FilePond.create(document.querySelector('.basic-filepond2'), {
            credits: null,
            allowImagePreview: false,
            allowMultiple: false,
            allowFileEncode: false,
            required: false,
            storeAsFile: true,
        })
        FilePond.create(document.querySelector('.basic-filepond3'), {
            credits: null,
            allowImagePreview: false,
            allowMultiple: false,
            allowFileEncode: false,
            required: false,
            storeAsFile: true,
        })
        FilePond.create(document.querySelector('.basic-filepond4'), {
            credits: null,
            allowImagePreview: false,
            allowMultiple: false,
            allowFileEncode: false,
            required: false,
            storeAsFile: true,
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
}
</script>
