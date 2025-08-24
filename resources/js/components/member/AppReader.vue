<template>
	<section class="row">
		<nav class="navbar py-2 d-flex justify-content-end" style="background-color: #435ebe; color: white;">
			<button class="btn btn-danger" @click="SelesaiBaca">Selesai Baca</button>
		</nav>
	</section>
    <section class="section" id="pdf-container">
        <div class="d-flex justify-content-center align-items-center position-relative overflow-auto">
            <!-- Floating Pagination -->
            <nav aria-label="Page navigation example" class="pagination-float">
                <ul class="pagination pagination-primary justify-content-center">
                    <li class="page-item"><a style="background-color: #435ebe; color: white;" class="page-link" href="javascript:void(0);" @click="prevPage">Prev</a></li>
                    <li class="page-item"><a style="background-color: #435ebe; color: white;" class="page-link disabled" href="javascript:void(0);">{{ currentPage }}</a></li>
                    <li class="page-item"><a style="background-color: #435ebe; color: white;" class="page-link disabled" href="javascript:void(0);">/</a></li>
                    <li class="page-item"><a style="background-color: #435ebe; color: white;" class="page-link disabled" href="javascript:void(0);">{{ totalPages }}</a></li>
                    <li class="page-item"><a style="background-color: #435ebe; color: white;" class="page-link" href="javascript:void(0);" @click="nextPage">Next</a></li>
                    <li class="page-item">
                        <select id="zoom" v-model="zoom" @change="renderPage" class="page-link h-100" style="background-color: #435ebe; color: white;">
                            <option value="0.25">25%</option>
                            <option value="0.5">50%</option>
                            <option value="0.75">75%</option>
                            <option value="1">100%</option>
                            <option value="1.5">150%</option>
                            <option value="2">200%</option>
                        </select></li>
                </ul>
            </nav>
            
            <!-- PDF Viewer -->
            <canvas ref="pdfCanvas"></canvas>
            
            <!-- Tooltip -->
            <div v-if="showTooltip" class="tooltip" :style="{ top: tooltipY + 'px', left: tooltipX + 'px' }">
                <p>Click to copy</p>
            </div>
        </div>

        <loading
            :active="isLoading" 
            :can-cancel="false"
            :is-full-page="true"
            :duration="0"
            :overlay="true"
            :spinner="true"
            :color="'#8080ff'"
            :background-color="'#111111'"
            :width="110"
            :height="110"
            :opacity="0.4"
            :z-index="1999"
            text="'Mohon Tunggu'"
        />
    </section>
    <div class="no-print">
        <p class="text-center">This content Cannot printing.</p>
    </div>
</template>

<script setup>
import { ref, watch, onMounted, onUnmounted } from 'vue'
import { useRoute } from 'vue-router'
import * as pdfjsLib from 'pdfjs-dist'
import Loading from 'vue-loading-overlay'
import 'vue-loading-overlay/dist/css/index.css'
import Swal from 'sweetalert2'

pdfjsLib.GlobalWorkerOptions.workerSrc = new URL('pdfjs-dist/build/pdf.worker.mjs', import.meta.url).toString()

const pdfUrl = ref(null)
const pdfCanvas = ref(null)
const currentPage = ref(1)
const totalPages = ref(1)
const zoom = ref(1)
const isLoading = ref(false)

const showTooltip = ref(false)
const tooltipX = ref(0)
const tooltipY = ref(0)
let pdfDocument = null

// State untuk swipe gesture
let touchStartX = 0
let touchEndX = 0

const route = useRoute()
let datenow = ref('')
let book_id = ref(route.query.pdfToken)

let timeout;

watch(() => route.query.pdfToken, (newId, oldId) => {
        book_id.value = newId
        loadDecryptedPdf(newId)
    }
)
 
// Fetch and render the PDF
const loadDecryptedPdf = async (id) => {
    isLoading.value = true
    try {
        const response = await window.axios.get('/book-pdf', {
            responseType: 'blob',
            params: {
                token: id,
            },
        })
        if (book_id.value) SendLastRead('N')

        const fileURL = URL.createObjectURL(new Blob([response.data], { type: 'application/pdf' }))
        pdfUrl.value = fileURL
        pdfDocument = await pdfjsLib.getDocument(fileURL).promise
        totalPages.value = pdfDocument.numPages
        renderPage()
    } catch (error) {
        console.error('Error fetching PDF:', error)
    } finally {
        isLoading.value = false
    }
}

// Render the current page
const renderPage = async () => {
    try{
        // Assume zoom.value is the zoom factor that users can adjust, e.g., 1 for 100%, 1.5 for 150%, etc.
		const page = await pdfDocument.getPage(currentPage.value);

		// Get the container dimensions
		const container = document.getElementById('pdf-container'); // Adjust this to your container element
		const containerWidth = container.clientWidth;
		const containerHeight = container.clientHeight;

		// Calculate the initial scale to fit the container
		const initialViewport = page.getViewport({ scale: 1 });
		const scaleX = window.innerWidth / initialViewport.width;
		const scaleY = window.innerHeight / initialViewport.height;
		const baseScale = Math.min(scaleX, scaleY); // Choose the smaller scale to fit the container

		// Apply the zoom factor
		const scale = baseScale * zoom.value;

		// Update the viewport with the new scale
		const viewport = page.getViewport({ scale });

		const canvas = pdfCanvas.value;
		const context = canvas.getContext('2d');

		const outputScale = window.devicePixelRatio || 1;

		canvas.width = Math.floor(viewport.width * outputScale);
		canvas.height = Math.floor(viewport.height * outputScale);
		canvas.style.width = Math.floor(viewport.width) + 'px';
		canvas.style.height = Math.floor(viewport.height) + 'px';

		context.scale(outputScale, outputScale);

		const renderContext = {
			canvasContext: context,
			viewport: viewport
		};
		await page.render(renderContext).promise;
    } finally {

    }
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

const disableRightClick = (event) => {
    event.preventDefault();
}

const preventCopy = (event) => {
    if (event.ctrlKey && event.key === 'c') {
        event.preventDefault();
        event.stopImmediatePropagation();
    }
}

const preventSave = (event) => {
    if (event.ctrlKey && event.key === 's') {
        event.preventDefault();
        event.stopImmediatePropagation();
    }
}

const preventPrint = (event) => {
    if (event.ctrlKey && event.key === 'p') {
        event.preventDefault();
        event.stopImmediatePropagation();
    }
}

const handleArrowKey = (event) => {
    if (event.key === 'ArrowRight') {
        nextPage()
    }
    if (event.key === 'ArrowLeft') {
        prevPage()
    }
}

const getCurrentDateTime = () => {
    const currentDateTime = new Date()
    const year = currentDateTime.getFullYear()
    const month = String(currentDateTime.getMonth() + 1).padStart(2, '0')
    const day = String(currentDateTime.getDate()).padStart(2, '0')
    const hours = String(currentDateTime.getHours()).padStart(2, '0')
    const minutes = String(currentDateTime.getMinutes()).padStart(2, '0')
    const seconds = String(currentDateTime.getSeconds()).padStart(2, '0')

    datenow = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`
}

const SendLastRead = async (param) => {
    try {
        const useruuid = sessionStorage.getItem("uuid");
        await window.axios.post('/LastRead', {
            start: datenow,
            token: book_id.value,
            useruuid: useruuid,
            active: param
        });
    } catch (error) {
        console.error('Error sending request:', error);
    }
}

const getCsrfToken = () => {
    return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
}

const SendLastReadSync = (param) => {
    const useruuid = sessionStorage.getItem("uuid");
    const csrfToken = getCsrfToken();
    const data = JSON.stringify({
        start: datenow,
        token: book_id.value,
        useruuid: useruuid,
        active: param,
        _token: csrfToken
    });

    if (navigator.sendBeacon) {
        const blob = new Blob([data], { type: 'application/json' });
        navigator.sendBeacon("/LastRead", blob);
    } else {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "/LastRead", false);
        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        xhr.setRequestHeader("X-CSRF-TOKEN", csrfToken);
        xhr.send(data);
    }
}

const SelesaiBaca = async () => {
    await SendLastRead('Y');
    window.location.href = '/';
}

const handleUnload = () => {
    SendLastReadSync('Y');
};

const handleBeforeUnload = (event) => {
    SendLastReadSync('Y');
}

const showInactivityPopup = () => {
    // console.log('inactive');
    
    Swal.fire({
        title: 'Halo',
        text: 'Apakah Anda Masih Membaca Buku Ini?',
        icon: 'warning',
        timer: 60000,
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak',
        onOpen: () => {
            const timerInterval = setInterval(() => {

            }, 100);

            Swal.getCancelButton().onclick = () => {
                clearInterval(timerInterval);
            };

            Swal.getConfirmButton().onclick = () => {
                clearInterval(timerInterval);
                resetInactivityTimer();
            };
        }
    }).then((result) => {
        if (result.dismiss === Swal.DismissReason.timer) {
            SelesaiBaca();
        } else if (result.isConfirmed) {
            resetInactivityTimer();
        } else {
            SelesaiBaca();
        }
    });
}

// Function to reset the inactivity timer
const resetInactivityTimer = () => {
    clearTimeout(timeout);
    timeout = setTimeout(showInactivityPopup, 300000);
}

// Setup event listeners to reset the timer on activity
const resetTimerOnActivity = () => {
    // console.log('active');
    
    resetInactivityTimer();
}

onMounted(() => {
    document.addEventListener('selectionchange', handleTextSelection)
    document.addEventListener('click', hideTooltip)

    // Tambahkan event listener untuk swipe gesture
    pdfCanvas.value.addEventListener('touchstart', handleTouchStart)
    pdfCanvas.value.addEventListener('touchmove', handleTouchMove)
    pdfCanvas.value.addEventListener('touchend', handleTouchEnd)
    document.addEventListener('keydown', preventSave)
    document.addEventListener('keydown', preventPrint)
    document.addEventListener('keydown', preventCopy)
    document.addEventListener('keydown', handleArrowKey)
    document.addEventListener('contextmenu', disableRightClick)
    
    getCurrentDateTime()
    setInterval(() => SendLastRead('N'), 300000)
    window.addEventListener('beforeunload', handleBeforeUnload)
    window.addEventListener('unload', handleUnload)

    document.addEventListener('mousemove', resetTimerOnActivity);
    document.addEventListener('keydown', resetTimerOnActivity);
    document.addEventListener('click', resetTimerOnActivity);
    document.addEventListener('scroll', resetTimerOnActivity);
})

onUnmounted(() => {
    document.removeEventListener('selectionchange', handleTextSelection)
    document.removeEventListener('click', hideTooltip)

    // Hapus event listener untuk swipe gesture
    pdfCanvas.value.removeEventListener('touchstart', handleTouchStart)
    pdfCanvas.value.removeEventListener('touchmove', handleTouchMove)
    pdfCanvas.value.removeEventListener('touchend', handleTouchEnd)
    document.removeEventListener('keydown', preventSave)
    document.removeEventListener('keydown', preventPrint)
    document.removeEventListener('keydown', preventCopy)
    document.removeEventListener('keydown', handleArrowKey)
    document.removeEventListener('contextmenu', disableRightClick)

    window.removeEventListener('beforeunload', handleBeforeUnload)
    window.removeEventListener('unload', handleUnload)

    clearTimeout(timeout);
    document.removeEventListener('mousemove', resetTimerOnActivity);
    document.removeEventListener('keydown', resetTimerOnActivity);
    document.removeEventListener('click', resetTimerOnActivity);
    document.removeEventListener('scroll', resetTimerOnActivity);
})
</script>

<style scoped>

#pdf-container {
  position: relative;
  overflow: hidden;
  width: 100%;
  height: 90%;
  min-height: 90vh;
}
.pagination-float {
    position: fixed; /* Use fixed to make it always visible at the bottom */
    z-index: 10;
    bottom: 0px; /* Space it a bit from the bottom */
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

.no-print {
    display: none !important;
}

.logo-overlay {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%; /* Full height of the overlay */
}

.spinner-logo {
    width: 80px; /* Adjust logo size */
    height: auto; /* Maintain aspect ratio */
    position: absolute; /* Position it in the center */
    z-index: 10; /* Ensure logo is above the spinner */
}

@media print {
    .section {
        display: none !important; /* Hide all elements */
    }

    /* Optionally, show specific elements */
    .no-print {
        display: block !important;
    }
}

@media (max-width: 1200px) {
    .pagination-float {
        position: fixed; /* Use fixed to make it always visible at the bottom */
		z-index: 10;
		bottom: 0px; /* Space it a bit from the bottom */
        left: 50%;
        opacity: 0.7;
    }
}
</style>
