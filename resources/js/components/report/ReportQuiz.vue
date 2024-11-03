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
        <div class="card overflow-auto">
            <div class="card-header">
                <div class="buttons">
                    <a href="#" class="btn icon icon-left btn-primary" data-bs-toggle="modal" data-bs-target="#border-less"><i class="bi bi-filter-square-fill"></i> Filter</a>
                    <a href="#" class="btn icon icon-left btn-info" @click="goDetail"><i class="bi bi-info-circle-fill"></i> Detail</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="data_rst">
                    <thead>
                        <tr>
                            <th class="text-center">Nama WL</th>
                            <th class="text-center">Provinsi</th>
                            <th class="text-center">Kab/Kota</th>
                            <th class="text-center">Nama Member</th>
                            <th class="text-center">Judul Quiz</th>
                            <th class="text-center">Total Point</th>
                            <th class="text-center">Tanggal Pengerjaan</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </section>

	<!-- Modal for Image Preview -->
    <div class="modal fade text-left" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="detailModalLabel">Detail</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
					<div class="modal-header">
						<div v-if="selected.length > 0">
							{{ selected[0].title }}

						</div>
					</div>
                    <div v-for="(data, i) in detail" :key="i" class="card mb-0 py-0">
						<div class="card-body">
							<div class="col-12">
								{{ i + 1 }}. {{ data.description }}
								<div v-if="data.type === 'checklist'">
									<div v-for="(ans, ii) in data.answer" :key="ans.id">
										<div class="form-check">
											<input type="checkbox" :value="ans.id" class="form-check-input" checked disabled>
											<label :for="data.id + '.' + ans.id">
												{{ ans.description }}
											</label>
										</div>
									</div>
								</div>
								<div v-if="data.type === 'multiple'">
									<div v-for="(ans, ii) in data.answer" :key="ans.id">
										<div class="form-check">
											<input class="form-check-input" type="radio" :id="data.id + '.' + ans.id" :name="data.id" :value="ans.id" checked disabled>
											<label class="form-check-label" :for="data.id + '.' + ans.id">
												{{ ans.description }}
											</label>
										</div>
									</div>
								</div>
								<div v-if="data.type === 'essay'">
									<div v-for="(ans, ii) in data.answer" :key="ans.id">
										<div class="form-group with-title mb-3">
											<textarea class="form-control" :id="data.id" rows="3" :value="ans.id" disabled>
											</textarea>
											<label>Your Answer</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for Image Preview -->
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

            option: {
                optProv: '',
                optKab: '',
                optWL: '',
            },
            filter: {
                date: '',
                provinsi: '',
                kabupaten: '',
                wl: ''
            },
			selected: [],
			detail: []
        }
    },

    mounted() {
        this.__MENU()
        this.$root.web_access_log()
        this.getProvinsi()

		let _row = this
        table = $('#data_rst').DataTable({
            paging: true,
            pagingType: 'full_numbers',
            lengthMenu: [[10, 25, 50, 100, 500], [10, 25, 50, 100, 500]],
            pageLength: 10,
            processing: true,
            ajax: "/report/loans-rpt?nodata=yes",
            columns: [
                { data: "wl_name", class: "text-center text-nowrap" },
                { data: "provinsi_name", class: "text-center text-nowrap" },
                { data: "kabupaten_name", class: "text-center text-nowrap" },
                { data: "name", class: "text-center text-nowrap" },
                { data: "title", class: "text-center text-nowrap" },
                { data: "point", class: "text-center text-nowrap" },
                { data: "tgl", class: "text-center text-nowrap" }
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

		window.$('#data_rst tbody').on('click', 'tr', function () {
            _row.selected = [];

            if ( window.$(this).hasClass('selected') ) {
                window.$(this).removeClass('selected');
            } else {
                table.$('tr.selected').removeClass('selected');
                window.$(this).addClass('selected');

                if (table.rows('.selected').data().length > 0) {
                    _row.selected.push(table.rows('.selected').data()[0]);
                }
            }
        });
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
                message += ' White Label, '
            }

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

                let urlParam = "PROVINSI="+ this.filter.provinsi; 
                    urlParam += "&KABUPATEN="+ this.filter.kabupaten;
                    urlParam += "&WL="+ this.filter.wl;
					urlParam += "&START_DATE="+ start_date;
                    urlParam += "&END_DATE="+ end_date;

                table.ajax.url("/report/quiz-rpt?menufn="+ this.$route.name +"&"+ urlParam ).load();
            }
        },

		goDetail(){
			if(this.selected.length > 0) {
				new bootstrap.Modal(document.getElementById('detailModal')).show()

				let loader = this.$loading.show();
				axios.get('/report/quiz-dtl', {
                    params:{
                        id: this.selected[0].id,
                        date: this.selected[0].tgl,
                        survey_id: this.selected[0].survey_id,
                        PROVINSI: this.selected[0].provinsi_id,
                        KABUPATEN: this.selected[0].kabupaten_id,
                        WL: this.selected[0].wl_name
                    }
                })
                .then((response) => {
                    this.detail = response.data.questions;
                    loader.hide();
                })
                .catch((e) => {
                    loader.hide();
                    console.error(e);
                });
			} else {
                this.$swal({
                    toast: true,
                    icon: 'warning',
                    text: 'Tidak ada baris yang dipilih!'
                });
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
                message += ' White Label, '
            }

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
                let loader      = this.$loading.show()

                window.axios({
                    url: '/report/quiz-xls',
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
                    link.setAttribute('download', 'Laporan Quiz ' + this.filter.date + '.xlsx');
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
