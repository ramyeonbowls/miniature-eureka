<template>
    <action-bar :data="menu" :menu-label="menu.menu_label"></action-bar>

    <section class="section">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="buttons">
                            <template v-if="!form.upload && !form.new && !form.edit">
                                <a href="#" class="btn icon icon-left btn-primary" @click="create"><i class="bi bi-folder-fill"></i> Tambah</a>
                                <a href="#" class="btn icon icon-left btn-success" @click="edit"><i class="bi bi-pen-fill"></i> Sunting</a>
                                <a href="#" class="btn icon icon-left btn-light-warning" @click="upload"><i class="bi bi-file-arrow-up-fill"></i> Unggah</a>
                                <a href="#" class="btn icon icon-left btn-light-success" @click="DownloadTpl"><i class="bi bi-file-arrow-down-fill"></i> Unduh Template</a>
                                <a href="#" class="btn icon icon-left btn-danger" @click="destroy"><i class="bi bi-x-square-fill"></i> Hapus</a>
                            </template>
                            <template v-else>
                                <a href="#" class="btn icon icon-left btn-success" @click.prevent="submit"><i class="bi bi-check-square-fill"></i> Submit</a>
                                <a href="#" class="btn icon icon-left btn-danger" @click="cancel"><i class="bi bi-x-square-fill"></i> Batal</a>
                            </template>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" :class="form.upload || form.new || form.edit ? 'disabled' : 'active'" id="data-tab" data-bs-toggle="tab" href="javascript:void(0);" role="tab" aria-controls="data" aria-selected="true">Data</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" :class="!form.upload && !form.new && !form.edit ? 'disabled' : 'active'" id="form-tab" data-bs-toggle="tab" href="javascript:void(0);" role="tab" aria-controls="form" aria-selected="false">Form</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade" :class="!form.upload && !form.new && !form.edit ? 'show active' : ''" id="data" role="tabpanel" aria-labelledby="data-tab">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="data_rst">
                                        <thead>
                                            <tr>
                                                <th>NIP</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>No. HP</th>
                                                <th>Tgl Lahir</th>
                                                <th>Waktu Daftar</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" :class="form.upload ? 'show active' : ''" id="form" role="tabpanel" aria-labelledby="form-tab">
                                <VeeForm ref="formupl" v-slot="{ handleSubmit }" as="div">
                                    <form class="form form-horizontal" @submit.prevent="handleSubmit($event, submit)">
                                        <div class="form-body">
                                            <div class="row">
                                                <p class="col-12"></p>
                                                <div class="col-12">
                                                    <label for="upl" class="col-sm-4 col-form-label-sm">Upload File <span class="text-danger">*</span></label>
                                                    <div class="col-sm-8">
                                                        <Field name="file" v-slot="{ field, errors }" :rules="{ required: true }">
                                                            <input type="file" ref="file_upl" v-bind="field" @change="onChangeFileUpload" accept=".xls,.xlsx" class="form-control" />
                                                            <ErrorMessage name="file" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                                        </Field>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </VeeForm>
                            </div>
                            <div class="tab-pane fade" :class="form.new || form.edit ? 'show active' : ''" id="form" role="tabpanel" aria-labelledby="form-tab">
                                <section id="basic-horizontal-layouts">
                                    <div class="row match-height">
                                        <div class="col-md-8 col-12">
                                            <div class="card">
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <VeeForm ref="form" v-slot="{ handleSubmit }" as="div">
                                                            <form class="form form-horizontal" @submit.prevent="handleSubmit($event, submit)">
                                                                <div class="form-body">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                                                                        </div>
                                                                        <div class="col-md-8 form-group">
                                                                            <Field type="text" id="name" v-model="form.field.name" class="form-control" name="name" rules="required" />
                                                                            <ErrorMessage name="name" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="nik">NIP</label>
                                                                        </div>
                                                                        <div class="col-md-8 form-group">
                                                                            <Field id="nik" v-model="form.field.nik" class="form-control" name="nik" rules="numeric"/>
                                                                            <ErrorMessage name="nik" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="email">Email <span class="text-danger">*</span></label>
                                                                        </div>
                                                                        <div class="col-md-8 form-group">
                                                                            <Field type="text" id="email" v-model="form.field.email" class="form-control" name="email" rules="required|email" :disabled="form.edit ? true : false"/>
                                                                            <ErrorMessage name="email" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="phone">No. HP <span class="text-danger">*</span></label>
                                                                        </div>
                                                                        <div class="col-md-8 form-group">
                                                                            <Field type="text" id="phone" v-model="form.field.phone" class="form-control" name="phone" rules="required|numeric"/>
                                                                            <ErrorMessage name="phone" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                                                        </div><div class="col-md-4">
                                                                            <label for="birthday">Tanggal Lahir <span class="text-danger">*</span></label>
                                                                        </div>
                                                                        <div class="col-md-8 form-group">
                                                                            <Field name="birthday" v-slot="{ field, errors }" :rules="{ required: true }" >
                                                                                <Flatpickr id="birthday" v-bind="field" v-model="form.field.birthday" class="form-control flatpickr-range" :config="configdate" placeholder="Select date.." 
                                                                                />
                                                                            </Field>
                                                                            <ErrorMessage name="birthday" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="gender">Jenis Kelamin <span class="text-danger">*</span></label>
                                                                        </div>
                                                                        <div class="col-md-8 form-group">
                                                                            <Field as="select" class="form-select" id="gender" v-model="form.field.gender" name="gender" rules="required">
                                                                                <option value="">--</option>
                                                                                <option value="L">Laki - Laki</option>
                                                                                <option value="P">Perempuan</option>
                                                                            </Field>
                                                                            <ErrorMessage name="gender" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="password">Password <span class="text-danger" v-if="form.new">*</span></label>
                                                                        </div>
                                                                        <div class="col-md-8 form-group">
                                                                            <Field type="password" id="password" v-model="form.field.password" class="form-control" name="password" :rules="passwordRules" />
                                                                            <ErrorMessage name="password" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="confirmPassword">Ulangi Kata Sandi <span class="text-danger" v-if="form.new">*</span></label>
                                                                        </div>
                                                                        <div class="col-md-8 form-group">
                                                                            <Field type="password" id="confirmPassword" v-model="form.field.confirmPassword" class="form-control" name="confirmPassword" :rules="confirmpasswordRules" />
                                                                            <ErrorMessage name="confirmPassword" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </VeeForm>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal for Image Preview -->
    <div class="modal fade text-left" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="imageModalLabel">Preview</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg text-black"></i>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid" alt="Preview" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for Image Preview -->
</template>

<script>
import { Field, Form as VeeForm, ErrorMessage } from 'vee-validate';
import { required, email, confirmed, numeric, min } from '@vee-validate/rules';
import { defineRule } from 'vee-validate';

defineRule('required', required);
defineRule('email', email);
defineRule('confirmed', confirmed);
defineRule('numeric', numeric);
defineRule('min', min);

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
            errors: {},
            selected: [],
            form: {
                submitted: false,
                new: false,
                edit: false,
                upload: false,
                field: {
                    id: '',
                    name: '',
                    phone: '',
                    birthday: '',
                    password: '',
                    email: '',
                    gender: '',
                    nik: '',
                    passwordConfirm: '',
                    file: '',
                }
            },
            configdate: {
                dateFormat: 'Y-m-d',
                disableMobile: true
            },
        }
    },

    mounted() {
        this.__MENU()
        this.$root.web_access_log()

        let _row = this
        table = $('#data_rst').DataTable({
            paging: true,
            pagingType: 'full_numbers',
            lengthMenu: [[10, 25, 50, 100, 500], [10, 25, 50, 100, 500]],
            pageLength: 25,
            processing: true,
            serverSide: true,
            deferRender: true,
            stateSave: true,
            select: true,
            rowId: 'extn',
            order: [[0, "asc"]],
            ajax: "/master/teacher-mst",
            columns: [
                { data: "nik" },
                { data: "name" },
                { data: "email" },
                { data: "phone" },
                { data: "birthday", class: "text-center" },
                { data: "created_at", class: "text-center" }
            ],
            language: {
                lengthMenu: "_MENU_",
                search: "_INPUT_",
                searchPlaceholder: "Pencarian..",
                info: '<span class="fs-sm">Menampilkan _START_ sampai _END_ dari _TOTAL_ entri</span>',
                infoEmpty: '<span class="fs-sm">Menampilkan 0 sampai 0 dari 0 entri</span>',
                infoFiltered: '<span class="fs-sm">(disaring dari _MAX_ total entri)</span>',
                zeroRecords: '<span class="fs-sm">Tidak Ada Data</span>',
                paginate: {
                    first: '<i class="bi bi-chevron-double-left"></i>',
                    previous: '<i class="bi bi-chevron-left"></i>',
                    next: '<i class="bi bi-chevron-right"></i>',
                    last: '<i class="bi bi-chevron-double-right"></i>'
                }
            }
        });
        window.$('#data_rst tbody').on('click', 'tr', function () {
            _row.selected = [];

            if ( window.$(this).hasClass('selected') ) {
                window.$(this).removeClass('selected');
            } else {
                table.$('tr.selected').removeClass('selected');
                window.$(this).addClass('selected');

                if (table.rows('.selected').data().length > 0) {
                    _row.selected.push(table.rows('.selected').data()[0]);
                }
            }
        });
        window.$('#data_rst tbody').on('click', '.thumbnail', function () {
            // Get the large image URL from data attribute
            var largeImageUrl = $(this).data('large');
            
            // Set the large image URL in the modal
            $('#modalImage').attr('src', largeImageUrl);
            
            // Show the modal
            new bootstrap.Modal(document.getElementById('imageModal')).show()
        });
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

        clearForm() {
            this.form.field.id              = ''
            this.form.field.name            = ''
            this.form.field.phone           = ''
            this.form.field.birthday        = ''
            this.form.field.password        = ''
            this.form.field.email           = ''
            this.form.field.gender          = ''
            this.form.field.nik             = ''
            this.form.field.passwordConfirm = ''
            this.form.field.file            = ''
            this.errors                     = {}
        },

        create() {
            this.form.new = true
            this.form.edit = false
            this.form.upload = false

            this.clearForm()
        },

        upload() {
            this.form.upload = true
            this.form.new = false
            this.form.edit = false
			this.clearForm()
        },

        edit() {
            if (this.selected.length > 0) {
                this.form.new = false
                this.form.edit = true
                this.form.upload = false
                this.submitted = false

                this.form.field.id              = this.selected[0].id
                this.form.field.name            = this.selected[0].name
                this.form.field.phone           = this.selected[0].phone
                this.form.field.birthday        = this.selected[0].birthday
                this.form.field.email           = this.selected[0].email
                this.form.field.gender          = this.selected[0].gender
                this.form.field.nik             = this.selected[0].nik
                this.form.field.file            = ''
            } else {
                this.$swal({
                    toast: true,
                    icon: 'warning',
                    text: 'Tidak ada baris yang dipilih!'
                });
            }
        },

        destroy() {
            if(this.selected.length > 0) {
                this.$swal({
                    icon: 'question',
                    text: 'Apakah anda yakin ingin menghapus data ini?',
                    showCancelButton: true,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    confirmButtonText: '<i class="bi bi-trash-fill"></i> Hapus',
                    cancelButtonText: '<i class="bi bi-x-square-fill"></i> Batal',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-sm btn-danger me-2',
                        cancelButton: 'btn btn-sm btn-secondary',
                    },
                }).then((result) => {
                    if (result.value) {
                        let loader = this.$loading.show();

                        window.axios.delete('/master/teacher-mst/'+ this.selected[0].id +'?menufn='+ this.$route.name)
                        .then(response => {
                            loader.hide();
                            this.selected = [];
                            table.ajax.reload();

                            this.$swal({
                                toast: true,
                                icon: 'success',
                                html: response.data
                            });
                        })
                    }
                })
            } else {
                this.$swal({
                    toast: true,
                    icon: 'warning',
                    text: 'Tidak ada baris yang dipilih!'
                });
            }
        },

        submit() {
            if(!this.form.submitted) {
                this.form.submitted = true;

                if(this.form.upload) {
                    this.$refs.formupl.validate().then(result => {
                        if(result.valid) {
                            let loader = this.$loading.show()

                            let form_data = new FormData();
                            form_data.append('file', this.form.field.file);

                            window.axios.post('/master/teacher-mst?menufn='+ this.$route.name+'&type=upl', form_data, {
                                headers: {
                                    'Content-Type': 'multipart/form-data'
                                }
                            })
                            .then((response) => {
                                loader.hide()
                                table.ajax.reload();

                                this.submit_count = 0;
                                this.cancel();

                                this.$swal({
                                    toast: true,
                                    position: 'top',
                                    icon: response.status === 201 ? 'success' : 'info',
                                    html: response.data
                                });
                            })
                            .catch((e) => {
                                loader.hide()

                                this.submit_count = 0;
                                console.error(e);
                            });

                            this.cancel()
                        } else {
                            this.form.submitted = false;
                        }
                    });
                }else{
                    this.$refs.form.validate().then(result => {
                        if(result.valid) {
                            let loader = this.$loading.show()

                            if(this.form.new) {
                                let form_data = new FormData();
                                form_data.append('name', this.form.field.name);
                                form_data.append('nik', this.form.field.nik);
                                form_data.append('email', this.form.field.email);
                                form_data.append('phone', this.form.field.phone);
                                form_data.append('birthday', this.form.field.birthday);
                                form_data.append('gender', this.form.field.gender);
                                form_data.append('password', this.form.field.password);
                                form_data.append('confirmPassword', this.form.field.confirmPassword);

                                window.axios.post('/master/teacher-mst?menufn='+ this.$route.name+'&type=new', form_data)
                                .then((response) => {
                                    loader.hide()
                                    table.ajax.reload();

                                    this.submit_count = 0;
                                    this.cancel();

                                    this.$swal({
                                        toast: true,
                                        position: 'top',
                                        icon: response.status === 201 ? 'success' : 'info',
                                        html: response.data
                                    });
                                })
                                .catch((e) => {
                                    loader.hide()

                                    this.submit_count = 0;
                                    console.error(e);
                                });
                            } else {
                                let form_data = new FormData();
                                form_data.append('_method', 'PUT');
                                form_data.append('id', this.form.field.id);
                                form_data.append('name', this.form.field.name);
                                form_data.append('nik', this.form.field.nik);
                                form_data.append('email', this.form.field.email);
                                form_data.append('phone', this.form.field.phone);
                                form_data.append('birthday', this.form.field.birthday);
                                form_data.append('gender', this.form.field.gender);
                                form_data.append('password', this.form.field.password);
                                form_data.append('confirmPassword', this.form.field.confirmPassword);

                                window.axios.post('/master/teacher-mst/'+this.form.field.id+'?menufn='+ this.$route.name, form_data)
                                .then((response) => {
                                    loader.hide()
                                    table.ajax.reload();

                                    this.submit_count = 0;
                                    this.cancel();

                                    this.$swal({
                                        toast: true,
                                        position: 'top',
                                        icon: response.status === 201 ? 'success' : 'info',
                                        html: response.data
                                    });
                                })
                                .catch((e) => {
                                    loader.hide()

                                    this.submit_count = 0;
                                    console.error(e);
                                });
                            }

                            this.cancel()
                        } else {
                            this.form.submitted = false;
                        }
                    });
                }
            }
        },

        DownloadTpl(){
            let loader = this.$loading.show()

            window.axios({
                url: '/master/teacher-mst?menufn='+ this.$route.name +'&download=tpl',
                method: 'POST',
                responseType: 'blob'
            })
            .then((response) => {
                loader.hide()

                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', 'Template Upload Teacher.xlsx');
                document.body.appendChild(link);
                link.click();
            })
            .catch((e) => {
                console.error(e);
                loader.hide()
            })
		},

		async onChangeFileUpload(e) {
			this.form.field.file = this.$refs.file_upl.files[0];
		},

        cancel() {
            this.form.new = false
            this.form.edit = false
            this.form.upload = false
            this.form.submitted = false

            this.selected = []
            this.clearForm()
            this.$refs.form.resetForm()
            table.ajax.reload(null, false)
        },

        filterInput(event, param) {
            if(param=='nik'){
                this.form.field.nik = event.target.value.replace(/\D/g, '');
            }else if(param=='phone'){
                this.form.field.phone = event.target.value.replace(/\D/g, '');
            }
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

        passwordRules() {
            return this.form.new ? { required: true, min:8 } : '';
        },

        confirmpasswordRules() {
            return this.form.field.password != '' ? 'confirmed:@password' : '';
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
    },

    beforeRouteLeave (to, from, next) {
        if (table) {
            table.destroy();
            table = null;
        }

        next();
    }
}
</script>
