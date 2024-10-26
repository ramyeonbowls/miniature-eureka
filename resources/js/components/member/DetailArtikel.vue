<template>
    <div class="page-content">
        <div class="col-12">
            <div class="card h-100">
                <div v-if="article.length != 0" class="card-content d-flex flex-column">
                    <div class="text-center">
                        <img :src="article[0].image" class="img-fluid">
                    </div>
                    <div class="card-body">
                        <div class="card-title mb-3">
                            <h5>
                                {{ article[0].title }}
                            </h5>
                            <div v-if="idart=='TU' || idart=='RB'">
                                <small class="text-muted mt-0">Oleh <strong>{{ article[0].author }}</strong> | {{ article[0].published_at }}</small>
                            </div>
                        </div>
                        <span v-html="article[0].content"></span>
                    </div>
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
            iddetail: '',
            article: [],
        };
    },

    mounted() {
        this.idart      = this.$route.params.idart;
        this.iddetail   = this.$route.params.detail;
        this.getDetailArtikel();
        this.ReadFitur();
    },

    methods: {
		ReadFitur(){
			try {
                let loader = this.$loading.show();
                axios.post('/api/ReadFitur', {
					category: this.idart,
					id: this.iddetail
                })
                .then((response) => {
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

        async getDetailArtikel() {
            try {
                let loader = this.$loading.show();
                axios.get('/getDetailArticle', {
                    params:{
                        category: this.idart,
                        id: this.iddetail
                    }
                })
                .then((response) => {
                    this.article = response.data;
                    
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
            this.idart      = this.$route.params.idart;
            this.iddetail   = this.$route.params.detail;
            await this.getDetailArtikel();
        }
    },

    computed: {

    },

    watch: {
        '$route.params.detail': 'refreshData'
    }
};
</script>