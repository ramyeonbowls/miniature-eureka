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
                                <table class="table table-striped" id="data_rst">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>NIK</th>
                                            <th>Jabatan</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="tab-pane fade" :class="form.new || form.edit ? 'show active' : ''" id="form" role="tabpanel" aria-labelledby="form-tab">
                                <VeeForm ref="form" v-slot="{ handleSubmit }" as="div">
									<form class="form form-horizontal" @submit.prevent="handleSubmit($event, submit)">
										<div class="form-body">
											<div class="row">
												<p class="col-12"></p>
												<div class="col-12">
													<div class="form-group has-icon-left">
														<label for="email-id-icon">NIP</label>
														<div class="position-relative">
															<input type="text" class="form-control" placeholder="NIP" id="email-id-icon" v-model="form.field.nip" />
															<div class="form-control-icon">
																<i class="bi bi-card-text"></i>
															</div>
														</div>
														<ErrorMessage name="nip" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
													</div>
												</div>
												<div class="col-12">
													<div class="form-group has-icon-left">
														<label for="first-name-icon">Nama</label>
														<div class="position-relative">
															<input type="text" class="form-control" placeholder="Nama" id="first-name-icon" v-model="form.field.name" />
															<div class="form-control-icon">
																<i class="bi bi-person"></i>
															</div>
														</div>
														<ErrorMessage name="name" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
													</div>
												</div>
												<div class="col-12">
													<div class="form-group has-icon-left">
														<label for="mobile-id-icon">Jabatan</label>
														<div class="position-relative">
															<input type="text" class="form-control" placeholder="Jabatan" id="mobile-id-icon" v-model="form.field.position" />
															<div class="form-control-icon">
																<i class="bi bi-person-vcard"></i>
															</div>
														</div>
														<ErrorMessage name="position" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
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
        </div>
    </section>
</template>

<script>
import { Form as VeeForm, Field, ErrorMessage } from 'vee-validate'

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
					nip: '',
					name: '',
					position: ''
				}
            },
			errors: {}
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
            ajax: "/master/library-officer-mst",
            columns: [
                { data: "nip" },
                { data: "name" },
                { data: "position" }
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
            this.clearForm()
        },

        edit() {
			if (this.selected.length > 0) {
                this.form.new	= false
                this.form.edit	= true
                this.submitted 	= false

                this.form.field.id			= this.selected[0].id
                this.form.field.nip			= this.selected[0].nip
                this.form.field.name		= this.selected[0].name
                this.form.field.position	= this.selected[0].position
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

                        window.axios.delete('/master/library-officer-mst/'+ this.selected[0].id +'?menufn='+ this.$route.name)
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
				this.$refs.form.setErrors({
					nip: [],
					name: [],
					position: []
				});

                this.$refs.form.validate().then(result => {
                    if(result.valid) {
                        this.form.submitted = false;

                        let loader = this.$loading.show();
                        if(this.form.new) {
                            let form_data = new FormData();
                            Object.keys(this.form.field).forEach(value => {
                                form_data.append(value, this.form.field[value]);
                            });
                            
                            window.axios.post('/master/library-officer-mst?menu_fn='+ this.$route.name, form_data)
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

                            window.axios.post('/master/library-officer-mst/'+ this.form.field.id +'?menu_fn='+ this.$route.name, form_data)
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
            table.ajax.reload(null, false)
        },

		clearForm() {
            this.form.field.id			= ''
            this.form.field.nip			= ''
            this.form.field.name		= ''
            this.form.field.position	= ''

			this.$refs.form.setErrors({
				nip: [],
				name: [],
				position: []
			})
			this.$refs.form.resetForm()
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
