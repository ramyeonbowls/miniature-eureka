<template>
    <action-bar :data="menu" :menu-label="menu.menu_label"></action-bar>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="buttons">
					<div class="buttons">
						<a href="#" class="btn icon icon-left btn-primary" @click="openDetail"><i class="bi bi-search"></i> Detail</a>
						<a href="#" class="btn icon icon-left btn-success" @click="openXLS"><i class="bi bi-file-earmark-excel-fill"></i> Export</a>
					</div>
                </div>
            </div>
            <div class="card-body">
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
    </section>

	<!-- Modal for Detail -->
	<div class="modal fade text-left" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="detailModalLabel">Detail PO - {{ po_number }}</h4>
					<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
						<i class="bi bi-x-lg text-black"></i>
					</button>
				</div>
				<div class="modal-body text-center">
					<table class="table table-striped" id="data_detail">
						<thead>
							<tr>
								<th class="text-center">Cover</th>
								<th class="text-center">Judul Buku</th>
								<th class="text-center">Penulis</th>
								<th class="text-center">Penerbit</th>
								<th class="text-center">Qty</th>
								<th class="text-center">Harga Beli</th>
							</tr>
						</thead>
					</table>
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
	<!-- Modal for Detail -->

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

let table, table_detail
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
                dateFormat: 'Y-m-d',
                mode: 'range',
				onClose: (selectedDates, dateStr, instance) => {
                    if (selectedDates.length === 1) {
                        instance.clear()
                        this.filter.date = ''
                    }
                },
            },

			selected: [],
			po_number: '',
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
            pageLength: 10,
            processing: true,
            ajax: "/report/po-rpt",
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
		
		table_detail = $('#data_detail').DataTable({
            paging: true,
            pagingType: 'full_numbers',
            lengthMenu: [[10, 25, 50, 100, 500], [10, 25, 50, 100, 500]],
            pageLength: 10,
            processing: true,
            ajax: "/report/po-rpt-dtl?nodata=yes",
            columns: [
				{
                    data: "cover",
                    render: function(data, type, row) {
                        return '<img src="/storage/covers/' + data + '" class="cover" data-large="/storage/covers/' + data + '" alt="Cover" style="width: 50px; cursor: pointer;" />';
                    }
                },
                { data: "title", class: "text-center text-nowrap" },
                { data: "writer", class: "text-center text-nowrap" },
                { data: "publisher", class: "text-center text-nowrap" },
                { data: "qty", class: "text-right text-nowrap" },
                {
					data: "sellprice",
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

		window.$('#data_detail').on('click', '.cover', function () {
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

		openDetail() {
            if (this.selected.length > 0) {
                new bootstrap.Modal(document.getElementById('detailModal')).show()

				this.po_number = this.selected[0].po_number

				let url = "PO_NUMBER="+ this.selected[0].po_number
                    url += "&PO_DATE="+ this.selected[0].po_date
                    url += "&PO_TYPE="+ this.selected[0].po_type

                table_detail.ajax.url("/report/po-rpt-dtl?menufn="+ this.$route.name +"&"+ url ).load();
            } else {
                this.$swal({
                    toast: true,
                    icon: 'warning',
                    text: 'Tidak ada baris yang dipilih!'
                });
            }
        },

        openXLS(){
			let loader      = this.$loading.show()

			window.axios({
				url: '/report/po-xls',
				method: 'POST',
				responseType: 'blob'
			})
			.then((response) => {
				loader.hide()

				const url = window.URL.createObjectURL(new Blob([response.data]));
				const link = document.createElement('a');
				link.href = url;
				link.setAttribute('download', 'Laporan Pembelian.xlsx');
				document.body.appendChild(link);
				link.click();
			})
			.catch((e) => {
				console.error(e);
				loader.hide()
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

	beforeRouteLeave (to, from, next) {
        if (table) {
            table.destroy();
            table = null;
        }
		
		if (table_detail) {
            table_detail.destroy();
            table_detail = null;
        }

        next();
    }
}
</script>
