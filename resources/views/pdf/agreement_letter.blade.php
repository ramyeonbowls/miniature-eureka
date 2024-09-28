@php
    $html = "
        <style>
            @page {
                margin: 3rem 4rem;
            }
            body {
                font-family: 'Georgia', 'Times New Roman', Times, sans-serif;
            }
            .border-0 {border: 0}
            .text-left{text-align:left!important}
            .text-center{text-align:center!important}
            .text-right{text-align:right!important}

            .font-w50{font-weight:10!important}
            .font-w600{font-weight:600!important}
            .font-w700{font-weight:700!important}
            .font-size-base{font-size:1rem!important}
            .font-size-lg{font-size:1.25rem!important}
            .font-size-sm{font-size:.875rem!important}
            .font-size-xs{font-size: .715rem!important}
            .font-size-xxs{font-size: .675rem!important}
            .font-size-xxxs{font-size: .500rem!important}

            .mt-2{margin-top:.5rem!important}
            .mb-2{margin-bottom:.5rem!important}
            .my-2{margin-top:.5rem!important}
            .my-2{margin-bottom:.5rem!important}
            .my-3{margin-top:1rem!important}
            .my-3{margin-bottom:1rem!important}
            .mx-3{margin-left:1rem!important}
            .mx-3{margin-right:1rem!important}

            .table {border-collapse: collapse}
            .table td,.table th{padding:.25rem;align-items: center;vertical-align:top;border-top:0px solid #000000;text-align: center;}
            .table thead th{vertical-align:bottom;border-bottom:0px solid #000000}
            .table tbody+tbody{border-top:0px solid #222222}
            .table tbody td{border-bottom:0px solid #222222}
            .table tfoot th{border:none}
            .table-sm td,.table-sm th{padding:.25rem}
            .table-bordered{border:1px solid #000000}
            .table-bordered td,.table-bordered th{border:1px solid #000000}
            .table-bordered thead td,.table-bordered thead th{border-bottom-width:2px}
            .table-borderless tbody+tbody,.table-borderless td,.table-borderless th,.table-borderless thead th{border:0}

            .page_break{ page-break-before: always}

            .line-text {
                display: flex;
                align-items: center;
                text-align: center;
                margin: 20px 0;
            }

            .line-text::before,
            .line-text::after {
                content: '';
                flex: 1;
                border-bottom: 2px solid black; /* Ketebalan dan warna garis */
                margin: 0 10px; /* Jarak antara teks dan garis */
            }

            footer {
                position: fixed;
                bottom: -120px;
                left: 0px;
                right: 0px;
                height: 110px;
            }
        </style>
    ";

    $html .= "
        <div class='font-size-xxs font-w50 text-center'><h2>PERJANJIAN PENJUALAN<br>PRODUK DIGITAL</h2></div>
        <div class='font-size-base font-w50'>Pada Hari ini Jumat Tanggal 25 Bulan Agustus Tahun 2023 Kami yang bertanda tangan di bawah ini:</div>
        <div class='font-size-base font-w50'>Kami yang bertanda tangan di bawah ini:</div>
        <table class='table-sm' cellspacing='0' style='width: 100%;padding: 1.75rem;'>
            <tr>
                <td style='vertical-align: top;'>Nama</td>
                <td style='vertical-align: top;'>:</td>
                <td style='vertical-align: top;'>PT. MEDIA DIGIDO NUSANTARA</td>
            </tr>
            <tr>
                <td style='vertical-align: top;'>Alamat</td>
                <td style='vertical-align: top;'>:</td>
                <td style='vertical-align: top;'>Candi Gebang Blok R-6 Jetis, RT 014 / RW 062, Kelurahan Wedomartani, Kecamatan Ngemplak, Kabupaten Sleman, Yogyakarta</td>
            </tr>
        </table>
        <div class='font-size-base font-w50'>dalam hal ini, diwakili oleh Mukhamad Ali Imron yang bertindak sebagai Direktur Utama selanjutnya disebut Pihak Pertama, dan</div>
        <table class='table-sm' cellspacing='0' style='width: 100%;padding: 1.75rem;'>
            <tr>
                <td style='vertical-align: top;'>Nama</td>
                <td style='vertical-align: top;'>:</td>
                <td style='vertical-align: top;'>PT. MEDIA DIGIDO NUSANTARA</td>
            </tr>
            <tr>
                <td style='vertical-align: top;'>Alamat</td>
                <td style='vertical-align: top;'>:</td>
                <td style='vertical-align: top;'>Candi Gebang Blok R-6 Jetis, RT 014 / RW 062, Kelurahan Wedomartani, Kecamatan Ngemplak, Kabupaten Sleman, Yogyakarta</td>
            </tr>
        </table>
        <div class='font-size-base font-w50'>dalam hal ini diwakili oleh Irfan Hilmi yang bertindak sebagai Direktur Utama dan selanjutnya disebut Pihak Kedua.</div>
        <div class='font-size-base font-w50'>Kedua belah pihak sepakat untuk membuat Perjanjian Pemakaian Perpustakaan Digital Berbasis Website di Platform milik Pihak Pertama sebagai berikut :</div>
        <div class='font-size-base font-w50'>Kedua belah pihak sepakat untuk membuat Perjanjian Penjualan Produk Digital Pihak Kedua di Platform milik Pihak Pertama sebagai berikut :</div>
        <table class='table-sm' cellspacing='0' style='width: 100%;'>
            <thead>
                <tr>
                    <th colspan='2' class='font-size-xxs font-w50 text-center' style='vertical-align: bottom;'><h2>PASAL 1<br>DEFINISI</h2></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style='vertical-align: top;width: 5%;'>1.</td>
                    <td style='vertical-align: top;width: 95%;'>Yang dimaksud dengan Produk Digital didalam perjanjian ini adalah Produk yang disuplai oleh pihak kedua kepada pihak pertama baik berbentuk ebook, audio book, video book atau video tutorial.</td>
                </tr>
                <tr>
                    <td style='vertical-align: top;width: 5%;'>2.</td>
                    <td style='vertical-align: top;width: 95%;'>Produk yang dimaksud dalam ayat 1 ditulis dan atau disampaikan oleh penulis buku dan atau mengisi suara dan perekaman video yang memiliki hubungan kerja dengan pihak kedua.</td>
                </tr>
                <tr>
                    <td style='vertical-align: top;width: 5%;'>3.</td>
                    <td style='vertical-align: top;width: 95%;'>Platform adalah hardware/software yang terangkai dalam satu arsitektur perangkat komputer.</td>
                </tr>
                <tr>
                    <td style='vertical-align: top;width: 5%;'>4.</td>
                    <td style='vertical-align: top;width: 95%;'>Perpustakaan digital adalah sebuah perpustakaan yang dimiliki oleh Lembaga dan atau perorangan yang dilengkapi dengan koleksi produk digital dalam berbagai bentuk.</td>
                </tr>
            </tbody>
        </table>
        <table class='table-sm' cellspacing='0' style='width: 100%;'>
            <thead>
                <tr>
                    <th colspan='2' class='font-size-xxs font-w50 text-center' style='vertical-align: bottom;'><h2>PASAL 2<br>PARA PIHAK</h2></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style='vertical-align: top;width: 5%;'>1.</td>
                    <td style='vertical-align: top;width: 95%;'>Pihak Pertama adalah Sebuah Perusahaan Pengembang Platform Digital berbasis web (web based) yang berkedudukan di Candi Gebang Blok R-6 RT 014 / RW 062 Kelurahan Wedomartani, Kecamatan Ngemplak, Kabupaten Sleman, Yogyakarta dengan Akte Notaris SUSETYORINI, S.H., Nomor 30, Tanggal 11 Agustus 2023.</td>
                </tr>
                <tr>
                    <td style='vertical-align: top;width: 5%;'>2.</td>
                    <td style='vertical-align: top;width: 95%;'>Pihak Kedua adalah Perusahaan yang Berbadan Hukum atau Berbadan Usaha.</td>
                </tr>
            </tbody>
        </table>
        <div class='page_break'></div>
        <table class='table-sm' cellspacing='0' style='width: 100%;'>
            <thead>
                <tr>
                    <th colspan='2' class='font-size-xxs font-w50 text-center' style='vertical-align: bottom;'><h2>PASAL 3<br>BENTUK KERJA SAMA</h2></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style='vertical-align: top;width: 5%;'>1.</td>
                    <td style='vertical-align: top;width: 95%;'>Pihak kedua memberi hak kepada pihak pertama untuk menjual produk digital pihak kedua dan atau produk digital pihak ketiga dimana pihak kedua diberi kuasa untuk menjual melalui platform pihak pertama.</td>
                </tr>
                <tr>
                    <td style='vertical-align: top;width: 5%;'>2.</td>
                    <td style='vertical-align: top;width: 95%;'>Hak distribusi dari produk Pihak Ketiga dinyatakan dalam blanko surat penunjukkan yang disiapkan oleh pihak pertama.</td>
                </tr>
                <tr>
                    <td style='vertical-align: top;width: 5%;'>3.</td>
                    <td style='vertical-align: top;width: 95%;'>Ruang lingkup perjanjian ini mencakup kerja sama penjualan produk digital yang disebutkan dalam ayat 1 di atas ke seluruh jaringan pemasaran yang dimiliki Pihak Pertama.</td>
                </tr>
                <tr>
                    <td style='vertical-align: top;width: 5%;'>4.</td>
                    <td style='vertical-align: top;width: 95%;'>Pemberian hak untuk menjual seperti disebutkan dalam ayat 1 pasal ini tidak serta merta menutup kemungkinan pihak kedua menunjuk pihak lain untuk menjualkan produk digitalnya.</td>
                </tr>
                <tr>
                    <td style='vertical-align: top;width: 5%;'>5.</td>
                    <td style='vertical-align: top;width: 95%;'>Detail produk akan dicantumkan didalam file metadata yang dikirimkan pihak kedua kepada pihak pertama Bersama dengan file produk digitalnya setelah file tersebut di-enkript. Adapun proses enkrispsi dilakukan oleh pihak kedua sehingga produk yang dikirimkan oleh pihak kedua kepada pihak pertama adalah file yang terenkrips.</td>
                </tr>
            </tbody>
        </table>
        <table class='table-sm' cellspacing='0' style='width: 100%;'>
            <thead>
                <tr>
                    <th class='font-size-xxs font-w50 text-center' style='vertical-align: bottom;'><h2>PASAL 4<br>KONSEP DASAR</h2></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style='vertical-align: top;width: 100%;'>Para Pihak sepakat bahwa Platform yang dimaksudkan dalam perjanjian ini meliputi Perpustakaan untuk Lembaga atau Perorangan.</td>
                </tr>
            </tbody>
        </table>
        <table class='table-sm' cellspacing='0' style='width: 100%;'>
            <thead>
                <tr>
                    <th colspan='2' class='font-size-xxs font-w50 text-center' style='vertical-align: bottom;'><h2>PASAL 5<br>MATERI PRODUK</h2></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan='2'>Pihak Kedua menjamin bahwa Produk Digital yang dikirimkan kepada Pihak Pertama,</td>
                </tr>
                <tr>
                    <td style='vertical-align: top;width: 5%;'>1.</td>
                    <td style='vertical-align: top;width: 95%;'>Tidak mengandung sesuatu yang melanggar hak cipta orang lain yang ketentuannya diatur dalam peraturan perundang-undangan, serta tidak mengandung unsur yang menyinggung Suku, Agama, Ras dan Antar Golongan (SARA) yang dapat menimbulkan perselisihan.</td>
                </tr>
                <tr>
                    <td style='vertical-align: top;width: 5%;'>2.</td>
                    <td style='vertical-align: top;width: 95%;'>Tidak mengandung sesuatu yang dapat dianggap sebagai penghinaan dan atau fitnahan terhadap pihak lain.</td>
                </tr>
                <tr>
                    <td style='vertical-align: top;width: 5%;'>3.</td>
                    <td style='vertical-align: top;width: 95%;'>Bebas dari masalah plagiasi.</td>
                </tr>
                <tr>
                    <td style='vertical-align: top;width: 5%;'>4.</td>
                    <td style='vertical-align: top;width: 95%;'>Telah memperoleh izin dari para kontributor (penulis) yang namanya tercantum dalam Produk yang dipublikasikan.</td>
                </tr>
                <tr>
                    <td style='vertical-align: top;width: 5%;'>5.</td>
                    <td style='vertical-align: top;width: 95%;'>Telah mendapatkan ijin dari Pihak Pemilik Hak Kekayaan Intelektual dari Produk Digital tersebut. Dalam hal ada tuntutan dari pihak ketiga atas pelanggaran kesepakatan ini, maka pihak kedua membebaskan pihak pertama dari segala tuntutan pihak ketiga dan pihak kedua sanggup mengganti kerugian pihak pertama akibat tuntutan pihak ketiga.</td>
                </tr>
                <tr>
                    <td style='vertical-align: top;width: 5%;'>6.</td>
                    <td style='vertical-align: top;width: 95%;'>Tidak memuat Logo atau Disain atau sejenisnya milik pihak ketiga. Apabila ada tuntutan pihak ketiga atas pelanggaran tersebut maka pihak kedua membebaskan pihak pertama dari tuntutan pihak ketiga, dan atau menanggung kerugian pihak pertama karena adanya tuntutan tersebut.</td>
                </tr>
            </tbody>
        </table>
        <div class='page_break'></div>
        <table class='table-sm' cellspacing='0' style='width: 100%;'>
            <thead>
                <tr>
                    <th class='font-size-xxs font-w50 text-center' style='vertical-align: bottom;'><h2>PASAL 6<br>HARGA JUAL</h2></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style='vertical-align: top;width: 100%;'>Pihak Kedua menetapkan harga jual Produk Digital yang dijual melalui Platform Pihak Pertama.</td>
                </tr>
            </tbody>
        </table>
        <table class='table-sm' cellspacing='0' style='width: 100%;'>
            <thead>
                <tr>
                    <th colspan='2' class='font-size-xxs font-w50 text-center' style='vertical-align: bottom;'><h2>PASAL 7<br>KOMISI PENJUALAN</h2></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style='vertical-align: top;width: 5%;'>1.</td>
                    <td style='vertical-align: top;width: 95%;'>Pihak pertama akan membayarkan setiap produk digital pihak kedua yang lunas terjual sebesar 40% dari harga produk digital yang ditetapkan oleh pihak kedua.</td>
                </tr>
                <tr>
                    <td style='vertical-align: top;width: 5%;'>2.</td>
                    <td style='vertical-align: top;width: 95%;'>Laporan Penjualan dari Pihak Pertama kepada Pihak Kedua akan dilakukan apabila seluruh proses transaksi Pihak Pertama dengan Lembaga Pembeli telah selesai dan lunas terbayar.</td>
                </tr>
                <tr>
                    <td style='vertical-align: top;width: 5%;'>3.</td>
                    <td style='vertical-align: top;width: 95%;'>Untuk setiap produk digital yang telah lunas terjual pada bulan ke N akan dibayarkan kepada pihak kedua pada bulan N+1.</td>
                </tr>
                <tr>
                    <td style='vertical-align: top;width: 5%;'>4.</td>
                    <td style='vertical-align: top;width: 95%;'>Pihak Kedua bisa melakukan perubahan permanen terhadap harga satuan jual produknya dan berlaku setelah Pihak Pertama menyetujuinya. Perubahan harga satuan jual maksimal dilakukan dalam satu kali satu tahun. Demikianpun setelah produk digital tersebut telah ada di platform pihak pertama minimal 1 (satu) tahun atau sudah 1 (satu) tahun dari update harga terakhir.</td>
                </tr>
            </tbody>
        </table>
        <table class='table-sm' cellspacing='0' style='width: 100%;'>
            <thead>
                <tr>
                    <th class='font-size-xxs font-w50 text-center' style='vertical-align: bottom;'><h2>PASAL 8<br>PENJUALAN</h2></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style='vertical-align: top;width: 100%;'>Untuk kepentingan Pihak Pembeli, baik swasta maupun lembaga pemerintahan, Pihak Pertama diijinkan untuk menyerahkan file buku yang sudah terenskripsi yang dibeli untuk dapat diakses di satu komputer melalui platform Pihak Pertama secara offline dan untuk membaca buku tersebut, Pihak Pembeli akan mendapatkan kode aktifasi secara online dari Pihak Pertama.</td>
                </tr>
            </tbody>
        </table>
        <table class='table-sm' cellspacing='0' style='width: 100%;'>
            <thead>
                <tr>
                    <th class='font-size-xxs font-w50 text-center' style='vertical-align: bottom;'><h2>PASAL 9<br>DATA PENDUKUNG</h2></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style='vertical-align: top;width: 100%;'>Pihak Kedua wajib mengisi data secara lengkap pada metadata buku yang dikirimkan kepada Pihak Pertama.</td>
                </tr>
            </tbody>
        </table>
        <table class='table-sm' cellspacing='0' style='width: 100%;'>
            <thead>
                <tr>
                    <th class='font-size-xxs font-w50 text-center' style='vertical-align: bottom;'><h2>PASAL 10<br>PENOLAKAN PIHAK PERTAMA ATAS PRODUK PIHAK KEDUA</h2></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style='vertical-align: top;width: 100%;'>Pihak Pertama berhak menyeleksi produk digital pihak kedua yang melanggar kesepakatan pada pasal terdahulu dalam perjanjian ini tanpa wajib memberitahukan alasannya kepada Pihak Kedua.</td>
                </tr>
            </tbody>
        </table>
        <table class='table-sm' cellspacing='0' style='width: 100%;'>
            <thead>
                <tr>
                    <th class='font-size-xxs font-w50 text-center' style='vertical-align: bottom;'><h2>PASAL 11<br>PAJAK</h2></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style='vertical-align: top;width: 100%;'>Pengenaan pajak atas produk yang dijual Pihak Pertama didasarkan kepada peraturan perundangan perpajakan yang berlaku pada saat transaksi dilakukan.</td>
                </tr>
            </tbody>
        </table>
        <div class='page_break'></div>
        <table class='table-sm' cellspacing='0' style='width: 100%;'>
            <thead>
                <tr>
                    <th colspan='2' class='font-size-xxs font-w50 text-center' style='vertical-align: bottom;'><h2>PASAL 12<br>PENGHENTIAN HAK EDAR BUKU KARENA PENETAPAN PEMERINTAH</h2></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style='vertical-align: top;width: 5%;'>1.</td>
                    <td style='vertical-align: top;width: 95%;'>Apabila karena sesuatu hal Pemerintah mengeluarkan peraturan dan atau ketetapan yang dapat berdampak terhadap kesepakatan yang telah disepakati dalam perjanjian ini, maka para pihak saling membebaskan tanggung jawab dan tidak memiliki kewajiban apapun.</td>
                </tr>
                <tr>
                    <td style='vertical-align: top;width: 5%;'>2.</td>
                    <td style='vertical-align: top;width: 95%;'>Seluruh produk yang ditarik dari platform digital tidak lagi dilaporkan dalam laporan penjualan periode sesudah larangan diumumkan oleh pemerintah.</td>
                </tr>
            </tbody>
        </table>
        <table class='table-sm' cellspacing='0' style='width: 100%;'>
            <thead>
                <tr>
                    <th colspan='2' class='font-size-xxs font-w50 text-center' style='vertical-align: bottom;'><h2>PASAL 13<br>PENGHENTIAN PEREDARAN PRODUK DIGITAL KARENA PERMINTAAN PIHAK KETIGA</h2></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style='vertical-align: top;width: 5%;'>1.</td>
                    <td style='vertical-align: top;width: 95%;'>Apabila ada pihak ketiga yang merasa keberatan atas peredaran produk digital yang disuplai Pihak Kedua di platform Pihak Pertama, maka Pihak Pertama berhak menghentikan sementara produk digital tersebut sambil menunggu tanggapan Pihak Kedua dan penyelesaian masalah antara Pihak Kedua dan Pihak Ketiga.</td>
                </tr>
                <tr>
                    <td style='vertical-align: top;width: 5%;'>2.</td>
                    <td style='vertical-align: top;width: 95%;'>Pihak Pertama akan memberikan kesempatan paling lama 60 hari. Penghentian tersebut hanya berlaku untuk kesempatan menjual. Apabila dalam waktu 60 hari Pihak Pertama belum mendapatkan jawaban penyelesaian antara Pihak Kedua dan Pihak Ketiga, maka Pihak Pertama berhak mengambil langkah langkah yang diperlukan.</td>
                </tr>
            </tbody>
        </table>
        <table class='table-sm' cellspacing='0' style='width: 100%;'>
            <thead>
                <tr>
                    <th class='font-size-xxs font-w50 text-center' style='vertical-align: bottom;'><h2>PASAL 14<br>SURAT PENUNJUKKAN DISTRIBUTOR</h2></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style='vertical-align: top;width: 100%;'>Pihak Kedua memberikan surat kuasa penunjukkan distributor kepada Pihak Pertama, yang akan digunakan apabila dibutuhkan dalam proses pelelangan.</td>
                </tr>
            </tbody>
        </table>
        <table class='table-sm' cellspacing='0' style='width: 100%;'>
            <thead>
                <tr>
                    <th colspan='2' class='font-size-xxs font-w50 text-center' style='vertical-align: bottom;'><h2>PASAL 15<br>KUASA UNTUK MEMBERIKAN DUKUNGAN</h2></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style='vertical-align: top;width: 5%;'>1.</td>
                    <td style='vertical-align: top;width: 95%;'>Pihak Kedua memberikan kuasa kepada Pihak Pertama untuk menandatangani Surat Dukungan untuk Pihak Ketiga apabila diperlukan dalam proses pengadaan.</td>
                </tr>
                <tr>
                    <td style='vertical-align: top;width: 5%;'>2.</td>
                    <td style='vertical-align: top;width: 95%;'>Surat dukungan ke Pihak Ketiga akan ditulis dengan menggunakan kertas berkop Pihak Pertama dan dilampiri copy Surat Kuasa dari Pihak Kedua.</td>
                </tr>
            </tbody>
        </table>
        <table class='table-sm mt-2' cellspacing='0' style='width: 100%;'>
            <thead>
                <tr>
                    <th class='font-size-xxs font-w50 text-center' style='vertical-align: bottom;'><h2>PASAL 16<br>FORCE MAJEURE</h2></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style='vertical-align: top;width: 100%;'>Para Pihak tidak dapat diminta pertanggungjawaban untuk keterlambatan atau kegagalan untuk memenuhi kewajibannya yang disebabkan oleh kejadian-kejadian luar biasa di luar kendali para pihak (selanjutnya disebut force majeure) peristiwa mana termasuk, tetapi tidak terbatas pada bencana alam, kebakaran, gempa bumi, banjir, epidemi, perang, huru-hara, pemogokan atau pemberlakuan atau perubahan peraturan perundang-undangan pembatasan oleh pemerintah yang kesemuanya langsung berhubungan dengan pelaksanaan perjanjian ini. Pihak yang mengalami force Majeure harus melakukan segala sesuatu yang dianggap penting sebagai upaya untuk tetap memenuhi kewajiban berdasarkan perjanjian ini. Apabila akibat dari force majeure berlangsung lebih dari 30 hari kalender maka masing-masing pihak dapat mengakhiri perjanjian ini dengan pemberitahuan tertulis kepada Pihak lainnya tanpa tanggung jawab kepada Pihak lawan atas kerugian yang terjadi.</td>
                </tr>
            </tbody>
        </table>
        <div class='page_break'></div>
        <table class='table-sm' cellspacing='0' style='width: 100%;'>
            <thead>
                <tr>
                    <th colspan='2' class='font-size-xxs font-w50 text-center' style='vertical-align: bottom;'><h2>PASAL 17<br>MASA BERLAKU PERJANJIAN</h2></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style='vertical-align: top;width: 5%;'>1.</td>
                    <td style='vertical-align: top;width: 95%;'>Perjanjian berlaku selama 5 (Lima) tahun terhitung sejak Perjanjian ini dibuat.</td>
                </tr>
                <tr>
                    <td style='vertical-align: top;width: 5%;'>2.</td>
                    <td style='vertical-align: top;width: 95%;'>Dalam hal perjanjian ini berakhir bila Pihak Kedua tidak mengajukan perpanjangan perjanjian kepada Pihak Pertama untuk waktu 1 (satu) bulan sebelum berakhirnya perjanjian maka perjanjian akan langsung berlaku kembali untuk 5 (lima) tahun berikutnya dan demikian seterusnya.</td>
                </tr>
            </tbody>
        </table>
        <table class='table-sm' cellspacing='0' style='width: 100%;'>
            <thead>
                <tr>
                    <th colspan='2' class='font-size-xxs font-w50 text-center' style='vertical-align: bottom;'><h2>PASAL 18<br>PENGAKHIRAN PERJANJIAN</h2></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style='vertical-align: top;width: 5%;'>1.</td>
                    <td style='vertical-align: top;width: 95%;'>Para Pihak dapat mengakhiri Perjanjian ini apabila :</td>
                </tr>
                <tr>
                    <td class='text-right' style='vertical-align: top;width: 5%;'>a</td>
                    <td style='vertical-align: top;width: 95%;'>Salah satu pihak melakukan wanprestasi dalam melaksanakan ketentuan dan syarat dari Perjanjian ini dan atau lampiran-lampirannya dan atau perubahan-perubahannya;</td>
                </tr>
                <tr>
                    <td class='text-right' style='vertical-align: top;width: 5%;'>b</td>
                    <td style='vertical-align: top;width: 95%;'>Adanya ketentuan yang menjadikan Perjanjian ini tidak sah bagi Pihak lainnya untuk melanjutkan Perjanjian ini;</td>
                </tr>
                <tr>
                    <td class='text-right' style='vertical-align: top;width: 5%;'>c</td>
                    <td style='vertical-align: top;width: 95%;'>Salah satu Pihak melanggar ketentuan peraturan perundang-undangan termasuk dan tidak terbatas pada aturan tentang Kerahasiaan Bank dan Undang-Undang tentang Tindak Pidana Pencucian Uang;</td>
                </tr>
                <tr>
                    <td class='text-right' style='vertical-align: top;width: 5%;'>c</td>
                    <td style='vertical-align: top;width: 95%;'>Adanya kesepakatan Para Pihak untuk mengakhiri Perjanjian</td>
                </tr>
                <tr>
                    <td style='vertical-align: top;width: 5%;'>2.</td>
                    <td style='vertical-align: top;width: 95%;'>Peralihan kepemilikan, perubahan pengurus dan atau pemegang saham, akuisisi, merger, tidak serta merta mengakhiri perjanjian ini.</td>
                </tr>
                <tr>
                    <td style='vertical-align: top;width: 5%;'>3.</td>
                    <td style='vertical-align: top;width: 95%;'>Para Pihak sepakat untuk mengesampingkan ketentuan Pasal 1266 dan Pasal 1267 Kitab Undang-Undang Hukum Perdata.</td>
                </tr>
            </tbody>
        </table>
        <table class='table-sm' cellspacing='0' style='width: 100%;'>
            <thead>
                <tr>
                    <th colspan='2' class='font-size-xxs font-w50 text-center' style='vertical-align: bottom;'><h2>PASAL 19<br>JUMLAH RANGKAP PERJANJIAN</h2></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style='vertical-align: top;width: 5%;'>1.</td>
                    <td style='vertical-align: top;width: 95%;'>Perjanjian ini dibuat sebagai kesepakatan tanpa paksaan dari siapa pun dan dalam bentuk apa pun. Perjanjian ini dilakukan secara elektronik dan masing-masing pihak mengakui keabsahannya walaupun tidak ada tanda tangan basah masing-masing pihak.</td>
                </tr>
                <tr>
                    <td style='vertical-align: top;width: 5%;'>2.</td>
                    <td style='vertical-align: top;width: 95%;'>Dalam hal dibutuhkan rangkap lebih dari 2(dua), maka rangkap yang ketiga dan seterusnya hanya dilakukan dengan meng-copy dari perjanjian asli dan menandatangani sesuai dengan pernyataan sesuai dengan yang asli.</td>
                </tr>
            </tbody>
        </table>
        <div class='page_break'></div>
        <table class='table-sm table' cellspacing='0' style='width: 100%;'>
            <thead>
                <tr>
                    <th class='font-size-xxs font-w50 text-center' style='vertical-align: bottom;'><h2>PASAL 20<br>PENYELESAIAN PERSELISIHAN</h2></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style='vertical-align: top;width: 100%;'>Apabila terjadi perselisihan mengenai penafsiran atau pelaksanaan Perjanjian ini akan diselesaikan
                    oleh Para Pihak dengan cara musyawarah untuk mufakat.</td>
                </tr>
            </tbody>
        </table>";

        use Endroid\QrCode\QrCode;
        use Endroid\QrCode\Writer\PngWriter;

        $qrCode = QrCode::create('https://pustakadigital.id/')->setSize(100); // Size in pixels

        $writer = new PngWriter();
        $qrCodeImage = $writer->write($qrCode);
        $qrCodeBase64 = base64_encode($qrCodeImage->getString());

        $html .= "<table class='table-sm' cellspacing='0' style='width: 100%; margin-top: 3rem!important'>
            <thead>
                <tr>
                    <th colspan='3' class='font-size-base font-w50 text-center' style='vertical-align: bottom;'>
                        <div class='line-text'>
                            <span>——————————— DEMIKIAN PERJANJIAN INI ———————————</span>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan='3' style='vertical-align: top;width: 100%;'>Dibuat dan disetujui melalui web di Yogyakarta.</td>
                </tr>
                <tr>
                    <td class='text-center'>Pihak Pertama</td>
                    <td class='text-center'></td>
                    <td class='text-center'>Pihak Kedua</td>
                </tr>
                <tr>
                    <td class='text-center' ><img src='data:image/png;base64," . $qrCodeBase64 . "' alt='QR Code'></td>
                    <td class='text-center'></td>
                    <td class='text-center'><img src='data:image/png;base64," . $qrCodeBase64 . "' alt='QR Code'></td>
                </tr>
                <tr>
                    <td class='text-center'><b>Nama</b></td>
                    <td class='text-center'></td>
                    <td class='text-center'><b>Nama</b></td>
                </tr>
            </tbody>
        </table>";


    $html .= "
        <div class='page_break'></div>
    ";


    use Dompdf\Dompdf;

    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);

    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

    // Render the HTML as PDF
    $dompdf->render();

    $canvas = $dompdf->getCanvas();
    $width = $canvas->get_width();
    $height = $canvas->get_height();

    // Parameters
    $x          = $width - 60;  // Adjusted for right alignment (60px margin from the right edge)
    $y          = $height - 33; // Adjusted for bottom alignment (33px margin from the bottom edge)
    $text       = "{PAGE_NUM} of {PAGE_COUNT}";     
    $font       = $dompdf->getFontMetrics()->get_font('Times', 'normal');   
    $size       = 8;    
    $color      = array(0, 0, 0);
    $word_space = 0.0;
    $char_space = 0.0;
    $angle      = 0.0;

    // Add page number to bottom-right corner
    $canvas->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);

    // Parameters for name on the left
    $x_left = 30;  // Adjusted for left alignment (30px margin from the left edge)
    $name_text = now()->format('d M Y H:i:s');  // Replace with the desired name

    // Add name to bottom-left corner
    $canvas->page_text($x_left, $y, $name_text, $font, $size, $color, $word_space, $char_space, $angle);

    // Output the generated PDF to Browser
    $dompdf->stream('Agreement Letter', array("Attachment" => false));
    exit(0);
@endphp