<template>
    <section class="section">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-center align-items-center position-relative">
                        <!-- Zoom Level Selector -->
                        <div class="zoom-selector">
                            <select id="zoom" v-model="zoom" @change="renderPage">
                                <option value="0.25">25%</option>
                                <option value="0.5">50%</option>
                                <option value="0.75">75%</option>
                                <option value="1">100%</option>
                                <option value="1.5">150%</option>
                                <option value="2">200%</option>
                            </select>
                        </div>
                        
                        <!-- Floating Pagination -->
                        <nav aria-label="Page navigation" class="pagination-float">
                            <ul class="pagination pagination-primary justify-content-center">
                                <li class="page-item"><a class="page-link" href="javascript:void(0);" @click="prevPage">Prev</a></li>
                                <li class="page-item"><a class="page-link disabled" href="javascript:void(0);">{{ currentPage }}</a></li>
                                <li class="page-item"><a class="page-link disabled" href="javascript:void(0);">/</a></li>
                                <li class="page-item"><a class="page-link disabled" href="javascript:void(0);">{{ totalPages }}</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);" @click="nextPage">Next</a></li>
                            </ul>
                        </nav>
                        
                        <!-- PDF Viewer -->
                        <canvas ref="pdfCanvas"></canvas>
                        
                        <!-- Tooltip -->
                        <div v-if="showTooltip" class="tooltip" :style="{ top: tooltipY + 'px', left: tooltipX + 'px' }">
                            <p>Click to copy</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, watch, onMounted, onUnmounted } from 'vue'
import { useRoute } from 'vue-router'
import * as pdfjsLib from 'pdfjs-dist'

pdfjsLib.GlobalWorkerOptions.workerSrc = new URL('pdfjs-dist/build/pdf.worker.mjs', import.meta.url).toString()

const pdfUrl = ref(null)
const pdfCanvas = ref(null)
const currentPage = ref(1)
const totalPages = ref(1)
const zoom = ref(1)

const showTooltip = ref(false)
const tooltipX = ref(0)
const tooltipY = ref(0)
let pdfDocument = null

// State untuk swipe gesture
let touchStartX = 0
let touchEndX = 0

const route = useRoute()

watch(() => route.query.pdfToken, (newId, oldId) => {
        loadDecryptedPdf(newId)
    }
)

// Fetch and render the PDF
const loadDecryptedPdf = async (id) => {
    try {
        const response = await window.axios.get('/book-pdf', {
            responseType: 'blob',
            params: {
                token: id,
            },
        })
        const fileURL = URL.createObjectURL(new Blob([response.data], { type: 'application/pdf' }))
        pdfUrl.value = fileURL
        pdfDocument = await pdfjsLib.getDocument(fileURL).promise
        totalPages.value = pdfDocument.numPages
        renderPage()
    } catch (error) {
        console.error('Error fetching PDF:', error)
    }
}

// Render the current page
const renderPage = async () => {
    const page = await pdfDocument.getPage(currentPage.value)
    const viewport = page.getViewport({ scale: zoom.value })
    const canvas = pdfCanvas.value
    const context = canvas.getContext('2d')

    canvas.height = viewport.height
    canvas.width = viewport.width

    const renderContext = {
        canvasContext: context,
        viewport: viewport
    }
    await page.render(renderContext).promise
}

const prevPage = () => {
    if (currentPage.value > 1) {
        currentPage.value -= 1
        renderPage()
    }
}

const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value += 1
        renderPage()
    }
}

// Swipe detection
const handleTouchStart = (event) => {
    touchStartX = event.changedTouches[0].screenX
}

const handleTouchMove = (event) => {
    touchEndX = event.changedTouches[0].screenX
}

const handleTouchEnd = () => {
    if (touchEndX < touchStartX - 50) {
        // Swipe left, next page
        nextPage()
    }
    if (touchEndX > touchStartX + 50) {
        // Swipe right, previous page
        prevPage()
    }
}

const handleTextSelection = (event) => {
    const selection = window.getSelection()
    if (selection.toString()) {
        const range = selection.getRangeAt(0)
        const rect = range.getBoundingClientRect()
        tooltipX.value = rect.left + window.scrollX
        tooltipY.value = rect.top + window.scrollY - 30
        showTooltip.value = true
    }
}

const hideTooltip = () => {
    showTooltip.value = false
}

onMounted(() => {
    document.addEventListener('selectionchange', handleTextSelection)
    document.addEventListener('click', hideTooltip)

    // Tambahkan event listener untuk swipe gesture
    pdfCanvas.value.addEventListener('touchstart', handleTouchStart)
    pdfCanvas.value.addEventListener('touchmove', handleTouchMove)
    pdfCanvas.value.addEventListener('touchend', handleTouchEnd)
})

onUnmounted(() => {
    document.removeEventListener('selectionchange', handleTextSelection)
    document.removeEventListener('click', hideTooltip)

    // Hapus event listener untuk swipe gesture
    pdfCanvas.value.removeEventListener('touchstart', handleTouchStart)
    pdfCanvas.value.removeEventListener('touchmove', handleTouchMove)
    pdfCanvas.value.removeEventListener('touchend', handleTouchEnd)
})
</script>

<style scoped>
.pagination-float {
    position: absolute;
    z-index: 10;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    opacity: 0.3; /* Makes the pagination transparent */
    transition: opacity 0.3s ease;
}
.pagination-float:hover {
    opacity: 0.7; /* Fully visible on hover */
}
.tooltip {
    position: absolute;
    background-color: #ff0000;
    border: 1px solid #ccc;
    padding: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    cursor: pointer;
}
.zoom-selector {
    position: absolute;
    z-index: 10;
    top: 10px;
    left: 50%;
    transform: translateX(-50%);
    opacity: 0.3; /* Makes the zoom selector transparent */
    transition: opacity 0.3s ease;
}
.zoom-selector:hover {
    opacity: 0.7; /* Fully visible on hover */
}
</style>
