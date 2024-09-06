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
                            <th>Nama Pembaca</th>
                            <th>Jumlah Buku di Baca</th>
                            <th>Total Jam</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Gramedia</td>
                            <td>Jawa Barat</td>
                            <td>Bandung</td>
                            <td>Arya</td>
                            <td>12</td>
                            <td>32</td>
                        </tr>
                        <tr>
                            <td>Mizan</td>
                            <td>Sumatera Utara</td>
                            <td>Medan</td>
                            <td>Siti</td>
                            <td>10</td>
                            <td>28</td>
                        </tr>
                        <tr>
                            <td>Balai Pustaka</td>
                            <td>Jawa Tengah</td>
                            <td>Semarang</td>
                            <td>Rani</td>
                            <td>8</td>
                            <td>21</td>
                        </tr>
                        <tr>
                            <td>Erlangga</td>
                            <td>Bali</td>
                            <td>Denpasar</td>
                            <td>Joko</td>
                            <td>15</td>
                            <td>40</td>
                        </tr>
                        <tr>
                            <td>Kanisius</td>
                            <td>DKI Jakarta</td>
                            <td>Jakarta Selatan</td>
                            <td>Budi</td>
                            <td>22</td>
                            <td>50</td>
                        </tr>
                        <tr>
                            <td>Salemba</td>
                            <td>Kalimantan Timur</td>
                            <td>Samarinda</td>
                            <td>Fatimah</td>
                            <td>13</td>
                            <td>36</td>
                        </tr>
                        <tr>
                            <td>Tiga Serangkai</td>
                            <td>Jawa Timur</td>
                            <td>Surabaya</td>
                            <td>Ahmad</td>
                            <td>18</td>
                            <td>42</td>
                        </tr>
                        <tr>
                            <td>Deepublish</td>
                            <td>Sulawesi Selatan</td>
                            <td>Makassar</td>
                            <td>Indra</td>
                            <td>20</td>
                            <td>45</td>
                        </tr>
                        <tr>
                            <td>Bukune</td>
                            <td>Banten</td>
                            <td>Serang</td>
                            <td>Maya</td>
                            <td>7</td>
                            <td>19</td>
                        </tr>
                        <tr>
                            <td>Visimedia</td>
                            <td>Nusa Tenggara Barat</td>
                            <td>Mataram</td>
                            <td>Andre</td>
                            <td>17</td>
                            <td>38</td>
                        </tr>
                        <tr>
                            <td>Harfeey</td>
                            <td>Papua</td>
                            <td>Jayapura</td>
                            <td>Yuni</td>
                            <td>16</td>
                            <td>30</td>
                        </tr>
                        <tr>
                            <td>Zikrul</td>
                            <td>Jambi</td>
                            <td>Kota Jambi</td>
                            <td>Rizki</td>
                            <td>14</td>
                            <td>35</td>
                        </tr>
                        <tr>
                            <td>Putaka Utama</td>
                            <td>Lampung</td>
                            <td>Bandar Lampung</td>
                            <td>Maria</td>
                            <td>19</td>
                            <td>41</td>
                        </tr>
                        <tr>
                            <td>Alfabeta</td>
                            <td>Riau</td>
                            <td>Pekanbaru</td>
                            <td>Asep</td>
                            <td>21</td>
                            <td>48</td>
                        </tr>
                        <tr>
                            <td>Cetakan Mulia</td>
                            <td>Maluku</td>
                            <td>Ambon</td>
                            <td>Hana</td>
                            <td>9</td>
                            <td>25</td>
                        </tr>
                        <tr>
                            <td>Ilman Press</td>
                            <td>Bengkulu</td>
                            <td>Kota Bengkulu</td>
                            <td>Tommy</td>
                            <td>11</td>
                            <td>30</td>
                        </tr>
                        <tr>
                            <td>Mentari</td>
                            <td>Kalimantan Barat</td>
                            <td>Pontianak</td>
                            <td>Anita</td>
                            <td>13</td>
                            <td>34</td>
                        </tr>
                        <tr>
                            <td>Surya Cipta</td>
                            <td>Sumatera Barat</td>
                            <td>Padang</td>
                            <td>Rizal</td>
                            <td>20</td>
                            <td>43</td>
                        </tr>
                        <tr>
                            <td>Media Presindo</td>
                            <td>Sumatera Selatan</td>
                            <td>Palembang</td>
                            <td>Toni</td>
                            <td>12</td>
                            <td>27</td>
                        </tr>
                        <tr>
                            <td>Asoka</td>
                            <td>Aceh</td>
                            <td>Banda Aceh</td>
                            <td>Yudha</td>
                            <td>14</td>
                            <td>31</td>
                        </tr>
                        <tr>
                            <td>Sinar Dunia</td>
                            <td>Sulawesi Tengah</td>
                            <td>Palu</td>
                            <td>Aldi</td>
                            <td>23</td>
                            <td>50</td>
                        </tr>
                        <tr>
                            <td>Penebar Swadaya</td>
                            <td>Nusa Tenggara Timur</td>
                            <td>Kupang</td>
                            <td>Hendra</td>
                            <td>22</td>
                            <td>46</td>
                        </tr>
                        <tr>
                            <td>Erlangga</td>
                            <td>Jawa Barat</td>
                            <td>Bekasi</td>
                            <td>Nina</td>
                            <td>9</td>
                            <td>26</td>
                        </tr>
                        <tr>
                            <td>Gramedia</td>
                            <td>Jawa Timur</td>
                            <td>Malang</td>
                            <td>Farhan</td>
                            <td>15</td>
                            <td>37</td>
                        </tr>
                        <tr>
                            <td>Mizan</td>
                            <td>Sumatera Utara</td>
                            <td>Binjai</td>
                            <td>Lisa</td>
                            <td>11</td>
                            <td>29</td>
                        </tr>
                        <tr>
                            <td>Balai Pustaka</td>
                            <td>Jawa Tengah</td>
                            <td>Solo</td>
                            <td>Aulia</td>
                            <td>24</td>
                            <td>53</td>
                        </tr>
                        <tr>
                            <td>Tiga Serangkai</td>
                            <td>Jawa Timur</td>
                            <td>Kediri</td>
                            <td>Renata</td>
                            <td>18</td>
                            <td>41</td>
                        </tr>
                        <tr>
                            <td>Deepublish</td>
                            <td>Sulawesi Utara</td>
                            <td>Manado</td>
                            <td>Fikri</td>
                            <td>17</td>
                            <td>38</td>
                        </tr>
                        <tr>
                            <td>Bukune</td>
                            <td>Banten</td>
                            <td>Tangerang</td>
                            <td>Gilang</td>
                            <td>25</td>
                            <td>55</td>
                        </tr>
                        <tr>
                            <td>Kanisius</td>
                            <td>Jawa Barat</td>
                            <td>Depok</td>
                            <td>Novi</td>
                            <td>16</td>
                            <td>36</td>
                        </tr>
                        <tr>
                            <td>Salemba</td>
                            <td>Kalimantan Tengah</td>
                            <td>Palangkaraya</td>
                            <td>Ilham</td>
                            <td>20</td>
                            <td>48</td>
                        </tr>
                        <tr>
                            <td>Zikrul</td>
                            <td>Jawa Timur</td>
                            <td>Pasuruan</td>
                            <td>Fahmi</td>
                            <td>14</td>
                            <td>30</td>
                        </tr>
                        <tr>
                            <td>Putaka Utama</td>
                            <td>Lampung</td>
                            <td>Metro</td>
                            <td>Vina</td>
                            <td>10</td>
                            <td>25</td>
                        </tr>
                        <tr>
                            <td>Visimedia</td>
                            <td>Sumatera Barat</td>
                            <td>Bukittinggi</td>
                            <td>Rosa</td>
                            <td>18</td>
                            <td>39</td>
                        </tr>
                        <tr>
                            <td>Harfeey</td>
                            <td>Bengkulu</td>
                            <td>Kota Bengkulu</td>
                            <td>Angga</td>
                            <td>21</td>
                            <td>47</td>
                        </tr>
                        <tr>
                            <td>Zikrul</td>
                            <td>Sumatera Selatan</td>
                            <td>Lubuklinggau</td>
                            <td>Putri</td>
                            <td>19</td>
                            <td>42</td>
                        </tr>
                        <tr>
                            <td>Penebar Swadaya</td>
                            <td>Jawa Barat</td>
                            <td>Cimahi</td>
                            <td>Dian</td>
                            <td>22</td>
                            <td>50</td>
                        </tr>
                        <tr>
                            <td>Erlangga</td>
                            <td>Bali</td>
                            <td>Badung</td>
                            <td>Agus</td>
                            <td>12</td>
                            <td>29</td>
                        </tr>
                        <tr>
                            <td>Gramedia</td>
                            <td>Kalimantan Timur</td>
                            <td>Balikpapan</td>
                            <td>Rina</td>
                            <td>15</td>
                            <td>34</td>
                        </tr>
                        <tr>
                            <td>Mizan</td>
                            <td>Jawa Barat</td>
                            <td>Subang</td>
                            <td>Juli</td>
                            <td>18</td>
                            <td>41</td>
                        </tr>
                        <tr>
                            <td>Balai Pustaka</td>
                            <td>Nusa Tenggara Barat</td>
                            <td>Lombok</td>
                            <td>Tari</td>
                            <td>23</td>
                            <td>49</td>
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
