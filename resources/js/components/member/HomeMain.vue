<template>
    <div class="page-heading">
        <!-- <template v-if="isAuthenticated"> -->
            <section class="row mb-4">
                <div class="col-12 col-lg-12">
                    <div class="row">
                        <div class="col-12">
                            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <template v-if="banner.length>0">
                                        <div v-for="(item, index) in banner" :key="index" :class="['carousel-item', { 'active': index === 0 }]">
                                            <img :src="item.image" class="d-block w-100" :alt="item.alt">
                                        </div>
                                    </template>
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="row">
                <div class="col-12 col-lg-9">
                    <div class="row">
                        <div class="divider divider-left-center">
                            <h2>Buku Terpopuler</h2>
                        </div>
                        <div class="col-12">
                            <div v-for="(group, groupIndex) in groupedBukuPopuler" :key="groupIndex" class="row">
                                <div v-for="buku in group" :key="buku.id" class="col-md-3 col-6">
                                    <div class="card" style="max-height: 330px;">
                                        <div class="card-content">
                                            <div class="product-image">
                                                <img :src="buku.image" :alt="buku.alt" class="img-fluid">
                                            </div>
                                            <div class="card-body py-2">
                                                <a href="#">
                                                    <h7 class="card-title" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" :title="buku.title">{{ buku.title }}</h7>
                                                </a>
                                            </div>
                                        </div>
                                        <!-- <div class="d-flex justify-content-between mb-3 px-1">
                                            <button class="btn btn-outline-primary mx-auto" @click="bacaBuku">Baca</button>
                                            <template v-if="isAuthenticated">
                                                <button class="btn btn-outline-warning mx-auto">Pinjam</button>
                                            </template>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-3">
                    <div class="card" style="height: 758px; max-height: 758px;">
                        <div class="card-body overflow-auto">
                            <div class="row mb-3">
                                <div class="comment">
                                    <div class="comment-header">
                                        <div class="comment-message">
                                            <p class="mx-auto">
                                                Terkadang saat kamu berada di tempatyang gelap, kamu mengira kamu terkubur. Tapi sebenarnya kamu sedang ditanam
                                            </p>
                                            <p><b><i>Christine Caine</i></b> </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="row">
                <div class="col-12 col-lg-12">
                    <div class="card">
                        <div class="row mb</div>-2 py-0 px-0 mx-0 my-0">
                            <div class="divider divider-left-center">
                                <h2>Koleksi Buku</h2>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <swiper
                                        :modules="modules"
                                        :slides-per-view="6"
                                        :space-between="0"
                                        :breakpoints="swiperBreakpoints"
                                        navigation
                                        :scrollbar="{ draggable: true }"
                                        @swiper="onSwiper"
                                        @slideChange="onSlideChange"
                                        class="swiper-container">
                                        <swiper-slide v-for="(item, index) in buku" :key="index" class="col-md-3 col-6">
                                            <div class="card">
                                                <div class="product-image">
                                                    <img :src="item.image" class="img-fluid" :alt="item.alt">
                                                </div>
                                                <div class="card-body py-2">
                                                    <a href="#">
                                                        <h7 class="card-title" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" :title="item.title">{{ item.title }}</h7>
                                                    </a>
                                                </div>
                                            </div>
                                        </swiper-slide>
                                    </swiper>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="row">
                <div class="col-12 col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h4>Perspektif</h4>
                        </div>
                        <div class="card-body">

                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <h4>Resensi Buku</h4>
                        </div>
                        <div class="card-body">

                        </div>
                    </div>
                </div>
            </section>
        <!-- </template> -->
    </div>
</template>

<style>
.swiper-scrollbar {
  display: none;
}

.swiper-container:hover .swiper-scrollbar {
  display: block;
  opacity: 0; /* Make it invisible while still being interactive */
}

.custom-swiper-slide {
  max-width: 100%; /* Pastikan tidak melebihi lebar kontainer */
}

@media (max-width: 767px) {
  .carousel-inner #carousel-item > div {
    display: none;
  }
  .carousel-inner #carousel-item > div:first-child {
    display: block;
  }
  .carousel-inner .carousel-item-end.active,
  .carousel-inner .carousel-item-next {
    transform: translateX(25%);
  }
  .carousel-inner .carousel-item-start.active,
  .carousel-inner .carousel-item-prev {
    transform: translateX(-25%);
  }
}
.carousel-inner .carousel-item.active,
.carousel-inner .carousel-item-next,
.carousel-inner .carousel-item-prev {
  display: flex;
}
@media (min-width: 768px) {
  .carousel-inner .carousel-item-end.active,
  .carousel-inner .carousel-item-next {
    transform: translateX(25%);
  }
  .carousel-inner .carousel-item-start.active,
  .carousel-inner .carousel-item-prev {
    transform: translateX(-25%);
  }
}
.carousel-inner .carousel-item-end,
.carousel-inner .carousel-item-start {
  transform: translateX(0);
}

    .content-wrapper {
        margin-top: 155px;
    }
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

        .content-wrapper {
            margin-top: 100px;
        }
    }
</style>

<script>
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Navigation, Pagination, Scrollbar, A11y } from 'swiper/modules';
import 'swiper/scss';
import 'swiper/scss/navigation';
import 'swiper/scss/pagination';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/scrollbar';

export default {
    components: {
        Swiper,
        SwiperSlide
    },
    props: {
        isAuthenticated: {
            type: Boolean,
            required: true
        }
    },
    setup() {
        const onSwiper = (swiper) => {
            console.log(swiper);
        };
        const onSlideChange = () => {
            console.log('slide change');
        };
        return {
            onSwiper,
            onSlideChange,
            modules: [Navigation, Pagination, Scrollbar, A11y],
        };
    },

    data() {
        return {
            banner: [
                { 
                    image: 'images/banner/banner1.jpg',
                    alt: 'banner1'
                },
                { 
                    image: 'images/banner/banner2.jpg',
                    alt: 'banner2'
                },
                { 
                    image: 'images/banner/banner3.jpg',
                    alt: 'banner3'
                }
            ],
            buku_populer: [],
            buku: [],
            swiperBreakpoints: {
                320: {
                    slidesPerView: 2,
                    spaceBetween: 10
                },
                640: {
                    slidesPerView: 2,
                    spaceBetween: 10
                },
                768: {
                    slidesPerView: 4,
                    spaceBetween: 10
                },
                1024: {
                    slidesPerView: 6,
                    spaceBetween: 10
                }
            }
        };
    },

    mounted() {
        this.getBukuPopuler();
        this.getBuku();
    },

    methods: {
        addCarouselClones() {
            this.$nextTick(() => {
                let items = document.querySelectorAll('#recipeCarousel #carousel-item-b');

                items.forEach((el) => {
                    const minPerSlide = 5;
                    let next = el.nextElementSibling
                    for (var i=1; i<minPerSlide; i++) {
                        if (!next) {
                            // wrap carousel by using first child
                            next = items[0]
                        }
                        let cloneChild = next.cloneNode(true)
                        el.appendChild(cloneChild.children[0])
                        next = next.nextElementSibling
                    }
                });
            });
        },
        bacaBuku(){
            if(!this.isAuthenticated){
                this.$router.push('/mlogin');
            }else{
                alert('sudah login');
            }
        },

        async getBukuPopuler() {
            this.buku_populer = [];

            window.axios
            .get('/getBukuPopuler')
            .then((response) => {
                this.buku_populer = response.data;
            })
            .catch((e) => {
                console.error(e)
            });
        },
        
        async getBuku() {
            this.buku = [];

            window.axios
            .get('/getBuku')
            .then((response) => {
                this.buku = response.data;
                
                this.addCarouselClones();
            })
            .catch((e) => {
                console.error(e)
            });
        },
    },

    computed:{
        groupedBukuPopuler() {
            const chunkSize = 4;
            const grouped = [];

            for (let i = 0; i < this.buku_populer.length; i += chunkSize) {
                grouped.push(this.buku_populer.slice(i, i + chunkSize));
            }

            return grouped;
        }
    }
};
</script>