<template>
    <div class="page-content">
            <div class="col-12">
                <div v-if="displayedContents <= 0" class="row">
                    <div class="card h-100">
                        <div class="card-content d-flex flex-column">
                            Tidak Ada Data {{ (idart=='TU' ? 'Tajuk Utama' : (idart=='WA' ? 'Wawasan' : (idart=='FR' ? 'Frasa' : (idart=='RB' ? 'Review Buku' : (idart=='LP' ? 'Layar Penulis' : (idart=='TF' ? 'Titik Fokus' : 'Humoria')))))) }}
                        </div>
                    </div>
                </div>
                <div v-if="idart=='LP'" class="row">
                    <div v-for="(data, i) in displayedContents" :key="i" class="col-12 col-lg-4 mb-2 mt-2">
                        <router-link :to="{ name: 'detail-artikel', params: { idart: idart, detail: data.id } }">
                            <div class="card h-100 px-2 mb-1 hover-shadow">
                                <div class="d-flex justify-content-center align-items-center flex-column mt-3">
                                    <div class="avatar">
                                        <img :src="data.image" style="height: 90px; width:90px;">
                                    </div>
                                </div>
                                <div class="card-body pb-0">
                                    <a href="#">
                                        <h5 data-bs-toggle="tooltip" data-bs-placement="bottom" style="color: #1995ad; display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" :title="data.title">
                                            {{ data.title }}
                                        </h5>
                                    </a>
                                    <p class="m-top-sm m-bottom-sm mt-2" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
                                        <span v-html="data.content"></span>
                                    </p>
                                    <a href="#">
                                        <h6>Lanjutkan Membaca </h6>
                                    </a>
                                </div>
                            </div>
                        </router-link>
                    </div>
                </div>
                <div v-else class="row">
                    <div v-for="(data, i) in displayedContents" :key="i" class="col-12 col-lg-4 mb-2 mt-2">
                        <router-link :to="{ name: 'detail-artikel', params: { idart: idart, detail: data.id } }">
                            <div class="card h-100 mb-0 hover-shadow">
                                <div class="card-content d-flex flex-column">
                                    <div class="product-image mb-0 pb-0">
                                        <img :src="data.image" class="img-fluid" style="border-radius: 5px 5px 0 0 !important;">
                                    </div>
                                    <div class="card-body">
                                        <div class="card-title">
                                            <a href="#">
                                                <h5 data-bs-toggle="tooltip" data-bs-placement="bottom" style="color: #1995ad; display: -webkit-box; line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" :title="data.title">
                                                    {{ data.title }}
                                                </h5>
                                            </a>
                                        </div>
                                        <div v-if="idart=='TU' || idart=='RB'">
                                            <small class="text-muted">Oleh <strong>{{ data.author }}</strong> | {{ data.published_at }}</small>
                                        </div>
                                        <p class="m-top-sm m-bottom-sm mt-2" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
                                            <span v-html="data.content"></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </router-link>
                    </div>
                </div>
                <div v-if="showLoadMore" class="divider">
                    <div class="divider-text bg-transparent">
                        <button class="btn btn-secondary mt-3 rounded-pill" @click="loadMore">Load More</button>
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

    data() {
        return {
            idart: '',
            displayedCount: 6,
            articles: [],
        };
    },

    mounted() {
        this.idart = this.$route.params.idart;
        this.getArtikel();
    },

    methods: {
        async getArtikel() {
            try {
                let loader = this.$loading.show();
                axios.get('/getArticle', {
                    params:{
                        id: this.idart
                    }
                })
                .then((response) => {
                    this.articles = response.data;
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

        async refreshData() {
            this.idart = this.$route.params.idart;
            await this.getArtikel();
        },

        loadMore() {
            this.displayedCount += 6;
        }
    },

    computed: {
        displayedContents() {
            return this.articles.slice(0, this.displayedCount);
        },

        showLoadMore() {
            return this.articles.length > this.displayedCount;
        }
    },

    watch: {
        '$route.params.idart': 'refreshData'
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