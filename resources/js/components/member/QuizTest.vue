<template>
    <div class="page-content">
		<div class="row">
			<div class="card">
				<div class="card-content d-flex flex-column">
					<div class="card-header">
						<h4 class="card-title">{{ header.title }}</h4>
						<template v-if="finished">
							<h6 class="card-subtitle">Nilai anda : {{ nilai }}</h6>
						</template>
					</div>
					<div class="card-body">
						<template v-if="finished">
							<div v-for="(data, i) in question" :key="i" class="row">
								<div class="col-12 mb-2 mt-2">
									{{ i + 1 }}. {{ data.description }}
									<div v-if="data.type === 'checklist'">
										<div v-for="(ans, ii) in data.answer" :key="ans.id">
											<div class="form-check">
												<input type="checkbox" :value="ans.id" class="form-check-input" checked disabled>
												<label :for="data.id + '.' + ans.id">
													{{ ans.description }}
												</label>
											</div>
										</div>
									</div>
									<div v-if="data.type === 'multiple'">
										<div v-for="(ans, ii) in data.answer" :key="ans.id">
											<div class="form-check">
												<input class="form-check-input" type="radio" :id="data.id + '.' + ans.id" :name="data.id" :value="ans.id" checked disabled>
												<label class="form-check-label" :for="data.id + '.' + ans.id">
													{{ ans.description }}
												</label>
											</div>
										</div>
									</div>
									<div v-if="data.type === 'essay'">
										<div v-for="(ans, ii) in data.answer" :key="ans.id">
											<div class="form-group with-title mb-3">
												<textarea class="form-control" :id="data.id" rows="3" :value="ans.id" disabled>
												</textarea>
												<label>Your Answer</label>
											</div>
										</div>
									</div>
								</div>
							</div>
						</template>
						<template v-else>
							<div v-for="(data, i) in question" :key="i" class="row">
								<div class="col-12 mb-2 mt-2">
									{{ i + 1 }}. {{ data.description }}
									<div v-if="data.type === 'checklist'">
										<div v-for="(ans, ii) in data.answer" :key="ans.id">
											<div class="form-check">
												<input type="checkbox" :id="data.id + '.' + ans.id" v-model="ans.checked" @change="updateChecklist(data.id, ans.id)" :value="ans.id" class="form-check-input" required>
												<label :for="data.id + '.' + ans.id">
													{{ ans.description }}
												</label>
											</div>
										</div>
									</div>
									<div v-if="data.type === 'multiple'">
										<div v-for="(ans, ii) in data.answer" :key="ans.id">
											<div class="form-check">
												<input class="form-check-input" type="radio" :id="data.id + '.' + ans.id" :name="data.id" v-model="selectedMultipleAnswer[data.id]" :value="ans.id" required>
												<label class="form-check-label" :for="data.id + '.' + ans.id">
													{{ ans.description }}
												</label>
											</div>
										</div>
									</div>
									<div v-if="data.type === 'essay'">
										<div class="form-group with-title mb-3">
											<textarea class="form-control" :id="data.id" rows="3" v-model="selectedEssayAnswer[data.id]" required>
											</textarea>
											<label>Your Answer</label>
										</div>
									</div>
								</div>
							</div>
						</template>
                    </div>
					<template v-if="!finished">
						<div class="card-footer">
							<div class="col-md-12">
								<div class="form-group my-2 d-flex justify-content-end">
									<button type="submit" class="btn btn-primary" @click="SetAnswer">Simpan Jawaban</button>
								</div>
							</div>
						</div>
					</template>
				</div>
			</div>
		</div>
    </div>
</template>

<script>

export default {
    props: {
        isAuthenticated: {
            type: Boolean,
            required: true
        }
    },

    data() {
        return {
            header: [],
            question: [],
            finished: false,
            nilai: 0,
			form:{
				field:{
					id:'',
					answers: [],
				}
			},
            selectedMultipleAnswer: {},
            selectedEssayAnswer: {} 
        };
    },

    mounted() {
        this.form.field.id = this.$route.params.ids;
		this.getDetailQuiz()
    },

    methods: {
        async getDetailQuiz(){
            try {
                let loader = this.$loading.show();
                axios.get('/getDetailQuiz', {
                    params:{
                        id: this.form.field.id
                    }
                })
                .then((response) => {
                    this.question	= response.data.questions;
                    this.header		= response.data.header[0];
                    this.finished	= response.data.finished;
                    this.nilai		= response.data.nilai;

					this.answer = this.question.map(q => ({
						questionId: q.id,
						type: q.type,
						questionPoint: q.point,
						selectedAnswer: q.type === 'checklist' ? [] : null,
						answerPoint: 0
					}));

                    loader.hide();
                })
                .catch((e) => {
                    loader.hide();
					if(e.response.status === 403){
						this.$swal({
							title: e.response.data.message,
							text: "Silahkan verifikasi email, jika klik Kirim Email jika ingin kirim ulang email verifikasi",
							icon: 'warning',
							showCancelButton: true,
							confirmButtonText: 'Kirim Email',
							cancelButtonText: 'Tutup'
						})
						.then(async (result) => {
							
							if (result.isConfirmed) {
								try {
									// Send a request to resend the verification email
									const response = await window.axios.post('/email/resend');
									this.$swal({
										title: 'Email Terkirim!',
										text: response.data.message,
										icon: 'success'
									});
								} catch (error) {
									// Handle error if the resend fails
									this.$swal({
										title: 'Gagal!',
										text: error.response.data.message || 'Terjadi kesalahan saat mengirim email.',
										icon: 'error'
									});
								}
							} else {
								window.location = '/quiz'
							}
						});
					} else {
						console.error(e.message)
					}
                });
            } catch (e) {
                loader.hide();
                console.error(e);
            }
		},

		updateChecklist(questionId, answerId) {
            const answer = this.form.field.answers.find(a => a.questionId === questionId);
            if (!answer) {
                this.form.field.answers.push({
                    answerPoint: 10,
                    questionId: questionId,
                    questionPoint: 30,
                    selectedAnswer: answerId,
                    type: "checklist"
                });
            } else {
               
                const idx = this.form.field.answers.findIndex(a => a.questionId === questionId && a.selectedAnswer === answerId);
                if (idx >= 0) {
                    this.form.field.answers.splice(idx, 1);
                } else {
                    this.form.field.answers.push({
                        answerPoint: 10,
                        questionId: questionId,
                        questionPoint: 30,
                        selectedAnswer: answerId,
                        type: "checklist"
                    });
                }
            }
        },

		SetAnswer(){
			this.form.field.answers = [];
            this.question.forEach(q => {
                if (q.type === 'checklist') {
                    q.answer.forEach(ans => {
                        if (ans.checked) {
                            this.form.field.answers.push({
                                answerPoint: 10,
                                questionId: q.id,
                                questionPoint: q.point,
                                selectedAnswer: ans.id,
                                type: q.type
                            });
                        }
                    });
                } else if (q.type === 'multiple') {
                    const selectedAnswer = this.selectedMultipleAnswer[q.id];
                    if (selectedAnswer) {
                        this.form.field.answers.push({
                            answerPoint: 10,
                            questionId: q.id,
                            questionPoint: q.point,
                            selectedAnswer: selectedAnswer,
                            type: q.type
                        });
                    }
                } else if (q.type === 'essay') {
                    const selectedAnswer = this.selectedEssayAnswer[q.id];
                    this.form.field.answers.push({
                        answerPoint: selectedAnswer ? q.point : 0,
                        questionId: q.id,
                        questionPoint: q.point,
                        selectedAnswer: selectedAnswer || '',
                        type: q.type
                    });
                }
            });

            const isValid = this.validateAnswer()
			if (isValid) {
				let loader = this.$loading.show();
				window.axios.post('/setQuiz', this.form.field)
				.then((response) => {
					loader.hide();
					this.$swal({
						toast: true,
						icon: response.status === 201 ? 'success' : 'info',
						html: response.data,
						showConfirmButton: true,
    					confirmButtonText: 'OK',
					})
					.then((result) => {
						if (result.isConfirmed) {
							location.reload();
						}
					});
				})
				.catch((e) => {
					loader.hide();
					console.error(e.message)
					this.$swal({
						toast: true,
						icon: 'error',
						html: e.response.data,
						showConfirmButton: true,
    					confirmButtonText: 'OK',
					});
				});
			}else{
				this.$swal({
					toast: true,
					position: 'top',
					icon: 'info',
					html: 'Pastikan semua pertanyaan sudah terjawab !'
				});
			}
		},

		validateAnswer() {
            for (const data of this.question) {
                if (data.type === 'checklist') {
                    const isChecked = data.answer.some(ans => ans.checked);
                    if (!isChecked) return false;
                } else if (data.type === 'multiple') {
                    if (!this.selectedMultipleAnswer[data.id]) return false;
                } else if (data.type === 'essay') {
                    if (!this.selectedEssayAnswer[data.id]) return false;
                }
            }
            return true;
        },
    },
};
</script>