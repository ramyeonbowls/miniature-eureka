<template>
    <div class="page-heading">
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
                                                <h6 class="card-title" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" :title="buku.title">{{ buku.title }}</h6>
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
                <div class="divider divider-left-center">
                        <h2>Frasa</h2>
                    </div>
                <div class="card" style="height: 660px; max-height: 660px;">
                    <div class="card-body overflow-auto">
                        <div class="row mb-3">
                            <div v-for="(value, findex) in frasa" :key="findex" class="comment">
                                <div class="comment-header">
                                    <div class="comment-message">
                                        <p class="mx-auto">
                                            {{ value.kata }}
                                        </p>
                                        <p class="text-center"><b><i>{{ value.by }}</i></b> </p>
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
                                    class="swiper-container"
                                    loop
                                >
                                    <swiper-slide v-for="(item, index) in buku" :key="index" class="col-md-3 col-6">
                                        <div class="card">
                                            <div class="product-image">
                                                <img :src="item.image" class="img-fluid" :alt="item.alt">
                                            </div>
                                            <div class="card-body py-2">
                                                <a href="#">
                                                    <h6 class="card-title" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" :title="item.title">{{ item.title }}</h6>
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
            <div class="col-12 col-lg-12">
                <div class="divider divider-left-center">
                    <h2>Tajuk Utama</h2>
                </div>
                <div class="card">
                    <div class="row">
                        <div style="display: flex; align-items: center; justify-content: flex-end;" class="mt-2 px-5 py-3">
                            <a href="#">Lihat Semua</a>
                            <span class="line"></span>
                        </div>
                        <div class="col-md-6 my-auto mx-3">
                            <div class="panel blog-container">
                                <div class="panel-body pb-3">
                                    <div class="image-wrapper py-2 mb-3">
                                        <a class="image-wrapper" href="#">
                                            <img src="images/news/literasiday.png" alt="Photo of Blog" style="max-width: 650px; max-height: 210px;">
                                        </a>
                                    </div>
                                    <h5><a href="#">Merayakan Hari Literasi Internasional 2024: Menyongsong Masa Depan Melalui Kekuatan Membaca</a></h5>
                                    <small class="text-muted">By <a href="#"><strong> John Doe</strong></a> |  Post on Jan 8, 2013</small>
                                    <p class="m-top-sm m-bottom-sm mt-3">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam eros nibh, viverra a dui a, gravida varius velit. Nunc vel tempor nisi. Aenean id pellentesque mi, non placerat mi. Integer luctus accumsan tellus. Vivamus quis elit sit amet nibh lacinia suscipit eu quis purus. Vivamus tristique est non ipsum dapibus lacinia sed nec metus.
                                    </p>
                                    <a href="#"><i class="fa fa-angle-double-right"></i> Continue reading</a>
                                    <!-- <span class="post-like text-muted tooltip-test" data-toggle="tooltip" data-original-title="I like this post!">
                                        <i class="fa fa-heart"></i> <span class="like-count">25</span>
                                    </span> -->
                                </div>
                            </div>           
                        </div>
                        <div class="col-md-5 mx-3">
                            <div class="media popular-post py-2">
                                <a class="pull-left" href="#">
                                    <img src="images/samples/architecture1.jpg" alt="Photo of Blog" style="max-width: 150px; max-height: 150px;">
                                </a>
                                <div class="media-body">
                                    Merayakan Hari Literasi Internasional 2024: Menyongsong Masa Depan Melalui Kekuatan Membaca
                                </div>
                            </div>
                            <div class="media popular-post py-2">
                                <a class="pull-left" href="#">
                                    <img src="images/samples/motorcycle.jpg" alt="Photo of Blog" style="max-width: 150px; max-height: 150px;">
                                </a>
                                <div class="media-body">
                                    Kampus Terbaik Dunia: Universitas-Inovasi yang Mendorong Masa Depan Pendidikan
                                </div>
                            </div>
                            <div class="media popular-post py-2">
                                <a class="pull-left" href="#">
                                    <img src="images/samples/architecture1.jpg" alt="Photo of Blog" style="max-width: 150px; max-height: 150px;">
                                </a>
                                <div class="media-body">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<style>
    .image-wrapper {
        position: relative;
        display: block;
        overflow: hidden;
    }

    .blog-container a:not(.btn) {
        color: #999;
        transition: all .2s linear;
        -webkit-transition: all .2s linear;
        -moz-transition: all .2s linear;
        -ms-transition: all .2s linear;
        -o-transition: all .2s linear;
    }

    .image-wrapper img {
        transition: all .4s ease;
        -webkit-transition: all .4s ease;
        -moz-transition: all .4s ease;
        -ms-transition: all .4s ease;
        -o-transition: all .4s ease;
    }

    .post-like {
        float: right;
        cursor: pointer;
    }

    .headline {
        margin: 20px 0;
        padding: 5px 0 10px;
        border-bottom: 1px solid #eee;
        font-weight: 500;
    }
    .media, .media-body {
        overflow: hidden;
        zoom: 1;
    }
    .swiper-scrollbar {
        display: none;
    }

    .swiper-container:hover .swiper-scrollbar {
        display: block;
        opacity: 0;
    }

    .custom-swiper-slide {
        max-width: 100%;
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
    }
</style>

<script>
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Navigation, Pagination, Scrollbar, A11y } from 'swiper/modules';
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
            // console.log(swiper);
        };
        const onSlideChange = () => {
            // console.log('slide change');
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
                    image: 'images/banner/banner1.png',
                    alt: 'banner1'
                },
                { 
                    image: 'images/banner/banner2.png',
                    alt: 'banner2'
                },
                { 
                    image: 'images/banner/banner3.png',
                    alt: 'banner3'
                }
            ],
            buku_populer: [],
            buku: [],
            frasa: [
                {kata: "Literasi bukan hanya tentang membaca dan menulis, tetapi tentang memahami dan menciptakan dunia di sekitar kita.", by: "Anonim"},
                {kata: "Membaca adalah kunci untuk membuka pintu pengetahuan dan kemungkinan yang tak terbatas. Setiap buku adalah jendela ke dunia baru.", by: "Oprah Winfrey"},
                {kata: "Budaya literasi adalah fondasi untuk masa depan yang cerdas dan berdaya. Dalam setiap kata yang kita baca, kita membangun dunia yang lebih baik.", by: "Anonim"},
                {kata: "Literasi adalah alat yang memberdayakan individu untuk mengejar impian mereka dan berkontribusi pada masyarakat. Semakin kita membaca, semakin besar kapasitas kita untuk bertindak.", by: "Nelson Mandela"},
                {kata: "Setiap buku yang dibaca adalah sebuah petualangan yang dimulai. Budaya literasi adalah perjalanan tanpa akhir menuju pengetahuan dan pemahaman yang lebih dalam.", by: "Anonim"}
            ],
            news: [
                    {
                        "id": 1,
                        "title": "Berita Pertama",
                        "content": "Ini adalah konten berita pertama.",
                        "author": "Penulis 1",
                        "published_at": "2024-09-07T00:00:00Z"
                    },
                    {
                        "id": 2,
                        "title": "Berita Kedua",
                        "content": "Ini adalah konten berita kedua.",
                        "author": "Penulis 2",
                        "published_at": "2024-09-06T00:00:00Z"
                    },
                    {
                        "id": 3,
                        "title": "Berita Ketiga",
                        "content": "Ini adalah konten berita ketiga.",
                        "author": "Penulis 3",
                        "published_at": "2024-09-05T00:00:00Z"
                    },
                    {
                        "id": 4,
                        "title": "Berita Keempat",
                        "content": "Ini adalah konten berita keempat.",
                        "author": "Penulis 4",
                        "published_at": "2024-09-04T00:00:00Z"
                    }
            ],
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