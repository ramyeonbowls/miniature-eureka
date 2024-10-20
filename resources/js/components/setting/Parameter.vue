<template>
    <action-bar :data="menu" :menu-label="menu.menu_label"></action-bar>

    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Pengaturan Aplikasi</h5>
                    </div>
                    <div class="card-body">
                        <form class="form" @submit.prevent="handleUpdateParam">
                            <div class="row">
                                <div class="col-md-6 mb-4" v-for="(data, key) in parameters">
                                    <div class="form-group">
                                        <label for="name" class="form-label">{{ data.description }}</label>
                                        <template v-if="data.name=='reg_member'">
                                            <select class="form-control col-3" :name="data.name" :id="data.name" v-model="form.param[data.name]">
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </template>
                                        <template v-else-if="data.name=='app_reg_member'">
                                            <select class="form-control col-3" :name="data.name" :id="data.name" v-model="form.param[data.name]">
                                                <option value="1">Manual</option>
                                                <option value="0">Auto</option>
                                            </select>
                                        </template>
                                        <template v-else>
                                            <input type="number" :name="data.name" :id="data.name" class="form-control" :placeholder="data.description" v-model="form.param[data.name]"/>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="form-group my-2 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>

export default {

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

            parameters: [],
            user: {},
            form: {
                param: {},
            },
            errors: {}
        }
    },

    mounted() {
        this.__MENU()
        this.getParameter()
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

        getParameter() {
            this.user = {}

            window.axios.get('/setting/appparam')
            .then((response) => {
                this.parameters = response.data

                Object.keys(this.parameters).forEach((key) => {
                    const val = this.parameters[key];
                    this.form.param[val.name] = val.value;
                });
            })
            .catch((e) => {
                console.error(e)
            })
        },

        async handleUpdateParam() {
            let loader = this.$loading.show()

            let form_data = new FormData()
            Object.keys(this.form.param).forEach(value => {
                form_data.append(value, this.form.param[value])
            })

            console.log(form_data);
            
            await axios.post('/setting/appparam', form_data)
            .then((response) => {
                loader.hide();
                this.$swal({
                    title: "Update Pengaturan",
                    text: response.data,
                    icon: response.status === 201 ? 'success' : 'error',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showCloseButton: false,
                    showCancelButton: false
                }).then((result) => {
                    location.reload(); 
                });
            })
            .catch(error => {
                loader.hide();
                console.error(error)

                this.$swal({
                    icon: 'error',
                    title: 'Kesalahan',
                    text: 'Terjadi kesalahan, silakan coba lagi nanti.',
                })
            });
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