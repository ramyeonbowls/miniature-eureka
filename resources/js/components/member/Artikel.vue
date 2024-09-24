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
                        <div class="card h-100 px-2 mb-1">
                            <div class="d-flex justify-content-center align-items-center flex-column mt-3">
                                <div class="avatar">
                                    <img :src="data.image" style="height: 90px; width:90px;">
                                </div>
                            </div>
                            <div class="card-body pb-0">
                                <a href="#">
                                    <h5 data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" :title="data.title">
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
                    </div>
                </div>
                <div v-else class="row">
                    <div v-for="(data, i) in displayedContents" :key="i" class="col-12 col-lg-4 mb-2 mt-2">
                        <div class="card h-100 mb-0">
                            <div class="card-content d-flex flex-column">
                                <div class="product-image mb-0 pb-0">
                                    <img :src="data.image" class="img-fluid rounded-3">
                                </div>
                                <div class="card-body mb-0 mx-0 px-2 flex-grow-1">
                                    <a href="#">
                                        <h5 data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" :title="data.title">
                                            {{ data.title }}
                                        </h5>
                                    </a>
                                    <div v-if="idart=='TU'">
                                        <small class="text-muted">Oleh <strong>{{ data.author }}</strong> | {{ data.published_at }}</small>
                                    </div>
                                    <p class="m-top-sm m-bottom-sm mt-2" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
                                        <span v-html="data.content"></span>
                                    </p>
                                    <a href="#">
                                        <h6>Lanjutkan Membaca </h6>
                                    </a>
                                </div>
                            </div>
                        </div>
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