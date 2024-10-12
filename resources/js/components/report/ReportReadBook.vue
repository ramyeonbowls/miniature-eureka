<template>
    <action-bar :data="menu" :menu-label="menu.menu_label"></action-bar>

    <!-- filter modal -->
    <div class="modal fade text-left modal-borderless" id="border-less" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Filter</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-6">
                            <div class="row">
                                <div class="col-md-12 mb-12">
                                    <div class="form-group">
                                        <label for="basicSelect1" class="form-label">Provinsi</label>
                                        <select class="form-select" id="basicSelect1" v-model="filter.provinsi" @change="getKabupaten">
                                            <option value="">--</option>
                                            <option v-for="(prov, key) in option.optProv" :key="key" :value="prov.provinsi_id">{{ prov.provinsi_id +" "+ prov.provinsi_name }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-12">
                                    <div class="form-group">
                                        <label for="basicSelect2" class="form-label">Kabupaten/Kota</label>
                                        <select class="form-select" id="basicSelect2" v-model="filter.kabupaten" @change="getWhiteLabel">
                                            <option value="">--</option>
                                            <option v-for="(kab, key) in option.optKab" :key="key" :value="kab.kabupaten_id">{{ kab.kabupaten_id +" "+ kab.kabupaten_name }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-6">
                            <div class="row">
                                <div class="col-md-12 mb-12">
                                    <div class="form-group">
                                        <label for="basicSelect3" class="form-label">White Label</label>
                                        <select class="form-select" id="basicSelect3" v-model="filter.wl">
                                            <option value="">--</option>
                                            <option v-for="(inst, key) in option.optWL" :key="key" :value="inst.instansi_name">{{ inst.instansi_name }}</option>
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
                    <button type="button" class="btn btn-primary ms-1" data-bs-dismiss="modal" @click="openExecute">
                        <i class="bi bi-file-earmark-excel-fill"></i> Proses Data
                    </button>
                    <button type="button" class="btn btn-success ms-1" data-bs-dismiss="modal" @click="openXLS">
                        <i class="bi bi-file-earmark-excel-fill"></i> Export
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
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="data_rst">
                        <thead>
                            <tr>
                                <th class="text-center">Nama WL</th>
                                <th class="text-center">Provinsi</th>
                                <th class="text-center">Kab/Kota</th>
                                <th class="text-center">Jumlah Pembaca</th>
                                <th class="text-center">Total Jam</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
</template>

<script>

let table
export default {
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
                dateFormat: 'Y-m-d',
                mode: 'range',
            },

            option: {
                optProv: '',
                optKab: '',
                optWL: '',
            },
            filter: {
                date: '',
                provinsi: '',
                kabupaten: '',
                wl: '',
            },
        }
    },

    mounted() {
        this.__MENU()
        this.$root.web_access_log()
        this.getProvinsi()

        table = $('#data_rst').DataTable({
            paging: true,
            pagingType: 'full_numbers',
            lengthMenu: [[10, 25, 50, 100, 500], [10, 25, 50, 100, 500]],
            pageLength: 25,
            processing: true,
            ajax: "/report/readbook-rpt?nodata=yes",
            columns: [
                { data: "wl_name", class: "text-center text-nowrap" },
                { data: "provinsi_name", class: "text-center text-nowrap" },
                { data: "kabupaten_name", class: "text-center text-nowrap" },
                { data: "pembaca", class: "text-center text-nowrap" },
                { data: "durasi", class: "text-right" }
            ],
            language: {
                lengthMenu: "_MENU_",
                search: "_INPUT_",
                searchPlaceholder: "Search..",
                info: '<span class="fs-sm">Showing _START_ to _END_ of _TOTAL_ entries</span>',
                infoEmpty: '<span class="fs-sm">Showing 0 to 0 of 0 entries</span>',
                infoFiltered: '<span class="fs-sm">(filtered from _MENU_ total entries)</span>',
                zeroRecords: '<span class="fs-sm">No Data</span>',
                paginate: {
                    first: '<i class="bi bi-chevron-double-left"></i>',
                    previous: '<i class="bi bi-chevron-left"></i>',
                    next: '<i class="bi bi-chevron-right"></i>',
                    last: '<i class="bi bi-chevron-double-right"></i>'
                }
            }
        })
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

        getProvinsi() {
            this.option.optProv = '';
            this.option.optKab  = '';
            this.option.optWL   = '';

            let loader = this.$loading.show()
            window.axios.post('/getOpt', { 'opt': 'Provinsi'})
            .then((response) => {
                loader.hide()
                this.option.optProv = response.data;

                if(this.option.optProv.length == 1) {
                    this.filter.provinsi = this.option.optProv[0]['provinsi_id'];
                    this.getKabupaten();
                }
            })
            .catch((e) => {
                loader.hide()

                console.error(e);
            });
        },

        getKabupaten() {
            this.option.optKab  = '';
            this.option.optWL   = '';

            window.axios.post('/getOpt', {
                'opt': 'Kabupaten',
                'PROVINSI': this.filter.provinsi
            })
            .then((response) => {
                this.option.optKab = response.data;

                if(this.option.optKab.length == 1) {
                    this.filter.kabupaten = this.option.optKab[0]['kabupaten_id'];
                    this.getWhiteLabel()
                }
            })
            .catch((e) => {
                console.error(e);
            });
        },

        getWhiteLabel() {
            this.option.optWL   = '';

            window.axios.post('/getOpt', {
                'opt': 'WhiteLabel',
                'PROVINSI': this.filter.provinsi,
                'KABUPATEN': this.filter.kabupaten
            })
            .then((response) => {
                this.option.optWL = response.data;

                if(this.option.optWL.length == 1) {
                    this.filter.wl = this.option.optWL[0]['instansi_name'];
                }
            })
            .catch((e) => {
                console.error(e);
            });
        },

        openExecute(){
            let check = true
            let message = ''

            if(this.filter.provinsi==''){
                check = false
                message += ' Provinsi, '
            }

            if(this.filter.kabupaten==''){
                check = false
                message += ' Kabupaten, '
            }

            if(this.filter.wl==''){
                check = false
                message += ' White List, '
            }

            if(this.filter.date==''){
                check = false
                message += ' Tanggal, '
            }

            if(!check){
                this.$swal({
                    toast: true,
                    icon: 'warning',
                    text: 'Silahkan Isi'+ message.slice(0, -2) +'!'
                });
            }else{
                let start_date  = this.filter.date.split(' to ')[0] ?? ''
                let end_date    = this.filter.date.split(' to ')[1] ?? ''

                let urlParam = "PROVINSI="+ this.filter.provinsi; 
                    urlParam += "&KABUPATEN="+ this.filter.kabupaten;
                    urlParam += "&WL="+ this.filter.wl;
                    urlParam += "&START_DATE="+ start_date; 
                    urlParam += "&END_DATE="+ end_date; 

                table.ajax.url("/report/readbook-rpt?menufn="+ this.$route.name +"&"+ urlParam ).load();
            }
        },

        openXLS(){
			let check = true
            let message = ''

            if(this.filter.provinsi==''){
                check = false
                message += ' Provinsi, '
            }

            if(this.filter.kabupaten==''){
                check = false
                message += ' Kabupaten, '
            }

            if(this.filter.wl==''){
                check = false
                message += ' White List, '
            }

            if(this.filter.date==''){
                check = false
                message += ' Tanggal, '
            }

            if(!check){
                this.$swal({
                    toast: true,
                    icon: 'warning',
                    text: 'Silahkan Isi'+ message.slice(0, -2) +'!'
                });
            }else{
                let loader      = this.$loading.show()
                let start_date  = this.filter.date.split(' to ')[0] ?? ''
                let end_date    = this.filter.date.split(' to ')[1] ?? ''

                window.axios({
                    url: '/report/readbook-xls',
                    method: 'POST',
                    responseType: 'blob',
                    data: {
                        PROVINSI: this.filter.provinsi,
                        KABUPATEN: this.filter.kabupaten,
                        WL: this.filter.wl,
                        START_DATE: start_date,
                        END_DATE: end_date
                    }
                })
                .then((response) => {
                    loader.hide()

                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', 'Laporan Baca Buku ' + this.filter.date + '.xlsx');
                    document.body.appendChild(link);
                    link.click();
                })
                .catch((e) => {
                    console.error(e);
                    loader.hide()
                });
            }
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

    beforeRouteLeave (to, from, next) {
        if (table) {
            table.destroy();
            table = null;
        }

        next();
    }
}
</script>
