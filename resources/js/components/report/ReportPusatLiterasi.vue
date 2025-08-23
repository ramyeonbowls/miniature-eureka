<template>
    <action-bar :data="menu" :menu-label="menu.menu_label"></action-bar>

    <!-- filter modal -->
    <div class="modal fade text-left modal-borderless" id="border-less" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Filter</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-md text-black"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="row">
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
        <div class="card overflow-auto">
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
                                <th class="text-center text-nowrap">Sesi ID</th>
                                <th class="text-center text-nowrap">Device</th>
                                <th class="text-center text-nowrap">Sistem Operasi</th>
                                <th class="text-center text-nowrap">Jenis Browser</th>
                                <th class="text-center text-nowrap">IP Address</th>
                                <th class="text-center text-nowrap">Diakses Pada</th>
                                <th class="text-center text-nowrap">Judul Buku</th>
                                <th class="text-center text-nowrap">Mulai Baca</th>
                                <th class="text-center text-nowrap">Akhir Baca</th>
                                <th class="text-center text-nowrap">Persentase Baca</th>
                                <th class="text-center text-nowrap">Durasi</th>
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
				onClose: (selectedDates, dateStr, instance) => {
                    if (selectedDates.length === 1) {
                        instance.clear()
                        this.filter.date = ''
                    }
                },
            },

            filter: {
                date: '',
            },
        }
    },

    mounted() {
        this.__MENU()
        this.$root.web_access_log()

        table = $('#data_rst').DataTable({
            paging: true,
            pagingType: 'full_numbers',
            lengthMenu: [[10, 25, 50, 100, 500], [10, 25, 50, 100, 500]],
            pageLength: 25,
            processing: true,
            ajax: "/report/literasi-rpt?nodata=yes",
            columns: [
                { data: "sesId", class: "text-center text-nowrap" },
                { data: "device", class: "text-center text-nowrap" },
                { data: "systemOs", class: "text-center text-nowrap" },
                { data: "browser", class: "text-center text-nowrap" },
                { data: "ip_address", class: "text-center text-nowrap" },
                { data: "visit", class: "text-center text-nowrap" },
                { data: "judulBuku", class: "text-center text-nowrap" },
                { data: "mulaiBaca", class: "text-center text-nowrap" },
                { data: "selesaiBaca", class: "text-center text-nowrap" },
                { data: "presentaseBaca", class: "text-center text-nowrap" },
                { data: "durationRead", class: "text-center text-nowrap" },
            ],
            language: {
                lengthMenu: "_MENU_",
                search: "_INPUT_",
                searchPlaceholder: "Pencarian..",
                info: '<span class="fs-sm">Menampilkan _START_ sampai _END_ dari _TOTAL_ entri</span>',
                infoEmpty: '<span class="fs-sm">Menampilkan 0 sampai 0 dari 0 entri</span>',
                infoFiltered: '<span class="fs-sm">(disaring dari _MAX_ total entri)</span>',
                zeroRecords: '<span class="fs-sm">Tidak Ada Data</span>',
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

        openExecute(){
            let check = true
            let message = ''

            if (this.filter.date === '' || this.filter.date === null) {
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

                let urlParam = "&START_DATE="+ start_date; 
                    urlParam += "&END_DATE="+ end_date; 

                table.ajax.url("/report/literasi-rpt?menufn="+ this.$route.name +"&"+ urlParam ).load();
            }
        },

        openXLS(){
			let check = true
            let message = ''

            if (this.filter.date === '' || this.filter.date === null) {
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
                    url: '/report/literasi-xls',
                    method: 'POST',
                    responseType: 'blob',
                    data: {
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
