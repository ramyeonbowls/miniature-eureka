<template>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <p class="text-subtitle text-muted">Nisa Amalia</p>
                <h3 class="mt-1">5 Manfaat Daun Pandan yang Populer di Masyarakat</h3>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-center align-items-center position-relative">
                    <!-- Floating Pagination -->
                    <nav aria-label="Page navigation example" class="pagination-float">
                        <ul class="pagination pagination-primary justify-content-center">
                            <li class="page-item"><a class="page-link" href="javascript:void(0);" @click="page = page > 1 ? page - 1 : page">Prev</a></li>
                            <li class="page-item"><a class="page-link disabled" href="javascript:void(0);">{{ page }}</a></li>
                            <li class="page-item"><a class="page-link disabled" href="javascript:void(0);">/</a></li>
                            <li class="page-item"><a class="page-link disabled" href="javascript:void(0);">{{ pages }}</a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void(0);" @click="page = page < pages ? page + 1 : page">Next</a></li>
                        </ul>
                    </nav>
                    <!-- PDF Viewer -->
                    <VuePDF :pdf="pdf" :page="page" />
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref } from 'vue'
import { VuePDF, usePDF } from '@tato30/vue-pdf'
import '@tato30/vue-pdf/style.css'

let page = ref(1)
let { pdf, pages } = usePDF('/storage/pdf/5 Manfaat Daun Pandan yang Populer di Masyarakat.pdf')
</script>

<style scoped>
.pagination-float {
    position: absolute;
    z-index: 10;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    opacity: 0.1; /* Makes the pagination transparent */
    transition: opacity 0.3s ease;
}
.pagination-float:hover {
    opacity: 0.7; /* Fully visible on hover */
}
</style>
