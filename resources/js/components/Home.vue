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
                                        <h6 class="text-muted font-semibold">Data Visitor</h6>
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
                                            <i class="iconly-boldAdd-User"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Data Members</h6>
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
                                            <i class="iconly-boldBookmark"></i>
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
                    <div class="col-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Total Visitor</h4>
                            </div>
                            <div class="card-body">
                                <div id="chart-profile-visit"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Top 3 Read Book</h4>
                            </div>
                            <div class="card-body">
                                <div id="bar"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Growth Member</h4>
                            </div>
                            <div class="card-body">
                                <div id="area"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Tpp 10 Member Read Books</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-lg">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Jam</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="col-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-md">
                                                            <img src="./../assets/static/images/faces/5.jpg" />
                                                        </div>
                                                        <p class="font-bold ms-3 mb-0">Si Cantik</p>
                                                    </div>
                                                </td>
                                                <td class="col-auto">
                                                    <p class="mb-0">00:01:36</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-md">
                                                            <img src="./../assets/static/images/faces/2.jpg" />
                                                        </div>
                                                        <p class="font-bold ms-3 mb-0">Si Ganteng</p>
                                                    </div>
                                                </td>
                                                <td class="col-auto">
                                                    <p class="mb-0">00:01:36</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-md">
                                                            <img src="./../assets/static/images/faces/8.jpg" />
                                                        </div>
                                                        <p class="font-bold ms-3 mb-0">Singh Eknoor</p>
                                                    </div>
                                                </td>
                                                <td class="col-auto">
                                                    <p class="mb-0">00:01:36</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-md">
                                                            <img src="./../assets/static/images/faces/5.jpg" />
                                                        </div>
                                                        <p class="font-bold ms-3 mb-0">Rani Jhadav</p>
                                                    </div>
                                                </td>
                                                <td class="col-auto">
                                                    <p class="mb-0">00:01:36</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-md">
                                                            <img src="./../assets/static/images/faces/6.jpg" />
                                                        </div>
                                                        <p class="font-bold ms-3 mb-0">Rani Jhadav</p>
                                                    </div>
                                                </td>
                                                <td class="col-auto">
                                                    <p class="mb-0">00:01:36</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-md">
                                                            <img src="./../assets/static/images/faces/7.jpg" />
                                                        </div>
                                                        <p class="font-bold ms-3 mb-0">Rani Jhadav</p>
                                                    </div>
                                                </td>
                                                <td class="col-auto">
                                                    <p class="mb-0">00:01:36</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-md">
                                                            <img src="./../assets/static/images/faces/1.jpg" />
                                                        </div>
                                                        <p class="font-bold ms-3 mb-0">Rani Jhadav</p>
                                                    </div>
                                                </td>
                                                <td class="col-auto">
                                                    <p class="mb-0">00:01:36</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-md">
                                                            <img src="./../assets/static/images/faces/4.jpg" />
                                                        </div>
                                                        <p class="font-bold ms-3 mb-0">Rani Jhadav</p>
                                                    </div>
                                                </td>
                                                <td class="col-auto">
                                                    <p class="mb-0">00:01:36</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-md">
                                                            <img src="./../assets/static/images/faces/5.jpg" />
                                                        </div>
                                                        <p class="font-bold ms-3 mb-0">Rani Jhadav</p>
                                                    </div>
                                                </td>
                                                <td class="col-auto">
                                                    <p class="mb-0">00:01:36</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-md">
                                                            <img src="./../assets/static/images/faces/3.jpg" />
                                                        </div>
                                                        <p class="font-bold ms-3 mb-0">Rani Jhadav</p>
                                                    </div>
                                                </td>
                                                <td class="col-auto">
                                                    <p class="mb-0">00:01:36</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Top 10 Read Books</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-lg">
                                        <thead>
                                            <tr>
                                                <th>Cover</th>
                                                <th>Judul</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="col-3">
                                                    <div class="d-flex align-items-center">
                                                        <img src="https://via.placeholder.com/50x80" />
                                                    </div>
                                                </td>
                                                <td class="col-auto">
                                                    <p class="mb-0">Pemrograman Web Modern</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-3">
                                                    <div class="d-flex align-items-center">
                                                        <img src="https://via.placeholder.com/50x80" />
                                                    </div>
                                                </td>
                                                <td class="col-auto">
                                                    <p class="mb-0">Belajar Laravel Pemula</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-3">
                                                    <div class="d-flex align-items-center">
                                                        <img src="https://via.placeholder.com/50x80" />
                                                    </div>
                                                </td>
                                                <td class="col-auto">
                                                    <p class="mb-0">Pemrograman Web Modern</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-3">
                                                    <div class="d-flex align-items-center">
                                                        <img src="https://via.placeholder.com/50x80" />
                                                    </div>
                                                </td>
                                                <td class="col-auto">
                                                    <p class="mb-0">Data Science Fundamental</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-3">
                                                    <div class="d-flex align-items-center">
                                                        <img src="https://via.placeholder.com/50x80" />
                                                    </div>
                                                </td>
                                                <td class="col-auto">
                                                    <p class="mb-0">Manajemen Waktu Efektif</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-3">
                                                    <div class="d-flex align-items-center">
                                                        <img src="https://via.placeholder.com/50x80" />
                                                    </div>
                                                </td>
                                                <td class="col-auto">
                                                    <p class="mb-0">Kreativitas Tanpa Batas</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-3">
                                                    <div class="d-flex align-items-center">
                                                        <img src="https://via.placeholder.com/50x80" />
                                                    </div>
                                                </td>
                                                <td class="col-auto">
                                                    <p class="mb-0">Pemrograman Web Modern</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-3">
                                                    <div class="d-flex align-items-center">
                                                        <img src="https://via.placeholder.com/50x80" />
                                                    </div>
                                                </td>
                                                <td class="col-auto">
                                                    <p class="mb-0">Belajar Laravel Pemula</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-3">
                                                    <div class="d-flex align-items-center">
                                                        <img src="https://via.placeholder.com/50x80" />
                                                    </div>
                                                </td>
                                                <td class="col-auto">
                                                    <p class="mb-0">Pemrograman Web Modern</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-3">
                                                    <div class="d-flex align-items-center">
                                                        <img src="https://via.placeholder.com/50x80" />
                                                    </div>
                                                </td>
                                                <td class="col-auto">
                                                    <p class="mb-0">Data Science Fundamental</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import ApexCharts from 'apexcharts'

export default {
    components: {},

    data() {
        return {}
    },

    mounted() {
        this.__Chart()
    },

    methods: {
        __Chart() {
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
                        name: 'sales',
                        data: [9, 20, 30, 20, 10, 20, 30, 20, 10, 20, 30, 20],
                    },
                ],
                colors: '#435ebe',
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                },
            }
            let optionsVisitorsProfile = {
                series: [70, 30],
                labels: ['Male', 'Female'],
                colors: ['#435ebe', '#55c6e8'],
                chart: {
                    type: 'donut',
                    width: '100%',
                    height: '350px',
                },
                legend: {
                    position: 'bottom',
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '30%',
                        },
                    },
                },
            }

            var chartProfileVisit = new ApexCharts(document.querySelector('#chart-profile-visit'), optionsProfileVisit)
            var chartVisitorsProfile = new ApexCharts(document.getElementById('chart-visitors-profile'), optionsVisitorsProfile)

            chartProfileVisit.render()
            chartVisitorsProfile.render()

            var barOptions = {
                series: [
                    {
                        name: 'Book 1',
                        data: [44, 55, 57, 56, 61, 58, 63, 60, 66],
                    },
                    {
                        name: 'Book 2',
                        data: [76, 85, 101, 98, 87, 105, 91, 114, 94],
                    },
                    {
                        name: 'Book 3',
                        data: [35, 41, 36, 26, 45, 48, 52, 53, 41],
                    },
                ],
                chart: {
                    type: 'bar',
                    height: 350,
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded',
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
                    categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
                },
                yaxis: {
                    title: {
                        text: '$ (thousands)',
                    },
                },
                fill: {
                    opacity: 1,
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return '$ ' + val + ' thousands'
                        },
                    },
                },
            }
            var areaOptions = {
                series: [
                    {
                        name: '2023',
                        data: [31, 40, 28, 51, 42, 109, 100],
                    },
                    {
                        name: '2024',
                        data: [11, 32, 45, 32, 34, 52, 41],
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
                    type: 'datetime',
                    categories: ['2018-09-19T00:00:00.000Z', '2018-09-19T01:30:00.000Z', '2018-09-19T02:30:00.000Z', '2018-09-19T03:30:00.000Z', '2018-09-19T04:30:00.000Z', '2018-09-19T05:30:00.000Z', '2018-09-19T06:30:00.000Z'],
                },
                tooltip: {
                    x: {
                        format: 'dd/MM/yy HH:mm',
                    },
                },
            }
            var area = new ApexCharts(document.querySelector('#area'), areaOptions)
            var bar = new ApexCharts(document.querySelector('#bar'), barOptions)
            area.render()
            bar.render()
        },
    },

    computed: {},
}
</script>
