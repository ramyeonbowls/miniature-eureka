<template>
    <div class="page-content">
		<div class="col-12">
			<div v-if="quizs <= 0" class="row">
				<div class="card" style="height: 400px;">
					<p></p>
					<div class="card-content d-flex flex-column text-center">
						<h1 style="color: #1995ad;">Tidak Ada Quiz</h1>
					</div>
				</div>
			</div>
			<div v-else class="row">
				<div v-for="(data, i) in quizs" :key="i" class="col-12 col-lg-4 mb-2 mt-2">
					<div class="card hover-shadow">
						<div class="card-content d-flex flex-column">
							<div class="d-flex justify-content-center align-items-center flex-column mt-3 mb-0 mx-4 mb-0 py-1" style="height: 55px; max-height: 55px;" :title="data.title">
								<h6 style="color: #1995ad;" class="mb-0">{{ data.title }}</h6>
							</div>
							<hr>
							<div class="card-body-quiz" style="height: 125px;">
								<div class="card-description-quiz mx-4 mb-0 h-100" style="display: -webkit-box; line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" :title="data.description">
									{{ data.description }}
								</div>
							</div>
							<div class="row mx-2">
								<div class="col-12 text-center mb-2">
									<small class="text-muted"><i class="bi bi-calendar-check"></i> Tenggat Waktu : {{ data.start_date }} s/d {{ data.start_date }}</small>
								</div>
							</div>
							<div class="card-footer-quiz mb-1">
								<div class="row mx-2">
									<div class="card-date-quiz mb-1">
										<button :class="data.finished ? 'btn btn-success btn-block' : 'btn btn-primary btn-block'" @click="goToQuiz(data.id, data.finished)">{{ data.finished ? 'Lihat Nilai' : 'Lihat Quiz' }}</button>
									</div>
									<div class="card-author-quiz">
										<small class="text-muted"><i class="bi bi-person-circle"></i> <strong>{{ data.name }}</strong></small>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            quizs: [],
			param: {
				additional_features: 0
            },
        };
    },

    mounted() {
		this.getParam();
        this.getQuiz();
    },

    methods: {
		getParam() {
            this.param.additional_features = '';

            axios.get('/getParam')
            .then((response) => {
                this.param.additional_features = response.data.additional_features;

				if (this.param.additional_features!=2 && this.param.additional_features!=3) {
					this.$swal({
						title: "Access Denied",
						icon: 'error',
						allowOutsideClick: false,
						allowEscapeKey: false,
						showCloseButton: false,
						showCancelButton: false
					}).then((result) => {
						window.location.href = '/';
					});
				}
            })
            .catch((e) => {
                console.error(e)
            });
        },

		getQuiz() {
			let loader = this.$loading.show();
            this.quizs = [];

            axios.get('/getQuiz')
            .then((response) => {
				loader.hide();
                this.quizs = response.data
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
								window.location = '/'
							}
						});
					} else {
						console.error(e.message)
					}
            });
        },

		goToQuiz(id, finished) {
			if(finished){
				this.$router.push({ name: 'quiz-test', params: { ids: id } });
			}else{
				this.$swal({
					icon: 'question',
					text: 'Apakah anda yakin ingin memulai quiz ini?',
					showCancelButton: true,
					allowOutsideClick: false,
					allowEscapeKey: false,
					confirmButtonText: '<i class="bi bi-check-circle-fill"></i> Ya',
					cancelButtonText: '<i class="bi bi-x-square-fill"></i> Tidak',
					buttonsStyling: false,
					customClass: {
						confirmButton: 'btn btn-sm btn-primary me-2',
						cancelButton: 'btn btn-sm btn-secondary',
					},
				}).then((result) => {
					if (result.value) {
						this.$router.push({ name: 'quiz-test', params: { ids: id } });
					}
				})
			}
        }
    },

    computed: {

    },
};
</script>

<style scoped>
	.card-header-quiz {
		font-weight: bold;
		text-align: center;
	}

	.card-body-quiz {
		text-align: center;
	}

	.card-title-quiz {
		font-size: 18px;
		font-weight: bold;
		margin-bottom: 10px;
	}

	.card-description-quiz {
		text-align: left;
		margin-bottom: 10px;
	}

	.card-description-quiz p {
		margin: 0;
	}

	.button-quiz {
		display: inline-block;
		padding: 10px 20px;
		background-color: #4CAF50;
		color: white;
		text-align: center;
		text-decoration: none;  
		display: inline-block;
		font-size: 16px;
		margin: 4px 2px;
		cursor: pointer;
		border-radius: 4px;
	}

	.card-footer-quiz {
		text-align: center;
		font-size: 15px;
	}

	.card-author-quiz {
		font-weight: bold;
		margin-bottom: 5px;
	}

    .hover-scale {
        transition: all .05s ease-out;
        position: relative;
        transform-origin: center center;
    }
    .hover-scale:hover {
        transition: all .1s;
        transform: scale(1.025) !important;
    }
    .hover-shadow {
        transition: all .05s ease-out;
        box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
    }
    .hover-shadow:hover {
        transition: all .1s;
        box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
    }
    .hover-border {
        transition: all .05s ease-out;
        border: 2px solid transparent;
    }
    .hover-border:hover {
        transition: all .1s;
        border-color: #00afff
    }
    .hover-pointer:hover {
        cursor: pointer !important;
    }

    .hover-child-scale > .hover-target {
        transition: all .05s ease-out;
        position: relative;
        transform-origin: center center;
    }
    .hover-child-scale:hover > .hover-target {
        transition: all .1s;
        transform: scale(1.025) !important;
    }
    .hover-child-shadow > .hover-target {
        transition: all .05s ease-out;
        box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
    }
    .hover-child-shadow:hover > .hover-target {
        transition: all .1s;
        box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
    }
    .hover-child-border > .hover-target {
        transition: all .05s ease-out;
        border: 2px solid transparent;
    }
</style>