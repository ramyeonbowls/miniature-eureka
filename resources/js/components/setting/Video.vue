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
                                                <th>Judul</th>
                                                <th>Aktif</th>
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
                                                                        <div class="col-md-2">
                                                                            <label for="desc">Judul <span class="text-danger">*</span></label>
                                                                        </div>
                                                                        <div class="col-md-10 form-group">
                                                                            <Field type="text" id="title" v-model="form.field.title" class="form-control" name="title" />
                                                                            <ErrorMessage name="judul" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <label for="desc">Deskripsi <span class="text-danger">*</span></label>
                                                                        </div>
                                                                        <div class="col-md-10 form-group">
                                                                            <textarea class="form-control" id="description" v-model="form.field.description" name="description" rows="3" maxlength="500"></textarea>
                                                                            <br><small class="text-muted">{{ remainingCharacters }}/{{ maxLength }}</small>
                                                                            <ErrorMessage name="description" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <label for="desc">Embed Video</label>
                                                                        </div>
                                                                        <div class="col-md-10 form-group">
																			<textarea class="form-control" id="file" v-model="form.field.file" name="file" rows="3"></textarea>
                                                                            <ErrorMessage name="file" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
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
                    file: ''
                }
            },
            maxLength: 500
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
            ajax: "/setting/video-mst",
            columns: [
                { data: "title" },
                { data: "flag_aktif" },
                { data: "created_by" },
                { data: "created_at", class: "text-center" },
                { data: "update_by" },
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
            this.form.field.file          = ''
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
				let decodedHtml = this.decodeHtml(this.selected[0].file)

                this.form.field.id              = this.selected[0].id
                this.form.field.title           = this.selected[0].title
                this.form.field.description     = this.selected[0].description
                this.form.field.flag_aktif      = (this.selected[0].flag_aktif=='Y') ? true : false
                this.form.field.file            = decodedHtml
            } else {
                this.$swal({
                    toast: true,
                    icon: 'warning',
                    text: 'Tidak ada baris yang dipilih!'
                });
            }
        },

		decodeHtml(html) {
            const txt = document.createElement('textarea');
            txt.innerHTML = html
            const decodedValue = txt.value
            txt.remove();

            return decodedValue;
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

                        window.axios.delete('/setting/video-mst/'+ this.selected[0].id +'?menufn='+ this.$route.name)
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
                            
                            window.axios.post('/setting/video-mst?menu_fn='+ this.$route.name, form_data)
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

                            window.axios.post('/setting/video-mst/'+ this.form.field.id +'?menu_fn='+ this.$route.name, form_data)
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
