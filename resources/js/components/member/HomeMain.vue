<template>
    <div class="page-content">
        <!-- <template v-if="isAuthenticated"> -->
        <section class="row">
            <div class="row mb-4">
                <div class="col-12 col-lg-12">
                    <div class="row">
                        <div class="col-12">
                            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <template v-if="banner.length > 0">
                                        <div v-for="(item, index) in banner" :key="index" :class="['carousel-item', { active: index === 0 }]">
                                            <img :src="item.image" class="d-block w-100" :alt="item.alt" height="400px" />
                                        </div>
                                        <!-- <div class="carousel-item active">
                                                <img src="/images/banner/banner1.jpg" class="d-block w-100" height="400px" alt="...">
                                            </div>
                                            <div class="carousel-item active">
                                                <img src="/images/banner/banner2.jpg" class="d-block w-100" height="400px" alt="...">
                                            </div>
                                            <div class="carousel-item active">
                                                <img src="/images/banner/banner3.jpg" class="d-block w-100" height="400px" alt="...">
                                            </div> -->
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
            <div class="row">
                <div class="col-12 col-lg-9">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Buku Populer</h4>
                                </div>
                                <div class="card-body">
                                    <div id="chart-profile-visit"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Kata - Kata</h4>
                            <hr />
                            <div class="comment-header">
                                <div class="pr-50">
                                    <div class="avatar avatar-xl">
                                        <img src="/images/faces/5.jpg" alt="Avatar" />
                                    </div>
                                </div>
                                <div class="comment-body">
                                    <div class="comment-message">
                                        <p class="list-group-item-text truncate mb-20">Terkadang saat kamu berada di tempat yang gelap, kamu mengira kamu terkubur. Tapi sebenarnya kamu sedang ditanam</p>
                                    </div>
                                    <div class="comment-profileName">
                                        <b><i>Christine Caine</i></b>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Koleksi Buku</h4>
                                </div>
                                <div class="card-body">
                                    <div id="chart-profile-visit"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h4>Perspektif</h4>
                        </div>
                        <div class="card-body"></div>
                    </div>
                </div>
                <div class="col-12 col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <h4>Resensi Buku</h4>
                        </div>
                        <div class="card-body"></div>
                    </div>
                </div>
            </div>
        </section>
        <!-- </template> -->
    </div>
</template>

<style>
.content-wrapper {
        margin-top: 126px;
    }
</style>
<script>
export default {
    data() {
        return {
            isAuthenticated: false,
            banner: [
                {
                    image: 'images/banner/banner1.jpg',
                    alt: 'banner1',
                },
                {
                    image: 'images/banner/banner2.jpg',
                    alt: 'Banana',
                },
                {
                    image: 'images/banner/banner3.jpg',
                    alt: 'Mountain',
                },
            ],
        }
    },

    mounted() {
        this.getInfo()
    },

    methods: {
        getInfo() {
            this.user = {}

            window.axios
                .get('/getInfo')
                .then((response) => {
                    this.user = response.data

                    if (response.data.name != '') {
                        this.isAuthenticated = true
                    }
                })
                .catch((e) => {
                    console.error(e)
                })
        },
    },
}
</script>
