<template>
    <action-bar :data="menu" :menu-label="menu.menu_label"></action-bar>

    <section class="section">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="buttons">
                            <template v-if="!form.new && !form.edit">
                                <a href="#" class="btn icon icon-left btn-primary" @click="create"><i class="bi bi-folder-fill"></i> Tambah</a>
                                <a href="#" class="btn icon icon-left btn-success" @click="edit"><i class="bi bi-pen-fill"></i> Sunting</a>
                                <a href="#" class="btn icon icon-left btn-danger" @click="destroy"><i class="bi bi-trash-fill"></i> Hapus</a>
                            </template>
                            <template v-else>
                                <a href="#" class="btn icon icon-left btn-success" @click.prevent="submit"><i class="bi bi-cloud-arrow-up-fill"></i> Simpan</a>
                                <a href="#" class="btn icon icon-left btn-danger" @click="cancel"><i class="bi bi-arrow-left-square-fill"></i> Batal</a>
                            </template>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" :class="form.new || form.edit ? 'disabled' : 'active'" id="data-tab" data-bs-toggle="tab" href="javascript:void(0);" role="tab" aria-controls="data" aria-selected="true">Data</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" :class="!form.new && !form.edit ? 'disabled' : 'active'" id="form-tab" data-bs-toggle="tab" href="javascript:void(0);" role="tab" aria-controls="form" aria-selected="false">Form</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade" :class="!form.new && !form.edit ? 'show active' : ''" id="data" role="tabpanel" aria-labelledby="data-tab">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="data_rst">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Nama WL</th>
                                                <th class="text-center">Provinsi</th>
                                                <th class="text-center">Kab/Kota</th>
                                                <th class="text-center">Nomor PO</th>
                                                <th class="text-center">Jenis PO</th>
                                                <th class="text-center">Tanggal</th>
                                                <th class="text-center">Total</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" :class="form.new || form.edit ? 'show active' : ''" id="form" role="tabpanel" aria-labelledby="form-tab">
                                <section id="basic-horizontal-layouts">
                                    <div class="row match-height">
                                        <div class="col-md-8 col-12">
                                            <div class="card">
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <VeeForm ref="form" v-slot="{ handleSubmit }" as="div">
                                                            <form class="form form-horizontal" @submit.prevent="handleSubmit($event, submit)">
                                                                <div class="form-body">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-striped" id="data_po" width="100%">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th class="text-center">Judul Buku</th>
                                                                                    <th class="text-center">Harga</th>
                                                                                    <th class="text-center">Copy</th>
                                                                                    <th class="text-center">
                                                                                        <button type="button" class="btn btn-sm btn-primary py-0" @click="showBooks(keys)">
                                                                                            <i class="bi bi-plus-circle-fill fs-6 text-white"></i>
                                                                                        </button>
                                                                                    </th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr v-for="(book, key) in form.field.books" :key="key">
                                                                                    <td>
                                                                                        <Field type="text" :disabled="true" :id="'title'+key" v-model="book.title" class="form-control" :name="'title'+key" size="100"/>
                                                                                        <ErrorMessage :name="'title'+key" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                                                                    </td>
                                                                                    <td>
                                                                                        <Field type="text" :disabled="true" :id="'sellprice'+key" v-model="book.sellprice" class="form-control" :name="'sellprice'+key" />
                                                                                        <ErrorMessage :name="'sellprice'+key" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                                                                    </td>
                                                                                    <td>
                                                                                        <Field type="text" :id="'qty'+key" v-model="book.qty" class="form-control" :name="'qty'+key" />
                                                                                        <ErrorMessage :name="'qty'+key" class="invalid-feedback animated fadeIn mt-0 mb-1" style="display:block;" />
                                                                                    </td>
                                                                                    <td class="text-center">
                                                                                        <button type="button" class="btn btn-sm btn-danger py-0" @click="delBooks(book.book_id)">
                                                                                            <i class="bi-dash-circle-fill fs-6 text-white"></i>
                                                                                        </button>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </VeeForm>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal for Book List -->
    <div class="modal fade text-left" id="BooksModal" tabindex="-1" role="dialog" aria-labelledby="BooksModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="BooksModalLabel">Data Buku</h4>
					<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
						<i class="bi bi-x-lg text-black"></i>
					</button>
				</div>
				<div class="modal-body overflow-auto">
                    <div class="row mb-3 px-2">
                        <div class="col-md-4 ms-auto">
                            <input type="text" class="form-control" v-model="searchQuery" placeholder="Cari Buku...">
                        </div>
                        <table class="table table-striped" id="data_buku">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Judul Buku</th>
                                    <th class="text-center">Cover</th>
                                    <th class="text-center">Harga Jual</th>
                                    <th class="text-center">Penulis</th>
                                    <th class="text-center">Penerbit</th>
                                    <th class="text-center">Sinopsis</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(buku, i) in paginatedBooks" :key="i">
                                    <td class="text-left">
                                        <div class="custom-control custom-checkbox custom-control-lg">
                                            <!-- <input type="checkbox" class="custom-control-input" style="cursor: pointer;" :id="'buku_'+ i" :name="'buku_'+ i" :value="{ book_id: buku.book_id, title: buku.title, sellprice: buku.sellprice, qty: buku.qty ? buku.qty : 1 }" v-model="form.field.books"> -->
                                            <input type="checkbox" class="custom-control-input" style="cursor: pointer;" :id="'buku_'+ i" :name="'buku_'+ i" :value="buku.book_id+'|'+buku.title+'|'+buku.sellprice" v-model="selectedBooks">
                                        </div>
                                    </td>
                                    <td class="text-left">
                                        <label style="cursor:pointer;" :for="'buku_'+ i">{{ buku.title }}</label>
                                    </td>
                                    <td class="text-left">
                                        <img :src="'/storage/covers/' + buku.cover" class="cover thumbnail" :data-large="'/storage/covers/' + buku.cover" alt="Cover" style="width: 50px; cursor: pointer;" />
                                    </td>
                                    <td class="text-right">
                                        <label style="cursor:pointer;" :for="'buku_'+ i">{{ buku.sellprice }}</label>
                                    </td>
                                    <td class="text-left">
                                        <label style="cursor:pointer;" :for="'buku_'+ i">{{ buku.writer }}</label>
                                    </td>
                                    <td class="text-left">
                                        <label style="cursor:pointer;" :for="'buku_'+ i">{{ buku.publisher }}</label>
                                    </td>
                                    <td class="text-right">
                                        <label style="cursor:pointer;" :for="'buku_'+ i">{{ buku.sinopsis }}</label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="col-md-12">
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <!-- Tombol Previous -->
                                    <li class="page-item" :class="{ disabled: currentPage === 1 }">
                                        <a class="page-link" href="#" @click.prevent="changePage(currentPage - 1)">Sebelumnya</a>
                                    </li>

                                    <!-- Tombol halaman pertama (1) -->
                                    <li v-if="currentPage > 3" class="page-item">
                                        <a class="page-link" href="#" @click.prevent="changePage(1)">1</a>
                                    </li>

                                    <!-- Tombol titik-titik ("...") jika ada halaman yang terlewat sebelum halaman aktif -->
                                    <li v-if="currentPage > 4" class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>

                                    <!-- Halaman sekitar halaman aktif (misalnya 2 halaman sebelumnya dan 2 halaman setelahnya) -->
                                    <li v-for="page in visiblePages" :key="page" :class="{ active: currentPage === page }" class="page-item">
                                        <a class="page-link" href="#" @click.prevent="changePage(page)">{{ page }}</a>
                                    </li>

                                    <!-- Tombol titik-titik ("...") jika ada halaman yang terlewat setelah halaman aktif -->
                                    <li v-if="currentPage < totalPages - 3" class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>

                                    <!-- Tombol halaman terakhir -->
                                    <li v-if="currentPage < totalPages - 2" class="page-item">
                                        <a class="page-link" href="#" @click.prevent="changePage(totalPages)">{{ totalPages }}</a>
                                    </li>

                                    <!-- Tombol Next -->
                                    <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                                        <a class="page-link" href="#" @click.prevent="changePage(currentPage + 1)">Selanjutnya</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
				<div class="modal-footer">
                    <button type="button" class="btn btn-light-primary" @click="addCheckboxes" data-bs-dismiss="modal">
						<i class="bx bx-x d-block d-sm-none"></i>
						<span class="d-none d-sm-block">Tambahkan</span>
					</button>
                    <button type="button" class="btn btn-light-danger" @click="resetCheckboxes">
						<i class="bx bx-x d-block d-sm-none"></i>
						<span class="d-none d-sm-block">Hapus</span>
					</button>
				</div>
			</div>
        </div>
    </div>
    <!-- Modal for Book List -->

    <!-- Modal for Image Preview -->
    <div class="modal fade text-left" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="imageModalLabel">Preview</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg text-black"></i>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid" alt="Preview" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
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
            currentPage: 1,
            itemsPerPage: 25,
            searchQuery: '',
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

            selected: [],
            selectedBooks: [],
            form: {
                submitted: false,
                new: false,
                edit: false,
                field: {
                    books: [],
                }
            },
            option: {
                books: [],
            },
        }
    },

    mounted() {
        this.__MENU()
        this.$root.web_access_log()

        let _row = this
        table = $('#data_rst').DataTable({
            paging: true,
            pagingType: 'full_numbers',
            lengthMenu: [[10, 25, 50, 100, 500], [10, 25, 50, 100, 500]],
            pageLength: 25,
            processing: true,
            serverSide: true,
            deferRender: true,
            stateSave: true,
            select: true,
            rowId: 'extn',
            order: [[0, "asc"]],
            ajax: "/transaction/po-mst",
            columns: [
                { data: "wl_name", class: "text-center text-nowrap" },
                { data: "provinsi_name", class: "text-center text-nowrap" },
                { data: "kabupaten_name", class: "text-center text-nowrap" },
                { data: "po_number", class: "text-right text-nowrap" },
                { data: "po_type", class: "text-center text-nowrap" },
                { data: "po_date", class: "text-center text-nowrap" },
                {
					data: "po_amount",
					class: "text-right text-nowrap",
					render: function (data, type, row) {
						return type === 'display' ? $.fn.dataTable.render.number('.', ',', 2).display(data) : data;
					}
				}
            ],
            language: {
                lengthMenu: "_MENU_",
                search: "_INPUT_",
                searchPlaceholder: "Pencarian..",
                info: '<span class="fs-sm">Menampilkan _START_ sampai _END_ dari _TOTAL_ entri</span>',
                infoEmpty: '<span class="fs-sm">Menampilkan 0 sampai 0 dari 0 entri</span>',
                infoFiltered: '<span class="fs-sm">(disaring dari _MAX_ total entri)</span>',
                zeroRecords: '<span class="fs-sm">Tidak Ada Data</span>',
                paginate: {
                    first: '<i class="bi bi-chevron-double-left"></i>',
                    previous: '<i class="bi bi-chevron-left"></i>',
                    next: '<i class="bi bi-chevron-right"></i>',
                    last: '<i class="bi bi-chevron-double-right"></i>'
                }
            }
        })

        window.$('#data_rst tbody').on('click', 'tr', function () {
            _row.selected = [];

            if ( window.$(this).hasClass('selected') ) {
                window.$(this).removeClass('selected');
            } else {
                table.$('tr.selected').removeClass('selected');
                window.$(this).addClass('selected');

                if (table.rows('.selected').data().length > 0) {
                    _row.selected.push(table.rows('.selected').data()[0]);
                }
            }
        });

        window.$('#data_buku').on('click', '.cover', function () {
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

        addCheckboxes() {
            this.selectedBooks.forEach(book => {
                let [book_id, title, sellprice] = book.split('|')
                if (!this.form.field.books.some(b => b.book_id === book_id)) {
                    this.form.field.books.push({
                        book_id: book_id,
                        title: title,
                        sellprice: sellprice,
                        qty: 1
                    })
                }
            });
        },

        resetCheckboxes() {
            this.selectedBooks      = []
            this.form.field.books   = []
        },

        clearForm() {
            this.form.field.books   = []
            this.currentPage        = 1
            this.searchQuery        = ''
            this.resetCheckboxes()
        },

        create() {
            this.form.new = true
            this.form.edit = false

            this.clearForm()
        },

        edit() {
            if (this.selected.length > 0) {
                let loader = this.$loading.show();
                this.form.new = false
                this.form.edit = true
                this.submitted = false

                let code = this.selected[0].po_number+'|'+this.selected[0].po_date

                window.axios.get('/transaction/po-mst/'+ code +'?menufn='+ this.$route.name)
                .then((response) => {
                    loader.hide();
                    this.form.field.books = response.data.data;
                    this.selectedBooks = response.data.selectedbooks;
                })
                .catch((e) => {
                    loader.hide();
                    console.error(e);
                });

                this.form.field.id = code
            } else {
                this.$swal({
                    toast: true,
                    icon: 'warning',
                    text: 'Tidak ada baris yang dipilih!'
                });
            }
        },

        destroy() {
            if(this.selected.length > 0) {
                this.$swal({
                    icon: 'question',
                    text: 'Apakah anda yakin ingin menghapus data ini?',
                    showCancelButton: true,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    confirmButtonText: '<i class="bi bi-trash-fill"></i> Hapus',
                    cancelButtonText: '<i class="bi bi-x-square-fill"></i> Batal',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-sm btn-danger me-2',
                        cancelButton: 'btn btn-sm btn-secondary',
                    },
                }).then((result) => {
                    if (result.value) {
                        let loader = this.$loading.show();

                        let code = this.selected[0].po_number+'|'+this.selected[0].po_date

                        window.axios.delete('/transaction/po-mst/'+ code +'?menufn='+ this.$route.name)
                            .then(response => {
                                loader.hide();
                                this.selected = [];
                                table.ajax.reload();

                                this.$swal({
                                    toast: true,
                                    icon: 'success',
                                    html: response.data
                                });
                            })
                    }
                })
            } else {
                this.$swal({
                    toast: true,
                    icon: 'warning',
                    text: 'Tidak ada baris yang dipilih!'
                });
            }
        },

        submit() {
            if(this.form.field.books.length === 0) {
                this.$swal({
                    toast: true,
                    icon: 'warning',
                    text: 'Tidak ada buku yang dipilih!'
                });
                return;
            }

            if(!this.form.submitted) {
                this.form.submitted = true;

                this.$refs.form.validate().then(result => {
                    if(result.valid) {
                        this.form.submitted = false;

                        let loader = this.$loading.show();
                        if(this.form.new) {
                            let form_data = new FormData();
                            Object.keys(this.form.field).forEach(value => {
                                if (value === 'books') {
                                    this.form.field.books.forEach((book, index) => {
                                        Object.keys(book).forEach(bookKey => {
                                            form_data.append(`${value}[${index}][${bookKey}]`, book[bookKey]);
                                        });
                                    });
                                } else {
                                    form_data.append(value, this.form.field[value]);
                                }
                            });
                            
                            window.axios.post('/transaction/po-mst?menu_fn='+ this.$route.name, form_data)
                                .then((response) => {
                                    loader.hide();
                                    this.cancel();

                                    this.$swal({
                                        toast: true,
                                        position: 'top',
                                        icon: response.status === 201 ? 'success' : 'info',
                                        html: response.data
                                    });
                                })
                                .catch((e) => {
                                    loader.hide();
                                    this.form.submitted = false;

                                    if(e.response.status === 422) {
                                        this.$refs.form.setErrors(e.response.data.errors);
                                    }
                                });
                        } else {
                            let form_data = new FormData();
                            form_data.append('_method', 'PUT');
                            Object.keys(this.form.field).forEach(value => {
                                if (value === 'books') {
                                    this.form.field.books.forEach((book, index) => {
                                        Object.keys(book).forEach(bookKey => {
                                            form_data.append(`${value}[${index}][${bookKey}]`, book[bookKey]);
                                        });
                                    });
                                } else {
                                    form_data.append(value, this.form.field[value]);
                                }
                            });

                            let code = this.selected[0].po_number+'|'+this.selected[0].po_date

                            window.axios.post('/transaction/po-mst/'+ code +'?menu_fn='+ this.$route.name, form_data)
                                .then((response) => {
                                    loader.hide();
                                    this.cancel();

                                    this.$swal({
                                        toast: true,
                                        position: 'top',
                                        icon: response.status === 201 ? 'success' : 'info',
                                        html: response.data
                                    });
                                })
                                .catch((e) => {
                                    loader.hide();
                                    this.form.submitted = false;

                                    if(e.response.status === 422) {
                                        this.$refs.form.setErrors(e.response.data.errors);
                                    }
                                });
                        }
                    } else {
                        this.form.submitted = false;
                    }
                });
            }
        },

        cancel() {
            this.form.new = false
            this.form.edit = false
            this.form.submitted = false

            this.selected = []
            this.clearForm()
            this.$refs.form.resetForm()
            table.ajax.reload(null, false)
        },

        showBooks() {
            new bootstrap.Modal(document.getElementById('BooksModal')).show();
            let loader = this.$loading.show()
            window.axios.post('/getOpt', { 'opt': 'Books'})
            .then((response) => {
                loader.hide()
                this.option.books = response.data;
            })
            .catch((e) => {
                loader.hide()

                console.error(e);
            });
        },

        delBooks(id) {
            let data = JSON.parse(JSON.stringify(this.form.field.books))
            data = data.filter(book => book.book_id !== id);

            this.form.field.books = data;
        },

        changePage(page) {
            this.currentPage = page;
        }
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

        filteredBooks() {
            if (this.searchQuery) {
                return this.option.books.filter(book => 
                    book.title.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    book.publisher.toLowerCase().includes(this.searchQuery.toLowerCase())
                );
            }
            return this.option.books;
        },

        paginatedBooks() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.filteredBooks.slice(start, end);
        },

        totalPages() {
            return Math.ceil(this.filteredBooks.length / this.itemsPerPage);
        },

        visiblePages() {
            const range = 2;  // Menampilkan 2 halaman di sebelah kiri dan kanan halaman aktif
            let start = Math.max(1, this.currentPage - range);
            let end = Math.min(this.totalPages, this.currentPage + range);

            const pages = [];
            for (let i = start; i <= end; i++) {
                pages.push(i);
            }
            return pages;
        }
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