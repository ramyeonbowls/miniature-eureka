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
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>Cover</th>
                                <th>Judul</th>
                                <th>ISBN</th>
                                <th>EISBN</th>
                                <th>Thn. Penerbit</th>
                                <th>Penulis</th>
                                <th>Penerbit</th>
                                <th>Kategori Buku</th>
                                <th>Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><img src="https://via.placeholder.com/50x80" alt="Cover Buku 1" /></td>
                                <td>Pemrograman Web Modern</td>
                                <td>978-602-1234-56-7</td>
                                <td>978-602-1234-56-8</td>
                                <td>2021</td>
                                <td>Rizky Maulana</td>
                                <td>Pustaka Cendekia</td>
                                <td>Teknologi</td>
                                <td>20</td>
                            </tr>
                            <tr>
                                <td><img src="https://via.placeholder.com/50x80" alt="Cover Buku 2" /></td>
                                <td>Belajar Laravel untuk Pemula</td>
                                <td>978-602-4321-78-9</td>
                                <td>978-602-4321-78-0</td>
                                <td>2020</td>
                                <td>Faisal Rahman</td>
                                <td>Gramedia</td>
                                <td>Teknologi</td>
                                <td>15</td>
                            </tr>
                            <tr>
                                <td><img src="https://via.placeholder.com/50x80" alt="Cover Buku 3" /></td>
                                <td>Data Science Fundamental</td>
                                <td>978-602-9876-54-3</td>
                                <td>978-602-9876-54-4</td>
                                <td>2019</td>
                                <td>Dewi Lestari</td>
                                <td>Elex Media</td>
                                <td>Sains</td>
                                <td>30</td>
                            </tr>
                            <tr>
                                <td><img src="https://via.placeholder.com/50x80" alt="Cover Buku 4" /></td>
                                <td>Manajemen Waktu Efektif</td>
                                <td>978-602-5567-89-0</td>
                                <td>978-602-5567-89-1</td>
                                <td>2018</td>
                                <td>Yusuf Maulana</td>
                                <td>Pustaka Inspirasi</td>
                                <td>Manajemen</td>
                                <td>25</td>
                            </tr>
                            <tr>
                                <td><img src="https://via.placeholder.com/50x80" alt="Cover Buku 5" /></td>
                                <td>Kreativitas Tanpa Batas</td>
                                <td>978-602-4444-22-1</td>
                                <td>978-602-4444-22-2</td>
                                <td>2022</td>
                                <td>Siti Nurhaliza</td>
                                <td>Literasi Maju</td>
                                <td>Pengembangan Diri</td>
                                <td>10</td>
                            </tr>
                            <tr>
                                <td><img src="https://via.placeholder.com/50x80" alt="Cover Buku 6" /></td>
                                <td>Pengenalan Jaringan Komputer</td>
                                <td>978-602-3333-11-0</td>
                                <td>978-602-3333-11-1</td>
                                <td>2020</td>
                                <td>Fikri Ramadhan</td>
                                <td>Erlangga</td>
                                <td>Teknologi</td>
                                <td>50</td>
                            </tr>
                            <tr>
                                <td><img src="https://via.placeholder.com/50x80" alt="Cover Buku 7" /></td>
                                <td>Teori Algoritma Modern</td>
                                <td>978-602-2211-44-5</td>
                                <td>978-602-2211-44-6</td>
                                <td>2017</td>
                                <td>Nadia Anggraeni</td>
                                <td>Deepublish</td>
                                <td>Teknologi</td>
                                <td>12</td>
                            </tr>
                            <tr>
                                <td><img src="https://via.placeholder.com/50x80" alt="Cover Buku 8" /></td>
                                <td>Pemrograman Python untuk Data Science</td>
                                <td>978-602-5432-99-7</td>
                                <td>978-602-5432-99-8</td>
                                <td>2021</td>
                                <td>Ahmad Fauzan</td>
                                <td>Indeks</td>
                                <td>Teknologi</td>
                                <td>18</td>
                            </tr>
                            <tr>
                                <td><img src="https://via.placeholder.com/50x80" alt="Cover Buku 9" /></td>
                                <td>Strategi Bisnis Digital</td>
                                <td>978-602-1234-88-8</td>
                                <td>978-602-1234-88-9</td>
                                <td>2019</td>
                                <td>Rahmawati Kusuma</td>
                                <td>Pustaka Sejahtera</td>
                                <td>Bisnis</td>
                                <td>22</td>
                            </tr>
                            <tr>
                                <td><img src="https://via.placeholder.com/50x80" alt="Cover Buku 10" /></td>
                                <td>Desain Grafis dengan Adobe Illustrator</td>
                                <td>978-602-1111-33-4</td>
                                <td>978-602-1111-33-5</td>
                                <td>2020</td>
                                <td>Bayu Setiawan</td>
                                <td>Literasi Cemerlang</td>
                                <td>Desain</td>
                                <td>17</td>
                            </tr>
                            <tr>
                                <td><img src="https://via.placeholder.com/50x80" alt="Cover Buku 11" /></td>
                                <td>Statistika Terapan untuk Bisnis</td>
                                <td>978-602-6543-22-2</td>
                                <td>978-602-6543-22-3</td>
                                <td>2021</td>
                                <td>Rina Puspitasari</td>
                                <td>Elex Media</td>
                                <td>Bisnis</td>
                                <td>27</td>
                            </tr>
                            <tr>
                                <td><img src="https://via.placeholder.com/50x80" alt="Cover Buku 12" /></td>
                                <td>Pengantar Sistem Informasi</td>
                                <td>978-602-9876-66-1</td>
                                <td>978-602-9876-66-2</td>
                                <td>2018</td>
                                <td>Aditya Santoso</td>
                                <td>Indeks</td>
                                <td>Teknologi</td>
                                <td>35</td>
                            </tr>
                            <tr>
                                <td><img src="https://via.placeholder.com/50x80" alt="Cover Buku 13" /></td>
                                <td>Pemrograman Java Lanjutan</td>
                                <td>978-602-6543-88-7</td>
                                <td>978-602-6543-88-8</td>
                                <td>2017</td>
                                <td>Farhan Abdul</td>
                                <td>Pustaka Terdepan</td>
                                <td>Teknologi</td>
                                <td>40</td>
                            </tr>
                            <tr>
                                <td><img src="https://via.placeholder.com/50x80" alt="Cover Buku 14" /></td>
                                <td>Manajemen Keuangan Perusahaan</td>
                                <td>978-602-9876-12-1</td>
                                <td>978-602-9876-12-2</td>
                                <td>2019</td>
                                <td>Fitriani Mutia</td>
                                <td>Gramedia</td>
                                <td>Manajemen</td>
                                <td>32</td>
                            </tr>
                            <tr>
                                <td><img src="https://via.placeholder.com/50x80" alt="Cover Buku 15" /></td>
                                <td>Keamanan Jaringan dan Sistem Informasi</td>
                                <td>978-602-5432-78-8</td>
                                <td>978-602-5432-78-9</td>
                                <td>2020</td>
                                <td>Rizky Putra</td>
                                <td>Deepublish</td>
                                <td>Teknologi</td>
                                <td>45</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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

        table = $('#table1').DataTable()
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
