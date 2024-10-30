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
                                                <th>Judul</th>
                                                <th>Dari</th>
                                                <th>Sampai</th>
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
                                    <div class="row">
                                        <div class="col-12">
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
																<Field type="text" id="title" v-model="form.field.title" class="form-control" placeholder="Tulis judul disini" name="title" />
																<ErrorMessage name="title" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
															</div>
															<div class="col-md-2">
																<label for="start_date">Tanggal Mulai <span class="text-danger">*</span></label>
															</div>
															<div class="col-md-4 form-group">
																<Field name="start_date">
																	<Flatpickr v-model="form.field.start_date" class="form-control flatpickr-range" :config="configsdate" placeholder="Pilih tanggal.."></Flatpickr>
																</Field>
																<ErrorMessage name="start_date" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
															</div>
															<div class="col-md-2">
																<label for="end_date">Tanggal Selesai <span class="text-danger">*</span></label>
															</div>
															<div class="col-md-4 form-group">
																<Field name="end_date">
																	<Flatpickr v-model="form.field.end_date" class="form-control flatpickr-range" :config="configedate" placeholder="Pilih tanggal.."></Flatpickr>
																</Field>
																<ErrorMessage name="end_date" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
															</div>

															<div class="col-md-12 mt-3">Menetapkan Pertanyaan dan Jawaban</div>
															<div class="col-md-12" v-for="(question, i) in form.field.questions" :key="i">
																<div class="px-2 py-1 border-bottom" :class="(i % 2 == 0) ? 'bg-body-lighter' : 'bg-body-light'">
																	<div class="row">
																		<div class="form-group mt-1 mb-0 col-md-1">
																			<label class="form-label mb-0"><small class="text-muted">ID</small></label>
																			<Field type="text" :name="'questions.'+i+'.id'" v-model="question.id" class="form-control form-control-sm" :placeholder="'ID = Q'+ (i+1)" :readonly="!question.editable" />
																			<div v-if="errors['questions.' + i + '.id']" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;">
																				<div v-for="(message, index) in errors['questions.' + i + '.id']" :key="index">{{ message }}</div>
																			</div>
																		</div>
																		<div class="form-group mt-1 mb-0 col-md-9">
																			<label class="form-label mb-0"><small class="text-muted">Pertanyaan</small></label>
																			<Field type="text" :name="'questions.'+i+'.description'" v-model="question.description" class="form-control form-control-sm" placeholder="Tulis pertanyaan disini" :title="question.description" />
																			<div v-if="errors['questions.' + i + '.description']" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;">
																				<div v-for="(message, index) in errors['questions.' + i + '.description']" :key="index">{{ message }}</div>
																			</div>
																		</div>
																		<div class="form-group mt-1 mb-0 col-md-2">
																			<label class="form-label mb-0"><small class="text-muted">Urutan</small></label>
																			<Field type="number" :name="'questions.'+i+'.template_sequence'" v-model.number="question.template_sequence" min="1" step="1" class="form-control form-control-sm" placeholder="Seq. template here" :title="question.template_sequence" />
																		</div>
																		<div class="form-group mt-1 mb-0 col-md-2">
																			<label class="form-label mb-0"><small class="text-muted">Tipe Jawaban</small></label>
																			<select :disabled="!question.editable" :name="'questions.'+i+'.type'" v-model="question.type" class="form-select form-select-sm" @change="changeType(question)">
																				<option value="">Pilih Tipe</option>
																				<option value="essay">Essai</option>
																				<!-- <option value="date">Date</option> -->
																				<option value="multiple">Pilihan Ganda</option>
																				<option value="checklist">Checklist</option>
																				<!-- <option value="rating">Rating</option>
																				<option value="ranking">Ranking</option> -->
																			</select>
																			<div v-if="errors['questions.' + i + '.type']" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;">
																				<div v-for="(message, index) in errors['questions.' + i + '.type']" :key="index">{{ message }}</div>
																			</div>
																		</div>
																		<div class="form-group mt-1 mb-0 col-md-2">
																			<label class="form-label mb-0"><small class="text-muted">Poin</small></label>
																			<div class="input-group">
																				<Field type="text" :name="'questions.'+i+'.point'" v-model.number="question.point" class="form-control form-control-sm" placeholder="Point" :disabled="question.type!= 'essay' ? true : false" />
																				<div class="input-group-append">
																					<template v-if="!question.flag_new">
																						<button type="button" class="btn btn-sm btn-danger ml-1" @click="delQuestion(question)">
																							<i class="bi bi-x-circle"></i>
																						</button>
																					</template>
																					<template v-if="question.flag_new">
																						<button type="button" class="btn btn-sm btn-primary ml-1" @click="addQuestion(question)">
																							<i class="bi bi-plus-circle"></i>
																						</button>
																						<button type="button" class="btn btn-sm btn-danger ml-1" @click="delQuestion(question)">
																							<i class="bi bi-x-circle"></i>
																						</button>
																					</template>
																				</div>
																			</div>
																		</div>
																	</div>

																	<div class="row mt-3">
																		<div class="col-lg-12 col-xl-12 px-4 py-2" v-if="question.type == 'multiple' || question.type == 'checklist' || question.type == 'ranking'">
																			<label class="pl-5">Answer Choice</label>
																			<template v-if="question.visible">
																				<div class="pl-5 py-1" v-for="(answer, ii) in question.answer" :key="ii">
																					<div class="row">
																						<div class="form-group mt-1 mb-0 col-md-6">
																							<label class="form-label mb-0"><small class="text-muted">Answer</small></label>
																							<div class="input-group input-group-sm">
																								<div class="input-group-append">
																									<span class="input-group-text text-sm">
																										{{ ((ii + 1) > 10) ? (ii + 1) : '0'+ (ii + 1) }}
																									</span>
																								</div>
																								<Field type="text" :name="'questions.'+i+'.answer.'+ii+'.description'" class="form-control form-control-sm" v-model="answer.description" placeholder="Write the answer here" />
																								<div v-if="errors['questions.'+i+'.answer.'+ii+'.description']" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;">
																									<div v-for="(message, index) in errors['questions.'+i+'.answer.'+ii+'.description']" :key="index">{{ message }}</div>
																								</div>
																							</div>
																						</div>
																						<div class="form-group my-1 col-md-2">
																							<label class="form-label mb-0"><small class="text-muted">Point</small></label>
																							<div class="input-group">
																								<Field type="text" :name="'questions.'+i+'.answer.'+ii+'.point'" class="form-control form-control-sm" v-model.number="answer.point" placeholder="Point" />
																								<div class="input-group-append">
																									<button v-if="!answer.flag_new" type="button" class="btn btn-sm btn-danger ml-1" @click="delAnswer(i, ii)">
																										<i class="bi bi-x-circle ml-1 mr-1"></i>
																									</button>
																									<button v-if="answer.flag_new" type="button" class="btn btn-sm btn-primary ml-1" @click="addAnswer(i, ii)">
																										<i class="bi bi-plus-circle ml-1 mr-1"></i>
																									</button>
																								</div>
																							</div>
																						</div>
																					</div>
																				</div>
																			</template>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</form>
											</VeeForm>
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

			configsdate: {
                dateFormat: 'Y-m-d',
                mode: 'single'
            },
			configedate: {
                dateFormat: 'Y-m-d',
                mode: 'single',
				minDate: null,
            },

            selected: [],
            form: {
                submitted: false,
                new: false,
                edit: false,
                field: {
                    id: '',
                    title: '',
                    start_date: '',
                    end_date: '',
                    questions: [],
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
            ajax: "/setting/quiz-mst",
            columns: [
                { data: "id" },
                { data: "title" },
                { data: "start_date" },
                { data: "end_date" },
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
            this.form.field.id				= ''
            this.form.field.title			= ''
            this.form.field.start_date		= ''
            this.form.field.end_date		= ''
			this.form.field.questions		= []
			this.errors						= {}
        },

        create() {
            this.form.new = true
            this.form.edit = false

            this.clearForm()
            this.form.field.id = uuidv4();
			this.newQuestion();
        },

        edit() {
            if (this.selected.length > 0) {
                this.form.new = false
                this.form.edit = true
                this.submitted = false

                this.form.field.id			= this.selected[0].id
                this.form.field.title		= this.selected[0].title
                this.form.field.start_date	= this.selected[0].start_date
                this.form.field.end_date	= this.selected[0].end_date

				this.getQuiz()
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

                        window.axios.delete('/setting/quiz-mst/'+ this.selected[0].id +'?menufn='+ this.$route.name)
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
                            window.axios.post('/setting/quiz-mst?menu_fn='+ this.$route.name, this.form.field)
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
                                        this.$refs.form.setErrors(e.response.data.errors)

										for (const [key, messages] of Object.entries(e.response.data.errors)) {
											this.errors[key] = messages
										}
                                    }
                                });
                        } else {
                            window.axios.put('/setting/quiz-mst/'+ this.form.field.id +'?menu_fn='+ this.$route.name, this.form.field)
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

		getQuiz(){
			let loader = this.$loading.show();

			window.axios.get('/setting/quiz-mst/'+ this.selected[0].id +'?menufn='+ this.$route.name)
            .then((response) => {
                loader.hide();

                if(response.data.questions.length > 0) {
                    this.form.field.questions = response.data.questions;
                } else {
                    this.newQuestion();
                }
            })
            .catch((e) => {
                loader.hide();
            });
		},

		newQuestion() {
            let self = this;

            self.form.field.questions.push({
                editable: true,
                id: '',
                description: '',
                template_sequence: 1,
                required: true,
                type: '',
                point: 0,
                flag_new: true,
                visible: true,
                answer: [{
                    description: '',
                    point: 0,
                    flag_new: true
                }]
            });
        },

        changeType(question) {
            let self = this;

            question.answer = [];
            if(question.type == 'multiple' || question.type == 'checklist' || question.type == 'ranking') {
                question.answer.push({
                    description: '',
                    point: 0,
                    flag_new: true
                });
            }
        },

        addQuestion(question) {
            let self = this;

            question.flag_new = false;
            let max_sequence = self.form.field.questions.length + 1;
            self.form.field.questions.push({
                editable: true,
                id: '',
                description: '',
                template_sequence: max_sequence,
                required: true,
                type: '',
                point: 0,
                flag_new: true,
                visible: true,
                answer: [{
                    description: '',
                    point: 0,
                    flag_new: true
                }]
            });
        },

        delQuestion(question) {
            let self = this;

            if(self.form.field.questions.length > 1) {
                if(self.selected.length > 0 && self.selected[0].survey_id) {
                    self.form.field.questions.splice(self.form.field.questions.indexOf(question), 1);

                    if(question.id != '') {
                        self.form.field.questions[(self.form.field.questions.length - 1)].flag_new = true;

                        return axios.delete('/survey-mst/'+ self.selected[0].survey_id +'?question_id='+ question.id);
                    }
                } else {
                    self.form.field.questions.splice(self.form.field.questions.indexOf(question), 1);
                }

                self.form.field.questions[(self.form.field.questions.length - 1)].flag_new = true;
            }
        },

        addAnswer(i, ii) {
            let self = this;

			self.form.field.questions[i].answer[ii].flag_new = true;
			self.form.field.questions[i].answer.push({
				description: '',
				point: 0,
				flag_new: false
			});
        },

        delAnswer(i, ii) {
            let self = this;

            if(self.selected.length > 0 && self.selected[0].survey_id) {
                let question_id = self.form.field.questions[i].id;
                let answer_id = self.form.field.questions[i].answer[ii].id;

                self.form.field.questions[i].answer.splice(ii, 1);

                if(question_id!='' && answer_id!='') {
                    return axios.delete('/survey-mst/'+ self.selected[0].survey_id +'?question_id='+ question_id +'&answer_id='+ answer_id);
                }
            } else {
                self.form.field.questions[i].answer.splice(ii, 1);
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
    },

	watch: {
        'form.field.start_date'(newStartDate) {
            if (newStartDate) {
                this.configedate.minDate = newStartDate;
            } else {
                this.configedate.minDate = null;
            }
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
