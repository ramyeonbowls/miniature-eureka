<template>
    <div class="page-content">
		<div class="col-12">
			<div class="row">
				<div  class="col-12 col-lg-4 mb-2 mt-2">
					<router-link :to="{ name: 'game-math' }">
						<div class="card h-100 mb-0 hover-shadow">
							<div class="card-content d-flex flex-column">
								<!-- <div class="product-image mb-0 pb-0">
									<img src="" class="img-fluid" style="border-radius: 5px 5px 0 0 !important;">
								</div> -->
								<div class="card-body">
									<div class="card-title">
										<a href="#">
											<h5> Game Perhitungan </h5>
										</a>
									</div>
									<p>
										<span>game untuk mengasah perhitungan</span>
									</p>
								</div>
							</div>
						</div>
					</router-link>
				</div>
				<div  class="col-12 col-lg-4 mb-2 mt-2">
					<router-link :to="{ name: 'word-scramble' }">
						<div class="card h-100 mb-0 hover-shadow">
							<div class="card-content d-flex flex-column">
								<!-- <div class="product-image mb-0 pb-0">
									<img src="" class="img-fluid" style="border-radius: 5px 5px 0 0 !important;">
								</div> -->
								<div class="card-body">
									<div class="card-title">
										<a href="#">
											<h5> Game Scramble Word </h5>
										</a>
									</div>
									<p>
										<span>game untuk mengasah kemampuan</span>
									</p>
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
    props: {
        isAuthenticated: {
            type: Boolean,
            required: true
        }
    },

    mounted() {
    },

    methods: {
        
    },

    computed: {
        
    },

    watch: {
        
    }
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