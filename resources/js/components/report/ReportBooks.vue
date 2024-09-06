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
                            <th>Judul Buku</th>
                            <th>Penerbit</th>
                            <th>Penulis</th>
                            <th>ISBN</th>
                            <th>EISBN</th>
                            <th>Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Gramedia</td>
                            <td>Jawa Barat</td>
                            <td>Bandung</td>
                            <td>Teknologi Masa Depan</td>
                            <td>Erlangga</td>
                            <td>Budi Santoso</td>
                            <td>978-1234567890</td>
                            <td>978-9876543210</td>
                            <td>100</td>
                        </tr>
                        <tr>
                            <td>Toko Buku Agung</td>
                            <td>Jawa Timur</td>
                            <td>Surabaya</td>
                            <td>Sejarah Indonesia</td>
                            <td>Gramedia</td>
                            <td>Agus Supriyadi</td>
                            <td>978-2345678901</td>
                            <td>978-8765432109</td>
                            <td>75</td>
                        </tr>
                        <tr>
                            <td>Pustaka Utama</td>
                            <td>Sumatera Utara</td>
                            <td>Medan</td>
                            <td>Pendidikan di Era Digital</td>
                            <td>Mizan</td>
                            <td>Siti Nurhaliza</td>
                            <td>978-3456789012</td>
                            <td>978-7654321098</td>
                            <td>120</td>
                        </tr>
                        <tr>
                            <td>Balai Pustaka</td>
                            <td>Jawa Tengah</td>
                            <td>Semarang</td>
                            <td>Ekonomi Global</td>
                            <td>Balai Pustaka</td>
                            <td>Dedi Kurniawan</td>
                            <td>978-4567890123</td>
                            <td>978-6543210987</td>
                            <td>60</td>
                        </tr>
                        <tr>
                            <td>Toko Buku Online</td>
                            <td>DI Yogyakarta</td>
                            <td>Yogyakarta</td>
                            <td>Kesehatan Masyarakat</td>
                            <td>Erlangga</td>
                            <td>Ani Susanti</td>
                            <td>978-5678901234</td>
                            <td>978-5432109876</td>
                            <td>80</td>
                        </tr>
                        <tr>
                            <td>Surya Pustaka</td>
                            <td>Bali</td>
                            <td>Denpasar</td>
                            <td>Seni dan Budaya Indonesia</td>
                            <td>Visimedia</td>
                            <td>Putra Aditya</td>
                            <td>978-6789012345</td>
                            <td>978-4321098765</td>
                            <td>95</td>
                        </tr>
                        <tr>
                            <td>Mulia Buku</td>
                            <td>Kalimantan Timur</td>
                            <td>Samarinda</td>
                            <td>Teknologi Informasi</td>
                            <td>Zikrul</td>
                            <td>Arif Hidayat</td>
                            <td>978-7890123456</td>
                            <td>978-3210987654</td>
                            <td>50</td>
                        </tr>
                        <tr>
                            <td>Toko Buku Serambi</td>
                            <td>Sulawesi Selatan</td>
                            <td>Makassar</td>
                            <td>Ilmu Sosial dan Politik</td>
                            <td>Pustaka Utama</td>
                            <td>Indra Wijaya</td>
                            <td>978-8901234567</td>
                            <td>978-2109876543</td>
                            <td>110</td>
                        </tr>
                        <tr>
                            <td>Gramedia</td>
                            <td>Banten</td>
                            <td>Tangerang</td>
                            <td>Manajemen dan Kepemimpinan</td>
                            <td>Erlangga</td>
                            <td>Diana Pramesti</td>
                            <td>978-9012345678</td>
                            <td>978-1098765432</td>
                            <td>90</td>
                        </tr>
                        <tr>
                            <td>Pustaka Jaya</td>
                            <td>Jawa Barat</td>
                            <td>Bogor</td>
                            <td>Psikologi dan Perilaku</td>
                            <td>Mizan</td>
                            <td>Wahyu Setiawan</td>
                            <td>978-0123456789</td>
                            <td>978-0987654321</td>
                            <td>70</td>
                        </tr>
                        <tr>
                            <td>Toko Buku Harapan</td>
                            <td>Jawa Timur</td>
                            <td>Malang</td>
                            <td>Bisnis dan Investasi</td>
                            <td>Gramedia</td>
                            <td>Ratna Dewi</td>
                            <td>978-8765432109</td>
                            <td>978-2345678901</td>
                            <td>105</td>
                        </tr>
                        <tr>
                            <td>Literasi Pustaka</td>
                            <td>Sumatera Selatan</td>
                            <td>Palembang</td>
                            <td>Sejarah Dunia</td>
                            <td>Visimedia</td>
                            <td>Denny Sugiarto</td>
                            <td>978-7654321098</td>
                            <td>978-3456789012</td>
                            <td>115</td>
                        </tr>
                        <tr>
                            <td>Toko Buku Nusantara</td>
                            <td>Jawa Tengah</td>
                            <td>Solo</td>
                            <td>Pengembangan Diri</td>
                            <td>Erlangga</td>
                            <td>Yusuf Pratama</td>
                            <td>978-6543210987</td>
                            <td>978-4567890123</td>
                            <td>85</td>
                        </tr>
                        <tr>
                            <td>Pustaka Sejahtera</td>
                            <td>Sumatera Barat</td>
                            <td>Padang</td>
                            <td>Ekonomi Kreatif</td>
                            <td>Mizan</td>
                            <td>Maria Ulfa</td>
                            <td>978-5432109876</td>
                            <td>978-5678901234</td>
                            <td>130</td>
                        </tr>
                        <tr>
                            <td>Toko Buku Sahabat</td>
                            <td>Kalimantan Barat</td>
                            <td>Pontianak</td>
                            <td>Perkembangan Teknologi AI</td>
                            <td>Zikrul</td>
                            <td>Hasan Basri</td>
                            <td>978-4321098765</td>
                            <td>978-6789012345</td>
                            <td>65</td>
                        </tr>
                        <tr>
                            <td>Pustaka Utama</td>
                            <td>Jawa Timur</td>
                            <td>Kediri</td>
                            <td>Pengantar Ilmu Komputer</td>
                            <td>Pustaka Utama</td>
                            <td>Fitriani</td>
                            <td>978-3210987654</td>
                            <td>978-7890123456</td>
                            <td>125</td>
                        </tr>
                        <tr>
                            <td>Gramedia</td>
                            <td>DKI Jakarta</td>
                            <td>Jakarta</td>
                            <td>Teknologi di Era Globalisasi</td>
                            <td>Erlangga</td>
                            <td>Budi Nugraha</td>
                            <td>978-2109876543</td>
                            <td>978-8901234567</td>
                            <td>140</td>
                        </tr>
                        <tr>
                            <td>Toko Buku Mega</td>
                            <td>Bali</td>
                            <td>Kuta</td>
                            <td>Bisnis Digital</td>
                            <td>Gramedia</td>
                            <td>Andi Kurniawan</td>
                            <td>978-1098765432</td>
                            <td>978-9012345678</td>
                            <td>90</td>
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
