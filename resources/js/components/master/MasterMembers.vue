<template>
    <action-bar :data="menu" :menu-label="menu.menu_label"></action-bar>

    <section class="section">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="buttons">
                            <template v-if="!form.new && !form.edit">
                                <a href="#" class="btn icon icon-left btn-primary" @click="create"><i class="bi bi-check-square-fill"></i> New</a>
                                <a href="#" class="btn icon icon-left btn-success" @click="edit"><i class="bi bi-pencil-square"></i> Edit</a>
                                <a href="#" class="btn icon icon-left btn-danger" @click="destroy"><i class="bi bi-x-square-fill"></i> Delete</a>
                            </template>
                            <template v-else>
                                <a href="#" class="btn icon icon-left btn-success" @click.prevent="submit"><i class="bi bi-check-square-fill"></i> Submit</a>
                                <a href="#" class="btn icon icon-left btn-danger" @click="cancel"><i class="bi bi-x-square-fill"></i> Cancel</a>
                            </template>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" :class="form.new || form.edit ? 'disabled' : 'active'" id="data-tab" data-bs-toggle="tab" href="javascript:void(0);" role="tab" aria-controls="data" aria-selected="true">Data</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" :class="!form.new && !form.edit ? 'disabled' : 'active'" id="form-tab" data-bs-toggle="tab" href="javascript:void(0);" role="tab" aria-controls="form" aria-selected="false">Form</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade" :class="!form.new && !form.edit ? 'show active' : ''" id="data" role="tabpanel" aria-labelledby="data-tab">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table1">
                                        <thead>
                                            <tr>
                                                <th>NIK</th>
                                                <th>Foto</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>No. HP</th>
                                                <th>Tgl Lahir</th>
                                                <th>Status</th>
                                                <th>Waktu Daftar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1234567890</td>
                                                <td><img src="https://via.placeholder.com/50x80" alt="Foto 1" /></td>
                                                <td>Ahmad Kusuma</td>
                                                <td>ahmad@example.com</td>
                                                <td>08123456789</td>
                                                <td>1990-04-12</td>
                                                <td><span class="badge bg-success">Verifikasi</span></td>
                                                <td>2024-09-07 14:30</td>
                                            </tr>
                                            <tr>
                                                <td>1234567891</td>
                                                <td><img src="https://via.placeholder.com/50x80" alt="Foto 2" /></td>
                                                <td>Budi Santoso</td>
                                                <td>budi@example.com</td>
                                                <td>08123456780</td>
                                                <td>1985-08-22</td>
                                                <td><span class="badge bg-danger">Belum Verifikasi</span></td>
                                                <td>2024-09-06 10:15</td>
                                            </tr>
                                            <tr>
                                                <td>1234567892</td>
                                                <td><img src="https://via.placeholder.com/50x80" alt="Foto 3" /></td>
                                                <td>Citra Melati</td>
                                                <td>citra@example.com</td>
                                                <td>08123456781</td>
                                                <td>1992-11-19</td>
                                                <td><span class="badge bg-success">Verifikasi</span></td>
                                                <td>2024-09-05 16:20</td>
                                            </tr>
                                            <tr>
                                                <td>1234567893</td>
                                                <td><img src="https://via.placeholder.com/50x80" alt="Foto 4" /></td>
                                                <td>Dedi Supriadi</td>
                                                <td>dedi@example.com</td>
                                                <td>08123456782</td>
                                                <td>1988-07-14</td>
                                                <td><span class="badge bg-danger">Belum Verifikasi</span></td>
                                                <td>2024-09-04 09:45</td>
                                            </tr>
                                            <tr>
                                                <td>1234567894</td>
                                                <td><img src="https://via.placeholder.com/50x80" alt="Foto 5" /></td>
                                                <td>Eka Wijaya</td>
                                                <td>eka@example.com</td>
                                                <td>08123456783</td>
                                                <td>1995-03-28</td>
                                                <td><span class="badge bg-success">Verifikasi</span></td>
                                                <td>2024-09-03 11:30</td>
                                            </tr>
                                            <tr>
                                                <td>1234567895</td>
                                                <td><img src="https://via.placeholder.com/50x80" alt="Foto 6" /></td>
                                                <td>Farhan Saputra</td>
                                                <td>farhan@example.com</td>
                                                <td>08123456784</td>
                                                <td>1991-06-10</td>
                                                <td><span class="badge bg-danger">Belum Verifikasi</span></td>
                                                <td>2024-09-02 13:50</td>
                                            </tr>
                                            <tr>
                                                <td>1234567896</td>
                                                <td><img src="https://via.placeholder.com/50x80" alt="Foto 7" /></td>
                                                <td>Gina Pratiwi</td>
                                                <td>gina@example.com</td>
                                                <td>08123456785</td>
                                                <td>1989-12-15</td>
                                                <td><span class="badge bg-success">Verifikasi</span></td>
                                                <td>2024-09-01 15:00</td>
                                            </tr>
                                            <tr>
                                                <td>1234567897</td>
                                                <td><img src="https://via.placeholder.com/50x80" alt="Foto 8" /></td>
                                                <td>Hadi Kurniawan</td>
                                                <td>hadi@example.com</td>
                                                <td>08123456786</td>
                                                <td>1987-09-30</td>
                                                <td><span class="badge bg-danger">Belum Verifikasi</span></td>
                                                <td>2024-08-31 08:30</td>
                                            </tr>
                                            <tr>
                                                <td>1234567898</td>
                                                <td><img src="https://via.placeholder.com/50x80" alt="Foto 9" /></td>
                                                <td>Ika Amelia</td>
                                                <td>ika@example.com</td>
                                                <td>08123456787</td>
                                                <td>1996-04-21</td>
                                                <td><span class="badge bg-success">Verifikasi</span></td>
                                                <td>2024-08-30 18:40</td>
                                            </tr>
                                            <tr>
                                                <td>1234567899</td>
                                                <td><img src="https://via.placeholder.com/50x80" alt="Foto 10" /></td>
                                                <td>Joko Widodo</td>
                                                <td>joko@example.com</td>
                                                <td>08123456788</td>
                                                <td>1983-05-01</td>
                                                <td><span class="badge bg-danger">Belum Verifikasi</span></td>
                                                <td>2024-08-29 20:10</td>
                                            </tr>
                                            <tr>
                                                <td>1234567900</td>
                                                <td><img src="https://via.placeholder.com/50x80" alt="Foto 11" /></td>
                                                <td>Kiki Ananda</td>
                                                <td>kiki@example.com</td>
                                                <td>08123456789</td>
                                                <td>1994-02-13</td>
                                                <td><span class="badge bg-success">Verifikasi</span></td>
                                                <td>2024-08-28 14:00</td>
                                            </tr>
                                            <tr>
                                                <td>1234567901</td>
                                                <td><img src="https://via.placeholder.com/50x80" alt="Foto 12" /></td>
                                                <td>Lia Pratama</td>
                                                <td>lia@example.com</td>
                                                <td>08123456780</td>
                                                <td>1986-11-11</td>
                                                <td><span class="badge bg-danger">Belum Verifikasi</span></td>
                                                <td>2024-08-27 17:45</td>
                                            </tr>
                                            <tr>
                                                <td>1234567902</td>
                                                <td><img src="https://via.placeholder.com/50x80" alt="Foto 13" /></td>
                                                <td>Miko Prasetyo</td>
                                                <td>miko@example.com</td>
                                                <td>08123456781</td>
                                                <td>1993-07-08</td>
                                                <td><span class="badge bg-success">Verifikasi</span></td>
                                                <td>2024-08-26 09:25</td>
                                            </tr>
                                            <tr>
                                                <td>1234567903</td>
                                                <td><img src="https://via.placeholder.com/50x80" alt="Foto 14" /></td>
                                                <td>Nina Kurniawati</td>
                                                <td>nina@example.com</td>
                                                <td>08123456782</td>
                                                <td>1991-10-05</td>
                                                <td><span class="badge bg-danger">Belum Verifikasi</span></td>
                                                <td>2024-08-25 07:50</td>
                                            </tr>
                                            <tr>
                                                <td>1234567904</td>
                                                <td><img src="https://via.placeholder.com/50x80" alt="Foto 15" /></td>
                                                <td>Omar Arifin</td>
                                                <td>omar@example.com</td>
                                                <td>08123456783</td>
                                                <td>1988-01-18</td>
                                                <td><span class="badge bg-success">Verifikasi</span></td>
                                                <td>2024-08-24 13:20</td>
                                            </tr>
                                            <tr>
                                                <td>1234567905</td>
                                                <td><img src="https://via.placeholder.com/50x80" alt="Foto 16" /></td>
                                                <td>Putri Melati</td>
                                                <td>putri@example.com</td>
                                                <td>08123456784</td>
                                                <td>1997-05-09</td>
                                                <td><span class="badge bg-danger">Belum Verifikasi</span></td>
                                                <td>2024-08-23 11:35</td>
                                            </tr>
                                            <tr>
                                                <td>1234567906</td>
                                                <td><img src="https://via.placeholder.com/50x80" alt="Foto 17" /></td>
                                                <td>Qori Ismail</td>
                                                <td>qori@example.com</td>
                                                <td>08123456785</td>
                                                <td>1990-09-27</td>
                                                <td><span class="badge bg-success">Verifikasi</span></td>
                                                <td>2024-08-22 10:00</td>
                                            </tr>
                                            <tr>
                                                <td>1234567907</td>
                                                <td><img src="https://via.placeholder.com/50x80" alt="Foto 18" /></td>
                                                <td>Rina Amelia</td>
                                                <td>rina@example.com</td>
                                                <td>08123456786</td>
                                                <td>1989-04-03</td>
                                                <td><span class="badge bg-danger">Belum Verifikasi</span></td>
                                                <td>2024-08-21 19:40</td>
                                            </tr>
                                            <tr>
                                                <td>1234567908</td>
                                                <td><img src="https://via.placeholder.com/50x80" alt="Foto 19" /></td>
                                                <td>Siti Nurhasanah</td>
                                                <td>siti@example.com</td>
                                                <td>08123456787</td>
                                                <td>1993-12-12</td>
                                                <td><span class="badge bg-success">Verifikasi</span></td>
                                                <td>2024-08-20 15:10</td>
                                            </tr>
                                            <tr>
                                                <td>1234567909</td>
                                                <td><img src="https://via.placeholder.com/50x80" alt="Foto 20" /></td>
                                                <td>Toni Santoso</td>
                                                <td>toni@example.com</td>
                                                <td>08123456788</td>
                                                <td>1987-06-01</td>
                                                <td><span class="badge bg-danger">Belum Verifikasi</span></td>
                                                <td>2024-08-19 21:05</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" :class="form.new || form.edit ? 'show active' : ''" id="form" role="tabpanel" aria-labelledby="form-tab">
                                <form class="form form-vertical">
                                    <div class="form-body">
                                        <div class="row">
                                            <p class="col-12"></p>
                                            <div class="col-12">
                                                <div class="form-group has-icon-left">
                                                    <label for="email-id-icon">Email</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" placeholder="Email" id="email-id-icon" />
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-envelope"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group has-icon-left">
                                                    <label for="first-name-icon">Name</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" placeholder="Name" id="first-name-icon" />
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-person"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group has-icon-left">
                                                    <label for="mobile-id-icon">No Hp</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" placeholder="No. HP" id="mobile-id-icon" />
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-phone"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group has-icon-left">
                                                    <label for="mobile-id-icon">Tanggal Lahir</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" placeholder="Tanggal Lahir" id="mobile-id-icon" />
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-calendar"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group has-icon-left">
                                                    <label for="mobile-id-icon">NIK</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" placeholder="NIK" id="mobile-id-icon" />
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-card-list"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group has-icon-left">
                                                    <label for="mobile-id-icon">Jenis Kelamin</label>
                                                    <div class="position-relative">
                                                        <select name="mobile-id-icon" id="mobile-id-icon" class="form-control">
                                                            <option value="">--</option>
                                                            <option value="L">Laki-Laki</option>
                                                            <option value="P">Perempuan</option>
                                                        </select>
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-gender-male"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group has-icon-left">
                                                    <label for="password-id-icon">Password</label>
                                                    <div class="position-relative">
                                                        <input type="password" class="form-control" placeholder="Password" id="password-id-icon" />
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-lock"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group has-icon-left">
                                                    <label for="mobile-id-icon">Verifikasi</label>
                                                    <div class="position-relative">
                                                        <select name="mobile-id-icon" id="mobile-id-icon" class="form-control">
                                                            <option value="">--</option>
                                                            <option value="L">Verifiaksi</option>
                                                            <option value="P">Belum Verifiaksi</option>
                                                        </select>
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-check"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="mobile-id-icon">Foto</label>
                                                    <input type="file" class="basic-filepond1" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
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

let table
export default {
    components: {
        VeeForm,
        Field,
        ErrorMessage,
    },

    data() {
        return {
            menu: {
                menu_label: '',
                menu_desc: '',
                permission: {
                    create: false,
                    read: false,
                    update: false,
                    delete: false,
                    print: false,
                    approve: false,
                },
            },

            form: {
                new: false,
                edit: false,
            },
        }
    },

    mounted() {
        this.__MENU()
        this.$root.web_access_log()

        table = $('#table1').DataTable()

        FilePond.create(document.querySelector('.basic-filepond1'), {
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

        create() {
            this.form.new = true
            this.form.edit = false
        },

        edit() {
            this.form.new = false
            this.form.edit = true
        },

        destroy() {
            this.$swal({
                icon: 'question',
                text: 'Are you sure you will delete this data?',
                showCancelButton: true,
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonText: '<i class="bi bi-trash-fill"></i> Delete',
                cancelButtonText: '<i class="bi bi-x-square-fill"></i> Cancel',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-sm btn-danger me-2',
                    cancelButton: 'btn btn-sm btn-secondary',
                },
            }).then((result) => {
                this.cancel()
            })
        },

        submit() {
            this.cancel()
        },

        cancel() {
            this.form.new = false
            this.form.edit = false
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
