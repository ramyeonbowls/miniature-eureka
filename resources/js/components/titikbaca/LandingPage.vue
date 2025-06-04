<template v-if="show">
  <div class="page-content">
    <section class="row mt-4">
      <div class="col-12 col-lg-12 align-items-center d-flex justify-content-center">
        <div class="card p-4">
          <h3 class="text-center">Scan Untuk Baca</h3>

          <div v-if="qrCodeDataUrl" class="mt-3 qr-container mx-0">
            <img :src="qrCodeDataUrl" alt="QR Code" />
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<style scoped>
    .qr-container {
        background: #ffffff;
        padding: 10px;
        border-radius: 12px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        max-width: 100%;
        width: 300px;
        text-align: center;
    }

    .qr-container img {
        width: 100%;
        height: auto;
        max-width: 250px;
    }

    .qr-container p {
        font-size: 1rem;
        margin-bottom: 12px;
        color: #003366;
        font-weight: bold;
    }

    @media (max-width: 480px) {
        .qr-container {
            width: 80%;
            padding: 16px;
        }

        .qr-container img {
            max-width: 200px;
        }

        .qr-container p {
            font-size: 0.95rem;
        }
    }
</style>

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
