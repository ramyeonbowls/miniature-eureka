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
                            <th>Jumlah Pengunjung</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Distributor Buku Nusantara</td>
                            <td>Jawa Barat</td>
                            <td>Bandung</td>
                            <td>1,230</td>
                        </tr>
                        <tr>
                            <td>Literasi Pustaka Mandiri</td>
                            <td>Jawa Timur</td>
                            <td>Surabaya</td>
                            <td>980</td>
                        </tr>
                        <tr>
                            <td>Warung Buku Sejahtera</td>
                            <td>Sumatera Barat</td>
                            <td>Padang</td>
                            <td>865</td>
                        </tr>
                        <tr>
                            <td>Distributor Cerdas</td>
                            <td>Jawa Tengah</td>
                            <td>Semarang</td>
                            <td>1,120</td>
                        </tr>
                        <tr>
                            <td>Pustaka Inspirasi</td>
                            <td>Bali</td>
                            <td>Denpasar</td>
                            <td>920</td>
                        </tr>
                        <tr>
                            <td>Literasi Indonesia Maju</td>
                            <td>Riau</td>
                            <td>Pekanbaru</td>
                            <td>750</td>
                        </tr>
                        <tr>
                            <td>Distributor Sukses</td>
                            <td>Kalimantan Timur</td>
                            <td>Samarinda</td>
                            <td>600</td>
                        </tr>
                        <tr>
                            <td>Warung Buku Cendekia</td>
                            <td>Jawa Timur</td>
                            <td>Malang</td>
                            <td>1,050</td>
                        </tr>
                        <tr>
                            <td>Literasi Terdepan</td>
                            <td>Jawa Barat</td>
                            <td>Bogor</td>
                            <td>1,270</td>
                        </tr>
                        <tr>
                            <td>Pustaka Cemerlang</td>
                            <td>Jawa Tengah</td>
                            <td>Solo</td>
                            <td>890</td>
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
