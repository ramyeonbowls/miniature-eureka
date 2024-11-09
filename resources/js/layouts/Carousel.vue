<template>
    <Carousel :autoplay="2000" v-bind="settings" :breakpoints="breakpoints">
        <Slide v-for="slide in buku" :key="slide">
            <div class="carousel__item">
				<div class="card">
					<div class="card-content">
						<div class="product-image">
							<img :src="slide.image.replace('&amp;', '&')" :alt="slide.alt" class="img-fluid">
						</div>
						<div class="card-body">
							<p class="card-title mb-0">{{ slide.writer }}</p>
							<p class="card-title" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" :title="slide.title">{{ slide.title }}</p>
						</div>
					</div>
				</div>
			</div>
        </Slide>

		<template #addons>
			<Navigation />
		</template>
    </Carousel>
</template>

<script>
import { defineComponent } from 'vue'
import { Carousel, Navigation, Pagination, Slide } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'

export default defineComponent({
    name: 'Breakpoints',
    components: {
        Carousel,
		Slide,
		Pagination,
		Navigation,
    },

	data() {
		return {
			buku: [],
			settings: {
				itemsToShow: 1,
				snapAlign: 'center',
			},
			breakpoints: {
				700: {
					itemsToShow: 3.5,
					snapAlign: 'center',
				},
				1024: {
					itemsToShow: 5,
					snapAlign: 'start',
				},
			},
		}
	},

	mounted() {
		this.getBook()
	},
	
	methods: {
		getBook() {
            this.buku = [];

            window.axios
            .get('/dashboard/getKatalog')
            .then((response) => {
                this.buku = response.data;
            })
            .catch((e) => {
                console.error(e)
            });
        },
	},
})
</script>

<style scoped>
.product-card {
	width: 220px;
	border-radius: 10px;
	-webkit-box-shadow: 0px 0px 47px -20px rgba(0,0,0,1);
	-moz-box-shadow: 0px 0px 47px -20px rgba(0,0,0,1);
	box-shadow: 0px 0px 47px -20px rgba(0,0,0,1);
	margin: 60px 0;
	background-color: #fff;
	display: flex;
	flex-direction: column;
	align-items: center;
}

.product-image {
	height: 250px;
	overflow: hidden;
	position: relative;
	/* top: -20px; */
	padding: 10px;
	display: flex;
	justify-content: center;
	align-items: center;
}

.product-image img {
	width: 75%;
	object-fit: cover;
	transition: transform 0.5s;
	border-radius: 10px;
}

.product-image:hover img {
	transform: scale(1.1);
}

/* Media Queries untuk Mobile View */
@media (max-width: 500px) {
	.product-image {
		height: auto;
		padding: 10px;
	}

	.product-image img {
		width: 95%;
	}

	.card-title {
		font-size: 14px;
	}
}
</style>
