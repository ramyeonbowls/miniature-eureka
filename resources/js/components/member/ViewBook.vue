<template>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-4 mb-3">
                <div class="sticky-section">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="card-content text-center mb-2">
                                <img :src="detail.image" class="img-fluid" :alt="detail.title" height="80%" width="80%">
                            </div>
                            <div class="buttons">
                                <button class="btn btn-light-primary mr-2" @click="bacaBuku">Baca</button>
                                <template v-if="isAuthenticated">
                                    <button class="btn btn-light-primary ml-2">Pinjam</button>
                                </template>
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
                                    <div class="comment-time mt-0">2/2</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="comment-body">
                                    <div class="comment-profileName mb-0">Jumlah Halaman </div>
                                    <div class="comment-time mt-0">{{ detail.page }}</div>
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
                                    <div class="comment-profileName mb-0">Tahun Terbit </div>
                                    <div class="comment-time mt-0">{{ detail.year }}</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="comment-body">
                                    <div class="comment-profileName mb-0">Penerbit </div>
                                    <div class="comment-time mt-0">Elementa Agro Lestari</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="row mt-5">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="row mb-2 py-0 px-0 mx-0 my-0">
                        <div class="divider divider-left-center">
                            <h2>Buku Terpopuler</h2>
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
                                    <swiper-slide v-for="(item, index) in buku_populer" :key="index" class="col-md-3 col-6">
                                        <router-link :to="{ name: 'detail_buku', params: { idb: item.isbn } }">
                                            <div class="card">
                                                <div class="product-image">
                                                    <img :src="item.image" class="img-fluid" :alt="item.alt">
                                                </div>
                                                <div class="card-body py-2">
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
        </section>
    </div>
</template>

<style>
.sticky-section {
  position: sticky;
  top: 150px;
  text-align: -webkit-center;
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
        idb: {
            required:true
        },
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

    mounted() {
        this.idb = this.$route.params.idb;
        this.getBukuPopuler();
        this.getDetail();
    },

    methods: {
        toggleText() {
            this.isExpanded = !this.isExpanded;
        },

        bacaBuku(){
            if(!this.isAuthenticated){
                this.$router.push('/mlogin');
            }else{
                const routeData = this.$router.resolve({
                    name: 'appreader',
                    query: { pdfToken: encodeURIComponent(this.detail.filename) }
                });
                console.log('Route URL:', routeData.href);
                window.open(routeData.href, '_blank');
            }
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

        async getDetail() {
            try {
                axios.get('/getDetail', {
                    params:{
                        id: this.idb
                    }
                })
                .then((response) => {
                    this.detail = response.data;
                })
                .catch((e) => {
                    console.error(e);
                });
            } catch (e) {
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
            await this.getDetail();
            await this.getBukuPopuler();
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