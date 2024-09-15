<template>
    <p>{{ pdfToken }}</p>
    <div class="pdf-viewer">
      <div class="toolbar">
        <button @click="previousPage" :disabled="currentPage <= 1" class="btn btn-primary">Previous</button>
        <button @click="nextPage" :disabled="currentPage >= totalPages" class="btn btn-primary">Next</button>
        <span>Page {{ currentPage }} of {{ totalPages }}</span>
        <div class="zoom-controls btn-group">
          <button @click="zoomOut" class="btn btn-secondary">-</button>
          <span>Zoom: {{ zoomLevel * 100 }}%</span>
          <button @click="zoomIn" class="btn btn-secondary">+</button>
        </div>
        <button @click="toggleAnnotationMode" class="btn btn-info">{{ isAnnotating ? 'Stop Annotating' : 'Start Annotating' }}</button>
        <button @click="togglePencilMode" class="btn btn-info">{{ isPencilMode ? 'Stop Freehand' : 'Start Freehand' }}</button>
        <button @click="searchPdf" class="btn btn-info">Search</button>
        <button @click="toggleSidebar" class="btn btn-info">{{ isSidebarOpen ? 'Close Sidebar' : 'Open Sidebar' }}</button>
      </div>
      <div class="pdf-container">
        <canvas ref="pdfCanvas" @mousedown="startDrawing" @mouseup="stopDrawing" @mousemove="draw" @click="addAnnotation"></canvas>
      </div>
      <div class="annotation-form" v-if="isAnnotating">
        <textarea v-model="newAnnotation" class="form-control" placeholder="Type your annotation here..."></textarea>
        <button @click="saveAnnotation" class="btn btn-success">Save Annotation</button>
      </div>
      <div class="sidebar" v-if="isSidebarOpen">
        <h3>Pages</h3>
        <ul>
          <li v-for="page in totalPages" :key="page" @click="gotoPage(page)" class="list-group-item">Page {{ page }}</li>
        </ul>
      </div>
    </div>
  </template>
  
  <script>
  import { ref, onMounted, watch } from 'vue';
  import * as pdfjsLib from 'pdfjs-dist/legacy/build/pdf';
  
  export default {
    name: 'AppReader',
    data() {
      return {
        pdfUrl: '',
      };
    },
    setup() {
      const pdfCanvas = ref(null);
      const currentPage = ref(1);
      const totalPages = ref(0);
      const zoomLevel = ref(1);
      const isAnnotating = ref(false);
      const isPencilMode = ref(false);
      const isSidebarOpen = ref(false);
      const newAnnotation = ref('');
      const isRendering = ref(false);
      let pdfDoc = null;
      let annotations = ref([]);
      let drawing = false;
      let context = null;
  
      // Set up PDF.js worker
      pdfjsLib.GlobalWorkerOptions.workerSrc = new URL(
        'pdfjs-dist/build/pdf.worker.mjs',
        import.meta.url
      ).toString();
  
      const loadPdf = async () => {
        const url = '/storage/pdf/5 Manfaat Daun Pandan yang Populer di Masyarakat.pdf';
        pdfDoc = await pdfjsLib.getDocument(url).promise;
        totalPages.value = pdfDoc.numPages;
        renderPage(currentPage.value);
      };
  
      const renderPage = async (pageNum) => {
        if (isRendering.value) return;
        isRendering.value = true;
  
        try {
          const page = await pdfDoc.getPage(pageNum);
          const viewport = page.getViewport({ scale: zoomLevel.value });
          const canvas = pdfCanvas.value;
          context = canvas.getContext('2d');
          canvas.width = viewport.width;
          canvas.height = viewport.height;
  
          await page.render({
            canvasContext: context,
            viewport: viewport
          }).promise;
  
          // Draw annotations and freehand
          drawAnnotations(context);
          drawFreehand(context);
        } finally {
          isRendering.value = false;
        }
      };
  
      const drawAnnotations = (context) => {
        annotations.value.forEach(annot => {
          if (annot.page === currentPage.value) {
            context.font = '16px Arial';
            context.fillStyle = 'red';
            context.fillText(annot.text, annot.x, annot.y);
          }
        });
      };
  
      const drawFreehand = (context) => {
        if (isPencilMode.value && drawing) {
          context.strokeStyle = 'blue';
          context.lineWidth = 2;
          context.lineCap = 'round';
          context.lineJoin = 'round';
        }
      };
  
      const previousPage = () => {
        if (currentPage.value > 1) {
          currentPage.value--;
          renderPage(currentPage.value);
        }
      };
  
      const nextPage = () => {
        if (currentPage.value < totalPages.value) {
          currentPage.value++;
          renderPage(currentPage.value);
        }
      };
  
      const zoomIn = () => {
        zoomLevel.value += 0.1;
        renderPage(currentPage.value);
      };
  
      const zoomOut = () => {
        if (zoomLevel.value > 0.2) {
          zoomLevel.value -= 0.1;
          renderPage(currentPage.value);
        }
      };
  
      const toggleAnnotationMode = () => {
        isAnnotating.value = !isAnnotating.value;
      };
  
      const togglePencilMode = () => {
        isPencilMode.value = !isPencilMode.value;
      };
  
      const searchPdf = () => {
        // Implement search functionality here
      };
  
      const toggleSidebar = () => {
        isSidebarOpen.value = !isSidebarOpen.value;
      };
  
      const addAnnotation = (event) => {
        if (isAnnotating.value) {
          const canvas = pdfCanvas.value;
          const rect = canvas.getBoundingClientRect();
          const x = event.clientX - rect.left;
          const y = event.clientY - rect.top;
          annotations.value.push({
            page: currentPage.value,
            x,
            y,
            text: newAnnotation.value
          });
          renderPage(currentPage.value);
          newAnnotation.value = '';
          autosaveAnnotations();
        }
      };
  
      const startDrawing = (event) => {
        if (isPencilMode.value) {
          drawing = true;
          const canvas = pdfCanvas.value;
          const rect = canvas.getBoundingClientRect();
          context.beginPath();
          context.moveTo(event.clientX - rect.left, event.clientY - rect.top);
        }
      };
  
      const stopDrawing = () => {
        if (isPencilMode.value) {
          drawing = false;
          context.closePath();
        }
      };
  
      const draw = (event) => {
        if (isPencilMode.value && drawing) {
          const canvas = pdfCanvas.value;
          const rect = canvas.getBoundingClientRect();
          context.lineTo(event.clientX - rect.left, event.clientY - rect.top);
          context.stroke();
        }
      };
  
      const saveAnnotation = () => {
        if (newAnnotation.value.trim()) {
          addAnnotation({ clientX: 100, clientY: 100 }); // Dummy coordinates, you should add real interaction
          newAnnotation.value = '';
        }
      };
  
      const gotoPage = (pageNum) => {
        currentPage.value = pageNum;
        renderPage(pageNum);
      };
  
      const autosaveAnnotations = () => {
        // Implement autosave functionality here
      };
  
      watch([currentPage, zoomLevel], () => {
        renderPage(currentPage.value);
      });
  
      onMounted(() => {
        loadPdf();
      });
  
      return {
        pdfCanvas,
        currentPage,
        totalPages,
        zoomLevel,
        isAnnotating,
        isPencilMode,
        isSidebarOpen,
        newAnnotation,
        previousPage,
        nextPage,
        zoomIn,
        zoomOut,
        toggleAnnotationMode,
        togglePencilMode,
        searchPdf,
        toggleSidebar,
        saveAnnotation,
        addAnnotation,
        startDrawing,
        stopDrawing,
        draw,
        gotoPage
      };
    },
  
    mounted(){
  
    },
  
    computed:{
      pdfToken() {
        return decodeURIComponent(this.$route.query.pdfToken) || '';
      }
    }
  };
  </script>
  
  <style scoped>
  .pdf-viewer {
    max-width: 800px;
    margin: 0 auto;
    font-family: Arial, sans-serif;
  }
  
  .toolbar {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
  }
  
  button {
    padding: 5px 10px;
    cursor: pointer;
  }
  
  button:disabled {
    cursor: not-allowed;
    opacity: 0.5;
  }
  
  .zoom-controls {
    display: flex;
    align-items: center;
  }
  
  .zoom-controls button {
    padding: 5px;
    cursor: pointer;
  }
  
  .pdf-container {
    border: 1px solid #ddd;
    padding: 10px;
    position: relative;
  }
  
  canvas {
    display: block;
    margin: 0 auto;
  }
  
  .annotation-form {
    margin-top: 10px;
  }
  
  .annotation-form textarea {
    width: 100%;
    height: 60px;
  }
  
  .sidebar {
    position: absolute;
    right: 0;
    top: 0;
    width: 200px;
    background-color: #f4f4f4;
    border-left: 1px solid #ddd;
    padding: 10px;
  }
  
  .sidebar h3 {
    margin-top: 0;
  }
  
  .sidebar ul {
    list-style: none;
    padding: 0;
  }
  
  .sidebar li {
    padding: 5px;
    cursor: pointer;
  }
  
  .sidebar li:hover {
    background-color: #ddd;
  }
  </style>
  