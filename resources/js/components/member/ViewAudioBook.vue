<template>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-4 card-cover">
                <div class="sticky-section h-100">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="card-content text-center mb-2">
                                <img v-if="detail.image" :src="detail.image.replace('&amp;', '&')" class="img-fluid img-detail" :alt="detail.title" height="80%" width="80%" style="border-radius: 10px 10px 10px 10px !important;">
                            </div>
                            <div class="buttons mt-3" v-if="audioUrl == ''">
                                <button class="btn btn-primary btn-md me-2" @click="bacaBuku"><i class="bi bi-book-fill"></i> Putar</button>
                                <!-- <template v-if="isAuthenticated">
                                    <template v-if="detail.rent=='Y'">
                                        <button class="btn btn-warning text-white btn-md me-2" @click="kembaliBuku"><i class="bi bi-bookmarks"></i> Kembalikan</button>
                                    </template>
                                    <template v-else>
                                        <button class="btn btn-warning text-white btn-md me-2" @click="pinjamBuku"><i class="bi bi-bookmarks"></i> Pinjam</button>
                                    </template>
                                </template> -->
                            </div>
                            <div v-else>
                                <audio
                                    controls
                                    controlsList="nodownload"
                                    oncontextmenu="return false;"
                                    ref="audioPlayer"
                                    :src="audioUrl"
                                    autoplay
                                    class="w-full rounded border"
                                ></audio>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8">
                <div class="card h-100">
                    <div class="card-header">
                        <p class="text-subtitle text-muted">{{ detail.writer }}</p>
                        <h3 class="mt-1">{{ detail.title }}</h3>
                    </div>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" :class="{ active: activeTab === 'sinopsis' }" @click="scrollTo('sinopsis')" id="sinopsis-tab" type="button" role="tab" aria-controls="sinopsis" :aria-selected="activeTab === 'sinopsis'" >
                                Sinopsis
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" :class="{ active: activeTab === 'details' }" @click="scrollTo('details')" id="detail-tab" type="button" role="tab" aria-controls="details" :aria-selected="activeTab === 'details'" >
                                Detail
                            </button>
                        </li>
                    </ul>
                    <div class="card-body">
                        <div class="divider divider-left">
                            <div class="divider-text">Deskripsi Buku</div>
                        </div>
                        <p class="my-2 tab-pane" id="sinopsis">
                            <span v-if="!isExpanded">{{ truncatedText }}</span>
                            <span v-else>{{ detail.sinopsis }}</span>
                        </p>
                        <a v-if="needsReadMore" class="my-2 d-flex justify-content-end" role="button" id="toggleDescription" @click="toggleText"> {{ isExpanded ? 'Ringkas Deskripsi' : 'Baca Selengkapnya' }} </a>
                        <div class="divider divider-left">
                            <div class="divider-text">Detail</div>
                        </div>
                        <div class="row tab-pane details" id="details">
                            <div class="col-md-6 mb-1 mt-0">
                                <div class="form-group">
                                    <div class="comment-body">
                                    <div class="comment-profileName mb-0">Copy </div>
                                    <div class="comment-time mt-0">{{ detail.remaining }}/{{ detail.copy }}</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="comment-body">
                                    <div class="comment-profileName mb-0">Penerbit </div>
                                    <div class="comment-time mt-0">{{ detail.publisher }}</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="comment-body">
                                    <div class="comment-profileName mb-0">ISBN </div>
                                    <div class="comment-time mt-0">{{ detail.isbn }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-1 mt-0">
                                <div class="form-group">
                                    <div class="comment-body">
                                    <div class="comment-profileName mb-0">Penulis </div>
                                    <div class="comment-time mt-0">{{ detail.writer }}</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="comment-body">
                                    <div class="comment-profileName mb-0">Batas Umur </div>
                                    <div class="comment-time mt-0">{{ detail.age }} Tahun</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- <section class="row mt-4">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="row mb-2 py-0 px-0 mx-0 my-0">
                        <div class="divider divider-left-center">
                            <h2>BUKU TERPOPULER</h2>
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
                                    :autoplay= "{ delay: 3000 }"
                                    class="swiper-container"
                                    loop
                                >
                                    <swiper-slide v-for="(item, index) in buku_populer" :key="index" class="col-md-3 col-6">
                                        <router-link :to="{ name: 'detail-buku', params: { idb: item.isbn } }">
                                            <div class="card">
                                                <div class="product-image">
                                                    <img :src="item.image.replace('&amp;', '&')" class="img-fluid" :alt="item.alt" style="width: 150px; height: 220px;">
                                                </div>
                                                <div class="card-body py-2">
                                                    <p class="card-title mb-0">
                                                        <div data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" :title="item.writer">{{ item.writer }}</div>
                                                    </p>
                                                    <a href="#">
                                                        <h6 class="card-title" data-bs-toggle="tooltip" data-bs-placement="bottom" 
                                                        style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" 
                                                            :title="item.title">
                                                            {{ item.title }}
                                                        </h6>
                                                    </a>
                                                </div>
                                            </div>
                                        </router-link>
                                    </swiper-slide>
                                </swiper>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
    </div>
</template>

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
            idb: '',
            limit: 200,
            isExpanded: false,
            buku_populer: [],
            audioUrl: '',
            detail: {},
            activeTab: 'sinopsis',
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
            },
        };
    },

    created(){
        this.getBukuPopuler();
        this.initializeSubMenu();
    },

    mounted() {
        this.idb = this.$route.params.idb;
        this.getDetailAudioBook();
    },

    methods: {
        toggleText() {
            this.isExpanded = !this.isExpanded;
        },

        bacaBuku(){
            if(!this.isAuthenticated){
                this.$router.push('/mlogin');
            }else{
                let loader = this.$loading.show();
                window.axios
                .get('/ReadAudioCheck', {
                    params:{
                        pdfToken: encodeURIComponent(this.detail.book_id),
                        age: this.detail.age
                    }
                })
                .then((response) => {
                    loader.hide();
                    if(response.data.code == 1){
                        this.audioUrl = `/audiobook/stream?book_id=${this.detail.book_id}`;
                    }else{
                        this.$swal({
                            text: response.data.message,
                            icon: response.data.code=='2' ? 'warning' : 'error',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showCloseButton: false,
                            showCancelButton: false
                        });
                    }
                })
                .catch((e) => {
                    loader.hide();
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
                        }
                    });
                });
            }
        },

        pinjamBuku(){
            let loader = this.$loading.show();
            window.axios.post('/RentBook', {
                pdfToken: encodeURIComponent(this.detail.book_id),
                age: this.detail.age
            })
            .then((response) => {
                loader.hide();
                this.$swal({
                    text: response.data.message,
                    icon: response.data.code == 1 ? 'success' : 'warning',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showCloseButton: false,
                    showCancelButton: false
                }).then((result) => {
                    if(response.data.code == 1){
                        location.reload(); 
                    }
                });
            })
            .catch((e) => {
                loader.hide();

                if(e.response.data.message == 'Email anda belum terverifikasi.'){
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
                        }
                    });
                }else{
                    this.$swal({
                        text: 'Terjadi kesalahan saat pinjam buku, silahkan coba kembali',
                        icon: 'error',
                        showCancelButton: false
                    })
                }
                
            });
        },

        kembaliBuku(){
            let loader = this.$loading.show();
            window.axios.post('/ReturnBook', {
                pdfToken: encodeURIComponent(this.detail.book_id)
            })
            .then((response) => {
                loader.hide();
                this.$swal({
                    text: response.data.message,
                    icon: response.data.code == 1 ? 'success' : 'error',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showCloseButton: false,
                    showCancelButton: false
                }).then((result) => {
                    location.reload(); 
                });
            })
            .catch((e) => {
                loader.hide();
                this.$swal({
                    text: 'Terjadi kesalahan saat pinjam buku, silahkan coba kembali',
                    icon: 'error',
                    showCancelButton: false
                })
                
            });
        },

        getBukuPopuler() {
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

        async getDetailAudioBook() {
            try {
                let loader = this.$loading.show();
                axios.get('/getDetailAudioBook', {
                    params:{
                        id: this.idb
                    }
                })
                .then((response) => {
                    this.detail = response.data;
                    loader.hide();
                })
                .catch((e) => {
                    loader.hide();
                    console.error(e);
                });
            } catch (e) {
                loader.hide();
                console.error(e);
            }
        },

        scrollTo(sectionId) {
            const element = document.getElementById(sectionId);
            this.activeTab = sectionId;
            if (element) {
                const offsetTop = element.getBoundingClientRect().top + window.pageYOffset;
                window.scrollTo({
                top: offsetTop - 200,
                behavior: 'smooth'
                });
            }
        },

        async refreshData() {
            this.idb = this.$route.params.idb;
            await this.getDetailAudioBook();
            await this.getBukuPopuler();

            this.initializeSubMenu();
            this.activeTab = 'sinopsis';
			window.scrollTo({ top: 0, behavior: 'smooth' });
        },

        initializeSubMenu() {
            let submenus = document.querySelectorAll('.submenu-item')
    
            submenus.forEach((submenu) => {
                submenu.querySelector('.submenu-link').addEventListener('click', (e) => {
                    let navbar = document.querySelector('.main-navbar');
                    if (navbar.classList.contains('active')) {
                        navbar.classList.remove('active');
                    }
                    e.preventDefault()
                })
            })
        }
    },

    computed: {
        truncatedText() {
            if (this.detail.sinopsis) {
                return this.detail.sinopsis.length > this.limit ? this.detail.sinopsis.slice(0, this.limit) + '...' : this.detail.sinopsis;
            }
            return '';
        },
        needsReadMore() {
            return this.detail.sinopsis && this.detail.sinopsis.length > this.limit;
        }
    },

    watch: {
        '$route.params.idb': 'refreshData'
    }
};
</script>

<style scoped>
    .sticky-section {
        position: sticky;
        text-align: -webkit-center;
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
        max-height: 250px;
        overflow: hidden;
        position: relative;
        padding: 0px;
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

    :deep(.swiper-button-next),
    :deep(.swiper-button-prev) {
        width: 30px !important;
        height: 30px !important;
        background-color: rgba(255, 255, 255, 0.656);
        border-radius: 70%;
    }

    :deep(.swiper-button-next::after),
    :deep(.swiper-button-prev::after) {
        font-size: 20px !important;
        color: rgb(0, 0, 0) !important;
    }

    :deep(.swiper-button-next) {
        right: 10px;
    }

    :deep(.swiper-button-prev) {
        left: 10px;
    }

    @media (max-width: 1200px) {
        .card-cover {
            margin-bottom: 20px;
        }
        .img-detail {
            width: 70%;
        }

        .product-image {
            height: auto;
            padding: 10px;
        }

        .product-image img {
            width: 70%;
        }

        :deep(.swiper-button-next),
        :deep(.swiper-button-prev) {
            display: none;
        }
    }
</style>