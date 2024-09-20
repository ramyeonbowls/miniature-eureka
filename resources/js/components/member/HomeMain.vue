<template>
    <div class="page-heading mb-0">
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
    </div>
    <div class="page-content">
        <section class="row mt-3">
            <div class="divider divider-left-center mb-0">
                <h2>BUKU POPULER</h2>
            </div>
            <div class="col-xl-3 d-none d-xl-block mb-1 mt-3">
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
                            <div class="card h-100 mb-0">
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
                <div class="card">
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
            </div>
        </section>
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="card py-2 px-4">
                    <div class="row">
                        <div class="col-7 text-start pt-3 pe-0">
                            <h2>TAJUK UTAMA</h2>
                        </div>
                        <div class="col-5 text-end pt-3">
                            <button class="btn btn-primary btn-sm">Lihat Semua</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="panel blog-container">
                                <div class="panel-body mt-4">
                                    <div class="mb-3">
                                        <a href="#">
                                            <img src="images/news/literasiday.png" class="img-fluid rounded-3" alt="Photo of Blog">
                                        </a>
                                    </div>
                                    <a href="#">
                                        <h5 data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" title="Merayakan Hari Literasi Internasional 2024: Menyongsong Masa Depan Melalui Kekuatan Membaca">
                                            Merayakan Hari Literasi Internasional 2024: Menyongsong Masa Depan Melalui Kekuatan Membaca
                                        </h5>
                                    </a>
                                    <small class="text-muted">By <strong> Abdurrahman</strong> |  17 September 2024</small>
                                    <p class="m-top-sm m-bottom-sm mt-2">
                                        Pada 8 September 2024, dunia akan merayakan Hari Literasi Internasional, sebuah hari yang didedikasikan untuk merayakan pentingnya literasi dalam kehidupan kita dan mendorong upaya untuk meningkatkan tingkat literasi di seluruh dunia. Hari ini bukan hanya momen untuk menghargai kemampuan membaca dan menulis, tetapi juga kesempatan untuk merenungkan dampak positif yang dapat ditimbulkan oleh literasi terhadap individu dan masyarakat.
                                    </p>
                                    <a href="#">
                                        <i class="fa fa-angle-double-right"></i> <h6>Lanjutkan Membaca </h6>
                                    </a>
                                </div>
                            </div>           
                        </div>
                        <div class="col-lg-6">
                            <div class="media popular-post" style="height: 150px; max-height: 150px;">
                                <a class="pull-left" href="#">
                                    <img src="images/news/tajuk-utama3.jpg" alt="Photo of Blog" class="rounded-3" style="max-width: 150px; max-height: 150px;">
                                </a>
                                <div class="media-body">
                                    <a href="#">
                                        <h6 class="card-title" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" title="Revolusi Belajar: Sekolah Ramah Lingkungan Ciptakan Generasi Peduli Bumi">Revolusi Belajar: Sekolah Ramah Lingkungan Ciptakan Generasi Peduli Bumi</h6>
                                    </a>
                                </div>
                            </div>
                            <div class="media popular-post" style="height: 150px; max-height: 150px;">
                                <a class="pull-left" href="#">
                                    <img src="images/news/tajuk-utama2.jpg" alt="Photo of Blog" class="rounded-3" style="max-width: 150px; max-height: 150px;">
                                </a>
                                <div class="media-body">
                                    <a href="#">
                                        <h6 class="card-title" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" title="Perpustakaan Terapung Terbesar Berlabuh di Yordania">Perpustakaan Terapung Terbesar Berlabuh di Yordania</h6>
                                    </a>
                                </div>
                            </div>
                            <div class="media popular-post" style="height: 150px; max-height: 150px;">
                                <a class="pull-left" href="#">
                                    <img src="images/news/tajuk-utama1.jpg" alt="Photo of Blog" class="rounded-3" style="max-width: 150px; max-height: 150px;">
                                </a>
                                <div class="media-body">
                                    <a href="#">
                                        <h6 class="card-title" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" title="Kampus Terbaik Dunia: Universitas-Inovasi yang Mendorong Masa Depan Pendidikan">Kampus Terbaik Dunia: Universitas-Inovasi yang Mendorong Masa Depan Pendidikan</h6>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="testimonial-slider">
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
                                                <img src="/images/faces/1.jpg" style="height: 90px; width:90px;">
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
        <section class="row mt-4">
            <div class="col-12 col-lg-12">
                <div class="row mb-3">
                    <div class="col-6 text-start pt-3">
                        <h2>WAWASAN</h2>
                    </div>
                    <div class="col-6 text-end pt-3">
                        <button class="btn btn-primary btn-sm">Lihat Semua</button>
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
                        class="swiper-container"
                        loop
                    >
                        <swiper-slide v-for="(value, index) in wawasan" :key="index">
                            <div class="card h-100 px-2">
                                <div class="img-wrapper">
                                    <img :src="value.image" class="d-block w-100 gambar-kotak rounded-3">
                                </div>
                                <div class="card-body pb-0">
                                    <a href="#">
                                        <h5 data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" :title="value.title">
                                            {{ value.title }}
                                        </h5>
                                    </a>
                                    <!-- <small class="text-muted">By <strong> {{ value.author }}</strong> |  Post on {{ value.published_at }}</small> -->
                                    <p class="m-top-sm m-bottom-sm mt-2" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
                                        {{ value.content }}
                                    </p>
                                    <a href="#">
                                        <i class="fa fa-angle-double-right"></i> <h6>Lanjutkan Membaca </h6>
                                    </a>
                                </div>
                            </div>
                        </swiper-slide>
                    </swiper>
                </div>
            </div>
        </section>
        <section class="row mt-4">
            <div class="col-12 col-lg-12">
                <div class="row mb-3">
                    <div class="col-8 text-start pt-3">
                        <h2>REVIEW BUKU</h2>
                    </div>
                    <div class="col-4 text-end pt-3">
                        <button class="btn btn-primary btn-sm">Lihat Semua</button>
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
                        class="swiper-container"
                        loop
                    >
                        <swiper-slide v-for="(value, index) in review_buku" :key="index">
                            <div class="card h-100 px-2">
                                <div class="img-wrapper">
                                    <img :src="value.image" class="d-block w-100 gambar-kotak">
                                </div>
                                <div class="card-body pb-0">
                                    <a href="#">
                                        <h5 data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" :title="value.title">
                                            {{ value.title }}
                                        </h5>
                                    </a>
                                    <small class="text-muted">Oleh <strong> {{ value.author }}</strong></small>
                                    <p class="m-top-sm m-bottom-sm mt-2" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
                                        {{ value.content }}
                                    </p>
                                    <a href="#">
                                        <i class="fa fa-angle-double-right"></i> <h6>Lanjutkan Membaca </h6>
                                    </a>
                                </div>
                            </div>
                        </swiper-slide>
                    </swiper>
                </div>
            </div>
        </section>
        <section class="row mt-4">
            <div class="col-12 col-lg-12">
                <div class="row mb-3">
                    <div class="col-8 text-start pt-3">
                        <h2>LAYAR PENULIS</h2>
                    </div>
                    <div class="col-4 text-end pt-3">
                        <button class="btn btn-primary btn-sm">Lihat Semua</button>
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
                        class="swiper-container"
                        loop
                    >
                        <swiper-slide v-for="(value, index) in layar_penulis" :key="index">
                            <div class="card h-100 px-2">
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
                                        {{ value.content }}
                                    </p>
                                    <a href="#">
                                        <i class="fa fa-angle-double-right"></i> <h6>Lanjutkan Membaca </h6>
                                    </a>
                                </div>
                            </div>
                        </swiper-slide>
                    </swiper>
                </div>
            </div>
        </section>
        <section class="row mt-4">
            <div class="col-12 col-lg-12">
                <div class="row mb-3">
                    <div class="col-8 text-start pt-3">
                        <h2>TITIK FOKUS</h2>
                    </div>
                    <div class="col-4 text-end pt-3">
                        <button class="btn btn-primary btn-sm">Lihat Semua</button>
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
                        class="swiper-container"
                        loop
                    >
                        <swiper-slide v-for="(value, index) in titik_fokus" :key="index">
                            <div class="card h-100 px-2">
                                <div class="img-wrapper">
                                    <img :src="value.image" class="d-block w-100 gambar-kotak">
                                </div>
                                <div class="card-body pb-0">
                                    <a href="#">
                                        <h5 data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" :title="value.title">
                                            {{ value.title }}
                                        </h5>
                                    </a>
                                    <!-- <small class="text-muted">Oleh <strong> {{ value.author }}</strong></small> -->
                                    <p class="m-top-sm m-bottom-sm mt-2" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
                                        {{ value.content }}
                                    </p>
                                    <a href="#">
                                        <i class="fa fa-angle-double-right"></i> <h6>Lanjutkan Membaca </h6>
                                    </a>
                                </div>
                            </div>
                        </swiper-slide>
                    </swiper>
                </div>
            </div>
        </section>
        <section class="row mt-4">
            <div class="col-12 col-lg-12">
                <div class="row mb-3">
                    <div class="col-8 text-start pt-3">
                        <h2>HUMORIA</h2>
                    </div>
                    <div class="col-4 text-end pt-3">
                        <button class="btn btn-primary btn-sm">Lihat Semua</button>
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
                        class="swiper-container"
                        loop
                    >
                        <swiper-slide v-for="(value, index) in humoria" :key="index">
                            <div class="card h-100 px-2">
                                <div class="img-wrapper">
                                    <img :src="value.image" class="d-block w-100 gambar-kotak">
                                </div>
                                <div class="card-body pb-0">
                                    <a href="#">
                                        <h5 data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" :title="value.title">
                                            {{ value.title }}
                                        </h5>
                                    </a>
                                    <!-- <small class="text-muted">Oleh <strong> {{ value.author }}</strong></small> -->
                                    <p class="m-top-sm m-bottom-sm mt-2" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
                                        {{ value.content }}
                                    </p>
                                    <a href="#">
                                        <i class="fa fa-angle-double-right"></i> <h6>Lanjutkan Membaca </h6>
                                    </a>
                                </div>
                            </div>
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
                        "published_at": "2024-09-07T00:00:00Z",
                        "image": '/images/news/images1.jpg'
                    },
                    {
                        "id": 2,
                        "title": "Berita Kedua",
                        "content": "Ini adalah konten berita kedua.",
                        "author": "Penulis 2",
                        "published_at": "2024-09-06T00:00:00Z",
                        "image": '/images/news/images1.jpg'
                    },
                    {
                        "id": 3,
                        "title": "Berita Ketiga",
                        "content": "Ini adalah konten berita ketiga.",
                        "author": "Penulis 3",
                        "published_at": "2024-09-05T00:00:00Z",
                        "image": '/images/news/images1.jpg'
                    },
                    {
                        "id": 4,
                        "title": "Berita Keempat",
                        "content": "Ini adalah konten berita keempat.",
                        "author": "Penulis 4",
                        "published_at": "2024-09-04T00:00:00Z",
                        "image": '/images/news/images1.jpg'
                    }
            ],
            wawasan: [
                {
                    "id": 1,
                    "title": "Mengungkap Sejarah Singkat Internet: Dari ARPANET hingga Web 3.0",
                    "content": "Internet, yang kini menjadi bagian tak terpisahkan dari kehidupan sehari-hari, memiliki sejarah panjang yang dimulai pada tahun 1960-an dengan proyek ARPANET. Proyek ini awalnya dikembangkan oleh Departemen Pertahanan Amerika Serikat untuk tujuan penelitian dan komunikasi. ARPANET adalah sistem jaringan pertama yang menggunakan teknik paket-switching, yang memungkinkan data dikirim dalam bentuk paket kecil yang dapat diatur ulang di tujuan. <br>Pada 1980-an, ARPANET berkembang menjadi jaringan yang lebih luas dengan penambahan protokol TCP/IP, yang merupakan fondasi dari internet modern. Pada tahun 1991, Tim Berners-Lee, seorang ilmuwan komputer asal Inggris, memperkenalkan World Wide Web (WWW) sebagai sistem hypertext yang mempermudah akses informasi melalui web browser. Saat ini, internet terus berkembang dengan munculnya Web 2.0 yang memperkenalkan interaksi sosial dan konten yang dihasilkan pengguna. Melangkah ke depan, Web 3.0 atau web semantik bertujuan untuk membuat internet lebih cerdas dengan memanfaatkan teknologi seperti kecerdasan buatan dan blockchain. Transformasi ini berpotensi mengubah cara kita berinteraksi dengan data dan informasi di dunia maya.",
                    "image": '/images/news/wawasan1-sejarah-internet.png'
                },
                {
                    "id": 2,
                    "title": "Perubahan Iklim dan Dampaknya Terhadap Ekosistem Global",
                    "content": "Perubahan iklim adalah fenomena global yang disebabkan oleh peningkatan konsentrasi gas rumah kaca di atmosfer, terutama karbon dioksida (CO₂), metana (CH₄), dan nitrogen oksida (NOₓ). Gas-gas ini terperangkap di atmosfer dan menyebabkan efek rumah kaca yang mengakibatkan pemanasan global.<br>Dampak perubahan iklim terhadap ekosistem sangat luas. Peningkatan suhu global menyebabkan pencairan es di kutub dan peningkatan permukaan laut, yang mengancam habitat spesies-spesies pesisir dan pulau-pulau kecil. Selain itu, perubahan pola curah hujan dan suhu mempengaruhi keseimbangan ekosistem, menyebabkan pergeseran habitat dan mengancam spesies yang tidak dapat beradaptasi dengan cepat.<br>Ekosistem terumbu karang, misalnya, mengalami pemutihan akibat suhu laut yang lebih tinggi, mengancam biodiversitas laut yang bergantung pada terumbu tersebut. Di darat, perubahan iklim meningkatkan risiko kebakaran hutan dan mengubah pola migrasi hewan. Upaya mitigasi termasuk pengurangan emisi gas rumah kaca, pelestarian habitat, dan adaptasi terhadap perubahan iklim sangat penting untuk melindungi keberagaman ekosistem dan menjaga keseimbangan planet.",
                    "image": '/images/news/wawasan2-perubahan-iklim.png'
                },
                {
                    "id": 3,
                    "title": "Teknologi Energi Terbarukan: Solusi untuk Masa Depan yang Berkelanjutan",
                    "content": "Teknologi energi terbarukan menawarkan solusi potensial untuk memenuhi kebutuhan energi global sambil mengurangi dampak lingkungan. Energi terbarukan mencakup berbagai sumber energi yang dapat diperbarui secara alami, seperti tenaga matahari, angin, hidro, dan biomassa.<br>Energi matahari, misalnya, menggunakan panel fotovoltaik untuk mengubah sinar matahari langsung menjadi listrik. Teknologi ini terus berkembang dengan peningkatan efisiensi dan penurunan biaya, menjadikannya pilihan yang semakin menarik untuk pembangkit energi. Energi angin memanfaatkan turbin untuk mengubah energi kinetik dari angin menjadi listrik, dan banyak negara telah meningkatkan kapasitas pembangkit tenaga angin mereka dalam beberapa tahun terakhir.<br>Energi hidro memanfaatkan aliran air dari bendungan atau aliran sungai untuk menghasilkan listrik. Meskipun dampaknya terhadap ekosistem lokal harus dipertimbangkan, teknologi ini tetap menjadi salah satu sumber energi terbarukan yang paling stabil. Biomassa, yang berasal dari bahan organik, dapat digunakan untuk menghasilkan energi dengan pembakaran atau proses biologis lainnya.<br>Pengembangan teknologi energi terbarukan tidak hanya mengurangi ketergantungan pada bahan bakar fosil tetapi juga berkontribusi pada pengurangan emisi karbon dan perubahan iklim. Inovasi dalam sektor ini terus berlanjut dengan penekanan pada efisiensi, penyimpanan energi, dan integrasi dalam jaringan energi global untuk memastikan masa depan yang lebih berkelanjutan.",
                    "image": '/images/news/wawasan3-energy-terbarukan.png'
                }
            ],
            review_buku: [
                {
                    "id": 1,
                    "title": "Laskar Pelangi",
                    "author": "Andrea Hirata",
                    "content": "Andrea Hirata berhasil menghadirkan sebuah karya yang menyentuh hati dalam Laskar Pelangi, sebuah novel yang menceritakan kehidupan anak-anak dari desa terpencil di Belitung. Dengan gaya penulisan yang lincah dan penuh warna, Hirata mengajak pembaca menyelami dunia anak-anak yang penuh impian dan kesulitan.<br>Cerita ini berpusat pada Ikal dan teman-temannya, yang dikenal sebagai Laskar Pelangi, sekelompok anak-anak yang berjuang melawan kemiskinan dan kekurangan fasilitas pendidikan. Di balik perjalanan mereka yang penuh liku, terdapat pesan mendalam tentang kekuatan pendidikan dan persahabatan.<br>Hirata dengan cerdas menyoroti realitas sosial Indonesia sambil menyelipkan unsur humor dan harapan. Laskar Pelangi tidak hanya menawarkan hiburan tetapi juga refleksi mendalam tentang kehidupan, tekad, dan semangat untuk meraih mimpi. Ini adalah karya yang memadukan elemen lokal dengan universalitas yang membuatnya relevan bagi pembaca dari berbagai latar belakang.",
                    "image": '/images/news/review-buku1-laskar-pelangi.png'
                },
                {
                    "id": 2,
                    "title": "Ayat-Ayat Cinta",
                    "author": "oleh Habiburrahman El Shirazy",
                    "content": "Ayat-Ayat Cinta karya Habiburrahman El Shirazy adalah sebuah novel yang menggali tema cinta dan agama dengan cara yang elegan dan mendalam. Dalam novel ini, Shirazy mengisahkan perjalanan cinta seorang mahasiswa Indonesia di Kairo, yang terjebak dalam konflik antara perasaan pribadi dan kewajiban religius.<br>Kisah ini mengikuti Fahri, seorang mahasiswa yang berjuang untuk menyeimbangkan antara cinta dan keyakinan dalam kehidupannya. Dengan latar belakang kota Kairo dan lingkungan akademis, Shirazy memberikan pembaca wawasan yang mendalam tentang budaya dan tradisi Islam melalui cerita cinta yang penuh intrik.<br>Ayat-Ayat Cinta berhasil menyentuh hati dengan narasi yang penuh emosi dan dialog yang reflektif. Buku ini tidak hanya menawarkan kisah cinta yang memikat tetapi juga membuka dialog tentang nilai-nilai agama dan moralitas dalam konteks modern. Dengan gaya penulisan yang puitis dan penuh makna, Shirazy menciptakan sebuah karya yang tak hanya menghibur tetapi juga memberikan pelajaran berharga tentang cinta dan iman.",
                    "image": '/images/news/review-buku2-ayat-ayat-cinta.png'
                },
                {
                    "id": 3,
                    "title": "Garis Waktu",
                    "author": "Fiersa Besari",
                    "content": "Fiersa Besari, dikenal luas sebagai seorang penulis dan musisi, menyuguhkan sebuah karya yang menyentuh dalam Garis Waktu. Buku ini merupakan eksplorasi mendalam tentang kehidupan, cinta, dan perjalanan waktu melalui lensa seorang individu yang sedang mencari makna dalam kehidupan.<br>Garis Waktu membawa pembaca mengikuti perjalanan emosional tokoh utama, yang berusaha memahami berbagai peristiwa dan pengalaman hidup yang membentuk siapa dirinya. Dengan gaya penulisan yang sederhana namun penuh makna, Besari menghadirkan refleksi yang mendalam tentang cinta, kehilangan, dan harapan.<br>Novel ini dipenuhi dengan kutipan-kutipan yang resonan dan pencerahan pribadi, menjadikannya sebagai cerminan perjalanan hidup yang relatable bagi banyak orang. Garis Waktu adalah karya yang mengajak pembaca merenung dan meresapi setiap momen dalam kehidupan mereka sendiri, sambil menikmati narasi yang penuh kejujuran dan kedalaman emosional.",
                    "image": '/images/news/review-buku3-garis-waktu.png'
                }
            ],
            layar_penulis: [
                {
                    "id": 1,
                    "title": "Buya Hamka: Sang Penulis dan Pembaharu Agama",
                    "content": "Buya Hamka, lahir sebagai Haji Abdul Malik Karim Amrullah pada 17 Februari 1908 di Minangkabau, Sumatera Barat, adalah seorang penulis, ulama, dan cendekiawan yang memiliki pengaruh besar dalam literatur dan pemikiran Islam di Indonesia. Hamka dikenal tidak hanya karena karya sastra yang menggugah, tetapi juga kontribusinya yang signifikan dalam pembaharuan pemikiran agama.<br.Dengan latar belakang pendidikan yang kuat dan pengalaman luas, Hamka menulis berbagai karya yang meliputi novel, esai, dan tafsir Al-Qur’an. Karya monumentalnya, Tenggelamnya Kapal Van Der Wijck, menggambarkan dengan mendalam konflik sosial dan budaya masyarakat Minangkabau pada masa itu. Melalui tulisan-tulisannya, Hamka berhasil menggabungkan nilai-nilai agama dengan permasalahan sosial kontemporer, menjadikannya sebagai suara penting dalam sejarah intelektual Indonesia.<br>Selain sebagai penulis, Buya Hamka juga aktif dalam organisasi Islam dan pernah menjabat sebagai ketua Majelis Ulama Indonesia (MUI). Ia meninggal pada 24 Juli 1981, namun warisan pemikiran dan karya-karyanya terus menginspirasi generasi mendatang.",
                    "image": '/images/faces/1.jpg'
                },
                {
                    "id": 2,
                    "title": "Pramoedya Ananta Toer: Suara Perjuangan dalam Gelap",
                    "content": "Pramoedya Ananta Toer, lahir pada 6 Februari 1925 di Blora, Jawa Tengah, adalah salah satu penulis terbesar Indonesia yang dikenal dengan karya-karya yang berani dan penuh dengan kritik sosial. Pramoedya adalah seorang penulis yang tidak hanya menciptakan karya sastra tetapi juga terlibat aktif dalam perjuangan politik dan sosial di Indonesia.<br>Salah satu karya terbaiknya, Bumi Manusia, adalah bagian dari tetralogi Buru Quartet yang menggambarkan kehidupan dan perjuangan masyarakat Indonesia selama periode kolonial Belanda. Karya ini tidak hanya mengeksplorasi isu-isu sosial dan politik tetapi juga menghadirkan karakter-karakter yang kuat dan kompleks.<br>Selama masa hidupnya, Pramoedya mengalami berbagai tantangan politik, termasuk penahanan oleh pemerintah Orde Baru. Meskipun mengalami penahanan dan penganiayaan, ia tetap berdiri teguh dengan prinsip-prinsipnya dan terus menulis. Pramoedya Ananta Toer meninggal pada 30 April 2006, tetapi warisan sastra dan semangat perjuangannya terus hidup melalui karya-karyanya yang mempengaruhi pembaca dan penulis di seluruh dunia.",
                    "image": '/images/faces/2.jpg'
                },
                {
                    "id": 3,
                    "title": "J.K. Rowling: Dari Keringat hingga Keajaiban Dunia Harry Potter",
                    "content": "J.K. Rowling, lahir sebagai Joanne Rowling pada 31 Juli 1965 di Yate, Gloucestershire, Inggris, adalah penulis yang mengubah dunia sastra anak-anak dengan seri Harry Potter. Sebelum mencapai kesuksesan besar, Rowling menghadapi tantangan besar dalam hidupnya, termasuk kehidupan sebagai ibu tunggal yang berjuang untuk bertahan hidup.<br>Kisah Harry Potter, yang pertama kali diterbitkan pada tahun 1997, tidak hanya menjadi fenomena global tetapi juga melahirkan dunia magis yang dicintai oleh jutaan pembaca di seluruh dunia. Kesuksesan buku ini membawa Rowling dari keadaan ekonomi yang sulit menuju status miliarder dan ikon budaya global.<br>Selain menulis, Rowling juga aktif dalam berbagai kegiatan amal melalui lembaga filantropi yang didirikannya. Karya-karya lanjutan dalam dunia Harry Potter, serta buku-buku dewasa seperti The Casual Vacancy, menunjukkan kemampuannya untuk melintasi genre dan mempengaruhi berbagai kalangan pembaca. J.K. Rowling tetap menjadi salah satu penulis paling berpengaruh di era modern, dan warisan Harry Potter-nya terus berkembang.",
                    "image": '/images/faces/3.jpg'
                }
            ],
            titik_fokus: [
                {
                    "id": 1,
                    "title": "Kesehatan Mental di Era Digital: Menjaga Keseimbangan di Dunia Maya",
                    "content": "Di tengah perkembangan teknologi yang pesat, kita sering kali lupa bahwa kesehatan mental tidak kalah pentingnya dibandingkan kesehatan fisik. Era digital membawa berbagai kemudahan, tetapi juga tantangan baru bagi kesejahteraan mental kita. Dengan meningkatnya penggunaan media sosial dan teknologi, tekanan untuk selalu terhubung dan tampil sempurna sering kali menyebabkan stres dan kecemasan.<br>Menjaga keseimbangan dalam dunia maya memerlukan kesadaran dan usaha yang sadar. Ini berarti membatasi waktu layar, menetapkan batasan yang sehat dalam berinteraksi di media sosial, dan mencari dukungan ketika merasa kewalahan. Selain itu, penting untuk kembali ke aktivitas yang dapat meredakan stres seperti olahraga, meditasi, atau hobi yang menyenangkan.<br>Dalam dunia yang semakin terhubung, kesehatan mental harus menjadi prioritas utama. Menjaga keseimbangan di dunia maya bukan hanya tentang menghindari dampak negatif, tetapi juga tentang menciptakan ruang untuk pemulihan dan pertumbuhan pribadi. Hanya dengan cara ini kita dapat menikmati manfaat teknologi tanpa mengorbankan kesejahteraan mental kita.",
                    "image": '/images/news/titik-fokus1.png'
                },
                {
                    "id": 2,
                    "title": "Pariwisata Berkelanjutan: Mengapa Kita Perlu Berpikir Kembali Tentang Liburan Kita",
                    "content": "Pariwisata berkelanjutan bukanlah konsep baru, tetapi semakin relevan dalam era di mana dampak lingkungan dan sosial dari perjalanan semakin terlihat. Ketika kita merencanakan liburan, sering kali kita hanya fokus pada destinasi dan pengalaman tanpa mempertimbangkan dampaknya terhadap lingkungan dan komunitas lokal.<br>Pariwisata berkelanjutan menekankan pada prinsip-prinsip seperti pengurangan jejak karbon, dukungan untuk ekonomi lokal, dan pelestarian budaya serta lingkungan. Ini bukan hanya tentang memilih akomodasi ramah lingkungan, tetapi juga tentang memahami dan menghormati budaya lokal, serta berpartisipasi dalam kegiatan yang memberi manfaat langsung bagi masyarakat.<br>Dengan menjadi wisatawan yang lebih sadar dan bertanggung jawab, kita dapat membantu menjaga keindahan destinasi yang kita kunjungi dan memastikan bahwa pariwisata terus memberikan manfaat positif bagi semua pihak. Saatnya untuk berpikir kembali tentang liburan kita dan menjadikannya sebagai pengalaman yang tidak hanya memuaskan tetapi juga berkelanjutan.",
                    "image": '/images/news/titik-fokus2.png'
                },
                {
                    "id": 3,
                    "title": "Mengejar Impian di Tengah Ketidakpastian: Berani Mengambil Langkah Pertama",
                    "content": "Mengikuti impian sering kali tampak seperti perjalanan yang menakutkan, terutama ketika dunia di sekitar kita penuh dengan ketidakpastian. Namun, inilah saatnya untuk berani mengambil langkah pertama menuju tujuan pribadi kita, meskipun jalan yang ditempuh mungkin tidak selalu jelas.<br<Ketidakpastian adalah bagian dari proses, dan ketakutan akan kegagalan sering kali menjadi penghalang terbesar. Namun, penting untuk diingat bahwa setiap langkah kecil menuju impian kita adalah kemajuan. Mengambil risiko, meski terkadang menakutkan, membuka peluang baru dan membawa kita lebih dekat kepada pencapaian yang kita impikan.<br>Dengan menetapkan tujuan yang realistis, mencari dukungan, dan tetap fleksibel dalam menghadapi perubahan, kita dapat menghadapi ketidakpastian dengan lebih percaya diri. Mengejar impian bukan hanya tentang mencapai tujuan akhir, tetapi juga tentang perjalanan yang membentuk kita dan memberikan makna dalam hidup. Saatnya untuk melangkah maju dan mengubah ketidakpastian menjadi kesempatan. ",
                    "image": '/images/news/titik-fokus3.png'
                }
            ],
            humoria: [
                {
                    "id": 1,
                    "title": "Ujian di Kafe",
                    "content": "Seorang mahasiswa sedang belajar di kafe sambil meminum kopi. Dia merasa stres karena ujian yang mendekat. Temannya datang dan bertanya, “Kenapa wajahmu kayak mau meledak?” Mahasiswa itu menjawab sambil menghela napas, “Ujian, bro! Rasanya kayak minum kopi tanpa gula, pahit banget!” Temannya tertawa, “Aduh, jangan khawatir. Kan ada trik baru, bawa kopi ke ruang ujian. Kalau ujian susah, minum kopinya dulu. Setidaknya, rasa pahitnya kebagi dua!”",
                    "image": '/images/news/humoria1.png'
                },
                {
                    "id": 2,
                    "title": "Kartu Kredit dan Diskon",
                    "content": "Pak Budi baru saja menerima tagihan kartu kreditnya dan mengeluh kepada temannya di warung kopi. “Duh, tagihan kartu kredit saya makin lama makin bikin pusing!”Temannya bertanya, “Kenapa, Pak Budi?” Pak Budi menjawab sambil tertawa, “Karena setiap kali belanja, saya selalu cek diskon. Eh, sekarang diskonnya malah bikin tagihan saya lebih banyak! Mungkin ini diskon ‘khusus’ buat saya supaya tetap bersemangat bayar tagihan!”",
                    "image": '/images/news/humoria2.png'
                },
                {
                    "id": 3,
                    "title": "Sentuhan Magis di Dapur: Kue Coklat yang Tak Pernah Mengecewakan",
                    "content": "Di sebuah kompleks perumahan, Bu Nani sedang sibuk memasak di dapur. Dia baru saja mencoba resep baru yang dia temukan di internet, yaitu kue coklat yang katanya super lezat. Sementara itu, tetangganya, Bu Tini, datang berkunjung untuk bertanya bagaimana cara membuat kue yang sama. Bu Tini melihat Bu Nani dengan penuh semangat dan bertanya, “Bu Nani, kok bisa kue ini jadi kelihatan begitu enak? Rahasianya apa?” Bu Nani dengan bangga menjawab, “Oh, itu rahasianya adalah resep dari internet! Saya mengikuti semua langkahnya dengan teliti.” Sambil mencicipi adonan kue, Bu Tini bertanya lagi, “Iya, tapi ada yang berbeda deh dari kue saya, kenapa ya?” Bu Nani dengan ceria menjelaskan, “Gampang, Bu Tini. Kalau resepnya bilang ‘panggang dalam oven 30 menit’, saya tambahkan sedikit waktu ekstra karena anak-anak suka kue yang ‘lebih gosong’! Jadi, saya panggang lagi sedikit lebih lama supaya lebih crunchy!” Bu Tini penasaran dan bertanya, “Jadi, kalau saya mau kue saya lebih enak, saya harus panggang lebih lama?” Bu Nani menjawab sambil tertawa, “Bukan hanya lebih lama, tapi juga sedikit ‘praktekin’! Misalnya, setiap kali saya lewat dapur, saya sapa ovennya, ‘Halo, oven! Kerja bagus, ya!’ Dan itu memberi semangat pada kue untuk lebih bersemangat!” Bu Tini terkejut dan bertanya, “Jadi kue bisa lebih enak karena kita ngomong sama oven?”",
                    "image": '/images/news/humoria3.png'
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
                    slidesPerView: 2,
                    spaceBetween: 10
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
    },

    computed:{
        groupedBukuPopuler() {
            const chunkSize = 4;
            const grouped = [];

            for (let i = 0; i < this.buku_populer.length; i += chunkSize) {
                grouped.push(this.buku_populer.slice(i, i + chunkSize));
            }

            return grouped;
        },
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

    /* Media Queries untuk Mobile View */
    @media (max-width: 999px) {
        :deep(.swiper-button-next),
        :deep(.swiper-button-prev) {
            display: none;
        }

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
        
        .buku-desc {
            font-size: 12px;
        }

        .gambar-kotak {
            height: auto;
        }
    }
</style>