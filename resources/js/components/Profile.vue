<template>
    <action-bar :data="menu" :menu-label="menu.menu_label"></action-bar>

    <section class="section">
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center flex-column">
                            <div class="avatar avatar-2xl">
                                <img src="./../assets/static/images/faces/2.jpg" alt="Avatar" />
                            </div>

                            <h3 class="mt-3">{{ user.name }}</h3>
                            <p class="text-small">{{ user.email }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="#" method="get">
                            <div class="form-group">
                                <label for="name" class="form-label">Nama Aplikasi</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Nama Aplikasi" value="Perpustakan Digital" />
                            </div>
                            <div class="form-group">
                                <label for="name" class="form-label">Alamat</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Alamat" value="Jakarta" />
                            </div>
                            <div class="form-group">
                                <label for="name" class="form-label">Kabupaten/Kota</label>
                                <select name="name" id="name" class="choices form-select">
                                    <option value="square">Jakarta Pusat</option>
                                    <option value="rectangle">Jakarta Utara</option>
                                    <option value="rombo">Jakarta Selatan</option>
                                    <option value="romboid">Jakarta Timur</option>
                                    <option value="trapeze">Jakarta Barat Daya</option>
                                    <option value="traible">Jakarta Timur ke Barat</option>
                                    <option value="polygon">Jakarta Selatan ke Utara</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="phone" class="form-label">NPWP</label>
                                <input type="text" name="phone" id="phone" class="form-control" placeholder="NPWP" value="123xxxxxxxxx" />
                            </div>
                            <div class="form-group">
                                <label for="phone" class="form-label">Nama Penanggung Jawab <small class="text-danger">*</small></label>
                                <input type="text" name="phone" id="phone" class="form-control" placeholder="Nama Penanggung Jawab" value="" />
                            </div>
                            <div class="form-group">
                                <label for="phone" class="form-label">Jabatan Penanggung Jawab <small class="text-danger">*</small></label>
                                <input type="text" name="phone" id="phone" class="form-control" placeholder="Jabatan Penanggung Jawab" value="" />
                            </div>
                            <div class="form-group">
                                <label for="email" class="form-label">E-Mail Pengelola (Admin) </label>
                                <input type="text" name="email" id="email" class="form-control" placeholder="Your Email" value="perpus.digital@example.net" />
                            </div>
                            <div class="form-group">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" name="phone" id="phone" class="form-control" placeholder="Your Phone" value="083xxxxxxxxx" />
                            </div>
                            <div class="form-group">
                                <label for="birthday" class="form-label">Birthday</label>
                                <input type="date" name="birthday" id="birthday" class="form-control" placeholder="Your Birthday" />
                            </div>
                            <div class="form-group">
                                <label for="gender" class="form-label">Gender</label>
                                <select name="gender" id="gender" class="form-control">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { Form as VeeForm, Field, ErrorMessage } from 'vee-validate'
import Choices from 'choices.js'
import 'choices.js/public/assets/styles/choices.min.css'

export default {
    components: {
        VeeForm,
        Field,
        ErrorMessage,
    },

    data() {
        return {
            menu: {
                menu_label: 'Profile',
                menu_desc: 'Profile Admin',
                permission: {
                    create: false,
                    read: false,
                    update: false,
                    delete: false,
                    print: false,
                    approve: false,
                },
            },

            user: {},
        }
    },

    mounted() {
        this.__MENU()
        this.userinfo()

        let choices = document.querySelectorAll('.choices')
        let initChoice
        for (let i = 0; i < choices.length; i++) {
            if (choices[i].classList.contains('multiple-remove')) {
                initChoice = new Choices(choices[i], {
                    delimiter: ',',
                    editItems: true,
                    maxItemCount: -1,
                    removeItemButton: true,
                })
            } else {
                initChoice = new Choices(choices[i])
            }
        }
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

        userinfo() {
            this.user = {}

            window.axios
                .get('/userinfo')
                .then((response) => {
                    this.user = response.data
                })
                .catch((e) => {
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
