<template>
    <div class="page-content">
        <section class="row">
            <div class="col-12">
                <!-- <div class="card h-100"> -->
                    <div class="row">
                        <div v-for="(data, i) in displayedContents" :key="i" class="col-12 col-lg-4 mb-2">
                            <div class="card-content">
                                <div class="product-image mt-3 mb-0 pb-0">
                                    <img :src="data.image" class="img-fluid rounded-3">
                                </div>
                                <div class="card-body mt-2 mb-0 mx-0 px-2">
                                    <a href="#">
                                        <h5 data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" :title="data.title">
                                            {{ data.title }}
                                        </h5>
                                    </a>
                                    <p class="m-top-sm m-bottom-sm mt-2" data-bs-toggle="tooltip" data-bs-placement="bottom" style="display: -webkit-box; line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
                                        <span v-html="data.content"></span>
                                    </p>
                                    <a href="#">
                                        <h6>Lanjutkan Membaca </h6>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="showLoadMore" class="divider">
                        <div class="divider-text">
                            <button class="btn btn-secondary mt-3" @click="loadMore">Load More</button>
                        </div>
                    </div>
                <!-- </div> -->
            </div>
        </section>
    </div>
</template>

<script>

export default {
    props: {
        isAuthenticated: {
            type: Boolean,
            required: true
        }
    },

    data() {
        return {
            idart: '',
            displayedCount: 3,
            contents: [
                    {
                        "id": 1,
                        "title": "Merayakan Hari Literasi Internasional 2024: Menyongsong Masa Depan Melalui Kekuatan Membaca",
                        "content": "Pada 8 September 2024, dunia akan merayakan Hari Literasi Internasional, sebuah hari yang didedikasikan untuk merayakan pentingnya literasi dalam kehidupan kita dan mendorong upaya untuk meningkatkan tingkat literasi di seluruh dunia. <br>Hari ini bukan hanya momen untuk menghargai kemampuan membaca dan menulis, tetapi juga kesempatan untuk merenungkan dampak positif yang dapat ditimbulkan oleh literasi terhadap individu dan masyarakat.<br>Literasi adalah fondasi dari perkembangan pribadi dan sosial. Melalui literasi, individu memperoleh keterampilan untuk memahami informasi, berkomunikasi secara efektif, dan berpartisipasi secara aktif dalam masyarakat. Keterampilan ini bukan hanya penting dalam konteks pendidikan formal, tetapi juga dalam kehidupan sehari-hari—mulai dari membaca tanda-tanda jalan hingga memahami instruksi medis atau berita terkini.<br>Hari Literasi Internasional 2024 mengusung tema <b>Membaca untuk Masa Depan: Mewujudkan Kesetaraan Melalui Literasi</b>. Tema ini menggarisbawahi peran literasi dalam menciptakan masa depan yang lebih inklusif dan setara. Literasi bukan hanya tentang membaca teks, tetapi juga tentang mengakses informasi yang penting untuk pengambilan keputusan yang berpengetahuan, mengurangi ketidaksetaraan, dan memberdayakan individu untuk mencapai potensi penuh mereka.<br>Untuk merayakan hari istimewa ini, berbagai kegiatan dapat dilakukan di tingkat lokal maupun global. Sekolah, perpustakaan, dan organisasi masyarakat dapat menyelenggarakan acara membaca, diskusi buku, atau workshop literasi yang mengajak peserta untuk terlibat aktif. Buku-buku yang merayakan keragaman dan inklusivitas juga dapat dipromosikan untuk memastikan bahwa setiap individu, tanpa memandang latar belakang, merasa terhubung dengan materi bacaan yang relevan dan bermanfaat.<br>Penting untuk diingat bahwa tantangan literasi tidak merata di seluruh dunia. Di beberapa daerah, akses ke pendidikan dan sumber daya literasi masih terbatas. Oleh karena itu, Hari Literasi Internasional juga merupakan waktu yang tepat untuk mendukung inisiatif-inisiatif yang bertujuan untuk mengatasi kesenjangan ini—baik melalui donasi, sukarelawan, atau penyebaran kesadaran tentang pentingnya literasi.<br>Mari kita semua merayakan Hari Literasi Internasional dengan tekad untuk memperluas akses terhadap pendidikan literasi dan berkomitmen untuk menciptakan dunia di mana setiap individu memiliki kesempatan untuk membaca, menulis, dan berkomunikasi dengan percaya diri. Dengan berbuat demikian, kita tidak hanya merayakan pencapaian literasi, tetapi juga berinvestasi dalam masa depan yang lebih cerdas, adil, dan terhubung.<br<Selamat Hari Literasi Internasional 2024! Mari kita terus menyemangati dan mendukung literasi di seluruh dunia, memastikan bahwa setiap orang memiliki kekuatan untuk menjelajahi dunia melalui kekuatan membaca.",
                        "author": "Rahman",
                        "published_at": "2024-09-07 00:00:00",
                        "image": '../images/news/literasiday.png'
                    },
                    {
                        "id": 2,
                        "title": "Revolusi Belajar: Sekolah Ramah Lingkungan Ciptakan Generasi Peduli Bumi",
                        "content": "Ini adalah konten berita kedua.",
                        "author": "Penulis 2",
                        "published_at": "2024-09-06 00:00:00",
                        "image": '../images/news/tajuk-utama3.jpg'
                    },
                    {
                        "id": 3,
                        "title": "Perpustakaan Terapung Terbesar Berlabuh di Yordania",
                        "content": "Ini adalah konten berita ketiga.",
                        "author": "Penulis 3",
                        "published_at": "2024-09-05 00:00:00",
                        "image": '../images/news/tajuk-utama2.jpg'
                    },
                    {
                        "id": 4,
                        "title": "Kampus Terbaik Dunia: Universitas-Inovasi yang Mendorong Masa Depan Pendidikan",
                        "content": "Dalam edisi terbaru World University Rankings 2024, sejumlah universitas di seluruh dunia telah mencatat prestasi gemilang dengan pendekatan inovatif mereka terhadap pendidikan. Massachusetts Institute of Technology (MIT) tetap mempertahankan posisinya sebagai universitas nomor satu dunia, berkat kepemimpinan dalam riset teknologi dan inovasi. MIT dikenal karena program-programnya yang mendorong mahasiswa untuk terlibat langsung dalam penelitian mutakhir.<br>Di Eropa, Universitas Oxford dan Universitas Cambridge terus bersaing ketat di peringkat atas, menawarkan kurikulum yang kaya dengan tradisi akademik yang mendalam dan pengajaran berkualitas tinggi. Kedua universitas ini juga menonjol dalam kolaborasi internasional dan penelitian lintas disiplin.<br>Sementara itu, Universitas Singapura (NUS) menunjukkan lonjakan signifikan, terhitung sebagai universitas terkemuka di Asia dengan fokus pada pengembangan teknologi dan inovasi. NUS dikenal karena kemitraan strategisnya dengan industri dan dukungannya terhadap startup teknologi.<br>Di Indonesia, beberapa universitas juga mengikuti jejak inovasi global dengan pendekatan yang sejalan. Institut Teknologi Bandung (ITB), misalnya, dikenal karena pusat riset dan inovasinya yang kuat, termasuk laboratorium penelitian mutakhir dan program-program kewirausahaan yang mendukung startup teknologi lokal. ITB juga aktif dalam kolaborasi internasional untuk proyek-proyek riset dan pengembangan teknologi.<br>Universitas Gadjah Mada (UGM), di sisi lain, mengedepankan integrasi pendidikan dan industri dengan berbagai inisiatif, seperti Program Pendidikan Kewirausahaan dan inkubator bisnis yang membantu mahasiswa mewujudkan ide-ide inovatif mereka. UGM juga terkenal dengan pusat studi interdisipliner yang menyatukan berbagai bidang ilmu untuk menangani tantangan sosial dan teknologi.<br>Universitas Airlangga (UNAIR), berfokus pada pengembangan riset kesehatan dan sains, dengan berbagai fasilitas modern untuk mendukung penelitian dan inovasi di bidang-bidang kritis seperti kesehatan masyarakat dan teknologi medis.<br>Keberhasilan universitas-universitas ini mencerminkan tren global dalam pendidikan tinggi yang semakin mengedepankan integrasi teknologi, penelitian, dan pengembangan keterampilan praktis untuk mempersiapkan mahasiswa menghadapi tantangan masa depan. Dengan terus berinovasi, kampus-kampus ini tidak hanya mendidik generasi masa depan tetapi juga mempengaruhi kemajuan global di berbagai bidang.",
                        "author": "Penulis 4",
                        "published_at": "2024-09-04 00:00:00",
                        "image": '../images/news/tajuk-utama1.jpg'
                    }
            ],
        };
    },

    mounted() {
        this.idart = this.$route.params.idart;
        this.getArtikel();
    },

    methods: {
        async getArtikel() {
            console.log(this.idart);
            
            try {
                let loader = this.$loading.show();
                axios.get('/getDetail', {
                    params:{
                        id: this.idart
                    }
                })
                .then((response) => {
                    // this.contents = response.data;
                    loader.hide();
                })
                .catch((e) => {
                    loader.hide();
                    console.error(e);
                });
            } catch (e) {
                loader.hide();
                console.error(e);
            }
        },

        async refreshData() {
            this.idart = this.$route.params.idart;
            await this.getArtikel();
        },

        loadMore() {
            this.displayedCount += 3;
        }
    },

    computed: {
        displayedContents() {
            return this.contents.slice(0, this.displayedCount);
        },

        showLoadMore() {
            return this.contents.length > this.displayedCount;
        }
    },

    watch: {
        '$route.params.idart': 'refreshData'
    }
};
</script>