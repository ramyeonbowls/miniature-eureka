<template>
    <action-bar :data="menu" :menu-label="menu.menu_label"></action-bar>

    <section class="section">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="buttons">
                            <template v-if="!form.new && !form.edit">
                                <a href="#" class="btn icon icon-left btn-primary" @click="create"><i class="bi bi-folder-fill"></i> Tambah</a>
                                <a href="#" class="btn icon icon-left btn-success" @click="edit"><i class="bi bi-pen-fill"></i> Sunting</a>
                                <a href="#" class="btn icon icon-left btn-danger" @click="destroy"><i class="bi bi-trash-fill"></i> Hapus</a>
                            </template>
                            <template v-else>
                                <a href="#" class="btn icon icon-left btn-success" @click.prevent="submit"><i class="bi bi-cloud-arrow-up-fill"></i> Simpan</a>
                                <a href="#" class="btn icon icon-left btn-danger" @click="cancel"><i class="bi bi-arrow-left-square-fill"></i> Batal</a>
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
                                                                            <Field type="text" :disabled="true" id="id" v-model="form.field.id" class="form-control" name="id" />
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
                                                                            <label for="type">Jenis file <span class="text-danger">*</span></label>
                                                                        </div>
                                                                        <div class="col-md-8 form-group">
                                                                            <Field as="select" id="type" v-model="form.field.type"  class="form-control" name="type">
                                                                                <option value="">--</option>
                                                                                <option value="web">Web</option>
                                                                                <option value="mobile">Mobile</option>
                                                                            </Field>
                                                                            <ErrorMessage name="type" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="file">File <span class="text-danger">*</span></label>
                                                                        </div>
                                                                        <div class="col-md-8 form-group">
                                                                            <Field name="file">
                                                                                <input type="file" ref="banner_files" id="file" name="file" @change="onChangeIcon" accept=".png,.jpg,.jpeg" />
                                                                            </Field>
                                                                            <ErrorMessage name="file" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                                                            <br><small v-if="form.field.type == 'web' || form.field.type == ''" class="text-muted">Max. size: 1500 kb (1300x500 pixels)<br>File types: png, jpg, jpeg</small><small v-else class="text-muted">Max. size: 1500 kb (400x250 pixels)<br>File types: png, jpg, jpeg</small>
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
            ajax: "/setting/banner-mst",
            columns: [
                { data: "id" },
                { data: "description" },
                {
                    data: "file",
                    render: function(data, type, row) {
                        return '<img src="/storage/images/banner/' + data + '" class="thumbnail" data-large="/storage/images/banner/' + data + '" alt="Image" style="width: 50px; cursor: pointer;" />';
                    }
                },
                { data: "disp_type" },
                { data: "created_by" },
                { data: "created_at", class: "text-center" },
                { data: "updated_by" },
                { data: "updated_at", class: "text-center" }
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
            this.form.field.id = ''
            this.form.field.desc = ''
            this.form.field.type = ''
            this.form.field.file = ''
            this.form.field.current_file = ''

            this.$refs.banner_files.value = '';
        },

        async onChangeIcon(e) {
            this.form.field.file = this.$refs.banner_files.files[0];
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

                this.form.field.id = this.selected[0].id
                this.form.field.desc = this.selected[0].description
                this.form.field.type = this.selected[0].disp_type
                this.form.field.file = ''
                this.form.field.current_file = this.selected[0].file
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

                        window.axios.delete('/setting/banner-mst/'+ this.selected[0].id +'?menufn='+ this.$route.name)
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

                this.$refs.form.validate().then(result => {
                    if(result.valid) {
                        this.form.submitted = false;

                        let loader = this.$loading.show();
                        if(this.form.new) {
                            let form_data = new FormData();
                            Object.keys(this.form.field).forEach(value => {
                                form_data.append(value, this.form.field[value]);
                            });
                            
                            window.axios.post('/setting/banner-mst?menu_fn='+ this.$route.name, form_data)
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

                            window.axios.post('/setting/banner-mst/'+ this.form.field.id +'?menu_fn='+ this.$route.name, form_data)
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
