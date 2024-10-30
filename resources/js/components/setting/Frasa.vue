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
                                <div class="table-responsive">
                                    <table class="table table-striped" id="data_rst">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Penulis</th>
                                                <th>Aktif</th>
                                                <th>File</th>
                                                <th>dibuat oleh</th>
                                                <th>dibuat pada</th>
                                                <th>diperbarui oleh</th>
                                                <th>diperbarui pada</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" :class="form.new || form.edit ? 'show active' : ''" id="form" role="tabpanel" aria-labelledby="form-tab">
                                <section id="basic-horizontal-layouts">
                                    <div class="row match-height">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <VeeForm ref="form" v-slot="{ handleSubmit }" as="div">
                                                            <form class="form form-horizontal" @submit.prevent="handleSubmit($event, submit)">
                                                                <div class="form-body">
                                                                    <div class="row">
                                                                        <div class="col-md-2">
                                                                            <label for="id">ID <span class="text-danger">*</span></label>
                                                                        </div>
                                                                        <div class="col-md-10 form-group">
                                                                            <Field type="text" :disabled="true" id="id" v-model="form.field.id" class="form-control" name="id" />
                                                                            <ErrorMessage name="id" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                                                        </div>
                                                                        <!-- <div class="col-md-2">
                                                                            <label for="desc">Judul <span class="text-danger">*</span></label>
                                                                        </div>
                                                                        <div class="col-md-10 form-group">
                                                                            <Field type="text" id="title" v-model="form.field.title" class="form-control" name="title" />
                                                                            <ErrorMessage name="judul" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                                                        </div> -->
                                                                        <div class="col-md-2">
                                                                            <label for="desc">Konten <span class="text-danger">*</span></label>
                                                                        </div>
                                                                        <div class="col-md-10 form-group">
                                                                            <textarea class="form-control" id="description" v-model="form.field.description" name="description" rows="3" maxlength="200"></textarea>
                                                                            <br><small class="text-muted">{{ remainingCharacters }}/{{ maxLength }}</small>
                                                                            <ErrorMessage name="description" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <label for="desc">Penulis</label>
                                                                        </div>
                                                                        <div class="col-md-10 form-group">
                                                                            <Field type="text" id="author" v-model="form.field.author" class="form-control" name="author" />
                                                                            <ErrorMessage name="penulis" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <label for="type">Flag Aktif</label>
                                                                        </div>
                                                                        <div class="col-md-10 form-group">
                                                                            <div class="form-check">
                                                                                <div class="checkbox">
                                                                                    <input type="checkbox" id="flag_aktif" class="form-check-input" v-model="form.field.flag_aktif">
                                                                                    <label for="flag_aktif">Aktif</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <label for="file">File <span class="text-danger">*</span></label>
                                                                        </div>
                                                                        <div class="col-md-10 form-group">
                                                                            <Field name="file">
                                                                                <input type="file" ref="frasa_files" id="file" name="file" @change="onChangeIcon" accept=".png,.jpg,.jpeg" />
                                                                            </Field>
                                                                            <ErrorMessage name="file" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                                                            <br><small class="text-muted">Max. size: 1500 kb (300x300 pixels)<br>File types: png, jpg, jpeg</small>
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
                        <i data-feather="x"></i>
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
import { Form as VeeForm, Field, ErrorMessage } from 'vee-validate'
import { v4 as uuidv4 } from 'uuid';

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
                    title: '',
                    description: '',
                    flag_aktif: true,
                    author: '',
                    file: '',
                    current_file: '',
                }
            },
            maxLength: 200
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
            ajax: "/setting/frasa-mst",
            columns: [
                { data: "id" },
                { data: "author" },
                { data: "flag_aktif" },
                {
                    data: "file",
                    render: function(data, type, row) {
                        return '<img src="/storage/images/news/' + data + '" class="thumbnail" data-large="/storage/images/news/' + data + '" alt="Image" style="width: 50px; cursor: pointer;" />';
                    }
                },
                { data: "created_by" },
                { data: "created_at", class: "text-center" },
                { data: "update_by" },
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
            this.form.field.id            = ''
            this.form.field.title         = ''
            this.form.field.description   = ''
            this.form.field.flag_aktif    = ''
            this.form.field.author        = ''
            this.form.field.file          = ''
            this.form.field.current_file  = ''

            this.$refs.frasa_files.value = '';
        },

        async onChangeIcon(e) {
            this.form.field.file = this.$refs.frasa_files.files[0];
        },

        create() {
            this.form.new = true
            this.form.edit = false

            this.clearForm()
            this.form.field.id = uuidv4();
        },

        edit() {
            if (this.selected.length > 0) {
                this.form.new = false
                this.form.edit = true
                this.submitted = false

                this.form.field.id              = this.selected[0].id
                this.form.field.title           = this.selected[0].title
                this.form.field.description     = this.selected[0].description
                this.form.field.flag_aktif      = (this.selected[0].flag_aktif=='Y') ? true : false
                this.form.field.author          = this.selected[0].author
                this.form.field.file            = ''
                this.form.field.current_file    = this.selected[0].file
            } else {
                this.$swal({
                    toast: true,
                    icon: 'warning',
                    text: 'No row selected!'
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
                    confirmButtonText: '<i class="bi bi-trash-fill"></i> Delete',
                    cancelButtonText: '<i class="bi bi-x-square-fill"></i> Cancel',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-sm btn-danger me-2',
                        cancelButton: 'btn btn-sm btn-secondary',
                    },
                }).then((result) => {
                    if (result.value) {
                        let loader = this.$loading.show();

                        window.axios.delete('/setting/frasa-mst/'+ this.selected[0].id +'?menufn='+ this.$route.name)
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
                    text: 'No row selected!'
                });
            }
        },

        submit() {
            if(!this.form.submitted) {
                this.form.submitted = true;

                this.$refs.form.validate().then(result => {
                    if(result.valid) {
                        this.form.submitted = false;

                        let loader = this.$loading.show();
                        if(this.form.new) {
                            let form_data = new FormData();
                            Object.keys(this.form.field).forEach(value => {
                                form_data.append(value, this.form.field[value]);
                            });
                            
                            window.axios.post('/setting/frasa-mst?menu_fn='+ this.$route.name, form_data)
                                .then((response) => {
                                    loader.hide();
                                    this.cancel();

                                    this.$swal({
                                        toast: true,
                                        position: 'top',
                                        icon: response.status === 201 ? 'success' : 'info',
                                        html: response.data
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
                            let form_data = new FormData();
                            form_data.append('_method', 'PUT');
                            Object.keys(this.form.field).forEach(value => {
                                form_data.append(value, this.form.field[value]);
                            });

                            window.axios.post('/setting/frasa-mst/'+ this.form.field.id +'?menu_fn='+ this.$route.name, form_data)
                                .then((response) => {
                                    loader.hide();
                                    this.cancel();

                                    this.$swal({
                                        toast: true,
                                        position: 'top',
                                        icon: response.status === 201 ? 'success' : 'info',
                                        html: response.data
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
            this.form.submitted = false

            this.selected = []
            this.clearForm()
            this.$refs.form.resetForm()
            table.ajax.reload(null, false)
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

        remainingCharacters() {
            return this.maxLength - this.form.field.description.length;
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
