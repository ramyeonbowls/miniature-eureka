<template>
    <action-bar :data="menu" :menu-label="menu.menu_label"></action-bar>

    <section class="section">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Horizontal Navs</h5>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Data</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Form</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <p class="my-2">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ut nulla neque. Ut hendrerit nulla a euismod pretium. Fusce venenatis sagittis ex efficitur suscipit. In tempor mattis fringilla. Sed id tincidunt orci, et volutpat ligula. Aliquam sollicitudin
                                    sagittis ex, a rhoncus nisl feugiat quis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ultricies ligula a tempor vulputate. Suspendisse pretium mollis ultrices.
                                </p>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                Integer interdum diam eleifend metus lacinia, quis gravida eros mollis. Fusce non sapien sit amet magna dapibus ultrices. Morbi tincidunt magna ex, eget faucibus sapien bibendum non. Duis a mauris ex. Ut finibus risus sed massa mattis porta. Aliquam sagittis massa et
                                purus efficitur ultricies. Integer pretium dolor at sapien laoreet ultricies. Fusce congue et lorem id convallis. Nulla volutpat tellus nec molestie finibus. In nec odio tincidunt eros finibus ullamcorper. Ut sodales, dui nec posuere finibus, nisl sem aliquam metus,
                                eu accumsan lacus felis at odio. Sed lacus quam, convallis quis condimentum ut, accumsan congue massa. Pellentesque et quam vel massa pretium ullamcorper vitae eu tortor.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
