<template>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-2 d-none d-lg-block">
                <div id="auth-right"></div>
            </div>
            <div class="col-lg-8 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="#"><img src="images/logo/logo.svg" alt="Logo" /></a>
                    </div>
                    <h1 class="auth-title text-center">Form Pendaftaran</h1>
                    <p class="auth-subtitle mb-5 text-center">Form Pendaftaran Supplier & Distributor</p>

                    <VeeForm ref="form" v-slot="{ handleSubmit }" as="div">
                        <form class="form form-horizontal" @submit.prevent="handleSubmit($event, submit)">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title">Kategori Pendaftaran</h5>
                                        </div>
                                        <div class="card-body">
                                            <p>Daftar Sebagai <span class="text-danger">*</span></p>
                                            <div class="form-check">
                                                <div class="checkbox">
                                                    <input type="checkbox" name="supplier" id="supplier" v-model="form.supplier" class="form-check-input" />
                                                    <label for="supplier">Supplier</label>
                                                    <ErrorMessage name="supplier" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                                </div>
                                                <div class="checkbox">
                                                    <input type="checkbox" name="distributor" id="distributor" v-model="form.distributor" class="form-check-input" />
                                                    <label for="distributor">Distributor</label>
                                                    <ErrorMessage name="distributor" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                                </div>
                                            </div>
                                            <div class="form-group my-2 d-flex justify-content-end">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title">Data Perusahaan</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group my-2">
                                                <label for="nama_perusahaan" class="form-label">Nama Perusahaan <span class="text-danger">*</span></label>
                                                <Field type="text" name="nama_perusahaan" id="nama_perusahaan" v-model="form.nama_perusahaan" class="form-control" placeholder="Nama Perusahaan" />
                                                <ErrorMessage name="nama_perusahaan" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                            </div>
                                            <div class="form-group my-2">
                                                <label for="email_perusahaan" class="form-label">Email Perusahaan <span class="text-danger">*</span></label>
                                                <Field type="email" name="email_perusahaan" id="email_perusahaan" v-model="form.email_perusahaan" class="form-control" placeholder="Email Perusahaan" />
                                                <ErrorMessage name="email_perusahaan" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                            </div>
                                            <div class="form-group my-2">
                                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                                <Field type="password" name="password" id="password" v-model="form.password" class="form-control" placeholder="Enter new password" />
                                                <ErrorMessage name="password" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                            </div>
                                            <div class="form-group my-2">
                                                <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                                <Field type="password" name="password_confirmation" id="password_confirmation" v-model="form.password_confirmation" class="form-control" placeholder="Enter confirm password" />
                                                <ErrorMessage name="password_confirmation" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title">Alamat Perusahaan</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row form-group my-2">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group my-2">
                                                        <label for="negara" class="form-label">Negara <span class="text-danger">*</span></label>
                                                        <Field as="select" name="negara" id="negara" v-model="form.negara" class="form-control" @change="getProvinsi">
                                                            <option value="">--</option>
                                                            <option value="id">INDONESIA</option>
                                                        </Field>
                                                        <ErrorMessage name="negara" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group my-2">
                                                        <label for="provinsi" class="form-label">Provinsi <span class="text-danger">*</span></label>
                                                        <Field as="select" name="provinsi" id="provinsi" v-model="form.provinsi" class="form-control" @change="getKabupaten">
                                                            <option value="">--</option>
                                                            <option v-for="(value, key) in option.fprovinsi" :key="key" :value="value.id">{{ value.name }}</option>
                                                        </Field>
                                                        <ErrorMessage name="provinsi" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group my-2">
                                                        <label for="kabupaten" class="form-label">Kabupaten/Kota <span class="text-danger">*</span></label>
                                                        <Field as="select" name="kabupaten" id="kabupaten" v-model="form.kabupaten" class="form-control" @change="getKecamatan">
                                                            <option value="">--</option>
                                                            <option v-for="(value, key) in option.fkabupaten" :key="key" :value="value.id">{{ value.name }}</option>
                                                        </Field>
                                                        <ErrorMessage name="kabupaten" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group my-2">
                                                        <label for="kecamatan" class="form-label">Kecamatan <span class="text-danger">*</span></label>
                                                        <Field as="select" name="kecamatan" id="kecamatan" v-model="form.kecamatan" class="form-control" @change="getKelurahan">
                                                            <option value="">--</option>
                                                            <option v-for="(value, key) in option.fkecamatan" :key="key" :value="value.id">{{ value.name }}</option>
                                                        </Field>
                                                        <ErrorMessage name="kecamatan" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group my-2">
                                                        <label for="keluarahan" class="form-label">Keluarahan <span class="text-danger">*</span></label>
                                                        <Field as="select" name="keluarahan" id="keluarahan" v-model="form.keluarahan" class="form-control">
                                                            <option value="">--</option>
                                                            <option v-for="(value, key) in option.fkelurahan" :key="key" :value="value.id">{{ value.name }}</option>
                                                        </Field>
                                                        <ErrorMessage name="keluarahan" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group my-2">
                                                        <label for="kode_pos" class="form-label">Kode Pos <span class="text-danger">*</span></label>
                                                        <Field type="text" name="kode_pos" id="kode_pos" v-model="form.kode_pos" class="form-control" placeholder="Kode Pos" />
                                                        <ErrorMessage name="kode_pos" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group my-2">
                                                <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                                                <Field as="textarea" name="alamat" id="alamat" v-model="form.alamat" class="form-control" placeholder="Alamat Perusahaan" />
                                                <ErrorMessage name="alamat" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                            </div>
                                            <div class="form-group my-2">
                                                <label for="telepon" class="form-label">No. Telepon <span class="text-danger">*</span></label>
                                                <Field type="text" name="telepon" id="telepon" v-model="form.telepon" class="form-control" placeholder="No. Telepon" />
                                                <ErrorMessage name="telepon" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                            </div>
                                            <div class="form-group my-2">
                                                <label for="handphone" class="form-label">No. Hp/Wa <span class="text-danger">*</span></label>
                                                <Field type="text" name="handphone" id="handphone" v-model="form.handphone" class="form-control" placeholder="No. Hp/Wa" />
                                                <ErrorMessage name="handphone" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title">Profile Perusahaan</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group my-2">
                                                <label for="pimpinan" class="form-label">Nama Pimpinan <span class="text-danger">*</span></label>
                                                <Field type="text" name="pimpinan" id="pimpinan" v-model="form.pimpinan" class="form-control" placeholder="Nama Pimpinan" />
                                                <ErrorMessage name="pimpinan" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                            </div>
                                            <div class="form-group my-2">
                                                <label for="jabatan" class="form-label">Jabatan <span class="text-danger">*</span></label>
                                                <Field type="text" name="jabatan" id="jabatan" v-model="form.jabatan" class="form-control" placeholder="Jabatan" />
                                                <ErrorMessage name="jabatan" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                            </div>
                                            <div class="form-group my-2">
                                                <label for="hpimpinan" class="form-label">No. Hp Pimpinan <span class="text-danger">*</span></label>
                                                <Field type="text" name="hpimpinan" id="hpimpinan" v-model="form.hpimpinan" class="form-control" placeholder="No. Hp Pimpinan" />
                                                <ErrorMessage name="hpimpinan" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                            </div>
                                            <div class="form-group my-2">
                                                <label for="pic" class="form-label">Nama Pic <span class="text-danger">*</span></label>
                                                <Field type="text" name="pic" id="pic" v-model="form.pic" class="form-control" placeholder="Nama Pic" />
                                                <ErrorMessage name="pic" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                            </div>
                                            <div class="form-group my-2">
                                                <label for="hpic" class="form-label">No. Hp Pic <span class="text-danger">*</span></label>
                                                <Field type="text" name="hpic" id="hpic" v-model="form.hpic" class="form-control" placeholder="No. Hp Pic" />
                                                <ErrorMessage name="hpic" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="form.supplier" class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title">Data Imprint</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive-sm">
                                                <table class="table table-sm mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center" style="width: 70%;">Nama</th>
                                                            <th class="text-center"><button type="button" class="btn icon btn-success" @click="addImp"><i class="bi bi-plus"></i></button></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <template v-if="form.imprint.length > 0">
                                                            <tr v-for="(imp, key) in form.imprint" :key="key">
                                                                <td class="text-center"><Field type="text" :name="'imprint_' + (key+1)" :id="'imprint_' + (key+1)" v-model="imp.nama" class="form-control" :placeholder="'Nama Imprint ' + (key+1)" /></td>
                                                                <td class="text-center"><button type="button" class="btn icon btn-danger" @click="delImp(imp)"><i class="bi bi-x"></i></button></td>
                                                            </tr>
                                                        </template>
                                                        <template v-else>
                                                            <tr><td colspan="2" class="text-center">klik tombol plus untuk menambahkan ( <i class="bi bi-plus-circle text-success"></i> )</td></tr>
                                                        </template>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="form.supplier" class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title">Penerbit Pemberi Kuasa</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-sm mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center" style="width: 70%;">Nama</th>
                                                            <th class="text-center"><button type="button" class="btn icon btn-success" @click="addKuasa"><i class="bi bi-plus"></i></button></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <template v-if="form.kuasa.length > 0">
                                                            <tr v-for="(ksa, key) in form.kuasa" :key="key">
                                                                <td class="text-center"><Field type="text" :name="'kuasa_' + (key+1)" :id="'kuasa_' + (key+1)" v-model="ksa.nama" class="form-control" :placeholder="'Nama Penerbit Pemberi Kuasa ' + (key+1)" /></td>
                                                                <td class="text-center"><button type="button" class="btn icon btn-danger" @click="delKuasa(ksa)"><i class="bi bi-x"></i></button></td>
                                                            </tr>
                                                        </template>
                                                        <template v-else>
                                                            <tr><td colspan="2" class="text-center">klik tombol plus untuk menambahkan ( <i class="bi bi-plus-circle text-success"></i> )</td></tr>
                                                        </template>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="form.supplier" class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title">Kategori Terbitan</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-sm mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center" style="width: 70%;">Kategori</th>
                                                            <th class="text-center"><button type="button" class="btn icon btn-success" @click="getKategori"><i class="bi bi-plus"></i></button></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <template v-if="form.kategori.length > 0">
                                                            <tr v-for="(ktg, key) in form.kategori" :key="key">
                                                                <td class="text-center">{{ ktg.desc }}</td>
                                                                <td class="text-center"><button type="button" class="btn icon btn-danger" @click="delKategori(ktg)"><i class="bi bi-x"></i></button></td>
                                                            </tr>
                                                        </template>
                                                        <template v-else>
                                                            <tr><td colspan="2" class="text-center">klik tombol plus untuk menambahkan ( <i class="bi bi-plus-circle text-success"></i> )</td></tr>
                                                        </template>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Rekening Bank</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive-sm">
                                            <table class="table table-sm p-3 mb-0">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">NPWP</th>
                                                        <th class="text-center">Nomor Rekening</th>
                                                        <th class="text-center">Nama Bank</th>
                                                        <th class="text-center">Nama Rekening</th>
                                                        <th class="text-center">Kota Bank</th>
                                                        <th class="text-center"><button type="button" class="btn icon btn-success" @click="addRekening"><i class="bi bi-plus"></i></button></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <template v-if="form.rekening.length > 0">
                                                        <tr v-for="(rkn, key) in form.rekening" :key="key">
                                                            <td class="text-center"><Field type="text" :name="'npwp_' + (key+1)" :id="'npwp_' + (key+1)" v-model="rkn.npwp" class="form-control" :placeholder="'NPWP ' + (key+1)" /></td>
                                                            <td class="text-center"><Field type="text" :name="'norek_' + (key+1)" :id="'norek_' + (key+1)" v-model="rkn.norek" class="form-control" :placeholder="'Nomor Rekening ' + (key+1)" /></td>
                                                            <td class="text-center"><Field type="text" :name="'bank_' + (key+1)" :id="'bank_' + (key+1)" v-model="rkn.bank" class="form-control" :placeholder="'Nama Bank ' + (key+1)" /></td>
                                                            <td class="text-center"><Field type="text" :name="'nama_' + (key+1)" :id="'nama_' + (key+1)" v-model="rkn.nama" class="form-control" :placeholder="'Nama Rekening ' + (key+1)" /></td>
                                                            <td class="text-center"><Field type="text" :name="'kota_' + (key+1)" :id="'kota_' + (key+1)" v-model="rkn.kota" class="form-control" :placeholder="'Kota Bank ' + (key+1)" /></td>
                                                            <td class="text-center"><button type="button" class="btn icon btn-danger" @click="delRekening(rkn)"><i class="bi bi-x"></i></button></td>
                                                        </tr>
                                                    </template>
                                                    <template v-else>
                                                        <tr><td colspan="6" class="text-center">klik tombol plus untuk menambahkan ( <i class="bi bi-plus-circle text-success"></i> )</td></tr>
                                                    </template>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Logo Perusahaan</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form form-horizontal">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-12 form-group">
                                                        <input type="file" ref="banner_files" id="file" name="file" @change="onChangeBanner" accept=".png,.jpg,.jpeg"/>
                                                        <ErrorMessage name="file" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                                        <br><small class="text-muted">Max. size: 1 MB (1980x750 pixels) File types: png, jpg, jpeg</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="alert alert-danger">
                                            <p>Saya menyatakan bahwa semua data telah diisi dengan data yang benar dan apabila ada perubahan saya akan mengisi ulang formulir ini sebagai data perbaikan. Saya bertanggungjawab terhadap kebenaran data ini, dan dokumen akan otomatis terbentuk tanda tangan elektronik atas dasar persetujuan saya.</p>
                                        </div>
                                        <div class="col-12 d-flex justify-content">
                                            <button class="btn icon icon-left btn-primary" @click.prevent="submit"><i class="bi bi-send-check"></i> Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </VeeForm>
                </div>
            </div>
            <div class="col-lg-2 d-none d-lg-block">
                <div id="auth-right"></div>
            </div>
        </div>
    </div>

    <!-- modal kategori -->
    <div class="modal fade text-left" id="mdl-kategori" tabindex="-1" role="dialog" aria-labelledby="modal-kategori" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-kategori">Kategori</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" @click="keyword = ''">
                        <i class="bi bi-x-lg text-black"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group my-2">
                        <input type="text" v-model="keyword" class="form-control form-control-sm font-sdeal" placeholder="Type here for searching">
                    </div>
                    <div class="form-group my-2">
                        <div class="form-check">
                            <div class="checkbox" v-for="(ktg, i) in kategoriView">
                                <input type="checkbox" class="form-check-input" v-model="form.kategori" :id="'ktgcode_'+ i" :name="'ktgcode_'+ i" :value="{ id: ktg.id, desc: ktg.name }">
                                <label :for="'ktgcode_'+ i">{{ ktg.id +' '+ ktg.name }}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal" @click="keyword = ''">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal kategori -->
</template>

<script>
import { Form as VeeForm, Field, ErrorMessage } from 'vee-validate'

export default {
    components: {
        VeeForm,
        Field,
        ErrorMessage,
    },

    data() {
        return {
            keyword: '',
            submitted: false,

            option: {
                fprovinsi: [],
                fkabupaten: [],
                fkecamatan: [],
                fkelurahan: [],
                fkategori: [],
            },

            form: {
                supplier: false,
                distributor: false,
                nama_perusahaan: false,
                email_perusahaan: '',
                password: '',
                password_confirmation: '',
                negara: '',
                provinsi: '',
                kabupaten: '',
                kecamatan: '',
                keluarahan: '',
                kode_pos: '',
                alamat: '',
                telepon: '',
                handphone: '',
                pimpinan: '',
                jabatan: '',
                hpimpinan: '',
                pic: '',
                hpic: '',
                imprint: [],
                kuasa: [],
                kategori: [],
                rekening: [],
                file: '',
                current_file: '',
            }
        }
    },

    mounted() {
        this.__clearForm()
    },

    methods: {
        __clearForm() {
            this.$refs.form.resetForm()

            this.keyword = ''
            this.submitted = false

            this.option.fprovinsi = []
            this.option.fkabupaten = []
            this.option.fkecamatan = []
            this.option.fkelurahan = []
            this.option.fkategori = []

            this.form.supplier = false
            this.form.distributor = false
            this.form.nama_perusahaan = ''
            this.form.email_perusahaan = ''
            this.form.password = ''
            this.form.password_confirmation = ''
            this.form.negara = ''
            this.form.negara = ''
            this.form.provinsi = ''
            this.form.kabupaten = ''
            this.form.kecamatan = ''
            this.form.keluarahan = ''
            this.form.kode_pos = ''
            this.form.alamat = ''
            this.form.telepon = ''
            this.form.handphone = ''
            this.form.pimpinan = ''
            this.form.jabatan = ''
            this.form.hpimpinan = ''
            this.form.pic = ''
            this.form.hpic = ''
            this.form.file = ''
            this.form.current_file = ''

            this.$refs.banner_files.value = ''
        },

        getProvinsi() {
            this.form.provinsi = ''
            this.form.kabupaten = ''
            this.form.kecamatan = ''
            this.form.keluarahan = ''

            let loader = this.$loading.show()
            window.axios.get('/form-regis/x0y0z0', {
                params: {
                    param: 'provinsi-mst',
                }
            })
            .then((response) => {
                loader.hide()
                this.option.fprovinsi = response.data
            })
            .catch((e) => {
                console.error(e)
            });
        },

        getKabupaten() {
            this.form.kabupaten = ''
            this.form.kecamatan = ''
            this.form.keluarahan = ''

            let loader = this.$loading.show()
            window.axios.get('/form-regis/x0y0z0', {
                params: {
                    param: 'kabupaten-mst',
                    provinsi: this.form.provinsi
                }
            })
            .then((response) => {
                loader.hide()
                this.option.fkabupaten = response.data
            })
            .catch((e) => {
                console.error(e)
            });
        },

        getKecamatan() {
            this.form.kecamatan = ''
            this.form.keluarahan = ''

            let loader = this.$loading.show()
            window.axios.get('/form-regis/x0y0z0', {
                params: {
                    param: 'kecamatan-mst',
                    provinsi: this.form.provinsi,
                    kabupaten: this.form.kabupaten,
                }
            })
            .then((response) => {
                loader.hide()
                this.option.fkecamatan = response.data
            })
            .catch((e) => {
                console.error(e)
            });
        },

        getKelurahan() {
            this.form.keluarahan = ''

            let loader = this.$loading.show()
            window.axios.get('/form-regis/x0y0z0', {
                params: {
                    param: 'kelurahan-mst',
                    provinsi: this.form.provinsi,
                    kabupaten: this.form.kabupaten,
                    kecamatan: this.form.kecamatan,
                }
            })
            .then((response) => {
                loader.hide()
                this.option.fkelurahan = response.data
            })
            .catch((e) => {
                console.error(e)
            });
        },

        addImp() {
            this.form.imprint.push({ nama: '' })
        },

        delImp(index) {
            this.form.imprint.splice(this.form.imprint.indexOf(index), 1)
        },

        addKuasa() {
            this.form.kuasa.push({ nama: '' })
        },

        delKuasa(index) {
            this.form.kuasa.splice(this.form.kuasa.indexOf(index), 1)
        },

        getKategori() {
            new bootstrap.Modal(document.getElementById('mdl-kategori')).show()

            window.axios.get('/form-regis/x0y0z0', { 
                params: {
                    param: 'kategori-mst',
                }
            })
            .then((response) => {
                this.option.fkategori = response.data;

                if (this.option.fkategori.length == 0) {
                    Swal.fire({
                        toast: true,
                        position: 'center',
                        icon: 'info',
                        title: 'No data to add',
                        buttonsStyling: false,
                        customClass: {
                            confirmButton: 'btn btn-sm btn-primary'
                        }
                    }).then((result) => {
                        if (result.value) {
                            bootstrap.Modal.getInstance(document.getElementById('mdl-kategori')).hide()
                        }
                    });
                }
            });
        },

        delKategori(index) {
            this.form.kategori.splice(this.form.kategori.indexOf(index), 1);
        },

        addRekening() {
            this.form.rekening.push({ 
                npwp: '',
                norek: '',
                bank: '',
                nama: '',
                kota: '', 
            })
        },

        delRekening(index) {
            this.form.rekening.splice(this.form.rekening.indexOf(index), 1)
        },

        async onChangeBanner(e) {
            this.form.file = this.$refs.banner_files.files[0];
        },

        submit() {
            if(!this.submitted) {
                this.submitted = true;

                this.$refs.form.validate().then(result => {
                    if(result.valid) {
                        this.submitted = false;

                        let loader = this.$loading.show();

                        let form_data = new FormData();
                        Object.keys(this.form).forEach(key => {
                            let value = this.form[key];
                            if (typeof value === 'object' && value !== null) {
                                form_data.append(key, JSON.stringify(value));
                            } else {
                                form_data.append(key, value);
                            }
                        });
                        
                        window.axios.post('/form-regis?form=register', form_data)
                            .then((response) => {
                                loader.hide();
                                this.close();
                                
                                this.$swal({
                                    title: "Register",
                                    text: response.data,
                                    icon: response.status === 201 ? 'success' : 'error',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    showCloseButton: false,
                                    showCancelButton: true,
                                    confirmButtonText: '<i class="bi bi-printer-fill"></i> Print',
                                    cancelButtonText: '<i class="bi bi-x-circle-fill"></i> Cancel'
                                }).then((result) => {
                                    if(result.value) {
                                        window.open('/agreement-letter?uuid='+ response.uuid + "_blank");
                                    }
                                });
                            })
                            .catch((e) => {
                                loader.hide();
                                this.submitted = false;

                                if(e.response.status === 422) {
                                    this.$refs.form.setErrors(e.response.data.errors);
                                }
                            });
                    } else {
                        this.submitted = false;
                    }
                });
            }
        },

        close() {
            this.__clearForm();
        }
    },

    computed: {
        kategoriView() {
            if(this.keyword && this.keyword != '') {
                return this.option.fkategori.filter((row) => {
                    return row.id.toLowerCase().includes(this.keyword.toLowerCase()) || row.name.toLowerCase().includes(this.keyword.toLowerCase())
                });
            }
            return this.option.fkategori;
        },
    },
}
</script>
