<template>
    <div class="page-content">
        <section class="row">
            <div class="divider divider-left-center">
                <h2>KOLEKSI BUKU</h2>
                <div v-if="seeks">
                    <p>hasil pencarian buku dengan kata kunci <b>"{{ seeks }}"</b></p>
                </div>
            </div>
            <!-- Dropdown button to toggle filter options -->
			<div class="col-12 text-start mb-3">
				<div class="btn-group">
					<button type="button" class="btn btn-primary dropdown-toggle px-5 py-2" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,15">
						Kategori
					</button>
					<ul class="dropdown-menu">
						<li v-for="cat in category" :key="cat.id" class="dropdown-item py-3">
							<input type="checkbox" :id="cat.id" class="form-check-input me-2" :value="cat.id" v-model="selectedCategories" @change="filterBooks">
							<label :for="cat.id">
								<span class="text-start">{{ cat.description }}</span>
								<span class="text-muted text-end">
									( {{ cat.total }} )
								</span>
							</label>
						</li>
					</ul>
				</div>
			</div>
            <div class="col-12">
                <template v-if="paginatedBuku.length > 0">
                    <div class="row row-cols-2 row-cols-md-6">
                        <template v-for="(group, groupIndex) in paginatedBuku" :key="groupIndex">
                            <div v-for="buku in group" :key="buku.id" class="col">
                                <router-link :to="{ name: 'detail-buku', params: { idb: buku.isbn } }">
                                    <div class="card">
                                        <div class="card-content">
                                            <div class="product-image">
                                                <img :src="buku.image" :alt="buku.alt" class="img-fluid">
                                            </div>
                                            <div class="card-body pt-0">
                                                <p class="card-title mb-0">{{ buku.writer }}</p>
                                                <a href="#">
                                                    <h6 class="card-title mt-2" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" :title="buku.title">{{ buku.title }}</h6>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </router-link>
                            </div>
                        </template>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item" :class="{ disabled: currentPage === 1 }">
                                        <a class="page-link" href="#" @click.prevent="previousPage">Previous</a>
                                    </li>
                                    <li class="page-item" v-for="page in totalPages" :key="page" :class="{ active: currentPage === page }">
                                        <a class="page-link" href="#" @click.prevent="goToPage(page)">{{ page }}</a>
                                    </li>
                                    <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                                        <a class="page-link" href="#" @click.prevent="nextPage">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </template>
                <template v-else>
                    <div class="row text-center">
                        <h6>Buku Tidak tersedia</h6>
                    </div>
                </template>
            </div>
        </section>
    </div>
</template>

<script>
export default {
    data(){
        return {
            buku: [],
            category: [],
            seeks: '',
            selectedCategories: [], 
            currentPage: 1,
            itemsPerPage: 18
        }
    },

    mounted(){
        this.filterBooks();
        this.getCategory();
    },

    methods: {
        filterBooks() {
            let loader = this.$loading.show();
            window.axios.get('/getBook', {
                params: {
                    categories: this.selectedCategories,
                    search: this.searchQuery
                }
            })
            .then((response) => {
                this.seeks = this.searchQuery;
                this.buku = response.data;
                
                this.$router.push({ 
                    path: this.$route.path, 
                    query: {} 
                });

                loader.hide();
            })
            .catch((e) => {
                loader.hide();
                console.error(e)
            });
        },
        
        getCategory() {
            window.axios
            .get('/getCategory')
            .then((response) => {
                this.category = response.data;
            })
            .catch((e) => {
                console.error(e)
            });
        },

        previousPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        },

        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
            }
        },

        goToPage(page) {
            this.currentPage = page;
        }
    },

    computed:{
        searchQuery() {
            return this.$route.query.search || '';
        },

        totalBuku() {
            return this.buku.length;
        },

        totalPages() {
            return Math.ceil(this.totalBuku / this.itemsPerPage);
        },

        paginatedBuku() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            const currentItems = this.buku.slice(start, end);

            const chunkSize = 4;
            const grouped = [];

            for (let i = 0; i < currentItems.length; i += chunkSize) {
                grouped.push(currentItems.slice(i, i + chunkSize));
            }

            return grouped;
        }
    },

    watch: {
        searchQuery(newValue, oldValue) {
            if (newValue !== '') {
                this.selectedCategories = [];
                this.filterBooks();
            }
        }
    }
}
</script>

<style scoped>
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

    /* Media Queries untuk Mobile View */
    @media (max-width: 1200px) {
        .product-image {
            height: auto;
            padding: 10px;
        }

        .product-image img {
            width: 70%;
        }
    }

	.dropdown-menu {
        max-height: 350px; /* Limit height */
        overflow-y: auto;  /* Enable vertical scrolling */
    }

    .dropdown-item {
        display: flex;
        align-items: center;
    }

    .form-check-input {
        margin-right: 5px; /* Adjust checkbox spacing */
    }
</style>
