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
        <section class="row">
            <div class="row mt-3">
                <div class="divider divider-left-center">
                    <h2>BUKU POPULER</h2>
                </div>
            </div>
            <div class="col-12 col-lg-3 d-none d-sm-block">
                <div class="card" style="height:658px;">
                    <div class="card-body background-populer">
                        &nbsp;
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-9">
                    <div class="col-12">
                        <div v-for="(group, groupIndex) in groupedBukuPopuler" :key="groupIndex" class="row">
                            <div v-for="buku in group" :key="buku.id" class="col-md-3 col-6">
                                <router-link :to="{ name: 'detail_buku', params: { idb: buku.isbn } }">
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
                                    </div>
                                </router-link>
                            </div>
                        </div>
                    </div>
            </div>
        </section>
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="row mb-2 py-0 px-0 mx-0 my-0">
                        <div class="divider divider-left-center">
                            <h2>KOLEKSI BUKU</h2>
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
                                            <img src="images/news/literasiday.png" class="img-fluid" alt="Photo of Blog">
                                        </a>
                                    </div>
                                    <a href="#">
                                        <h5 data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" title="Merayakan Hari Literasi Internasional 2024: Menyongsong Masa Depan Melalui Kekuatan Membaca">
                                            Merayakan Hari Literasi Internasional 2024: Menyongsong Masa Depan Melalui Kekuatan Membaca
                                        </h5>
                                    </a>
                                    <small class="text-muted">By <strong> John Doe</strong> |  Post on Jan 8, 2013</small>
                                    <p class="m-top-sm m-bottom-sm mt-2">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam eros nibh, viverra a dui a, gravida varius velit. Nunc vel tempor nisi. Aenean id pellentesque mi, non placerat mi. Integer luctus accumsan tellus. Vivamus quis elit sit amet nibh lacinia suscipit eu quis purus. Vivamus tristique est non ipsum dapibus lacinia sed nec metus.
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
                                    <img src="images/samples/architecture1.jpg" alt="Photo of Blog" style="max-width: 150px; max-height: 150px;">
                                </a>
                                <div class="media-body">
                                    <a href="#">
                                        <h6 class="card-title" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" title="Merayakan Hari Literasi Internasional 2024: Menyongsong Masa Depan Melalui Kekuatan Membaca">Merayakan Hari Literasi Internasional 2024: Menyongsong Masa Depan Melalui Kekuatan Membaca</h6>
                                    </a>
                                </div>
                            </div>
                            <div class="media popular-post" style="height: 150px; max-height: 150px;">
                                <a class="pull-left" href="#">
                                    <img src="images/samples/motorcycle.jpg" alt="Photo of Blog" style="max-width: 150px; max-height: 150px;">
                                </a>
                                <div class="media-body">
                                    <a href="#">
                                        <h6 class="card-title" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" title="Kampus Terbaik Dunia: Universitas-Inovasi yang Mendorong Masa Depan Pendidikan">Kampus Terbaik Dunia: Universitas-Inovasi yang Mendorong Masa Depan Pendidikan</h6>
                                    </a>
                                </div>
                            </div>
                            <div class="media popular-post" style="height: 150px; max-height: 150px;">
                                <a class="pull-left" href="#">
                                    <img src="images/samples/origami.jpg" alt="Photo of Blog" style="max-width: 150px; max-height: 150px;">
                                </a>
                                <div class="media-body">
                                    <a href="#">
                                        <h6 class="card-title" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" title="Lorem ipsum dolor sit amet, consectetur adipiscing elit.">Lorem ipsum dolor sit amet, consectetur adipiscing elit. </h6>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="row mb-4">
            <div class="col-12 col-lg-12">
                <div class="testimonial-slider">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="testimonial-title">
                                <i class="bi bi-quote display-2"></i>
                                <h2 class="fw-bold display-6 text-white">FRASA</h2>
                            </div>
                            <div class="d-flex justify-content-center mt-5 mb-3">
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
                                class="swiper-frasa col-md-10"
                                loop
                            >
                                <swiper-slide v-for="(value, index) in frasa" :key="index">
                                    <div class="card" style="height: 340px;">
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
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="card py-2 px-4">
                    <div class="row">
                        <div class="col-6 text-start pt-3">
                            <h2>Wawasan</h2>
                        </div>
                        <div class="col-6 text-end pt-3">
                            <button class="btn btn-primary btn-sm">Lihat Semua</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="panel blog-container">
                                <div class="panel-body mt-4">
                                    <div class="mb-3">
                                        <a href="#">
                                            <img src="images/news/literasiday.png" class="img-fluid" alt="Photo of Blog">
                                        </a>
                                    </div>
                                    <a href="#">
                                        <h5 data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" title="Merayakan Hari Literasi Internasional 2024: Menyongsong Masa Depan Melalui Kekuatan Membaca">
                                            Merayakan Hari Literasi Internasional 2024: Menyongsong Masa Depan Melalui Kekuatan Membaca
                                        </h5>
                                    </a>
                                    <small class="text-muted">By <strong> John Doe</strong> |  Post on Jan 8, 2013</small>
                                    <p class="m-top-sm m-bottom-sm mt-2">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam eros nibh, viverra a dui a, gravida varius velit. Nunc vel tempor nisi. Aenean id pellentesque mi, non placerat mi. Integer luctus accumsan tellus. Vivamus quis elit sit amet nibh lacinia suscipit eu quis purus. Vivamus tristique est non ipsum dapibus lacinia sed nec metus.
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
                                    <img src="images/samples/architecture1.jpg" alt="Photo of Blog" style="max-width: 150px; max-height: 150px;">
                                </a>
                                <div class="media-body">
                                    <a href="#">
                                        <h6 class="card-title" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" title="Merayakan Hari Literasi Internasional 2024: Menyongsong Masa Depan Melalui Kekuatan Membaca">Merayakan Hari Literasi Internasional 2024: Menyongsong Masa Depan Melalui Kekuatan Membaca</h6>
                                    </a>
                                </div>
                            </div>
                            <div class="media popular-post" style="height: 150px; max-height: 150px;">
                                <a class="pull-left" href="#">
                                    <img src="images/samples/motorcycle.jpg" alt="Photo of Blog" style="max-width: 150px; max-height: 150px;">
                                </a>
                                <div class="media-body">
                                    <a href="#">
                                        <h6 class="card-title" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" title="Kampus Terbaik Dunia: Universitas-Inovasi yang Mendorong Masa Depan Pendidikan">Kampus Terbaik Dunia: Universitas-Inovasi yang Mendorong Masa Depan Pendidikan</h6>
                                    </a>
                                </div>
                            </div>
                            <div class="media popular-post" style="height: 150px; max-height: 150px;">
                                <a class="pull-left" href="#">
                                    <img src="images/samples/origami.jpg" alt="Photo of Blog" style="max-width: 150px; max-height: 150px;">
                                </a>
                                <div class="media-body">
                                    <a href="#">
                                        <h6 class="card-title" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" title="Lorem ipsum dolor sit amet, consectetur adipiscing elit.">Lorem ipsum dolor sit amet, consectetur adipiscing elit. </h6>
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
                <div class="card py-2 px-4">
                    <div class="row">
                        <div class="col-6 text-start pt-3">
                            <h2>Wawasan</h2>
                        </div>
                        <div class="col-6 text-end pt-3">
                            <button class="btn btn-primary btn-sm">Lihat Semua</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="panel blog-container">
                                <div class="panel-body mt-4">
                                    <div class="mb-3">
                                        <a href="#">
                                            <img src="images/news/literasiday.png" class="img-fluid" alt="Photo of Blog">
                                        </a>
                                    </div>
                                    <a href="#">
                                        <h5 data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" title="Merayakan Hari Literasi Internasional 2024: Menyongsong Masa Depan Melalui Kekuatan Membaca">
                                            Merayakan Hari Literasi Internasional 2024: Menyongsong Masa Depan Melalui Kekuatan Membaca
                                        </h5>
                                    </a>
                                    <small class="text-muted">By <strong> John Doe</strong> |  Post on Jan 8, 2013</small>
                                    <p class="m-top-sm m-bottom-sm mt-2">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam eros nibh, viverra a dui a, gravida varius velit. Nunc vel tempor nisi. Aenean id pellentesque mi, non placerat mi. Integer luctus accumsan tellus. Vivamus quis elit sit amet nibh lacinia suscipit eu quis purus. Vivamus tristique est non ipsum dapibus lacinia sed nec metus.
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
                                    <img src="images/samples/architecture1.jpg" alt="Photo of Blog" style="max-width: 150px; max-height: 150px;">
                                </a>
                                <div class="media-body">
                                    <a href="#">
                                        <h6 class="card-title" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" title="Merayakan Hari Literasi Internasional 2024: Menyongsong Masa Depan Melalui Kekuatan Membaca">Merayakan Hari Literasi Internasional 2024: Menyongsong Masa Depan Melalui Kekuatan Membaca</h6>
                                    </a>
                                </div>
                            </div>
                            <div class="media popular-post" style="height: 150px; max-height: 150px;">
                                <a class="pull-left" href="#">
                                    <img src="images/samples/motorcycle.jpg" alt="Photo of Blog" style="max-width: 150px; max-height: 150px;">
                                </a>
                                <div class="media-body">
                                    <a href="#">
                                        <h6 class="card-title" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" title="Kampus Terbaik Dunia: Universitas-Inovasi yang Mendorong Masa Depan Pendidikan">Kampus Terbaik Dunia: Universitas-Inovasi yang Mendorong Masa Depan Pendidikan</h6>
                                    </a>
                                </div>
                            </div>
                            <div class="media popular-post" style="height: 150px; max-height: 150px;">
                                <a class="pull-left" href="#">
                                    <img src="images/samples/origami.jpg" alt="Photo of Blog" style="max-width: 150px; max-height: 150px;">
                                </a>
                                <div class="media-body">
                                    <a href="#">
                                        <h6 class="card-title" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" title="Lorem ipsum dolor sit amet, consectetur adipiscing elit.">Lorem ipsum dolor sit amet, consectetur adipiscing elit. </h6>
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
                <div class="card py-2 px-4">
                    <div class="row">
                        <div class="col-6 text-start pt-3">
                            <h2>Wawasan</h2>
                        </div>
                        <div class="col-6 text-end pt-3">
                            <button class="btn btn-primary btn-sm">Lihat Semua</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="panel blog-container">
                                <div class="panel-body mt-4">
                                    <div class="mb-3">
                                        <a href="#">
                                            <img src="images/news/literasiday.png" class="img-fluid" alt="Photo of Blog">
                                        </a>
                                    </div>
                                    <a href="#">
                                        <h5 data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" title="Merayakan Hari Literasi Internasional 2024: Menyongsong Masa Depan Melalui Kekuatan Membaca">
                                            Merayakan Hari Literasi Internasional 2024: Menyongsong Masa Depan Melalui Kekuatan Membaca
                                        </h5>
                                    </a>
                                    <small class="text-muted">By <strong> John Doe</strong> |  Post on Jan 8, 2013</small>
                                    <p class="m-top-sm m-bottom-sm mt-2">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam eros nibh, viverra a dui a, gravida varius velit. Nunc vel tempor nisi. Aenean id pellentesque mi, non placerat mi. Integer luctus accumsan tellus. Vivamus quis elit sit amet nibh lacinia suscipit eu quis purus. Vivamus tristique est non ipsum dapibus lacinia sed nec metus.
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
                                    <img src="images/samples/architecture1.jpg" alt="Photo of Blog" style="max-width: 150px; max-height: 150px;">
                                </a>
                                <div class="media-body">
                                    <a href="#">
                                        <h6 class="card-title" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" title="Merayakan Hari Literasi Internasional 2024: Menyongsong Masa Depan Melalui Kekuatan Membaca">Merayakan Hari Literasi Internasional 2024: Menyongsong Masa Depan Melalui Kekuatan Membaca</h6>
                                    </a>
                                </div>
                            </div>
                            <div class="media popular-post" style="height: 150px; max-height: 150px;">
                                <a class="pull-left" href="#">
                                    <img src="images/samples/motorcycle.jpg" alt="Photo of Blog" style="max-width: 150px; max-height: 150px;">
                                </a>
                                <div class="media-body">
                                    <a href="#">
                                        <h6 class="card-title" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" title="Kampus Terbaik Dunia: Universitas-Inovasi yang Mendorong Masa Depan Pendidikan">Kampus Terbaik Dunia: Universitas-Inovasi yang Mendorong Masa Depan Pendidikan</h6>
                                    </a>
                                </div>
                            </div>
                            <div class="media popular-post" style="height: 150px; max-height: 150px;">
                                <a class="pull-left" href="#">
                                    <img src="images/samples/origami.jpg" alt="Photo of Blog" style="max-width: 150px; max-height: 150px;">
                                </a>
                                <div class="media-body">
                                    <a href="#">
                                        <h6 class="card-title" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" title="Lorem ipsum dolor sit amet, consectetur adipiscing elit.">Lorem ipsum dolor sit amet, consectetur adipiscing elit. </h6>
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
                <div class="card py-2 px-4">
                    <div class="row">
                        <div class="col-6 text-start pt-3">
                            <h2>Wawasan</h2>
                        </div>
                        <div class="col-6 text-end pt-3">
                            <button class="btn btn-primary btn-sm">Lihat Semua</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="panel blog-container">
                                <div class="panel-body mt-4">
                                    <div class="mb-3">
                                        <a href="#">
                                            <img src="images/news/literasiday.png" class="img-fluid" alt="Photo of Blog">
                                        </a>
                                    </div>
                                    <a href="#">
                                        <h5 data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" title="Merayakan Hari Literasi Internasional 2024: Menyongsong Masa Depan Melalui Kekuatan Membaca">
                                            Merayakan Hari Literasi Internasional 2024: Menyongsong Masa Depan Melalui Kekuatan Membaca
                                        </h5>
                                    </a>
                                    <small class="text-muted">By <strong> John Doe</strong> |  Post on Jan 8, 2013</small>
                                    <p class="m-top-sm m-bottom-sm mt-2">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam eros nibh, viverra a dui a, gravida varius velit. Nunc vel tempor nisi. Aenean id pellentesque mi, non placerat mi. Integer luctus accumsan tellus. Vivamus quis elit sit amet nibh lacinia suscipit eu quis purus. Vivamus tristique est non ipsum dapibus lacinia sed nec metus.
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
                                    <img src="images/samples/architecture1.jpg" alt="Photo of Blog" style="max-width: 150px; max-height: 150px;">
                                </a>
                                <div class="media-body">
                                    <a href="#">
                                        <h6 class="card-title" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" title="Merayakan Hari Literasi Internasional 2024: Menyongsong Masa Depan Melalui Kekuatan Membaca">Merayakan Hari Literasi Internasional 2024: Menyongsong Masa Depan Melalui Kekuatan Membaca</h6>
                                    </a>
                                </div>
                            </div>
                            <div class="media popular-post" style="height: 150px; max-height: 150px;">
                                <a class="pull-left" href="#">
                                    <img src="images/samples/motorcycle.jpg" alt="Photo of Blog" style="max-width: 150px; max-height: 150px;">
                                </a>
                                <div class="media-body">
                                    <a href="#">
                                        <h6 class="card-title" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" title="Kampus Terbaik Dunia: Universitas-Inovasi yang Mendorong Masa Depan Pendidikan">Kampus Terbaik Dunia: Universitas-Inovasi yang Mendorong Masa Depan Pendidikan</h6>
                                    </a>
                                </div>
                            </div>
                            <div class="media popular-post" style="height: 150px; max-height: 150px;">
                                <a class="pull-left" href="#">
                                    <img src="images/samples/origami.jpg" alt="Photo of Blog" style="max-width: 150px; max-height: 150px;">
                                </a>
                                <div class="media-body">
                                    <a href="#">
                                        <h6 class="card-title" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" title="Lorem ipsum dolor sit amet, consectetur adipiscing elit.">Lorem ipsum dolor sit amet, consectetur adipiscing elit. </h6>
                                    </a>
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
        
        groupedfrasa() {
            const chunkSize = 2;
            const grouped = [];

            for (let i = 0; i < this.frasa.length; i += chunkSize) {
                grouped.push(this.frasa.slice(i, i + chunkSize));
            }

            return grouped;
        }
    }
};
</script>