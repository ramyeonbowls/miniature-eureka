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
                    <a href="#" class="btn icon icon-left btn-success"><i class="bi bi-search"></i> Detail</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Nomor PO</th>
                            <th>Jenis PO</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>PO0001</td>
                            <td>Barang</td>
                            <td>2024-09-01</td>
                            <td>Rp. 1.500.000</td>
                        </tr>
                        <tr>
                            <td>PO0002</td>
                            <td>Jasa</td>
                            <td>2024-09-02</td>
                            <td>Rp. 750.000</td>
                        </tr>
                        <tr>
                            <td>PO0003</td>
                            <td>Barang</td>
                            <td>2024-09-03</td>
                            <td>Rp. 2.000.000</td>
                        </tr>
                        <tr>
                            <td>PO0004</td>
                            <td>Barang</td>
                            <td>2024-09-04</td>
                            <td>Rp. 3.250.000</td>
                        </tr>
                        <tr>
                            <td>PO0005</td>
                            <td>Jasa</td>
                            <td>2024-09-05</td>
                            <td>Rp. 1.200.000</td>
                        </tr>
                        <tr>
                            <td>PO0006</td>
                            <td>Barang</td>
                            <td>2024-09-06</td>
                            <td>Rp. 1.800.000</td>
                        </tr>
                        <tr>
                            <td>PO0007</td>
                            <td>Barang</td>
                            <td>2024-09-07</td>
                            <td>Rp. 2.500.000</td>
                        </tr>
                        <tr>
                            <td>PO0008</td>
                            <td>Jasa</td>
                            <td>2024-09-08</td>
                            <td>Rp. 950.000</td>
                        </tr>
                        <tr>
                            <td>PO0009</td>
                            <td>Barang</td>
                            <td>2024-09-09</td>
                            <td>Rp. 1.600.000</td>
                        </tr>
                        <tr>
                            <td>PO0010</td>
                            <td>Barang</td>
                            <td>2024-09-10</td>
                            <td>Rp. 2.200.000</td>
                        </tr>
                        <tr>
                            <td>PO0011</td>
                            <td>Jasa</td>
                            <td>2024-09-11</td>
                            <td>Rp. 850.000</td>
                        </tr>
                        <tr>
                            <td>PO0012</td>
                            <td>Barang</td>
                            <td>2024-09-12</td>
                            <td>Rp. 1.900.000</td>
                        </tr>
                        <tr>
                            <td>PO0013</td>
                            <td>Barang</td>
                            <td>2024-09-13</td>
                            <td>Rp. 3.000.000</td>
                        </tr>
                        <tr>
                            <td>PO0014</td>
                            <td>Jasa</td>
                            <td>2024-09-14</td>
                            <td>Rp. 1.100.000</td>
                        </tr>
                        <tr>
                            <td>PO0015</td>
                            <td>Barang</td>
                            <td>2024-09-15</td>
                            <td>Rp. 2.800.000</td>
                        </tr>
                        <tr>
                            <td>PO0016</td>
                            <td>Barang</td>
                            <td>2024-09-16</td>
                            <td>Rp. 2.400.000</td>
                        </tr>
                        <tr>
                            <td>PO0017</td>
                            <td>Jasa</td>
                            <td>2024-09-17</td>
                            <td>Rp. 700.000</td>
                        </tr>
                        <tr>
                            <td>PO0018</td>
                            <td>Barang</td>
                            <td>2024-09-18</td>
                            <td>Rp. 1.750.000</td>
                        </tr>
                        <tr>
                            <td>PO0019</td>
                            <td>Barang</td>
                            <td>2024-09-19</td>
                            <td>Rp. 3.100.000</td>
                        </tr>
                        <tr>
                            <td>PO0020</td>
                            <td>Jasa</td>
                            <td>2024-09-20</td>
                            <td>Rp. 1.300.000</td>
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
