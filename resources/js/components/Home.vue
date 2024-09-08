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
                                        <h6 class="text-muted font-semibold">Data Books</h6>
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
                                <h4>Total Visitor</h4>
                            </div>
                            <div class="card-body">
                                <div id="chart-profile-visit"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Top 10 Read Book</h4>
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
                    <div class="col-12 col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Top 10 Member Read Books</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table_member">
                                        <thead>
                                            <tr>
                                                <th>Photo</th>
                                                <th>Name</th>
                                                <th>Total Hours</th>
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
                                <h4>Top 10 Read Books</h4>
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
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import ApexCharts from 'apexcharts'

let table_members, table_books
export default {
    components: {},

    data() {
        return {
            data_members: [],
        }
    },

    mounted() {
        this.__Chart()
        this.__randomDataMember()

        let _row = this
        $(document).ready(function() {
            table_members = $('#table_member').DataTable();
            _row.data_members.forEach(item => {
                table_members.row.add([
                    `<img src="${item.foto}" alt="${item.nama}" style="width: 50px; height: 50px;" />`,
                    item.nama,
                    item.lamaJam
                ]).draw();
            });

            table_books = $('#table_book').DataTable();
            const data = [
                {
                    cover: 'https://via.placeholder.com/80x80',
                    judul: 'The Great Adventure'
                },
                {
                    cover: 'https://via.placeholder.com/80x80',
                    judul: 'Journey to the Unknown'
                },
                {
                    cover: 'https://via.placeholder.com/80x80',
                    judul: 'Mystery of the Old Castle'
                },
                {
                    cover: 'https://via.placeholder.com/80x80',
                    judul: 'The Secret of the Forest'
                },
                {
                    cover: 'https://via.placeholder.com/80x80',
                    judul: 'Legends of the Lost City'
                },
                {
                    cover: 'https://via.placeholder.com/80x80',
                    judul: 'Quest for the Ancient Relic'
                },
                {
                    cover: 'https://via.placeholder.com/80x80',
                    judul: 'The Enchanted Kingdom'
                },
                {
                    cover: 'https://via.placeholder.com/80x80',
                    judul: 'Tales of the Forgotten'
                },
                {
                    cover: 'https://via.placeholder.com/80x80',
                    judul: 'Beyond the Horizon'
                },
                {
                    cover: 'https://via.placeholder.com/80x80',
                    judul: 'Wonders of the Deep Sea'
                }
            ];

            data.forEach(item => {
                table_books.row.add([
                    `<img src="${item.cover}" alt="${item.judul}" style="width: 50px; height: 80px;" />`,
                    item.judul
                ]).draw();
            });
        });

    },

    methods: {
        __randomDataMember() {
            this.data_members = [];
            let names = ['John Doe', 'Jane Smith', 'Alice Johnson', 'Bob Brown', 'Charlie Wilson', 'Emily Davis', 'Michael Taylor', 'Sophia Martinez', 'William Lee', 'Olivia Anderson'];

            for (let i = 0; i < 10; i++) {
                const randomSeconds = Math.floor(Math.random() * 3600);
                let randomData = {
                    foto: 'https://via.placeholder.com/50x80',
                    nama: names[i],
                    lamaJam: this.formatTime(randomSeconds)      
                };
                this.data_members.push(randomData);
            }
        },

        __Chart() {
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

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

            var barOptions = {
                series: [
                    {
                        name: 'Book 1',
                        data: months.map(() => Math.floor(Math.random() * 10)),
                    },
                    {
                        name: 'Book 2',
                        data: months.map(() => Math.floor(Math.random() * 10)),
                    },
                    {
                        name: 'Book 3',
                        data: months.map(() => Math.floor(Math.random() * 10)),
                    },
                    {
                        name: 'Book 4',
                        data: months.map(() => Math.floor(Math.random() * 10)),
                    },
                    {
                        name: 'Book 5',
                        data: months.map(() => Math.floor(Math.random() * 10)),
                    },
                    {
                        name: 'Book 6',
                        data: months.map(() => Math.floor(Math.random() * 10)),
                    },
                    {
                        name: 'Book 7',
                        data: months.map(() => Math.floor(Math.random() * 10)),
                    },
                    {
                        name: 'Book 8',
                        data: months.map(() => Math.floor(Math.random() * 10)),
                    },
                    {
                        name: 'Book 9',
                        data: months.map(() => Math.floor(Math.random() * 10)),
                    },
                    {
                        name: 'Book 10',
                        data: months.map(() => Math.floor(Math.random() * 10)),
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
                    categories: months,
                },
                yaxis: {
                    title: {
                        text: '(reads)',
                    },
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

            var bar = new ApexCharts(document.querySelector('#bar'), barOptions)
            bar.render()

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

        formatTime(seconds) {
            const hrs = Math.floor(seconds / 3600);
            const mins = Math.floor((seconds % 3600) / 60);
            const secs = seconds % 60;
            return `${hrs.toString().padStart(2, '0')}:${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
        }
    },

    computed: {},
}
</script>
