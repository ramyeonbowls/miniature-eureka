<template>
	<section class="section">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<!-- Zoom Level Selector -->
					<div class="zoom-selector">
						<select id="zoom" v-model="zoom">
							<option value="0.25">25%</option>
							<option value="0.5">50%</option>
							<option value="0.75">75%</option>
							<option value="1">100%</option>
							<option value="1.5">150%</option>
							<option value="2">200%</option>
						</select>
					</div>
				</div>
				<div class="card-body">
					<div class="d-flex justify-content-center align-items-center position-relative">
						<!-- Floating Pagination -->
						<nav aria-label="Page navigation example" class="pagination-float">
							<ul class="pagination pagination-primary justify-content-center">
								<li class="page-item"><a class="page-link" href="javascript:void(0);" @click="prevPage">Prev</a></li>
								<li class="page-item"><a class="page-link disabled" href="javascript:void(0);">{{ currentPage }}</a></li>
								<li class="page-item"><a class="page-link disabled" href="javascript:void(0);">/</a></li>
								<li class="page-item"><a class="page-link disabled" href="javascript:void(0);">{{ totalPages }}</a></li>
								<li class="page-item"><a class="page-link" href="javascript:void(0);" @click="nextPage">Next</a></li>
							</ul>
						</nav>
						<!-- PDF Viewer -->
						<VuePDF :pdf="pdf" :page="currentPage" :scale="zoom" text-layer />
						<div v-if="showTooltip" class="tooltip">
							<p>Click to copy</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</template>

<script>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useRoute } from 'vue-router'
import { VuePDF, usePDF } from '@tato30/vue-pdf'
import '@tato30/vue-pdf/style.css'

export default {
	name: 'AppReader',
	components: {
		VuePDF
	},

	data() {
		return {
			showTooltip: false,
			selectedText: '',
			zoom: 1, // Default zoom level
		};
	},

	setup() {
		const route = useRoute()
		const pdfToken = computed(() => decodeURIComponent(route.query.pdfToken) || '')
		const pdfUrl = computed(() => '/storage/pdf/' + pdfToken.value)
		const { pdf, pages } = usePDF(pdfUrl)
		const currentPage = ref(1)
		const totalPages = computed(() => pages.value)

		const prevPage = () => {
			if (currentPage.value > 1) {
				currentPage.value -= 1
			}
		}

		const nextPage = () => {
			if (currentPage.value < totalPages.value) {
				currentPage.value += 1
			}
		}

		const showTooltip = ref(false)
		const tooltipX = ref(0)
		const tooltipY = ref(0)

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
		})

		onUnmounted(() => {
			document.removeEventListener('selectionchange', handleTextSelection)
			document.removeEventListener('click', hideTooltip)
		})

		return {
			pdf,
			currentPage,
			totalPages,
			prevPage,
			nextPage,
			showTooltip,
			tooltipX,
			tooltipY
		}
	},

	mounted() {
		document.addEventListener('DOMContentLoaded', () => {
			let loader = this.$loading.show()
			setTimeout(() => {
				loader.hide()
			}, 1000)
		});
		document.addEventListener('keydown', this.preventCopy)
		document.addEventListener('contextmenu', this.disableRightClick)
	},

	beforeUnmount() {
		document.removeEventListener('contextmenu', this.disableRightClick)
		document.removeEventListener('keydown', this.preventCopy)
	},

	methods: {
		disableRightClick(event) {
			event.preventDefault();
		},

		preventCopy(event) {
			if (event.ctrlKey && event.key === 'c') {
				event.preventDefault();
				event.stopImmediatePropagation();
				console.log('Ctrl+C is disabled');
			}
		},
	}
}
</script>

<style scoped>
	.pagination-float {
		position: absolute;
		z-index: 10;
		bottom: 20px;
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
		margin-top: 10px;
		text-align: center;
		opacity: 0.3; /* Makes the pagination transparent */
		transition: opacity 0.3s ease;
	}
	.zoom-selector:hover {
		opacity: 0.7; /* Fully visible on hover */
	}
</style>
