<template>
    <action-bar :data="menu" :menu-label="menu.menu_label"></action-bar>

    <!-- filter modal -->
    <div class="modal fade text-left modal-borderless" id="border-less" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Filter</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="row">
                                <div class="col-md-12 mb-12">
                                    <div class="form-group">
                                        <label for="basicSelect1" class="form-label">Provinsi</label>
                                        <select class="form-select" id="basicSelect1">
                                            <option>--</option>
                                            <option>Jawa Barat</option>
                                            <option>Jawa TengaH</option>
                                            <option>DKI Jakarta</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-12">
                                    <div class="form-group">
                                        <label for="basicSelect2" class="form-label">Kabupaten/Kota</label>
                                        <select class="form-select" id="basicSelect2">
                                            <option>--</option>
                                            <option>Bandung</option>
                                            <option>Jakarta Pusat</option>
                                            <option>Semarang</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-12">
                                    <div class="form-group">
                                        <label for="basicSelect3" class="form-label">White Label</label>
                                        <select class="form-select" id="basicSelect3">
                                            <option>--</option>
                                            <option>Gramedia</option>
                                            <option>Mizan</option>
                                            <option>Erlangga</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-12">
                                    <div class="form-group">
                                        <label for="sdate" class="form-label">Tanggal</label>
                                        <Flatpickr v-model="filter.date" class="form-control flatpickr-range" :config="configdate" placeholder="Select date.."></Flatpickr>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary ms-1" data-bs-dismiss="modal">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Proses Data</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- filter modal -->

    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="buttons">
                    <a href="#" class="btn icon icon-left btn-primary" data-bs-toggle="modal" data-bs-target="#border-less"><i class="bi bi-filter-square-fill"></i> Filter</a>
                    <a href="#" class="btn icon icon-left btn-success"><i class="bi bi-file-earmark-excel-fill"></i> Export</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Penerbit Buku</th>
                            <th>Provinsi</th>
                            <th>Kab/Kota</th>
                            <th>Judul Berita</th>
                            <th>Jumlah Pembaca</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Gramedia</td>
                            <td>Jawa Barat</td>
                            <td>Bandung</td>
                            <td>Teknologi Baru di Indonesia</td>
                            <td>1200</td>
                        </tr>
                        <tr>
                            <td>Erlangga</td>
                            <td>Jawa Timur</td>
                            <td>Surabaya</td>
                            <td>Pendidikan Jarak Jauh Mulai Populer</td>
                            <td>950</td>
                        </tr>
                        <tr>
                            <td>Visimedia</td>
                            <td>Sumatera Utara</td>
                            <td>Medan</td>
                            <td>Ekonomi Indonesia Melambat</td>
                            <td>1120</td>
                        </tr>
                        <tr>
                            <td>Mizan</td>
                            <td>Jawa Tengah</td>
                            <td>Semarang</td>
                            <td>Peluncuran Aplikasi Kesehatan Baru</td>
                            <td>875</td>
                        </tr>
                        <tr>
                            <td>Balai Pustaka</td>
                            <td>DI Yogyakarta</td>
                            <td>Yogyakarta</td>
                            <td>Seni Tradisional Kembali Populer</td>
                            <td>1020</td>
                        </tr>
                        <tr>
                            <td>Penebar Swadaya</td>
                            <td>Bali</td>
                            <td>Denpasar</td>
                            <td>Pariwisata Bali Kembali Bergeliat</td>
                            <td>1340</td>
                        </tr>
                        <tr>
                            <td>Harfeey</td>
                            <td>Kalimantan Timur</td>
                            <td>Samarinda</td>
                            <td>Pertumbuhan Ekonomi Daerah</td>
                            <td>860</td>
                        </tr>
                        <tr>
                            <td>Zikrul</td>
                            <td>Sulawesi Selatan</td>
                            <td>Makassar</td>
                            <td>Pembangunan Infrastruktur Baru</td>
                            <td>1190</td>
                        </tr>
                        <tr>
                            <td>Pustaka Utama</td>
                            <td>Banten</td>
                            <td>Tangerang</td>
                            <td>Pabrik Otomotif Dibuka di Tangerang</td>
                            <td>945</td>
                        </tr>
                        <tr>
                            <td>Gramedia</td>
                            <td>Jawa Barat</td>
                            <td>Bekasi</td>
                            <td>Tren Pendidikan di Era Digital</td>
                            <td>880</td>
                        </tr>
                        <tr>
                            <td>Erlangga</td>
                            <td>Jawa Timur</td>
                            <td>Malang</td>
                            <td>Inovasi Baru di Bidang Pertanian</td>
                            <td>980</td>
                        </tr>
                        <tr>
                            <td>Visimedia</td>
                            <td>Sumatera Selatan</td>
                            <td>Palembang</td>
                            <td>Krisis Air Bersih di Sumatera Selatan</td>
                            <td>1125</td>
                        </tr>
                        <tr>
                            <td>Mizan</td>
                            <td>Jawa Tengah</td>
                            <td>Solo</td>
                            <td>Kerajinan Lokal Mulai Diminati</td>
                            <td>1060</td>
                        </tr>
                        <tr>
                            <td>Balai Pustaka</td>
                            <td>Sumatera Barat</td>
                            <td>Padang</td>
                            <td>Pangan Lokal Mendunia</td>
                            <td>1015</td>
                        </tr>
                        <tr>
                            <td>Penebar Swadaya</td>
                            <td>Kalimantan Barat</td>
                            <td>Pontianak</td>
                            <td>Festival Budaya Digelar di Pontianak</td>
                            <td>950</td>
                        </tr>
                        <tr>
                            <td>Harfeey</td>
                            <td>Jawa Barat</td>
                            <td>Depok</td>
                            <td>Pembangunan Infrastruktur Berkelanjutan</td>
                            <td>1100</td>
                        </tr>
                        <tr>
                            <td>Zikrul</td>
                            <td>Sulawesi Utara</td>
                            <td>Manado</td>
                            <td>Transportasi Publik yang Semakin Modern</td>
                            <td>975</td>
                        </tr>
                        <tr>
                            <td>Pustaka Utama</td>
                            <td>Jawa Timur</td>
                            <td>Blitar</td>
                            <td>Pabrik Baru Dibuka di Blitar</td>
                            <td>925</td>
                        </tr>
                        <tr>
                            <td>Gramedia</td>
                            <td>DKI Jakarta</td>
                            <td>Jakarta</td>
                            <td>Peran Startup dalam Ekonomi Indonesia</td>
                            <td>1150</td>
                        </tr>
                        <tr>
                            <td>Erlangga</td>
                            <td>Bali</td>
                            <td>Kuta</td>
                            <td>Peningkatan Wisatawan di Bali</td>
                            <td>1045</td>
                        </tr>
                        <tr>
                            <td>Visimedia</td>
                            <td>Jawa Tengah</td>
                            <td>Magelang</td>
                            <td>Penemuan Arkeologi di Magelang</td>
                            <td>1105</td>
                        </tr>
                        <tr>
                            <td>Mizan</td>
                            <td>Riau</td>
                            <td>Pekanbaru</td>
                            <td>Pertumbuhan Ekonomi Daerah</td>
                            <td>995</td>
                        </tr>
                        <tr>
                            <td>Balai Pustaka</td>
                            <td>Nusa Tenggara Timur</td>
                            <td>Ende</td>
                            <td>Budaya Lokal yang Mendunia</td>
                            <td>925</td>
                        </tr>
                        <tr>
                            <td>Penebar Swadaya</td>
                            <td>Kalimantan Tengah</td>
                            <td>Palangkaraya</td>
                            <td>Krisis Lingkungan di Palangkaraya</td>
                            <td>1085</td>
                        </tr>
                        <tr>
                            <td>Harfeey</td>
                            <td>Jawa Timur</td>
                            <td>Kediri</td>
                            <td>Peningkatan UMKM Lokal</td>
                            <td>1140</td>
                        </tr>
                        <tr>
                            <td>Zikrul</td>
                            <td>Sulawesi Tenggara</td>
                            <td>Kendari</td>
                            <td>Infrastruktur Baru Diresmikan</td>
                            <td>1020</td>
                        </tr>
                        <tr>
                            <td>Pustaka Utama</td>
                            <td>Kalimantan Timur</td>
                            <td>Balikpapan</td>
                            <td>Industri Energi Terbarukan</td>
                            <td>1155</td>
                        </tr>
                        <tr>
                            <td>Gramedia</td>
                            <td>Jawa Barat</td>
                            <td>Bandung</td>
                            <td>Pertumbuhan Startup di Bandung</td>
                            <td>1180</td>
                        </tr>
                        <tr>
                            <td>Erlangga</td>
                            <td>Sumatera Barat</td>
                            <td>Padang</td>
                            <td>Program Sosial untuk Kesejahteraan</td>
                            <td>1075</td>
                        </tr>
                        <tr>
                            <td>Visimedia</td>
                            <td>Jawa Timur</td>
                            <td>Banyuwangi</td>
                            <td>Pengembangan Teknologi Pertanian</td>
                            <td>940</td>
                        </tr>
                        <tr>
                            <td>Mizan</td>
                            <td>Sulawesi Selatan</td>
                            <td>Makassar</td>
                            <td>Tren Kuliner Lokal</td>
                            <td>1125</td>
                        </tr>
                        <tr>
                            <td>Balai Pustaka</td>
                            <td>Bali</td>
                            <td>Gianyar</td>
                            <td>Peningkatan Kualitas Pendidikan</td>
                            <td>950</td>
                        </tr>
                        <tr>
                            <td>Penebar Swadaya</td>
                            <td>Jawa Barat</td>
                            <td>Bogor</td>
                            <td>Program Penghijauan di Bogor</td>
                            <td>1200</td>
                        </tr>
                        <tr>
                            <td>Harfeey</td>
                            <td>Jawa Timur</td>
                            <td>Probolinggo</td>
                            <td>Pengelolaan Sampah Berbasis Teknologi</td>
                            <td>1120</td>
                        </tr>
                        <tr>
                            <td>Zikrul</td>
                            <td>Kalimantan Selatan</td>
                            <td>Banjarmasin</td>
                            <td>Perdagangan Internasional</td>
                            <td>980</td>
                        </tr>
                        <tr>
                            <td>Pustaka Utama</td>
                            <td>Jawa Barat</td>
                            <td>Cimahi</td>
                            <td>Peningkatan UMKM di Cimahi</td>
                            <td>1070</td>
                        </tr>
                        <tr>
                            <td>Gramedia</td>
                            <td>Jawa Barat</td>
                            <td>Bandung</td>
                            <td>Startup Kreatif di Bandung</td>
                            <td>950</td>
                        </tr>
                        <tr>
                            <td>Erlangga</td>
                            <td>Sumatera Utara</td>
                            <td>Medan</td>
                            <td>Pengembangan Infrastruktur</td>
                            <td>1205</td>
                        </tr>
                        <tr>
                            <td>Visimedia</td>
                            <td>Jawa Barat</td>
                            <td>Karawang</td>
                            <td>Penelitian Teknologi Baru</td>
                            <td>935</td>
                        </tr>
                        <tr>
                            <td>Mizan</td>
                            <td>Jawa Timur</td>
                            <td>Sidoarjo</td>
                            <td>Peningkatan Ekspor Lokal</td>
                            <td>1115</td>
                        </tr>
                        <tr>
                            <td>Balai Pustaka</td>
                            <td>Kalimantan Timur</td>
                            <td>Samarinda</td>
                            <td>Pembangunan Ekonomi Daerah</td>
                            <td>1090</td>
                        </tr>
                        <tr>
                            <td>Penebar Swadaya</td>
                            <td>Jawa Tengah</td>
                            <td>Surakarta</td>
                            <td>Inovasi dalam Pendidikan</td>
                            <td>1010</td>
                        </tr>
                        <tr>
                            <td>Harfeey</td>
                            <td>DKI Jakarta</td>
                            <td>Jakarta</td>
                            <td>Ekosistem Startup di Jakarta</td>
                            <td>1300</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</template>

<script>
import { Form as VeeForm, Field, ErrorMessage } from 'vee-validate'

let table
export default {
    components: {
        VeeForm,
        Field,
        ErrorMessage,
    },

    data() {
        return {
            menu: {
                menu_label: '',
                menu_desc: '',
                permission: {
                    create: false,
                    read: false,
                    update: false,
                    delete: false,
                    print: false,
                    approve: false,
                },
            },

            configdate: {
                dateFormat: 'F j, Y',
                mode: 'range',
            },

            filter: {
                date: '',
            },
        }
    },

    mounted() {
        this.__MENU()
        this.$root.web_access_log()

        $('#table1').DataTable({})
    },

    methods: {
        __MENU() {
            let loader = this.$loading.show()
            window.axios
                .get('/web-access-log/' + this.$route.name)
                .then((response) => {
                    loader.hide()

                    this.menu.menu_label = response.data.menu_label
                    this.menu.menu_desc = response.data.menu_desc
                    this.menu.permission = response.data.permission
                })
                .catch((e) => {
                    loader.hide()

                    console.error(e)
                })
        },
    },

    computed: {
        cPermitted() {
            return this.menu.permission.create
        },

        rPermitted() {
            return this.menu.permission.read
        },

        uPermitted() {
            return this.menu.permission.update
        },

        dPermitted() {
            return this.menu.permission.delete
        },

        pPermitted() {
            return this.menu.permission.print
        },

        aPermitted() {
            return this.menu.permission.approve
        },
    },
}
</script>
