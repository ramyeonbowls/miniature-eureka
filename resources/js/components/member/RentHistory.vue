<template>
    <section class="section">
        <div class="card overflow-auto">
            <div class="card-header text-center">
                <h2>Riwayat Peminjaman</h2>
            </div>
            <div class="card-body">
                <table class="table table-striped responsive-table" id="data_rst">
                    <thead>
                        <tr>
                            <th>Judul Buku</th>
                            <th>Cover</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                </table>
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
                        <i class="bi bi-x-lg text-black"></i>
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

let table;
export default {
    props: {
        isAuthenticated: {
            type: Boolean,
            required: true
        }
    },

    mounted() {
        let self = this

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
            order: [[0, "asc"]],
            ajax: "/RentHistory",
            columns: [
                { data: "title" },
                {
                    data: "cover",
                    render: function(data, type, row) {
                        return '<img src="/storage/covers/' + data + '" class="cover" data-large="/storage/covers/' + data + '" alt="Image" style="width: 50px; cursor: pointer;" />';
                    }
                },
                { data: "start_date" },
                { data: "end_date" },
                { 
                    data: "flag_end",
                    render: function(data, type, row) {
                        if (data === 'Y') {
                            return '<span class="badge bg-success">Sudah Dikembalikan</span>';
                        } else {
                            return '<button class="btn btn-warning" data-book-id="'+row.book_id+'">Kembalikan</button>';
                        }
                    }
                }
            ],
            language: {
                lengthMenu: "_MENU_",
                search: "_INPUT_",
                searchPlaceholder: "Pencarian..",
                info: '<span class="fs-sm">Menampilkan _START_ sampai _END_ of _TOTAL_ entri</span>',
                infoEmpty: '<span class="fs-sm">Menampilkan 0 sampai 0 of 0 entri</span>',
                infoFiltered: '<span class="fs-sm">(disaring dari _MAX_ total entri)</span>',
                zeroRecords: '<span class="fs-sm">Tidak Ada Data</span>',
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

        window.$('#data_rst tbody').on('click', '.btn-warning', function () {
            var bookId = $(this).data('book-id');

            self.kembaliBuku(bookId);
        });
    },

    methods: {
        kembaliBuku(bookId){
            let loader = this.$loading.show();
            window.axios.post('/ReturnBook', {
                pdfToken: bookId
            })
            .then((response) => {
                loader.hide();
                this.$swal({
                    text: response.data.message,
                    icon: response.data.code == 1 ? 'success' : 'error',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showCloseButton: false,
                    showCancelButton: false
                }).then((result) => {
                    table.ajax.reload(null, false)
                });
            })
            .catch((e) => {
                loader.hide();
                this.$swal({
                    text: 'Terjadi kesalahan saat pinjam buku, silahkan coba kembali',
                    icon: 'error',
                    showCancelButton: false
                })
                
            });
        }
    },

    beforeRouteLeave (to, from, next) {
        if (table) {
            table.destroy();
            table = null;
        }
        $('#data_rst tbody').off('click', '.cover');
        $('#data_rst tbody').off('click', '.btn-warning');
        next();
    }
}
</script>
