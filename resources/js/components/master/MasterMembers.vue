<template>
    <action-bar :data="menu" :menu-label="menu.menu_label"></action-bar>

    <section class="section">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="buttons">
                            <template v-if="!form.new && !form.edit">
                                <!-- <a href="#" class="btn icon icon-left btn-primary" @click="create"><i class="bi bi-check-square-fill"></i> New</a>
                                <a href="#" class="btn icon icon-left btn-success" @click="edit"><i class="bi bi-pencil-square"></i> Edit</a> -->
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
                new: false,
                edit: false,
            },
        }
    },

    mounted() {
        this.__MENU()
        this.$root.web_access_log()

        let _row = this
        table = $('#table1').DataTable({
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
            ajax: "/master/member-mst",
            columns: [
                { data: "nik" },
                {
                    data: "photo",
                    render: function(data, type, row) {
                        return '<img src="' + data + '" class="thumbnail" data-large="' + data + '" alt="Image" style="width: 50px; cursor: pointer;" />';
                    }
                },
                { data: "name" },
                { data: "email" },
                { data: "phone" },
                { data: "birthday", class: "text-center" },
                {
                    data: "email_verified_at",
                    render: function(data, type, row) {
                        if(data!='' && data!=null ){
                            return '<span class="badge bg-success">Verifikasi</span>'
                        }else{
                            return '<span class="badge bg-danger">Belum Verifikasi</span>'
                        }
                    }
                },
                { data: "created_at", class: "text-center" }
            ],
            language: {
                lengthMenu: "_MENU_",
                search: "_INPUT_",
                searchPlaceholder: "Search..",
                info: '<span class="fs-sm">Showing _START_ to _END_ of _TOTAL_ entries</span>',
                infoEmpty: '<span class="fs-sm">Showing 0 to 0 of 0 entries</span>',
                infoFiltered: '<span class="fs-sm">(filtered from _MENU_ total entries)</span>',
                zeroRecords: '<span class="fs-sm">No Data</span>',
                paginate: {
                    first: '<i class="bi bi-chevron-double-left"></i>',
                    previous: '<i class="bi bi-chevron-left"></i>',
                    next: '<i class="bi bi-chevron-right"></i>',
                    last: '<i class="bi bi-chevron-double-right"></i>'
                }
            }
        });
        window.$('#table1 tbody').on('click', 'tr', function () {
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
        window.$('#table1 tbody').on('click', '.thumbnail', function () {
            // Get the large image URL from data attribute
            var largeImageUrl = $(this).data('large');
            
            // Set the large image URL in the modal
            $('#modalImage').attr('src', largeImageUrl);
            
            // Show the modal
            new bootstrap.Modal(document.getElementById('imageModal')).show()
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

        create() {
            this.form.new = true
            this.form.edit = false
        },

        edit() {
            this.form.new = false
            this.form.edit = true
        },

        destroy() {
            if(this.selected.length > 0) {
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
                    if (result.value) {
                        let loader = this.$loading.show();

                        window.axios.delete('/master/member-mst/'+ this.selected[0].id +'?menufn='+ this.$route.name)
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

    beforeRouteLeave (to, from, next) {
        if (table) {
            table.destroy();
            table = null;
        }

        next();
    }
}
</script>
