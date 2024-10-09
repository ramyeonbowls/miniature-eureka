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
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="data_rst">
                        <thead>
                            <tr>
                                <th>Cover</th>
                                <th>Judul</th>
                                <th>ISBN</th>
                                <th>EISBN</th>
                                <th>Thn. Terbit</th>
                                <th>Penulis</th>
                                <th>Penerbit</th>
                                <th>Kategori Buku</th>
                                <th>Copy</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal for Image Preview -->
    <div class="modal fade text-left" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="imageModalLabel">Preview</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid" alt="Preview" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <span class="bx bx-x d-block d-sm-none">X</span>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for Image Preview -->
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

        table = $('#data_rst').DataTable({
            paging: true,
            pagingType: 'full_numbers',
            lengthMenu: [[10, 25, 50, 100, 500], [10, 25, 50, 100, 500]],
            pageLength: 10,
            processing: true,
            serverSide: true,
            deferRender: true,
            stateSave: true,
            select: true,
            order: [[0, "asc"]],
            ajax: "/report/book-rpt",
            columns: [
                {
                    data: "cover",
                    render: function(data, type, row) {
                        return '<img src="/storage/images/cover/' + data + '" class="cover" data-large="/storage/images/cover/' + data + '" alt="Image" style="width: 50px; cursor: pointer;" />';
                    }
                },
                { data: "title" },
                { data: "isbn" },
                { data: "eisbn" },
                { data: "year" },
                { data: "writer" },
                { data: "publisher" },
                { data: "category" },
                { data: "qty" }
            ],
            language: {
                lengthMenu: "_MENU_",
                search: "_INPUT_",
                searchPlaceholder: "Search..",
                info: '<span class="fs-sm">Showing _START_ to _END_ of _TOTAL_ entries</span>',
                infoEmpty: '<span class="fs-sm">Showing 0 to 0 of 0 entries</span>',
                infoFiltered: '<span class="fs-sm">(filtered from _MENU_ total entries)</span>',
                zeroRecords: '<span class="fs-sm">No Data</span>',
                paginate: {
                    first: '<i class="bi bi-chevron-double-left"></i>',
                    previous: '<i class="bi bi-chevron-left"></i>',
                    next: '<i class="bi bi-chevron-right"></i>',
                    last: '<i class="bi bi-chevron-double-right"></i>'
                }
            }
        });

        window.$('#data_rst tbody').on('click', '.cover', function () {
            // Get the large image URL from data attribute
            var largeImageUrl = $(this).data('large');
            
            // Set the large image URL in the modal
            $('#modalImage').attr('src', largeImageUrl);
            
            // Show the modal
            new bootstrap.Modal(document.getElementById('imageModal')).show()
        });
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

    beforeRouteLeave (to, from, next) {
        if (table) {
            table.destroy();
            table = null;
        }

        next();
    }
}
</script>
