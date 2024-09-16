<template>
    <action-bar :data="menu" :menu-label="menu.menu_label"></action-bar>

    <section class="section">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="buttons">
                            <template v-if="!form.new && !form.edit">
                                <a href="#" class="btn icon icon-left btn-primary" @click="create"><i class="bi bi-folder-fill"></i> New</a>
                                <a href="#" class="btn icon icon-left btn-success" @click="edit"><i class="bi bi-pen-fill"></i> Edit</a>
                                <a href="#" class="btn icon icon-left btn-danger" @click="destroy"><i class="bi bi-trash-fill"></i> Delete</a>
                            </template>
                            <template v-else>
                                <a href="#" class="btn icon icon-left btn-success" @click.prevent="submit"><i class="bi bi-cloud-arrow-up-fill"></i> Submit</a>
                                <a href="#" class="btn icon icon-left btn-danger" @click="cancel"><i class="bi bi-arrow-left-square-fill"></i> Cancel</a>
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
                                <table class="table table-striped" id="data_rst">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Keterangan</th>
                                            <th>File</th>
                                            <th>Display</th>
                                            <th>dibuat oleh</th>
                                            <th>dibuat pada</th>
                                            <th>diperbarui oleh</th>
                                            <th>diperbarui pada</th>
                                        </tr>
                                    </thead>
                                </table>
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
                                                                            <label for="id">ID <span class="text-danger">*</span></label>
                                                                        </div>
                                                                        <div class="col-md-8 form-group">
                                                                            <Field type="text" id="id" v-model="form.field.id" class="form-control" name="id" />
                                                                            <ErrorMessage name="id" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="desc">Keterangan <span class="text-danger">*</span></label>
                                                                        </div>
                                                                        <div class="col-md-8 form-group">
                                                                            <Field type="text" id="desc" v-model="form.field.desc" class="form-control" name="desc" />
                                                                            <ErrorMessage name="desc" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="file_type">Jenis file <span class="text-danger">*</span></label>
                                                                        </div>
                                                                        <div class="col-md-8 form-group">
                                                                            <Field as="select" id="file_type" v-model="form.field.type"  class="form-control" name="file_type">
                                                                                <option value="">--</option>
                                                                                <option value="web">Web</option>
                                                                                <option value="mobile">Mobile</option>
                                                                            </Field>
                                                                            <ErrorMessage name="file_type" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="file">File <span class="text-danger">*</span></label>
                                                                        </div>
                                                                        <div class="col-md-8 form-group">
                                                                            <Field type="file" ref="banner_files" id="file" name="file" class="basic-filepond1" />
                                                                            <ErrorMessage name="file" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                                                            <small class="text-muted">Max. size: 100 kb (50x50 pixels)<br>File types: png, jpg, jpeg</small>
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

            selected: [],
            form: {
                submitted: false,
                new: false,
                edit: false,
                field: {
                    id: '',
                    desc: '',
                    type: '',
                    file: '',
                    current_file: '',
                }
            },
        }
    },

    mounted() {
        this.__MENU()
        this.$root.web_access_log()

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
            ajax: "/setting/banner-mst",
            columns: [
                { data: "id" },
                { data: "description" },
                { data: "file" },
                { data: "disp_type" },
                { data: "created_by" },
                { data: "created_at", class: "text-center" },
                { data: "updated_by" },
                { data: "updated_at", class: "text-center" }
            ],
            language: {
                lengthMenu: "_MENU_",
                search: "_INPUT_",
                searchPlaceholder: "Search..",
                info: '<span class="fs-sm">Showing _START_ to _END_ of _TOTAL_ entries</span>',
                infoEmpty: '<span class="fs-sm">Showing 0 to 0 of 0 entries</span>',
                infoFiltered: '<span class="fs-sm">(filtered from _MAX_ total entries)</span>',
                zeroRecords: '<span class="fs-sm">No Data</span>',
                paginate: {
                    first: '<i class="bi bi-chevron-double-left"></i>',
                    previous: '<i class="bi bi-chevron-left"></i>',
                    next: '<i class="bi bi-chevron-right"></i>',
                    last: '<i class="bi bi-chevron-double-right"></i>'
                }
            }
        });

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

        clearForm() {
            this.form.field.id = ''
            this.form.field.desc = ''
            this.form.field.type = ''
            this.form.field.file = ''
            this.form.field.current_file = ''

            this.$refs.banner_files.value = '';
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
            if(!this.form.submitted) {
                this.form.submitted = true;

                this.$refs.form.validate().then(result => {
                    if(result.valid) {
                        this.form.submitted = false;

                        let loader = this.$loading.show();
                        if(this.form.new) {
                            window.axios.post('/setting/banner-mst?menu_fn='+ this.$route.name, this.form.field)
                                .then((response) => {
                                    loader.hide();
                                    this.close();

                                    this.$swal({
                                        toast: true,
                                        position: 'top',
                                        icon: response.data.success ? 'success' : 'error',
                                        html: response.data.message
                                    });
                                })
                                .catch((e) => {
                                    loader.hide();
                                    this.form.submitted = false;

                                    if(e.response.status === 422) {
                                        this.$refs.form.setErrors(e.response.data.errors);
                                    }
                                });
                        } else {
                            window.axios.put('/setting/banner-mst/'+ this.form.field.type +'?menu_fn='+ this.$route.name, this.form.field)
                                .then((response) => {
                                    loader.hide();
                                    this.close();

                                    this.$swal({
                                        toast: true,
                                        position: 'top',
                                        icon: response.data.success ? 'success' : 'error',
                                        html: response.data.message
                                    });
                                })
                                .catch((e) => {
                                    loader.hide();
                                    this.form.submitted = false;

                                    if(e.response.status === 422) {
                                        this.$refs.form.setErrors(e.response.data.errors);
                                    }
                                });
                        }
                    } else {
                        this.form.submitted = false;
                    }
                });
            }
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
