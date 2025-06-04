<template v-if="show">
  <div class="page-content">
    <section class="row mt-4">
      <div class="col-12 col-lg-12 align-items-center d-flex justify-content-center">
        <div class="card p-4">
          <h5>Scan Untuk Baca</h5>

          <div v-if="qrCodeDataUrl" class="mt-3">
            <img :src="qrCodeDataUrl" alt="QR Code" />
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import QRCode from 'qrcode'

export default {
  data() {
    return {
        show: false,
        idt: '',
        qrCodeDataUrl: ''
    }
  },

  created() {
    this.idt = this.$route.params.idt || ''
    this.CheckTitikBaca(this.idt)
    this.initializeSubMenu()
  },

  async mounted() {
    await this.generateQRCode()
  },

  methods: {
    initializeSubMenu() {
      let submenus = document.querySelectorAll('.submenu-item')
      submenus.forEach((submenu) => {
        submenu.querySelector('.submenu-link').addEventListener('click', (e) => {
          let navbar = document.querySelector('.main-navbar')
          if (navbar.classList.contains('active')) {
            navbar.classList.remove('active')
          }
          e.preventDefault()
        })
      })
    },

    CheckTitikBaca(id) {
        axios.get(`/check-titik-baca?idt=${id}`)
        .then((response) => {
            this.show = true
        })
        .catch((error) => {
            if (error.response && error.response.status === 404) {
                this.$router.push({ name: 'NotFound' });
            } else {
                console.error('Error checking Titik Baca:', error);
            }
        })
    },

    async generateQRCode() {
        try {
            const baseUrl = document.querySelector('meta[name="app-url"]')?.content;
            const scanLoginUrl = `${baseUrl}/scan-login/${this.idt}`;
            this.qrCodeDataUrl = await QRCode.toDataURL(scanLoginUrl);
        } catch (err) {
            console.error('QR Code generation failed:', err)
        }
    }
  }
}
</script>
