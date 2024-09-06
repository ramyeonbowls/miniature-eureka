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
                    <a href="#" class="btn icon icon-left btn-primary" data-bs-toggle="modal" data-bs-target="#border-less"><i class="bi bi-filter-square-fill"></i> Filter</a>
                    <a href="#" class="btn icon icon-left btn-success"><i class="bi bi-file-earmark-excel-fill"></i> Export</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Nama WL</th>
                            <th>Provinsi</th>
                            <th>Kab/Kota</th>
                            <th>Judul Buku</th>
                            <th>Jumlah Pembaca</th>
                            <th>Total Jam</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Gramedia</td>
                            <td>Jawa Barat</td>
                            <td>Bandung</td>
                            <td>Belajar Pemrograman</td>
                            <td>23</td>
                            <td>52</td>
                        </tr>
                        <tr>
                            <td>Erlangga</td>
                            <td>Jawa Timur</td>
                            <td>Surabaya</td>
                            <td>Matematika Dasar</td>
                            <td>19</td>
                            <td>43</td>
                        </tr>
                        <tr>
                            <td>Visimedia</td>
                            <td>Sumatera Utara</td>
                            <td>Medan</td>
                            <td>Sejarah Nusantara</td>
                            <td>15</td>
                            <td>35</td>
                        </tr>
                        <tr>
                            <td>Mizan</td>
                            <td>Jawa Tengah</td>
                            <td>Semarang</td>
                            <td>Pemikiran Islam</td>
                            <td>18</td>
                            <td>40</td>
                        </tr>
                        <tr>
                            <td>Balai Pustaka</td>
                            <td>DI Yogyakarta</td>
                            <td>Sleman</td>
                            <td>Sastra Klasik</td>
                            <td>20</td>
                            <td>45</td>
                        </tr>
                        <tr>
                            <td>Penebar Swadaya</td>
                            <td>Bali</td>
                            <td>Denpasar</td>
                            <td>Flora Indonesia</td>
                            <td>22</td>
                            <td>48</td>
                        </tr>
                        <tr>
                            <td>Harfeey</td>
                            <td>Kalimantan Timur</td>
                            <td>Samarinda</td>
                            <td>Petualangan di Hutan</td>
                            <td>12</td>
                            <td>28</td>
                        </tr>
                        <tr>
                            <td>Zikrul</td>
                            <td>Sulawesi Selatan</td>
                            <td>Makassar</td>
                            <td>Teknologi Modern</td>
                            <td>25</td>
                            <td>55</td>
                        </tr>
                        <tr>
                            <td>Pustaka Utama</td>
                            <td>Banten</td>
                            <td>Tangerang</td>
                            <td>Kewirausahaan</td>
                            <td>14</td>
                            <td>30</td>
                        </tr>
                        <tr>
                            <td>Gramedia</td>
                            <td>Jawa Barat</td>
                            <td>Bekasi</td>
                            <td>Sains Populer</td>
                            <td>16</td>
                            <td>33</td>
                        </tr>
                        <tr>
                            <td>Erlangga</td>
                            <td>Jawa Timur</td>
                            <td>Malang</td>
                            <td>Filsafat Hidup</td>
                            <td>17</td>
                            <td>39</td>
                        </tr>
                        <tr>
                            <td>Visimedia</td>
                            <td>Sumatera Selatan</td>
                            <td>Palembang</td>
                            <td>Psikologi Remaja</td>
                            <td>13</td>
                            <td>29</td>
                        </tr>
                        <tr>
                            <td>Mizan</td>
                            <td>Jawa Tengah</td>
                            <td>Solo</td>
                            <td>Sejarah Dunia</td>
                            <td>21</td>
                            <td>50</td>
                        </tr>
                        <tr>
                            <td>Balai Pustaka</td>
                            <td>Sumatera Barat</td>
                            <td>Padang</td>
                            <td>Legenda Lokal</td>
                            <td>18</td>
                            <td>41</td>
                        </tr>
                        <tr>
                            <td>Penebar Swadaya</td>
                            <td>Kalimantan Barat</td>
                            <td>Pontianak</td>
                            <td>Tanaman Obat</td>
                            <td>15</td>
                            <td>35</td>
                        </tr>
                        <tr>
                            <td>Harfeey</td>
                            <td>Jawa Barat</td>
                            <td>Depok</td>
                            <td>Kesehatan Alami</td>
                            <td>19</td>
                            <td>44</td>
                        </tr>
                        <tr>
                            <td>Zikrul</td>
                            <td>Sulawesi Utara</td>
                            <td>Manado</td>
                            <td>Pertanian Modern</td>
                            <td>23</td>
                            <td>52</td>
                        </tr>
                        <tr>
                            <td>Pustaka Utama</td>
                            <td>Jawa Timur</td>
                            <td>Blitar</td>
                            <td>Bisnis Digital</td>
                            <td>20</td>
                            <td>45</td>
                        </tr>
                        <tr>
                            <td>Gramedia</td>
                            <td>DKI Jakarta</td>
                            <td>Jakarta</td>
                            <td>Politik Indonesia</td>
                            <td>24</td>
                            <td>53</td>
                        </tr>
                        <tr>
                            <td>Erlangga</td>
                            <td>Bali</td>
                            <td>Kuta</td>
                            <td>Wisata Nusantara</td>
                            <td>14</td>
                            <td>31</td>
                        </tr>
                        <tr>
                            <td>Visimedia</td>
                            <td>Jawa Tengah</td>
                            <td>Magelang</td>
                            <td>Ekonomi Global</td>
                            <td>17</td>
                            <td>38</td>
                        </tr>
                        <tr>
                            <td>Mizan</td>
                            <td>Riau</td>
                            <td>Pekanbaru</td>
                            <td>Kesenian Tradisional</td>
                            <td>19</td>
                            <td>42</td>
                        </tr>
                        <tr>
                            <td>Balai Pustaka</td>
                            <td>Nusa Tenggara Timur</td>
                            <td>Ende</td>
                            <td>Geografi Indonesia</td>
                            <td>18</td>
                            <td>40</td>
                        </tr>
                        <tr>
                            <td>Penebar Swadaya</td>
                            <td>Kalimantan Tengah</td>
                            <td>Palangkaraya</td>
                            <td>Ilmu Sosial</td>
                            <td>16</td>
                            <td>34</td>
                        </tr>
                        <tr>
                            <td>Harfeey</td>
                            <td>Jawa Timur</td>
                            <td>Kediri</td>
                            <td>Teknologi Ramah Lingkungan</td>
                            <td>22</td>
                            <td>49</td>
                        </tr>
                        <tr>
                            <td>Zikrul</td>
                            <td>Sulawesi Tenggara</td>
                            <td>Kendari</td>
                            <td>Ekologi dan Lingkungan</td>
                            <td>13</td>
                            <td>29</td>
                        </tr>
                        <tr>
                            <td>Pustaka Utama</td>
                            <td>Kalimantan Timur</td>
                            <td>Balikpapan</td>
                            <td>Inovasi Teknologi</td>
                            <td>20</td>
                            <td>46</td>
                        </tr>
                        <tr>
                            <td>Gramedia</td>
                            <td>Jawa Barat</td>
                            <td>Bandung</td>
                            <td>Desain Grafis</td>
                            <td>21</td>
                            <td>48</td>
                        </tr>
                        <tr>
                            <td>Erlangga</td>
                            <td>Sumatera Barat</td>
                            <td>Padang</td>
                            <td>Pengetahuan Alam</td>
                            <td>17</td>
                            <td>37</td>
                        </tr>
                        <tr>
                            <td>Visimedia</td>
                            <td>Jawa Timur</td>
                            <td>Banyuwangi</td>
                            <td>Fotografi Digital</td>
                            <td>14</td>
                            <td>32</td>
                        </tr>
                        <tr>
                            <td>Mizan</td>
                            <td>Sulawesi Selatan</td>
                            <td>Makassar</td>
                            <td>Ekonomi Kreatif</td>
                            <td>18</td>
                            <td>41</td>
                        </tr>
                        <tr>
                            <td>Balai Pustaka</td>
                            <td>Bali</td>
                            <td>Gianyar</td>
                            <td>Seni Rupa Tradisional</td>
                            <td>16</td>
                            <td>34</td>
                        </tr>
                        <tr>
                            <td>Penebar Swadaya</td>
                            <td>Jawa Barat</td>
                            <td>Bogor</td>
                            <td>Pertanian Organik</td>
                            <td>15</td>
                            <td>36</td>
                        </tr>
                        <tr>
                            <td>Harfeey</td>
                            <td>Sumatera Utara</td>
                            <td>Medan</td>
                            <td>Kuliner Nusantara</td>
                            <td>22</td>
                            <td>50</td>
                        </tr>
                        <tr>
                            <td>Zikrul</td>
                            <td>Kalimantan Barat</td>
                            <td>Sintang</td>
                            <td>Teknologi Informasi</td>
                            <td>18</td>
                            <td>42</td>
                        </tr>
                        <tr>
                            <td>Pustaka Utama</td>
                            <td>Jawa Tengah</td>
                            <td>Solo</td>
                            <td>Perbankan Syariah</td>
                            <td>20</td>
                            <td>45</td>
                        </tr>
                        <tr>
                            <td>Gramedia</td>
                            <td>Jawa Timur</td>
                            <td>Surabaya</td>
                            <td>Analisis Data</td>
                            <td>19</td>
                            <td>44</td>
                        </tr>
                        <tr>
                            <td>Erlangga</td>
                            <td>Sulawesi Tengah</td>
                            <td>Palu</td>
                            <td>Ekonomi Makro</td>
                            <td>16</td>
                            <td>35</td>
                        </tr>
                        <tr>
                            <td>Visimedia</td>
                            <td>Kalimantan Timur</td>
                            <td>Samarinda</td>
                            <td>Ilmu Pengetahuan Alam</td>
                            <td>13</td>
                            <td>28</td>
                        </tr>
                        <tr>
                            <td>Mizan</td>
                            <td>Banten</td>
                            <td>Serang</td>
                            <td>Budaya Populer</td>
                            <td>21</td>
                            <td>47</td>
                        </tr>
                        <tr>
                            <td>Balai Pustaka</td>
                            <td>Jawa Barat</td>
                            <td>Cirebon</td>
                            <td>Sastra Dunia</td>
                            <td>22</td>
                            <td>51</td>
                        </tr>
                        <tr>
                            <td>Penebar Swadaya</td>
                            <td>Jawa Timur</td>
                            <td>Sidoarjo</td>
                            <td>Ekonomi Pembangunan</td>
                            <td>23</td>
                            <td>54</td>
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
