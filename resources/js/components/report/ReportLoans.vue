<template>
    <action-bar :data="menu" :menu-label="menu.menu_label"></action-bar>

    <!-- filter modal -->
    <div class="modal fade text-left modal-borderless" id="border-less" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Filter</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-12">
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
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="row">
                                <div class="col-md-12 mb-12">
                                    <div class="form-group">
                                        <label for="sdate" class="form-label">Tanggal</label>
                                        <Flatpickr v-model="filter.date" class="form-control flatpickr-range" :config="configdate" placeholder="Select date.."></Flatpickr>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-12">
                                    <div class="form-group">
                                        <label for="basicSelect4" class="form-label">Status</label>
                                        <select class="form-select" id="basicSelect4">
                                            <option>--</option>
                                            <option>Dipinjam</option>
                                            <option>Dikembalikan</option>
                                            <option>Overdue</option>
                                        </select>
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
                            <th>Tanggal Pinjam</th>
                            <th>Judul Buku</th>
                            <th>Tempo Kembali</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Gramedia</td>
                            <td>Jawa Barat</td>
                            <td>Bandung</td>
                            <td>Ardi Pratama</td>
                            <td>01 Januari 2024</td>
                            <td>Belajar Laravel dari Dasar</td>
                            <td>15 Januari 2024</td>
                            <td><span class="badge bg-success">Dikembalikan</span></td>
                        </tr>
                        <tr>
                            <td>Balai Pustaka</td>
                            <td>Jawa Timur</td>
                            <td>Surabaya</td>
                            <td>Siti Nurhaliza</td>
                            <td>05 Februari 2024</td>
                            <td>Pemrograman Vue.js Modern</td>
                            <td>19 Februari 2024</td>
                            <td><span class="badge bg-warning">Dipinjam</span></td>
                        </tr>
                        <tr>
                            <td>Pustaka Jaya</td>
                            <td>DI Yogyakarta</td>
                            <td>Yogyakarta</td>
                            <td>Joko Santoso</td>
                            <td>10 Maret 2024</td>
                            <td>Desain UI/UX untuk Pemula</td>
                            <td>24 Maret 2024</td>
                            <td><span class="badge bg-success">Dikembalikan</span></td>
                        </tr>
                        <tr>
                            <td>Literasi Utama</td>
                            <td>Sumatera Utara</td>
                            <td>Medan</td>
                            <td>Andi Wirawan</td>
                            <td>15 April 2024</td>
                            <td>Dasar-Dasar JavaScript</td>
                            <td>29 April 2024</td>
                            <td><span class="badge bg-warning">Dipinjam</span></td>
                        </tr>
                        <tr>
                            <td>Toko Buku Mandiri</td>
                            <td>Jawa Tengah</td>
                            <td>Semarang</td>
                            <td>Rina Melati</td>
                            <td>20 Mei 2024</td>
                            <td>Pemrograman PHP untuk Pemula</td>
                            <td>03 Juni 2024</td>
                            <td><span class="badge bg-danger">Overdue</span></td>
                        </tr>
                        <tr>
                            <td>Pustaka Sejahtera</td>
                            <td>Kalimantan Barat</td>
                            <td>Pontianak</td>
                            <td>Ahmad Zulkarnain</td>
                            <td>25 Juni 2024</td>
                            <td>Pengantar Database MySQL</td>
                            <td>09 Juli 2024</td>
                            <td><span class="badge bg-success">Dikembalikan</span></td>
                        </tr>
                        <tr>
                            <td>Gramedia</td>
                            <td>Sumatera Selatan</td>
                            <td>Palembang</td>
                            <td>Vivi Lestari</td>
                            <td>01 Agustus 2024</td>
                            <td>Pengenalan Python</td>
                            <td>15 Agustus 2024</td>
                            <td><span class="badge bg-warning">Dipinjam</span></td>
                        </tr>
                        <tr>
                            <td>Toko Buku Cerdas</td>
                            <td>Kalimantan Timur</td>
                            <td>Balikpapan</td>
                            <td>Rizky Anwar</td>
                            <td>05 September 2024</td>
                            <td>Pemrograman React.js</td>
                            <td>19 September 2024</td>
                            <td><span class="badge bg-danger">Overdue</span></td>
                        </tr>
                        <tr>
                            <td>Literasi Pustaka</td>
                            <td>Jawa Timur</td>
                            <td>Malang</td>
                            <td>Fitri Sari</td>
                            <td>10 Oktober 2024</td>
                            <td>Panduan CSS dan HTML</td>
                            <td>24 Oktober 2024</td>
                            <td><span class="badge bg-warning">Dipinjam</span></td>
                        </tr>
                        <tr>
                            <td>Pustaka Utama</td>
                            <td>Jawa Barat</td>
                            <td>Depok</td>
                            <td>Indah Pratiwi</td>
                            <td>15 November 2024</td>
                            <td>Pengantar Data Science</td>
                            <td>29 November 2024</td>
                            <td><span class="badge bg-success">Dikembalikan</span></td>
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
