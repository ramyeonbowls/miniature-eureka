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
                        <div class="col-md-6 col-12">
                            <div class="row">
                                <div class="col-md-12 mb-12">
                                    <h6>Provinsi</h6>
                                    <fieldset class="form-group">
                                        <select class="form-select" id="basicSelect">
                                            <option>IT</option>
                                            <option>Blade Runner</option>
                                            <option>Thor Ragnarok</option>
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-md-12 mb-12">
                                    <h6>Kabupaten/Kota</h6>
                                    <fieldset class="form-group">
                                        <select class="form-select" id="basicSelect">
                                            <option>IT</option>
                                            <option>Blade Runner</option>
                                            <option>Thor Ragnarok</option>
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-md-12 mb-12">
                                    <h6>White Label</h6>
                                    <fieldset class="form-group">
                                        <select class="form-select" id="basicSelect">
                                            <option>IT</option>
                                            <option>Blade Runner</option>
                                            <option>Thor Ragnarok</option>
                                        </select>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="row">
                                <div class="col-md-12 mb-12">
                                    <h6>Start Date</h6>
                                    <input type="date" class="form-control mb-3 flatpickr-no-config" placeholder="Select date..">
                                </div>
                                <div class="col-md-12 mb-12">
                                    <h6>End Date</h6>
                                    <input type="date" class="form-control mb-3 flatpickr-no-config" placeholder="Select date..">
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
                    <a href="#" class="btn icon icon-left btn-primary"><i class="bi bi-file-earmark-excel-fill"></i> Export</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Name WL</th>
                            <th>Provinsi</th>
                            <th>Kab/Kota</th>
                            <th>Jumlah Pembaca</th>
                            <th>Total Jam</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Raihan</td>
                            <td>Jawa Barat</td>
                            <td>Bandung</td>
                            <td>124</td>
                            <td>42</td>
                        </tr>
                        <tr>
                            <td>Mahendra</td>
                            <td>Sumatera Utara</td>
                            <td>Medan</td>
                            <td>203</td>
                            <td>56</td>
                        </tr>
                        <tr>
                            <td>Aldo</td>
                            <td>Jawa Tengah</td>
                            <td>Semarang</td>
                            <td>98</td>
                            <td>33</td>
                        </tr>
                        <tr>
                            <td>Ilham</td>
                            <td>Bali</td>
                            <td>Denpasar</td>
                            <td>145</td>
                            <td>49</td>
                        </tr>
                        <tr>
                            <td>Siti</td>
                            <td>DKI Jakarta</td>
                            <td>Jakarta Selatan</td>
                            <td>310</td>
                            <td>78</td>
                        </tr>
                        <tr>
                            <td>Dewi</td>
                            <td>Kalimantan Timur</td>
                            <td>Samarinda</td>
                            <td>210</td>
                            <td>64</td>
                        </tr>
                        <tr>
                            <td>Budi</td>
                            <td>Jawa Timur</td>
                            <td>Surabaya</td>
                            <td>190</td>
                            <td>55</td>
                        </tr>
                        <tr>
                            <td>Yusuf</td>
                            <td>Sulawesi Selatan</td>
                            <td>Makassar</td>
                            <td>230</td>
                            <td>62</td>
                        </tr>
                        <tr>
                            <td>Nurul</td>
                            <td>Banten</td>
                            <td>Serang</td>
                            <td>132</td>
                            <td>48</td>
                        </tr>
                        <tr>
                            <td>Fatimah</td>
                            <td>Nusa Tenggara Barat</td>
                            <td>Mataram</td>
                            <td>180</td>
                            <td>51</td>
                        </tr>
                        <tr>
                            <td>Rizky</td>
                            <td>Papua</td>
                            <td>Jayapura</td>
                            <td>110</td>
                            <td>44</td>
                        </tr>
                        <tr>
                            <td>Putri</td>
                            <td>Jambi</td>
                            <td>Kota Jambi</td>
                            <td>167</td>
                            <td>53</td>
                        </tr>
                        <tr>
                            <td>Aisyah</td>
                            <td>Sulawesi Tenggara</td>
                            <td>Kendari</td>
                            <td>146</td>
                            <td>47</td>
                        </tr>
                        <tr>
                            <td>Fikri</td>
                            <td>Lampung</td>
                            <td>Bandar Lampung</td>
                            <td>189</td>
                            <td>59</td>
                        </tr>
                        <tr>
                            <td>Firman</td>
                            <td>Jawa Barat</td>
                            <td>Bekasi</td>
                            <td>215</td>
                            <td>66</td>
                        </tr>
                        <tr>
                            <td>Hasan</td>
                            <td>Riau</td>
                            <td>Pekanbaru</td>
                            <td>128</td>
                            <td>40</td>
                        </tr>
                        <tr>
                            <td>Salsabila</td>
                            <td>Maluku</td>
                            <td>Ambon</td>
                            <td>141</td>
                            <td>45</td>
                        </tr>
                        <tr>
                            <td>Reza</td>
                            <td>Bengkulu</td>
                            <td>Kota Bengkulu</td>
                            <td>163</td>
                            <td>54</td>
                        </tr>
                        <tr>
                            <td>Fauzan</td>
                            <td>Kalimantan Barat</td>
                            <td>Pontianak</td>
                            <td>207</td>
                            <td>60</td>
                        </tr>
                        <tr>
                            <td>Rahmat</td>
                            <td>Sumatera Barat</td>
                            <td>Padang</td>
                            <td>186</td>
                            <td>57</td>
                        </tr>
                        <tr>
                            <td>Ahmad</td>
                            <td>Sumatera Selatan</td>
                            <td>Palembang</td>
                            <td>223</td>
                            <td>63</td>
                        </tr>
                        <tr>
                            <td>Nabila</td>
                            <td>Aceh</td>
                            <td>Banda Aceh</td>
                            <td>135</td>
                            <td>43</td>
                        </tr>
                        <tr>
                            <td>Hafiz</td>
                            <td>Sulawesi Tengah</td>
                            <td>Palu</td>
                            <td>150</td>
                            <td>46</td>
                        </tr>
                        <tr>
                            <td>Aditya</td>
                            <td>Nusa Tenggara Timur</td>
                            <td>Kupang</td>
                            <td>211</td>
                            <td>65</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</template>

<script>
import { Form as VeeForm, Field, ErrorMessage } from 'vee-validate'
import { DataTable } from 'simple-datatables'

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
        }
    },

    mounted() {
        this.__MENU()

        table = $('#table1').DataTable()
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
