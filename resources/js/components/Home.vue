<template>
    <div class="page-heading">
        <h3>Dashboard</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon purple mb-2">
                                            <i class="iconly-boldShow"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Data Pengunjung</h6>
                                        <h6 class="font-extrabold mb-0">112.000</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon blue mb-2">
                                            <i class="iconly-boldBookmark"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Data Buku</h6>
                                        <h6 class="font-extrabold mb-0">183.000</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon green mb-2">
                                            <i class="iconly-boldUser1"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Data Member</h6>
                                        <h6 class="font-extrabold mb-0">1000</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon red mb-2">
                                            <i class="iconly-boldBuy"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Data PO</h6>
                                        <h6 class="font-extrabold mb-0">112</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
								<div class="row">
									<div class="col-10 text-start">
										<h4>Jumlah Pengunjung Harian</h4>
									</div>
									<div class="col-2 text-end">
										<div class="buttons">
											<a href="#" class="btn icon icon-left btn-primary" data-bs-toggle="modal" data-bs-target="#filter-visit-daily"><i class="bi bi-filter-square-fill"></i> Filter</a>
										</div>
									</div>
								</div>
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
                                <div id="chart-profile-visit"></div>
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
                                <h4>pertumbuhan Member</h4>
                            </div>
                            <div class="card-body">
                                <div id="area"></div>
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
                                                <th>Foto</th>
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
                                <h4>Katalog Buku</h4>
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
		<div class="modal fade text-left modal-borderless" id="filter-visit-daily" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
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
						<button type="button" class="btn btn-primary ms-1" data-bs-dismiss="modal" @click="ExecuteVisitDaily">
							<i class="bi bi-file-earmark-excel-fill"></i> Proses Data
						</button>
					</div>
				</div>
			</div>
		</div>
		<!-- filter modal -->
    </div>
</template>

<script>
import ApexCharts from 'apexcharts'
import CarouselHome from './../layouts/Carousel.vue'

let table_members, table_books
export default {
    components: {
        CarouselHome,
    },

    data() {
        return {
            data_members: [],
			configdate: {
                dateFormat: 'Y-m-d',
                mode: 'range',
                onChange: function(selectedDates, dateStr, instance) {
                    instance.set('disable', [])

                    if (selectedDates.length === 1) {
                        const startDate = selectedDates[0]
                        const minDate = new Date(startDate.getTime() - 6 * 24 * 60 * 60 * 1000)
                        const maxDate = new Date(startDate.getTime() + 6 * 24 * 60 * 60 * 1000)

                        instance.set('disable', [
                            function(date) {
                                return date < minDate || date > maxDate;
                            }
                        ])
                    } else {
                        instance.set('disable', [])
                    }
                },
                onClose: function(selectedDates, dateStr, instance) {
					instance.set('disable', [])
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
                wl: '',
            },
        }
    },

    mounted() {
        this.__Chart()
        this.__DailyChart()
        this.__randomDataMember()
        this.getProvinsi()

        let _row = this
        $(document).ready(function () {
            table_members = $('#table_member').DataTable()
            _row.data_members.forEach((item) => {
                table_members.row.add([`<img src="${item.foto}" alt="${item.nama}" style="width: 50px; height: 50px;" />`, item.nama, item.lamaJam]).draw()
            })

            table_books = $('#table_book').DataTable()
            const data = [
                {
                    cover: 'https://via.placeholder.com/80x80',
                    judul: 'The Great Adventure',
                },
                {
                    cover: 'https://via.placeholder.com/80x80',
                    judul: 'Journey to the Unknown',
                },
                {
                    cover: 'https://via.placeholder.com/80x80',
                    judul: 'Mystery of the Old Castle',
                },
                {
                    cover: 'https://via.placeholder.com/80x80',
                    judul: 'The Secret of the Forest',
                },
                {
                    cover: 'https://via.placeholder.com/80x80',
                    judul: 'Legends of the Lost City',
                },
                {
                    cover: 'https://via.placeholder.com/80x80',
                    judul: 'Quest for the Ancient Relic',
                },
                {
                    cover: 'https://via.placeholder.com/80x80',
                    judul: 'The Enchanted Kingdom',
                },
                {
                    cover: 'https://via.placeholder.com/80x80',
                    judul: 'Tales of the Forgotten',
                },
                {
                    cover: 'https://via.placeholder.com/80x80',
                    judul: 'Beyond the Horizon',
                },
                {
                    cover: 'https://via.placeholder.com/80x80',
                    judul: 'Wonders of the Deep Sea',
                },
            ]

            data.forEach((item) => {
                table_books.row.add([`<img src="${item.cover}" alt="${item.judul}" style="width: 50px; height: 80px;" />`, item.judul]).draw()
            })
        })
    },

    methods: {
        __randomDataMember() {
            this.data_members = []
            let names = ['John Doe', 'Jane Smith', 'Alice Johnson', 'Bob Brown', 'Charlie Wilson', 'Emily Davis', 'Michael Taylor', 'Sophia Martinez', 'William Lee', 'Olivia Anderson']

            for (let i = 0; i < 10; i++) {
                const randomSeconds = Math.floor(Math.random() * 3600)
                let randomData = {
                    foto: 'https://via.placeholder.com/50x80',
                    nama: names[i],
                    lamaJam: this.formatTime(randomSeconds),
                }
                this.data_members.push(randomData)
            }
        },

        __Chart() {
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']

            var optionsProfileVisit = {
                annotations: {
                    position: 'back',
                },
                dataLabels: {
                    enabled: false,
                },
                chart: {
                    type: 'bar',
                    height: 300,
                },
                fill: {
                    opacity: 1,
                },
                plotOptions: {},
                series: [
                    {
                        name: 'Visitors',
                        data: months.map(() => Math.floor(Math.random() * 10)),
                    },
                ],
                colors: '#435ebe',
                xaxis: {
                    categories: months,
                },
            }

            var chartProfileVisit = new ApexCharts(document.querySelector('#chart-profile-visit'), optionsProfileVisit)
            chartProfileVisit.render()

            var optionsReaders = {
                annotations: {
                    position: 'back',
                },
                dataLabels: {
                    enabled: false,
                },
                chart: {
                    type: 'bar',
                    height: 300,
                },
                fill: {
                    opacity: 1,
                },
                plotOptions: {},
                series: [
                    {
                        name: 'Readers',
                        data: months.map(() => Math.floor(Math.random() * 10)),
                    },
                ],
                colors: '#435ebe',
                xaxis: {
                    categories: months,
                },
            }

            var chartReaders = new ApexCharts(document.querySelector('#chart-read-month'), optionsReaders)
            chartReaders.render()

            var areaOptions = {
                series: [
                    {
                        name: '2023',
                        data: months.map(() => Math.floor(Math.random() * 10)),
                    },
                    {
                        name: '2024',
                        data: months.map(() => Math.floor(Math.random() * 10)),
                    },
                ],
                chart: {
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
                    categories: months,
                },
                tooltip: {
                    x: {
                        format: 'MM',
                    },
                },
            }

            var area = new ApexCharts(document.querySelector('#area'), areaOptions)
            area.render()
        },

        __DailyChart() {
            let date = new Date()
            let options = { year: 'numeric', month: 'long' }
            let formattedDate = date.toLocaleDateString('en-US', options)
            let year = date.getFullYear()
            let month = date.getMonth() + 1
            let totalDaysInMonth = 7
            let days = Array.from({ length: totalDaysInMonth }, (_, i) => (i + 1).toString());
            

            var optionsReadDaily = {
                series: [
                    {
                        name: formattedDate,
                        data: days.map(() => Math.floor(Math.random() * 10)),
                    },
                ],
                title: {
                    text: formattedDate,
                    align: "center"
                },
                chart: {
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
                                    to: 5,
                                    color: '#00e396',
                                },
                                {
                                    from: 6,
                                    to: 7,
                                    color: '#f5aa19',
                                },
                                {
                                    from: 8,
                                    to: 10,
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
                    categories: days,
                },
                fill: {
                    opacity: 1,
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val + ' reads'
                        },
                    },
                },
            }

            var chartReadDaily = new ApexCharts(document.querySelector('#chart-read-daily'), optionsReadDaily)
            chartReadDaily.render()

            var optioVisitoradDaily = {
                series: [
                    {
                        name: formattedDate,
                        data: days.map(() => Math.floor(Math.random() * 10)),
                    },
                ],
                title: {
                    text: formattedDate,
                    align: "center"
                },
                chart: {
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
                                    to: 5,
                                    color: '#00e396',
                                },
                                {
                                    from: 6,
                                    to: 7,
                                    color: '#f5aa19',
                                },
                                {
                                    from: 8,
                                    to: 10,
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
                    categories: days,
                },
                fill: {
                    opacity: 1,
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val + ' visits'
                        },
                    },
                },
            }

            var chartVisitorDaily = new ApexCharts(document.querySelector('#chart-visit-daily'), optioVisitoradDaily)
            chartVisitorDaily.render()
        },

        formatTime(seconds) {
            const hrs = Math.floor(seconds / 3600)
            const mins = Math.floor((seconds % 3600) / 60)
            const secs = seconds % 60
            return `${hrs.toString().padStart(2, '0')}:${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`
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

		ExecuteVisitDaily(){
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

            if (!this.filter.date.split(' to ')[0] || !this.filter.date.split(' to ')[1]) {
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
				console.log('visit daily');
			}
			
		}
    },

    computed: {},
}
</script>
