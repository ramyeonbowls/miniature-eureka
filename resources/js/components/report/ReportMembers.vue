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
                            <th>Nama WL</th>
                            <th>Provinsi</th>
                            <th>Kab/Kota</th>
                            <th>Nama Member</th>
                            <th>Email Member</th>
                            <th>Waktu Daftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Gramedia</td>
                            <td>Jawa Barat</td>
                            <td>Bandung</td>
                            <td>Ardianto Prabowo</td>
                            <td>ardianto.prabowo@example.com</td>
                            <td>01 Januari 2024 09:30</td>
                        </tr>
                        <tr>
                            <td>Literasi Utama</td>
                            <td>Jawa Timur</td>
                            <td>Surabaya</td>
                            <td>Siti Nurhaliza</td>
                            <td>siti.nurhaliza@example.com</td>
                            <td>05 Februari 2024 14:45</td>
                        </tr>
                        <tr>
                            <td>Toko Buku Mandiri</td>
                            <td>DI Yogyakarta</td>
                            <td>Yogyakarta</td>
                            <td>Joko Santoso</td>
                            <td>joko.santoso@example.com</td>
                            <td>10 Maret 2024 11:00</td>
                        </tr>
                        <tr>
                            <td>Pustaka Sejahtera</td>
                            <td>Sumatera Selatan</td>
                            <td>Palembang</td>
                            <td>Rina Melati</td>
                            <td>rina.melati@example.com</td>
                            <td>15 April 2024 08:30</td>
                        </tr>
                        <tr>
                            <td>Balai Pustaka</td>
                            <td>Kalimantan Barat</td>
                            <td>Pontianak</td>
                            <td>Ahmad Zulkarnain</td>
                            <td>ahmad.zulkarnain@example.com</td>
                            <td>20 Mei 2024 13:15</td>
                        </tr>
                        <tr>
                            <td>Literasi Pustaka</td>
                            <td>Jawa Tengah</td>
                            <td>Semarang</td>
                            <td>Indah Pratiwi</td>
                            <td>indah.pratiwi@example.com</td>
                            <td>25 Juni 2024 16:45</td>
                        </tr>
                        <tr>
                            <td>Gramedia</td>
                            <td>Sumatera Utara</td>
                            <td>Medan</td>
                            <td>Fajar Nugroho</td>
                            <td>fajar.nugroho@example.com</td>
                            <td>30 Juli 2024 10:00</td>
                        </tr>
                        <tr>
                            <td>Toko Buku Cerdas</td>
                            <td>Jawa Barat</td>
                            <td>Bandung</td>
                            <td>Rizky Anwar</td>
                            <td>rizky.anwar@example.com</td>
                            <td>05 Agustus 2024 12:30</td>
                        </tr>
                        <tr>
                            <td>Pustaka Utama</td>
                            <td>Kalimantan Timur</td>
                            <td>Balikpapan</td>
                            <td>Fitri Sari</td>
                            <td>fitri.sari@example.com</td>
                            <td>10 September 2024 09:45</td>
                        </tr>
                        <tr>
                            <td>Toko Buku Sejahtera</td>
                            <td>DI Yogyakarta</td>
                            <td>Yogyakarta</td>
                            <td>Haris Subakti</td>
                            <td>haris.subakti@example.com</td>
                            <td>15 Oktober 2024 11:30</td>
                        </tr>
                        <tr>
                            <td>Pustaka Jaya</td>
                            <td>Sumatera Barat</td>
                            <td>Padang</td>
                            <td>Elena Desy</td>
                            <td>elena.desy@example.com</td>
                            <td>20 November 2024 15:00</td>
                        </tr>
                        <tr>
                            <td>Gramedia</td>
                            <td>Jawa Timur</td>
                            <td>Malang</td>
                            <td>Rendi Hidayat</td>
                            <td>rendi.hidayat@example.com</td>
                            <td>25 Desember 2024 14:00</td>
                        </tr>
                        <tr>
                            <td>Literasi Utama</td>
                            <td>Kalimantan Selatan</td>
                            <td>Banjarmasin</td>
                            <td>Yulia Sari</td>
                            <td>yulia.sari@example.com</td>
                            <td>01 Januari 2024 09:00</td>
                        </tr>
                        <tr>
                            <td>Pustaka Sejahtera</td>
                            <td>Jawa Tengah</td>
                            <td>Salatiga</td>
                            <td>Agus Santoso</td>
                            <td>agus.santoso@example.com</td>
                            <td>05 Februari 2024 10:15</td>
                        </tr>
                        <tr>
                            <td>Toko Buku Mandiri</td>
                            <td>Sumatera Utara</td>
                            <td>Medan</td>
                            <td>Yani Puspita</td>
                            <td>yani.puspita@example.com</td>
                            <td>10 Maret 2024 12:00</td>
                        </tr>
                        <tr>
                            <td>Pustaka Utama</td>
                            <td>DI Yogyakarta</td>
                            <td>Yogyakarta</td>
                            <td>Rizal Hakim</td>
                            <td>rizal.hakim@example.com</td>
                            <td>15 April 2024 13:45</td>
                        </tr>
                        <tr>
                            <td>Gramedia</td>
                            <td>Kalimantan Barat</td>
                            <td>Pontianak</td>
                            <td>Vivi Lestari</td>
                            <td>vivi.lestari@example.com</td>
                            <td>20 Mei 2024 14:30</td>
                        </tr>
                        <tr>
                            <td>Toko Buku Cerdas</td>
                            <td>Jawa Barat</td>
                            <td>Bandung</td>
                            <td>Andre Wijaya</td>
                            <td>andre.wijaya@example.com</td>
                            <td>25 Juni 2024 15:00</td>
                        </tr>
                        <tr>
                            <td>Pustaka Jaya</td>
                            <td>Sumatera Selatan</td>
                            <td>Palembang</td>
                            <td>Desi Melati</td>
                            <td>desi.melati@example.com</td>
                            <td>30 Juli 2024 16:30</td>
                        </tr>
                        <tr>
                            <td>Literasi Pustaka</td>
                            <td>Jawa Tengah</td>
                            <td>Solo</td>
                            <td>Rina Fitri</td>
                            <td>rina.fitri@example.com</td>
                            <td>05 Agustus 2024 09:15</td>
                        </tr>
                        <tr>
                            <td>Toko Buku Mandiri</td>
                            <td>Kalimantan Timur</td>
                            <td>Balikpapan</td>
                            <td>Oki Prasetyo</td>
                            <td>oki.prasetyo@example.com</td>
                            <td>10 September 2024 11:45</td>
                        </tr>
                        <tr>
                            <td>Pustaka Utama</td>
                            <td>Jawa Barat</td>
                            <td>Depok</td>
                            <td>Wulan Sari</td>
                            <td>wulan.sari@example.com</td>
                            <td>15 Oktober 2024 12:00</td>
                        </tr>
                        <tr>
                            <td>Gramedia</td>
                            <td>Sumatera Utara</td>
                            <td>Medan</td>
                            <td>Faisal Ardi</td>
                            <td>faisal.ardi@example.com</td>
                            <td>20 November 2024 13:30</td>
                        </tr>
                        <tr>
                            <td>Toko Buku Sejahtera</td>
                            <td>DI Yogyakarta</td>
                            <td>Yogyakarta</td>
                            <td>Susan Agustina</td>
                            <td>susan.agustina@example.com</td>
                            <td>25 Desember 2024 14:45</td>
                        </tr>
                        <tr>
                            <td>Pustaka Jaya</td>
                            <td>Jawa Timur</td>
                            <td>Malang</td>
                            <td>Dian Purnama</td>
                            <td>dian.purnama@example.com</td>
                            <td>01 Januari 2024 09:30</td>
                        </tr>
                        <tr>
                            <td>Gramedia</td>
                            <td>Kalimantan Selatan</td>
                            <td>Banjarmasin</td>
                            <td>Rina Kurniawati</td>
                            <td>rina.kurniawati@example.com</td>
                            <td>05 Februari 2024 10:00</td>
                        </tr>
                        <tr>
                            <td>Literasi Utama</td>
                            <td>Jawa Tengah</td>
                            <td>Salatiga</td>
                            <td>Rudi Setiawan</td>
                            <td>rudi.setiawan@example.com</td>
                            <td>10 Maret 2024 12:15</td>
                        </tr>
                        <tr>
                            <td>Pustaka Utama</td>
                            <td>Sumatera Selatan</td>
                            <td>Palembang</td>
                            <td>Yulianti</td>
                            <td>yulianti@example.com</td>
                            <td>15 April 2024 14:30</td>
                        </tr>
                        <tr>
                            <td>Toko Buku Mandiri</td>
                            <td>Kalimantan Barat</td>
                            <td>Pontianak</td>
                            <td>Hendra Gunawan</td>
                            <td>hendra.gunawan@example.com</td>
                            <td>20 Mei 2024 13:00</td>
                        </tr>
                        <tr>
                            <td>Pustaka Sejahtera</td>
                            <td>Jawa Timur</td>
                            <td>Surabaya</td>
                            <td>Intan Pratiwi</td>
                            <td>intan.pratiwi@example.com</td>
                            <td>25 Juni 2024 15:15</td>
                        </tr>
                        <tr>
                            <td>Gramedia</td>
                            <td>Sumatera Utara</td>
                            <td>Medan</td>
                            <td>Agung Wicaksono</td>
                            <td>agung.wicaksono@example.com</td>
                            <td>30 Juli 2024 09:45</td>
                        </tr>
                        <tr>
                            <td>Toko Buku Cerdas</td>
                            <td>DI Yogyakarta</td>
                            <td>Yogyakarta</td>
                            <td>Fany Setiawan</td>
                            <td>fany.setiawan@example.com</td>
                            <td>05 Agustus 2024 11:30</td>
                        </tr>
                        <tr>
                            <td>Pustaka Jaya</td>
                            <td>Kalimantan Timur</td>
                            <td>Balikpapan</td>
                            <td>Arif Prabowo</td>
                            <td>arif.prabowo@example.com</td>
                            <td>10 September 2024 12:00</td>
                        </tr>
                        <tr>
                            <td>Literasi Utama</td>
                            <td>Sumatera Selatan</td>
                            <td>Palembang</td>
                            <td>Gita Adi</td>
                            <td>gita.adi@example.com</td>
                            <td>15 Oktober 2024 13:30</td>
                        </tr>
                        <tr>
                            <td>Pustaka Utama</td>
                            <td>Jawa Barat</td>
                            <td>Cimahi</td>
                            <td>Rina Yuliana</td>
                            <td>rina.yuliana@example.com</td>
                            <td>20 November 2024 14:45</td>
                        </tr>
                        <tr>
                            <td>Toko Buku Mandiri</td>
                            <td>Kalimantan Selatan</td>
                            <td>Banjarmasin</td>
                            <td>Agung Supriyadi</td>
                            <td>agung.supriyadi@example.com</td>
                            <td>25 Desember 2024 10:00</td>
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
