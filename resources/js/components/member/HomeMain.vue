<template>
    <div class="page-heading mb-0">
        <template v-if="banner.length>0">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-12">
                        <!-- Web Carousel -->
                <div id="webCarousel" class="carousel slide d-none d-xl-block d-lg-none" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div v-for="(item, index) in banner.filter(item => item.display === 'web')" 
                             :key="index" 
                             :class="['carousel-item', { 'active': index === 0 }]">
                            <img :src="item.image" class="d-block w-100" :alt="item.description" style="max-height: 500px;">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#webCarousel" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#webCarousel" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </a>
                </div>

                <!-- Mobile Carousel -->
                <div id="mobileCarousel" class="carousel slide d-block d-sm-block d-xl-none" data-bs-ride="carousel" v-if="banner.some(item => item.display === 'mobile')">
                    <div class="carousel-inner">
                        <div v-for="(item, index) in banner.filter(item => item.display === 'mobile')" 
                             :key="index" 
                             :class="['carousel-item', { 'active': index === 0 }]">
                            <img :src="item.image" class="d-block w-100" :alt="item.description" style="max-height: 400px;">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#mobileCarousel" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#mobileCarousel" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </a>
                </div>
                        <!-- <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div v-for="(item, index) in banner" :key="index" :class="['carousel-item', { 'active': index === 0 }]">
                                    <img :src="item.image" class="d-block w-100" :alt="item.descriptiion">
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </a>
                        </div> -->
                    </div>
                </div>
            </div>
        </template>
    </div>
    <div class="page-content">
        <section class="row mt-3">
            <div class="divider divider-left-center mb-0">
                <h2>BUKU POPULER</h2>
            </div>
            <div class="col-xl-3 d-none d-xl-block mb-0 mt-3">
                <div class="card h-100">
                    <div class="card-body background-populer">
                        &nbsp;
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-9">
                <div class="row row-cols-2 row-cols-md-4">
                    <div v-for="(buku, i) in buku_populer" :key="i" class="col mt-3">
                        <router-link :to="{ name: 'detail-buku', params: { idb: buku.isbn } }">
                            <div class="card h-100 mb-0 hover-shadow">
                                <div class="card-content">
                                    <div class="product-image mt-3 mb-0 pb-0">
                                        <img :src="buku.image" :alt="buku.alt" class="img-fluid">
                                    </div>
                                    <div class="card-body mt-0 mb-0 mx-0 px-2">
                                        <p class="card-title mb-0">{{ buku.writer }}</p>
                                        <a href="#">
                                        <div data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" :title="buku.title">{{ buku.title }}</div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </router-link>
                    </div>
                </div>
            </div>
        </section>
        <section class="row mt-4">
            <div class="col-12 col-lg-12">
                <div class="card hover-shadow">
                    <div class="row mb-3 px-3">
                        <div class="col-7 text-start pt-3 pe-0">
                            <h2>KOLEKSI BUKU</h2>
                        </div>
                        <div class="col-5 text-end pt-3">
                            <router-link to="/koleksi-buku" class='menu-link'>
                                <button class="btn btn-primary btn-sm">Lihat Semua</button>
                            </router-link>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
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
                                <swiper-slide v-for="(item, index) in buku" :key="index" class="col-md-3 col-6">
                                    <router-link :to="{ name: 'detail-buku', params: { idb: item.isbn } }">
                                        <div class="card">
                                            <div class="product-image">
                                                <img :src="item.image" class="img-fluid" :alt="item.alt">
                                            </div>
                                            <div class="card-body py-2">
                                                <p class="card-title mb-0">{{ item.writer }}</p>
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
        </section>
        <section v-if="news.length>0" class="row">
            <div class="col-12 col-lg-12">
                <div class="card py-2 px-4 hover-shadow">
                    <div class="row">
                        <div class="col-7 text-start pt-3 pe-0">
                            <h2>TAJUK UTAMA</h2>
                        </div>
                        <div class="col-5 text-end pt-3">
                            <router-link :to="{ name: 'artikel', params: { idart: 'TU' } }">
                                <button class="btn btn-primary btn-sm">Lihat Semua</button>
                            </router-link>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div v-if="mainNews" class="panel blog-container">
                                <router-link :to="{ name: 'detail-artikel', params: { idart: 'TU', detail: mainNews.id } }">
                                    <div class="panel-body mt-3">
                                        <div class="mb-3">
                                            <a href="#">
                                                <img :src="mainNews.image" :alt="mainNews.title" class="img-fluid rounded-3" alt="Photo of Blog">
                                            </a>
                                        </div>
                                        <a href="#">
                                            <h5 data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" :title="mainNews.title">
                                                {{ mainNews.title }}
                                            </h5>
                                        </a>
                                        <small class="text-muted">Oleh <strong>{{ mainNews.author }}</strong> | {{ mainNews.published_at }}</small>
                                        <p class="m-top-sm m-bottom-sm mt-2" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
                                            <span v-html="mainNews.content"></span>
                                        </p>
                                        <a href="#">
                                            <h6>Lanjutkan Membaca </h6>
                                        </a>
                                    </div>
                                </router-link>
                            </div>           
                        </div>
                        <div class="col-lg-6">
                            <div v-for="newsItem in otherNews" :key="newsItem.id">
                                <router-link :to="{ name: 'detail-artikel', params: { idart: 'TU', detail: newsItem.id } }" class="media popular-post mt-0 mb-0" style="height: 150px; max-height: 150px;">
                                    <a class="pull-left" :href="'#' + newsItem.id">
                                        <img :src="newsItem.image" :alt="newsItem.title" class="rounded-3" style="max-width: 150px; max-height: 150px;">
                                    </a>
                                    <div class="media-body">
                                        <a :href="'#' + newsItem.id">
                                            <h6 class="card-title" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" :title="newsItem.title">
                                                {{ newsItem.title }}
                                            </h6>
                                        </a>
                                    </div>
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section  v-if="frasa.length>0" class="row">
            <div class="col-12 col-lg-12">
                <div class="testimonial-slider hover-shadow">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="testimonial-title">
                                <i class="bi bi-quote display-2"></i>
                                <h2 class="fw-bold display-6 text-white">FRASA</h2>
                            </div>
                            <div class="d-flex justify-content-center mt-2 mb-3">
                                <button class="swiper-button-prev-frasa btn rounded-pill me-2"><i class="bi bi-caret-left-fill" style="font-size: 2rem; color: white;"></i></button>
                                <button class="swiper-button-next-frasa btn rounded-pill"><i class="bi bi-caret-right-fill" style="font-size: 2rem; color: white;"></i></button>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <swiper
                                ref="swiperFrasa"
                                :modules="modules"
                                :slides-per-view="2"
                                :space-between="10"
                                :breakpoints="swiperBreakpointsfrasa"
                                :navigation="navigationFrasa"
                                :scrollbar="{ draggable: true }"
                                @swiper="onSwiper"
                                @slideChange="onSlideChange"
                                :autoplay= "{ delay: 4000 }"
                                class="swiper-frasa col-md-10"
                                loop
                            >
                                <swiper-slide v-for="(value, index) in frasa" :key="index">
                                    <div class="card" style="height: 350px;">
                                        <div class="d-flex justify-content-center align-items-center flex-column mt-3">
                                            <div class="avatar">
                                                <img :src="value.image" style="height: 90px; width:90px;">
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">{{ value.by }}</h5>
                                            <p class="card-text">"{{ value.kata }}"</p>
                                        </div>
                                    </div>
                                </swiper-slide>
                            </swiper>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section v-if="wawasan.length>0" class="row mt-4">
            <div class="col-12 col-lg-12">
                <div class="row mb-3">
                    <div class="col-6 text-start pt-3">
                        <h2>WAWASAN</h2>
                    </div>
                    <div class="col-6 text-end pt-3">
                        <router-link :to="{ name: 'artikel', params: { idart: 'WA' } }">
                            <button class="btn btn-primary btn-sm">Lihat Semua</button>
                        </router-link>
                    </div>
                </div>
                <div class="row">
                    <swiper
                        :modules="modules"
                        :slides-per-view="2"
                        :space-between="20"
                        :breakpoints="swiperBreakpointswawasan"
                        navigation
                        :scrollbar="{ draggable: true }"
                        @swiper="onSwiper"
                        @slideChange="onSlideChange"
                        :autoplay= "{ delay: 4000 }"
                        class="swiper-container px-2"
                        loop
                    >
                        <swiper-slide v-for="(value, index) in wawasan" :key="index">
                            <router-link :to="{ name: 'detail-artikel', params: { idart: 'WA', detail: value.id } }">
                                <div class="card h-100 hover-shadow">
                                    <div class="img-wrapper">
                                        <img :src="value.image" class="d-block w-100 gambar-kotak" style="border-radius: 5px 5px 0 0 !important;">
                                    </div>
                                    <div class="card-body pb-0">
                                        <a href="#">
                                            <h5 data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" :title="value.title">
                                                {{ value.title }}
                                            </h5>
                                        </a>
                                        <p class="m-top-sm m-bottom-sm mt-2" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
                                            <span v-html="value.content"></span>
                                        </p>
                                        <a href="#">
                                            <h6>Lanjutkan Membaca </h6>
                                        </a>
                                    </div>
                                </div>
                            </router-link>
                        </swiper-slide>
                    </swiper>
                </div>
            </div>
        </section>
        <section v-if="review_buku.length>0" class="row mt-4">
            <div class="col-12 col-lg-12">
                <div class="row mb-3">
                    <div class="col-8 text-start pt-3">
                        <h2>REVIEW BUKU</h2>
                    </div>
                    <div class="col-4 text-end pt-3">
                        <router-link :to="{ name: 'artikel', params: { idart: 'RB' } }">
                            <button class="btn btn-primary btn-sm">Lihat Semua</button>
                        </router-link>
                    </div>
                </div>
                <div class="row">
                    <swiper
                        :modules="modules"
                        :slides-per-view="2"
                        :space-between="20"
                        :breakpoints="swiperBreakpointswawasan"
                        navigation
                        :scrollbar="{ draggable: true }"
                        @swiper="onSwiper"
                        @slideChange="onSlideChange"
                        :autoplay= "{ delay: 4000 }"
                        class="swiper-container px-2"
                        loop
                    >
                        <swiper-slide v-for="(value, index) in review_buku" :key="index">
                            <router-link :to="{ name: 'detail-artikel', params: { idart: 'RB', detail: value.id } }">
                                <div class="card h-100 hover-shadow">
                                    <div class="img-wrapper">
                                        <img :src="value.image" class="d-block w-100 gambar-kotak" style="border-radius: 5px 5px 0 0 !important;">
                                    </div>
                                    <div class="card-body pb-0">
                                        <a href="#">
                                            <h5 data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" :title="value.title">
                                                {{ value.title }}
                                            </h5>
                                        </a>
                                        <small class="text-muted">Oleh <strong> {{ value.author }}</strong></small>
                                        <p class="m-top-sm m-bottom-sm mt-2" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
                                            <span v-html="value.content"></span>
                                        </p>
                                        <a href="#">
                                            <h6>Lanjutkan Membaca </h6>
                                        </a>
                                    </div>
                                </div>
                            </router-link>
                        </swiper-slide>
                    </swiper>
                </div>
            </div>
        </section>
        <section v-if="layar_penulis.length>0" class="row mt-4">
            <div class="col-12 col-lg-12">
                <div class="row mb-3">
                    <div class="col-8 text-start pt-3">
                        <h2>LAYAR PENULIS</h2>
                    </div>
                    <div class="col-4 text-end pt-3">
                        <router-link :to="{ name: 'artikel', params: { idart: 'LP' } }">
                            <button class="btn btn-primary btn-sm">Lihat Semua</button>
                        </router-link>
                    </div>
                </div>
                <div class="row">
                    <swiper
                        :modules="modules"
                        :slides-per-view="3"
                        :space-between="10"
                        :breakpoints="swiperBreakpointlayarpenulis"
                        navigation
                        :scrollbar="{ draggable: true }"
                        @swiper="onSwiper"
                        @slideChange="onSlideChange"
                        :autoplay= "{ delay: 4000 }"
                        class="swiper-container px-2"
                        loop
                    >
                        <swiper-slide v-for="(value, index) in layar_penulis" :key="index">
                            <router-link :to="{ name: 'detail-artikel', params: { idart: 'LP', detail: value.id } }">
                                <div class="card h-100 hover-shadow">
                                    <div class="d-flex justify-content-center align-items-center flex-column mt-3">
                                        <div class="avatar">
                                            <img :src="value.image" style="height: 90px; width:90px;">
                                        </div>
                                    </div>
                                    <div class="card-body pb-0">
                                        <a href="#">
                                            <h5 data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" :title="value.title">
                                                {{ value.title }}
                                            </h5>
                                        </a>
                                        <p class="m-top-sm m-bottom-sm mt-2" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
                                            <span v-html="value.content"></span>
                                        </p>
                                        <a href="#">
                                            <h6>Lanjutkan Membaca </h6>
                                        </a>
                                    </div>
                                </div>
                            </router-link>
                        </swiper-slide>
                    </swiper>
                </div>
            </div>
        </section>
        <section v-if="titik_fokus.length>0" class="row mt-4">
            <div class="col-12 col-lg-12">
                <div class="row mb-3">
                    <div class="col-8 text-start pt-3">
                        <h2>TITIK FOKUS</h2>
                    </div>
                    <div class="col-4 text-end pt-3">
                        <router-link :to="{ name: 'artikel', params: { idart: 'TF' } }">
                            <button class="btn btn-primary btn-sm">Lihat Semua</button>
                        </router-link>
                    </div>
                </div>
                <div class="row">
                    <swiper
                        :modules="modules"
                        :slides-per-view="2"
                        :space-between="20"
                        :breakpoints="swiperBreakpointswawasan"
                        navigation
                        :scrollbar="{ draggable: true }"
                        @swiper="onSwiper"
                        @slideChange="onSlideChange"
                        :autoplay= "{ delay: 4000 }"
                        class="swiper-container px-2"
                        loop
                    >
                        <swiper-slide v-for="(value, index) in titik_fokus" :key="index">
                            <router-link :to="{ name: 'detail-artikel', params: { idart: 'TF', detail: value.id } }">
                                <div class="card h-100 hover-shadow">
                                    <div class="img-wrapper">
                                        <img :src="value.image" class="d-block w-100 gambar-kotak" style="border-radius: 5px 5px 0 0 !important;">
                                    </div>
                                    <div class="card-body pb-0">
                                        <a href="#">
                                            <h5 data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" :title="value.title">
                                                {{ value.title }}
                                            </h5>
                                        </a>
                                        <!-- <small class="text-muted">Oleh <strong> {{ value.author }}</strong></small> -->
                                        <p class="m-top-sm m-bottom-sm mt-2" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
                                            <span v-html="value.content"></span>
                                        </p>
                                        <a href="#">
                                            <h6>Lanjutkan Membaca </h6>
                                        </a>
                                    </div>
                                </div>
                            </router-link>
                        </swiper-slide>
                    </swiper>
                </div>
            </div>
        </section>
        <section v-if="humoria.length>0" class="row mt-4">
            <div class="col-12 col-lg-12">
                <div class="row mb-3">
                    <div class="col-8 text-start pt-3">
                        <h2>HUMORIA</h2>
                    </div>
                    <div class="col-4 text-end pt-3">
                        <router-link :to="{ name: 'artikel', params: { idart: 'HU' } }">
                            <button class="btn btn-primary btn-sm">Lihat Semua</button>
                        </router-link>
                    </div>
                </div>
                <div class="row">
                    <swiper
                        :modules="modules"
                        :slides-per-view="2"
                        :space-between="20"
                        :breakpoints="swiperBreakpointswawasan"
                        navigation
                        :scrollbar="{ draggable: true }"
                        @swiper="onSwiper"
                        @slideChange="onSlideChange"
                        :autoplay= "{ delay: 4000 }"
                        class="swiper-container px-2"
                        loop
                    >
                        <swiper-slide v-for="(value, index) in humoria" :key="index">
                            <router-link :to="{ name: 'detail-artikel', params: { idart: 'HU', detail: value.id } }">
                                <div class="card h-100 hover-shadow">
                                    <div class="img-wrapper">
                                        <img :src="value.image" class="d-block w-100 gambar-kotak" style="border-radius: 5px 5px 0 0 !important;">
                                    </div>
                                    <div class="card-body pb-0">
                                        <a href="#">
                                            <h5 data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" :title="value.title">
                                                {{ value.title }}
                                            </h5>
                                        </a>
                                        <!-- <small class="text-muted">Oleh <strong> {{ value.author }}</strong></small> -->
                                        <p class="m-top-sm m-bottom-sm mt-2" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
                                            <span v-html="value.content"></span>
                                        </p>
                                        <a href="#">
                                            <h6>Lanjutkan Membaca </h6>
                                        </a>
                                    </div>
                                </div>
                            </router-link>
                        </swiper-slide>
                    </swiper>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Navigation, Pagination, Scrollbar, A11y, Autoplay } from 'swiper/modules';
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
            modules: [Navigation, Pagination, Autoplay, Scrollbar, A11y],
        };
    },

    data() {
        return {
            banner: [],
            buku_populer: [],
            buku: [],
            news: [],
            frasa: [],
            wawasan: [],
            review_buku: [],
            layar_penulis: [],
            titik_fokus: [],
            humoria: [],
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
            swiperBreakpointsfrasa: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 10
                },
                640: {
                    slidesPerView: 1,
                    spaceBetween: 10
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 10
                },
                1024: {
                    slidesPerView: 2,
                    spaceBetween: 10
                }
            },
            navigationFrasa: {
                nextEl: '.swiper-button-next-frasa',
                prevEl: '.swiper-button-prev-frasa',
            },
            swiperBreakpointswawasan: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 20
                },
                640: {
                    slidesPerView: 1,
                    spaceBetween: 20
                },
                768: {
                    slidesPerView: 1,
                    spaceBetween: 20
                },
                1024: {
                    slidesPerView: 2,
                    spaceBetween: 20
                }
            },
            swiperBreakpointlayarpenulis: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 10
                },
                640: {
                    slidesPerView: 1,
                    spaceBetween: 10
                },
                768: {
                    slidesPerView: 1,
                    spaceBetween: 10
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 10
                }
            },
        };
    },

    created(){
        this.getBukuPopuler();
        this.getBook();
        this.getBanner();
        this.getAllArticle();
    },

    mounted() {
        
    },

    methods: {
        swiperPrev() {
            this.$refs.swiperFrasa.swiper.slidePrev();
        },

        swiperNext() {
            this.$refs.swiperFrasa.swiper.slideNext();
        },

        getBukuPopuler() {
            this.buku_populer = [];

            let loader = this.$loading.show();
            window.axios.get('/getBukuPopuler')
            .then((response) => {
                this.buku_populer = response.data;
                loader.hide();
            })
            .catch((e) => {
                console.error(e)
            });
        },

        getBook() {
            this.buku = [];

            window.axios
            .get('/getBook')
            .then((response) => {
                this.buku = response.data;
            })
            .catch((e) => {
                console.error(e)
            });
        },

        getBanner() {
            this.buku = [];

            window.axios
            .get('/getBanner')
            .then((response) => {
                this.banner = response.data;
            })
            .catch((e) => {
                console.error(e)
            });
        },
        
        getAllArticle() {
            this.frasa          = [];
            this.news           = [];
            this.wawasan        = [];
            this.review_buku    = [];
            this.layar_penulis  = [];
            this.titik_fokus    = [];
            this.humoria        = [];

            window.axios
            .get('/getAllArticle')
            .then((response) => {
                this.frasa          = response.data.FR;
                this.news           = response.data.TU;
                this.wawasan        = response.data.WA;
                this.review_buku    = response.data.RB;
                this.layar_penulis  = response.data.LP;
                this.titik_fokus    = response.data.TF;
                this.humoria        = response.data.HU;
            })
            .catch((e) => {
                console.error(e)
            });
        },
    },

    computed: {
        mainNews() {
            return this.news.length ? this.news[0] : null;
        },
        otherNews() {
            return this.news.slice(1);
        }
    }
};
</script>

<style scoped>
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

    .testimonial-slider {
        background-color: #fab040;
        padding: 2em 2em 0em;
        border-radius: 10px;
    }
    .testimonial-title {
        color: #fff;
    }
    .testimonial-title h2 {
        padding-left: 0.2em;
    }

    .background-populer {
        background-image: url('/images/logo/buku-populer.jpg');
        background-size: cover;
        background-position: center;
        border-radius: 10px;
        width: 100%;
    }

    .swiper-frasa .swiper-button-next,
    .swiper-frasa .swiper-button-prev {
        width: 25px;
        height: 25px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .swiper-frasa .swiper-button-next::after,
    .swiper-frasa .swiper-button-prev::after {
        font-size: 16px;
    }

    .blog-container a:not(.btn) {
        color: #999;
        transition: all .2s linear;
        -webkit-transition: all .2s linear;
        -moz-transition: all .2s linear;
        -ms-transition: all .2s linear;
        -o-transition: all .2s linear;
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
    
    .gambar-kotak {
        height: 300px;
    }

    @media (max-width: 1200px) {
        :deep(.swiper-button-next),
        :deep(.swiper-button-prev) {
            display: none;
        }

        .product-image {
            height: auto;
            padding: 10px;
        }

        .product-image img {
            width: 70%;
        }

        .card-title {
            font-size: 14px;
        }
        
        .buku-desc {
            font-size: 12px;
        }

        .gambar-kotak {
            height: auto;
        }
    }
</style>