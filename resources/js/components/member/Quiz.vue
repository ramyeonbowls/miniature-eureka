<template>
    <div class="page-content">
		<div class="col-12">
			<div v-if="quizs <= 0" class="row">
				<div class="card" style="height: 400px;">
					<p></p>
					<div class="card-content d-flex flex-column text-center">
						<h1>Tidak Ada Kuis</h1>
					</div>
				</div>
			</div>
			<div v-else class="row">
				<div v-for="(data, i) in quizs" :key="i" class="col-12 col-lg-4 mb-2 mt-2">
					<router-link :to="{ name: 'quiz-test', params: { ids: data.id } }">
						<div class="card h-100 mb-0 hover-shadow">
							<div class="card-content d-flex flex-column">
								<div class="card-body">
									<div class="card-title">
										<a href="#">
											<h5 data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" :title="data.title">
												{{ data.title }}
											</h5>
										</a>
									</div>
									<div class="card-subtitle d-flex justify-content-between align-items-center">
										<small class="text-muted text-start">Berlaku Sampai <strong>{{ data.end_date }}</strong></small>
										<template v-if="data.finished">
											<small class="text-muted text-right"><i class="bi bi-check-circle-fill text-success"></i></small>
										</template>
									</div>
								</div>
							</div>
						</div>
					</router-link>
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
        };
    },

    mounted() {
        this.getQuiz();
    },

    methods: {
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
    },

    computed: {

    },
};
</script>

<style>
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