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
                                <table class="table table-striped" id="table1">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>NIK</th>
                                            <th>Jabatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Ahmad Faiz</td>
                                            <td>1234567890</td>
                                            <td>Penjaga</td>
                                        </tr>
                                        <tr>
                                            <td>Linda Sari</td>
                                            <td>1234567891</td>
                                            <td>Penjaga</td>
                                        </tr>
                                        <tr>
                                            <td>Joko Susanto</td>
                                            <td>1234567892</td>
                                            <td>Penjaga</td>
                                        </tr>
                                        <tr>
                                            <td>Rina Wulandari</td>
                                            <td>1234567893</td>
                                            <td>Penjaga</td>
                                        </tr>
                                        <tr>
                                            <td>Ali Riza</td>
                                            <td>1234567894</td>
                                            <td>Penjaga</td>
                                        </tr>
                                        <tr>
                                            <td>Farah Kurnia</td>
                                            <td>1234567895</td>
                                            <td>Penjaga</td>
                                        </tr>
                                        <tr>
                                            <td>Rudi Hartono</td>
                                            <td>1234567896</td>
                                            <td>Penjaga</td>
                                        </tr>
                                        <tr>
                                            <td>Putri Dewi</td>
                                            <td>1234567897</td>
                                            <td>Penjaga</td>
                                        </tr>
                                        <tr>
                                            <td>Yusuf Anwar</td>
                                            <td>1234567898</td>
                                            <td>Penjaga</td>
                                        </tr>
                                        <tr>
                                            <td>Desi Rahmawati</td>
                                            <td>1234567899</td>
                                            <td>Penjaga</td>
                                        </tr>
                                        <tr>
                                            <td>Wira Pratama</td>
                                            <td>1234567800</td>
                                            <td>Penjaga</td>
                                        </tr>
                                        <tr>
                                            <td>Ratna Puspita</td>
                                            <td>1234567801</td>
                                            <td>Penjaga</td>
                                        </tr>
                                        <tr>
                                            <td>Arief Maulana</td>
                                            <td>1234567802</td>
                                            <td>Penjaga</td>
                                        </tr>
                                        <tr>
                                            <td>Intan Jaya</td>
                                            <td>1234567803</td>
                                            <td>Penjaga</td>
                                        </tr>
                                        <tr>
                                            <td>Hadi Susilo</td>
                                            <td>1234567804</td>
                                            <td>Penjaga</td>
                                        </tr>
                                        <tr>
                                            <td>Melisa Amalia</td>
                                            <td>1234567805</td>
                                            <td>Penjaga</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" :class="form.new || form.edit ? 'show active' : ''" id="form" role="tabpanel" aria-labelledby="form-tab">
                                <form class="form form-vertical">
                                    <div class="form-body">
                                        <div class="row">
                                            <p class="col-12"></p>
                                            <div class="col-12">
                                                <div class="form-group has-icon-left">
                                                    <label for="email-id-icon">NIP</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" placeholder="NIP" id="email-id-icon" />
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-person"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group has-icon-left">
                                                    <label for="first-name-icon">Nama</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" placeholder="Nama" id="first-name-icon" />
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-person"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group has-icon-left">
                                                    <label for="mobile-id-icon">Jabatan</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" placeholder="Jabatan" id="mobile-id-icon" />
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-person"></i>
                                                        </div>
                                                    </div>
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

        $('#table1').DataTable({
            scrollY: true,
            scrollX: true,
        })

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
