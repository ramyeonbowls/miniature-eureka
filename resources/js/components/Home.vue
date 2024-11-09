<template>
    <div class="page-heading" v-if="welcome">
		<p>
			<h5 class="text-muted">Halo, {{ user.name }}</h5>
		</p>
		<h4>Selamat datang di {{ user.appname }}</h4>
	</div>
    <div class="page-content">
		<template v-if="user.role=='admin'">
			<section class="row">
				<div class="col-12 col-lg-12">
					<div class="row">
						<div class="col-6 col-lg-3 col-md-6">
							<div class="card" style="height: 150px;">
								<div class="card-body px-4 py-4-5">
									<div class="row">
										<div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
											<div class="stats-icon purple mb-2">
												<i class="iconly-boldShow"></i>
											</div>
										</div>
										<div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
											<h6 class="text-muted font-semibold">Data Pengunjung</h6>
											<h6 class="font-extrabold mb-0">{{ dashboard.atas.visitor }}</h6>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-6 col-lg-3 col-md-6">
							<div class="card" style="height: 150px;">
								<div class="card-body px-4 py-4-5">
									<div class="row">
										<div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
											<div class="stats-icon blue mb-2">
												<i class="iconly-boldBookmark"></i>
											</div>
										</div>
										<div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
											<h6 class="text-muted font-semibold">Data Buku</h6>
											<h6 class="font-extrabold mb-0">{{ dashboard.atas.book }}</h6>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-6 col-lg-3 col-md-6">
							<div class="card" style="height: 150px;">
								<div class="card-body px-4 py-4-5">
									<div class="row">
										<div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
											<div class="stats-icon green mb-2">
												<i class="iconly-boldUser1"></i>
											</div>
										</div>
										<div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
											<h6 class="text-muted font-semibold">Data Member</h6>
											<h6 class="font-extrabold mb-0">{{ dashboard.atas.member }}</h6>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-6 col-lg-3 col-md-6">
							<div class="card" style="height: 150px;">
								<div class="card-body px-4 py-4-5">
									<div class="row">
										<div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
											<div class="stats-icon red mb-2">
												<i class="iconly-boldBuy"></i>
											</div>
										</div>
										<div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
											<h6 class="text-muted font-semibold">Data PO</h6>
											<h6 class="font-extrabold mb-0">{{ dashboard.atas.po }}</h6>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="buttons text-end">
							<a href="#" class="btn icon icon-left btn-primary" data-bs-toggle="modal" data-bs-target="#filter-dashboard"><i class="bi bi-filter-square-fill"></i> Filter</a>
						</div>
						<div class="col-12">
							<div class="card">
								<div class="card-header">
									<h4>Jumlah Pengunjung Harian</h4>
								</div>
								<div class="card-body">
									<div id="chart-visit-daily"></div>
								</div>
							</div>
						</div>
						<div class="col-12">
							<div class="card">
								<div class="card-header">
									<h4>Jumlah Pembaca Harian</h4>
								</div>
								<div class="card-body">
									<div id="chart-read-daily"></div>
								</div>
							</div>
						</div>
						<div class="col-12">
							<div class="card">
								<div class="card-header">
									<h4>Jumlah Pengunjung Bulanan</h4>
								</div>
								<div class="card-body">
									<div id="chart-visit-month"></div>
								</div>
							</div>
						</div>
						<div class="col-12">
							<div class="card">
								<div class="card-header">
									<h4>Jumlah Pembaca Bulanan</h4>
								</div>
								<div class="card-body">
									<div id="chart-read-month"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12 col-xl-12">
							<div class="card">
								<div class="card-header">
									<h4>Pertumbuhan Member</h4>
								</div>
								<div class="card-body">
									<div id="growth-member"></div>
								</div>
							</div>
						</div>
						<div class="col-12 col-xl-12">
							<div class="card">
								<div class="card-header">
									<h4>Top 10 Member Baca Buku</h4>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-striped" id="table_member">
											<thead>
												<tr>
													<th>Nama</th>
													<th>Total Jam</th>
												</tr>
											</thead>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-xl-12">
							<div class="card">
								<div class="card-header">
									<h4>Top 10 Buku Dibaca</h4>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-striped" id="table_book">
											<thead>
												<tr>
													<th>Cover</th>
													<th>Judul</th>
													<th>Total Dibaca</th>
												</tr>
											</thead>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-xl-12">
							<div class="card">
								<div class="card-header">
									<h4>Katalog Buku Ginesia</h4>
								</div>
								<div class="card-body">
									<CarouselHome></CarouselHome>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
	
			<!-- filter modal -->
			<div class="modal fade text-left modal-borderless" id="filter-dashboard" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
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
												<Flatpickr id="sdate" v-model="filter.date" class="form-control flatpickr-month-year" :config="configdate" placeholder="Select date.."></Flatpickr>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary ms-1" data-bs-dismiss="modal" @click="execDashBawah">
								<i class="bi bi-file-earmark-excel-fill"></i> Proses Data
							</button>
						</div>
					</div>
				</div>
			</div>
			<!-- filter modal -->
		</template>
    </div>
</template>

<script>
import ApexCharts from 'apexcharts'
import CarouselHome from './../layouts/Carousel.vue'
import 'flatpickr/dist/plugins/monthSelect/style.css'
import monthSelectPlugin from 'flatpickr/dist/plugins/monthSelect/index';

let table_members, table_books, chartReadDaily, chartVisitorDaily, chartVisitMonthly, chartReadMonthly, chartGrowthMember
export default {
	props: {
        user: {
            type: Object,
            required: true
        }
    },

    components: {
        CarouselHome,
    },

    data() {
        return {
			welcome: false,
            data_members: [],
			configdate: {
                plugins: [
					new monthSelectPlugin({
						shorthand: true,
						dateFormat: "Y-m",
						altFormat: "F Y",
						theme: "light"
					})
				],
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
			dashboard:{
				atas:{
					visitor: 0,
					book: 0,
					member: 0,
					po: 0,
				}
			}
        }
    },

    mounted() {
		this.getNow()
		this.execDashboard()
    },

    methods: {
		getNow(){
			const currentDate = new Date()
			const year = currentDate.getFullYear()
			const month = String(currentDate.getMonth() + 1).padStart(2, '0')
			this.filter.date = year + '-' + month
		},

		async execDashboard() {
			if (this.user.role === 'admin') {
				try {
					await this.execDashAtas();
					await this.__DailyChart();
					await this.__Chart();

					this.execDashBawah();
					this.getProvinsi();
				} catch (error) {
					console.error("Error in dashboard execution:", error);
				}
			} else if (this.user.role === 'teacher') {
				this.welcome = true;
			}
		},

        __Chart() {
            let optionsVisitMonthly = {
                annotations: {
                    position: 'back',
                },
                dataLabels: {
                    enabled: false,
                },
                chart: {
					id: 'VisitMonthly',
                    type: 'bar',
                    height: 300,
                },
                fill: {
                    opacity: 1,
                },
                plotOptions: {},
                series: [
                    {
                        name: 'Pengunjung',
                        data: [],
						color: '#435ebe',
                    },
                ],
                xaxis: {
                    categories: [],
                },
            }

            chartVisitMonthly = new ApexCharts(document.querySelector('#chart-visit-month'), optionsVisitMonthly)
            chartVisitMonthly.render()

            let optionsReadMonthly = {
                annotations: {
                    position: 'back',
                },
                dataLabels: {
                    enabled: false,
                },
                chart: {
					id: 'ReadMonthly',
                    type: 'bar',
                    height: 300,
                },
                fill: {
                    opacity: 1,
                },
                plotOptions: {},
                series: [
                    {
                        name: 'Pembaca',
                        data: [],
						color: '#435ebe',
                    },
                ],
                xaxis: {
                    categories: [],
                },
            }

            chartReadMonthly = new ApexCharts(document.querySelector('#chart-read-month'), optionsReadMonthly)
            chartReadMonthly.render()

            let optionsGrowthMember = {
                series: [
                    {
                        name: 'Member',
                        data: []
                    }
                ],
                chart: {
					id: 'GrowthMember',
                    height: 350,
                    type: 'area',
                },
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    curve: 'smooth',
                },
                xaxis: {
                    type: 'month',
                    categories: [],
                },
                tooltip: {
                    x: {
                        format: 'MM',
                    },
                },
            }

            chartGrowthMember = new ApexCharts(document.querySelector('#growth-member'), optionsGrowthMember)
            chartGrowthMember.render()
        },

        __DailyChart() {
            let optionsReadDaily = {
                series: [
                    {
                        name: 'Pembaca',
                        data: [],
                    },
                ],
                title: {
                    text: '',
                    align: "center"
                },
                chart: {
					id: 'ReadDaily',
                    type: 'bar',
                    height: 350,
                    colors: ['#ff4560'],
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded',
                        colors: {
                            ranges: [
                                {
                                    from: 0,
                                    to: 20,
                                    color: '#00e396',
                                },
                                {
                                    from: 21,
                                    to: 50,
                                    color: '#f5aa19',
                                },
                                {
                                    from: 51,
                                    to: 100,
                                    color: '#ff4560',
                                },
                            ],
                        },
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent'],
                },
                xaxis: {
                    categories: [],
                },
                fill: {
                    opacity: 1,
                },
            }

            chartReadDaily = new ApexCharts(document.querySelector('#chart-read-daily'), optionsReadDaily)
            chartReadDaily.render()

            let optioVisitoradDaily = {
                series: [
                    {
                        name: 'Pengunjung',
                        data: [],
                    },
                ],
                title: {
                    text: '',
                    align: "center"
                },
                chart: {
					id: 'VisitDaily',
                    type: 'bar',
                    height: 350,
                    colors: ['#ff4560'],
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded',
                        colors: {
                            ranges: [
                                {
                                    from: 0,
                                    to: 20,
                                    color: '#00e396',
                                },
                                {
                                    from: 21,
                                    to: 50,
                                    color: '#f5aa19',
                                },
                                {
                                    from: 50,
                                    to: 100,
                                    color: '#ff4560',
                                },
                            ],
                        },
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent'],
                },
                xaxis: {
                    categories: [],
                },
                fill: {
                    opacity: 1,
                },
            }

            chartVisitorDaily = new ApexCharts(document.querySelector('#chart-visit-daily'), optioVisitoradDaily)
            chartVisitorDaily.render()
        },

		execDashAtas() {
            let loader = this.$loading.show()
            axios.get('/dashboard/dashAtas')
            .then((response) => {
				loader.hide()
				this.welcome = true
				
                this.dashboard.atas.visitor	= response.data.visitor;
                this.dashboard.atas.book	= response.data.book;
                this.dashboard.atas.member	= response.data.member;
                this.dashboard.atas.po		= response.data.po;
            })
            .catch((e) => {
				loader.hide()
                console.error(e)
            });
        },

		getProvinsi() {
            this.option.optProv = '';
            this.option.optKab  = '';
            this.option.optWL   = '';

            window.axios.post('/getOpt', { 'opt': 'Provinsi'})
            .then((response) => {
                this.option.optProv = response.data;

                if(this.option.optProv.length == 1) {
                    this.filter.provinsi = this.option.optProv[0]['provinsi_id'];
                    this.getKabupaten();
                }
            })
            .catch((e) => {
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

		execDashBawah(){
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
				let loader = this.$loading.show()
				axios.get('/dashboard/dashBawah', {
					params: {
						date: this.filter.date,
						provinsi: this.filter.provinsi,
						kabupaten: this.filter.kabupaten,
						wl: this.filter.wl
					},
				})
				.then((response) => {
					loader.hide()
					this.welcome = true

					if(response.data){
						this.updateDataTable(response.data.member_read, response.data.book_read)

						this.updateCharts(response.data.days, response.data.months, response.data.formattedDate, response.data.read_daily, response.data.visit_daily, response.data.read_monthly, response.data.visit_monthly, response.data.growth_member)
					}

					this.resizeCharts();
				})
				.catch((e) => {
					loader.hide()
					console.error(e)
				});
			}
			
		},

		updateDataTable(MemberRead, BookRead){
			if ($.fn.dataTable.isDataTable('#table_member')) {
				table_members.clear().draw();
				table_members.rows.add(MemberRead.map(item => [item.name, item.totalJam])).draw();
			} else {
				table_members = $('#table_member').DataTable({
					order: [[1, 'desc']],
					columnDefs: [
						{
							targets: 0,
							orderable: false,
							width: "70%",
							class: 'text-left',
							createdCell: function(td, cellData, rowData, row, col) {
								$(td).css({
									'font-weight': 'bold',
									'background-color': '#f9f9f9',
									'color': '#333'
								});
							}
						},
						{
							targets: 1,
							orderable: false,
							width: "30%",
							class: 'text-right'
						}
					]
				});
				table_members.rows.add(MemberRead.map(item => [item.name, item.totalJam])).draw();
			}

			if ($.fn.dataTable.isDataTable('#table_book')) {
				table_books.clear().draw();
				table_books.rows.add(BookRead.map(val => [`<img src="${val.cover.replace('&amp;', '&')}" alt="${val.title}" style="width: 50px; height: 80px;" />`, val.title, val.totalRead])).draw();
			} else {
				table_books = $('#table_book').DataTable({
					order: [[2, 'desc']],
					columnDefs: [
						{
							targets: 0,
							orderable: false,
							width: "15%",
							class: 'text-center'
						},
						{
							targets: 1,
							orderable: false,
							width: "70%",
							createdCell: function(td, cellData, rowData, row, col) {
								$(td).css({
									'font-weight': 'bold',
									'background-color': '#f9f9f9',
									'color': '#333'
								});
								$(td).addClass('text-left');
							}
						},
						{
							targets: 2,
							orderable: false,
							width: "15%",
							class: 'text-right'
						}
					]
				});
				table_books.rows.add(BookRead.map(val => [`<img src="${val.cover.replace('&amp;', '&')}" alt="${val.title}" style="width: 50px; height: 80px;" />`, val.title, val.totalRead])).draw();
			}
		},

		updateCharts(days, months, formattedDate, read_daily, visit_daily, read_monthly, visit_monthly, growth_member){
			let readDaily = read_daily.map((item) => item.data);
			let VisitDaily = visit_daily.map((item) => item.data);
			let ReadMonthly = read_monthly.map((item) => item.data);
			let VisitMonthly = visit_monthly.map((item) => item.data);
			let GrowthMember = growth_member.map((item) => item.data);

			if(chartReadDaily){
				ApexCharts.exec('ReadDaily', 'updateSeries', [{ data: readDaily }], true);
				ApexCharts.exec('ReadDaily', 'updateOptions', {
					xaxis: {
						categories: days,
					},
					title: {
						text: formattedDate,
					},
				}, false, true);
			}

			if(chartVisitorDaily){
				ApexCharts.exec('VisitDaily', 'updateSeries', [{ data: VisitDaily }], true);
				ApexCharts.exec('VisitDaily', 'updateOptions', {
					xaxis: {
						categories: days,
					},
					title: {
						text: formattedDate,
					},
				}, false, true);
			}

			if(chartVisitMonthly){
				ApexCharts.exec('VisitMonthly', 'updateSeries', [{ data: VisitMonthly }], true);
				ApexCharts.exec('VisitMonthly', 'updateOptions', {
					xaxis: {
						categories: months,
					},
				}, false, true);
			}

			if(chartReadMonthly){
				ApexCharts.exec('ReadMonthly', 'updateSeries', [{ data: ReadMonthly }], true);
				ApexCharts.exec('ReadMonthly', 'updateOptions', {
					xaxis: {
						categories: months,
					},
				}, false, true);
			}

			if(chartGrowthMember){
				ApexCharts.exec('GrowthMember', 'updateSeries', [{ data: GrowthMember }], true);
				ApexCharts.exec('GrowthMember', 'updateOptions', {
					xaxis: {
						categories: months,
					},
				}, false, true);
			}
		},

		resizeCharts() {
			ApexCharts.exec('ReadDaily', 'resize');
			ApexCharts.exec('VisitDaily', 'resize');
			ApexCharts.exec('ReadMonthly', 'resize');
			ApexCharts.exec('VisitMonthly', 'resize');
			ApexCharts.exec('GrowthMember', 'resize');
		},
    },

	watch: {
		user: {
			handler() {
				this.execDashboard();
			},
			immediate: true,
			deep: true
		}
	},

	beforeRouteLeave (to, from, next) {
        if (table_members) {
            table_members.destroy();
            table_members = null;
        }

		if (table_books) {
            table_books.destroy();
            table_books = null;
        }

		if (typeof ApexCharts !== 'undefined') {
			ApexCharts.exec('ReadDaily', 'destroy');
			ApexCharts.exec('VisitDaily', 'destroy');
			ApexCharts.exec('ReadMonthly', 'destroy');
			ApexCharts.exec('VisitMonthly', 'destroy');
			ApexCharts.exec('GrowthMember', 'destroy');
		}

        next();
    }
}
</script>
