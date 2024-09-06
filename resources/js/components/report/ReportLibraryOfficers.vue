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
                                    <h6>Provinsi</h6>
                                    <fieldset class="form-group">
                                        <select class="form-select" id="basicSelect">
                                            <option>--</option>
                                            <option>Jawa Barat</option>
                                            <option>Jawa TengaH</option>
                                            <option>DKI Jakarta</option>
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-md-12 mb-12">
                                    <h6>Kabupaten/Kota</h6>
                                    <fieldset class="form-group">
                                        <select class="form-select" id="basicSelect">
                                            <option>--</option>
                                            <option>Bandung</option>
                                            <option>Jakarta Pusat</option>
                                            <option>Semarang</option>
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-md-12 mb-12">
                                    <h6>White Label</h6>
                                    <fieldset class="form-group">
                                        <select class="form-select" id="basicSelect">
                                            <option>--</option>
                                            <option>Gramedia</option>
                                            <option>Mizan</option>
                                            <option>Erlangga</option>
                                        </select>
                                    </fieldset>
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
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Distributor Buku Nusantara</td>
                            <td>Jawa Barat</td>
                            <td>Bandung</td>
                            <td>1234567890</td>
                            <td>Rizky Pratama</td>
                            <td>Manager Pemasaran</td>
                        </tr>
                        <tr>
                            <td>Literasi Pustaka Mandiri</td>
                            <td>Jawa Timur</td>
                            <td>Surabaya</td>
                            <td>0987654321</td>
                            <td>Dewi Lestari</td>
                            <td>Direktur Operasional</td>
                        </tr>
                        <tr>
                            <td>Warung Buku Sejahtera</td>
                            <td>Sumatera Barat</td>
                            <td>Padang</td>
                            <td>1122334455</td>
                            <td>Faisal Ramadhan</td>
                            <td>Supervisor</td>
                        </tr>
                        <tr>
                            <td>Distributor Cerdas</td>
                            <td>Jawa Tengah</td>
                            <td>Semarang</td>
                            <td>5566778899</td>
                            <td>Andi Setiawan</td>
                            <td>Kepala Gudang</td>
                        </tr>
                        <tr>
                            <td>Pustaka Inspirasi</td>
                            <td>Bali</td>
                            <td>Denpasar</td>
                            <td>6677889900</td>
                            <td>Sri Kurniawati</td>
                            <td>Manajer Distribusi</td>
                        </tr>
                        <tr>
                            <td>Literasi Indonesia Maju</td>
                            <td>Riau</td>
                            <td>Pekanbaru</td>
                            <td>4455667788</td>
                            <td>Hasan Basri</td>
                            <td>Manajer Pemasaran</td>
                        </tr>
                        <tr>
                            <td>Distributor Sukses</td>
                            <td>Kalimantan Timur</td>
                            <td>Samarinda</td>
                            <td>9988776655</td>
                            <td>Muhammad Arif</td>
                            <td>Supervisor</td>
                        </tr>
                        <tr>
                            <td>Warung Buku Cendekia</td>
                            <td>Jawa Timur</td>
                            <td>Malang</td>
                            <td>3344556677</td>
                            <td>Lisa Permata</td>
                            <td>Direktur Keuangan</td>
                        </tr>
                        <tr>
                            <td>Literasi Terdepan</td>
                            <td>Jawa Barat</td>
                            <td>Bogor</td>
                            <td>2211334455</td>
                            <td>Reza Kurnia</td>
                            <td>Manajer Operasional</td>
                        </tr>
                        <tr>
                            <td>Pustaka Cemerlang</td>
                            <td>Jawa Tengah</td>
                            <td>Solo</td>
                            <td>7766554433</td>
                            <td>Dina Rahma</td>
                            <td>Kepala Seksi</td>
                        </tr>
                        <tr>
                            <td>Warung Buku Pintar</td>
                            <td>Jawa Barat</td>
                            <td>Depok</td>
                            <td>1234432112</td>
                            <td>Bayu Prasetyo</td>
                            <td>Manager Operasional</td>
                        </tr>
                        <tr>
                            <td>Pustaka Merdeka</td>
                            <td>Sumatera Utara</td>
                            <td>Medan</td>
                            <td>6655443322</td>
                            <td>Putri Anggraeni</td>
                            <td>Direktur Pemasaran</td>
                        </tr>
                        <tr>
                            <td>Literasi Masa Depan</td>
                            <td>Jawa Timur</td>
                            <td>Sidoarjo</td>
                            <td>8899007766</td>
                            <td>Wahyu Nugraha</td>
                            <td>Supervisor</td>
                        </tr>
                        <tr>
                            <td>Distributor Buku Abadi</td>
                            <td>Jawa Barat</td>
                            <td>Cirebon</td>
                            <td>4433221100</td>
                            <td>Yusuf Maulana</td>
                            <td>Kepala Distribusi</td>
                        </tr>
                        <tr>
                            <td>Warung Literasi</td>
                            <td>Jawa Tengah</td>
                            <td>Klaten</td>
                            <td>9988775544</td>
                            <td>Siti Fatimah</td>
                            <td>Manajer Keuangan</td>
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
