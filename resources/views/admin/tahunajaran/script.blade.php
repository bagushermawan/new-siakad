<script>
    $(document).ready(function() {
        var isAdmin = {{ $isAdmin ? 'true' : 'false' }};
        $('#myTable thead tr')
            // .clone(true)
            // .addClass('filters')
            // .appendTo('#myTable thead');
        var myTable = $('#myTable').DataTable({
            orderCellsTop: true,
            processing: true,
            serverside: true,
            dom: 'Bfrtipl',
            buttons: [{
                    extend: 'copy',
                    className: 'btn btn-outline-secondary',
                    text: '<i class="fas fa-copy"></i> Copy to clipboard',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    },
                },
                {
                    extend: 'csv',
                    className: 'btn btn-outline-success',
                    text: '<i class="fas fa-file-csv"></i>',
                    titleAttr: 'Download CSV',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    },
                },
                {
                    extend: 'excel',
                    className: 'btn btn-outline-success',
                    text: '<i class="far fa-file-excel"></i>',
                    titleAttr: 'Download Excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    },
                },
                {
                    extend: 'pdf',
                    className: 'btn btn-outline-danger',
                    text: '<i class="far fa-file-pdf"></i>',
                    titleAttr: 'Download PDF',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    },
                },
                {
                    extend: 'print',
                    className: 'btn btn-outline-info',
                    text: '<i class="fas fa-print"></i>',
                    titleAttr: 'Print Data',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    },
                },
                {
                    className: 'btn btn-outline-secondary',
                    text: '<i class="fas fa-sync-alt"></i>',
                    titleAttr: 'Reload Data',
                    action: function(e, dt, node, config) {
                        dt.ajax.reload();
                    }
                },
                {
                    className: 'btn btn-outline-danger',
                    text: '<i class="fas fa-trash"></i>',
                    titleAttr: 'Delete All',
                    action: function(e, dt, node, config) {
                        // Dapatkan nilai total_prestasi dari elemen HTML
                        var totalTahunajaran = parseInt($('#totalTahunajaran').data('total'));
                        console.log(totalTahunajaran);

                        if (totalTahunajaran > 0) {
                            // Tambahkan kondisi JavaScript berdasarkan nilai total_prestasi
                            Swal.fire({
                                title: 'Apa kamu yakin?',
                                text: 'Data yang sudah dihapus tidak bisa dikembalikan!',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: 'Ya, Hapus!',
                                cancelButtonText: 'Batal'
                            }).then((result) => {
                                // Jika pengguna mengkonfirmasi
                                if (result.isConfirmed) {
                                    // Kirim permintaan AJAX ke backend untuk menghapus data
                                    $.ajax({
                                        url: "/delete-all-tahunajaran", // Ganti dengan URL backend Anda
                                        method: "DELETE", // Sesuaikan dengan metode yang digunakan di backend
                                        success: function(response) {
                                            // Jika penghapusan dari database berhasil
                                            if (response.success) {
                                                // Hapus semua data dari DataTables
                                                $('#myTable').DataTable()
                                                    .ajax.reload();
                                                Swal.fire("Deleted!",
                                                    "Your data has been deleted.",
                                                    "success");
                                            } else {
                                                Swal.fire(
                                                    "Error!",
                                                    "Failed to delete data from database.",
                                                    "error"
                                                );
                                            }
                                        },
                                        error: function(error) {
                                            console.error(
                                                "Error deleting data:",
                                                error);
                                            Swal.fire(
                                                "Error!",
                                                "Failed to delete data from database.",
                                                "error"
                                            );
                                        },
                                    });
                                }
                            });
                        } else {
                            // Tampilkan pesan jika tidak ada data untuk dihapus
                            Swal.fire("Info", "Tidak ada data untuk dihapus.", "info");
                        }
                    },
                },
                {
                    className: 'btn btn-outline-success',
                    text: '<i class="fas fa-file-import"></i> Import Excel',
                    titleAttr: 'Import Data',
                    action: function(e, dt, node, config) {
                        Swal.fire({
                            html: `
                                    <input type="file" id="excel_file" class="swal2-file" accept=".xlsx, .xls, .csv">
                                    <br><br><br>
                                    <div class="accordion" id="accordionExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                    Contoh struktur kolom excell import kelas
                                                </button>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                                data-bs-parent="#accordionExample" style="">
                                                <div class="accordion-body">
                                                    <img src="/storage/kelas.png">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     `,
                            showCancelButton: true,
                            confirmButtonText: 'Import',
                            cancelButtonText: 'Batal',
                            footer: 'Download file sample excell <a href="/storage/kelas_import_sample.xlsx" download>disini</a>.',
                            backdrop: `
                                        rgba(60, 60, 60,0.3)
                                        //url("/storage/faw.png")
                                        top center
                                        no-repeat
                                      `,
                            showClass: {
                                popup: `animate__fadeInDown animate__animated animate__faster`
                            },
                            hideClass: {
                                popup: `animate__animated animate__fadeOutDown animate__faster`
                            },
                            preConfirm: () => {
                                const excelFile = document.getElementById(
                                    'excel_file').files[0];
                                if (!excelFile) {
                                    Swal.showValidationMessage(
                                        'Silahkan upload file terlebih dahulu');
                                }
                                return {
                                    excelFile: excelFile
                                };
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Handle import here, you can use AJAX to send the file
                                const formData = new FormData();
                                formData.append('excel_file', result.value.excelFile);

                                $.ajax({
                                    url: '{{ route('import.kelas') }}',
                                    method: 'POST',
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(response) {
                                        $('#myTable').DataTable().ajax
                                            .reload();
                                        Swal.fire('Sukses!',
                                            'Berhasil import data kelas.',
                                            'success');
                                    },
                                    error: function(error) {
                                        Swal.fire('Gagal!',
                                            'Gagal import data kelas.',
                                            'error');
                                    }
                                });
                            }
                        });
                    }
                },
            ],
            ajax: "{{ url('/qwe/tahunajaranAjax') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        if (type === 'display') {
                            return '<center>' + (meta.row + 1) + '</center>';
                        }
                        return meta.row + 1;
                    }
                },
                {
                    data: 'name',
                    name: 'Tahun'
                },
                {
                    data: 'semester',
                    name: 'Semester'
                },
                {
                    data: 'mulai',
                    render: function(data, type, full, meta) {
                        // Format tanggal menggunakan moment.js
                        return moment(data).format('DD MMMM YYYY');
                    }
                },
                {
                    data: 'selesai',
                    render: function(data, type, full, meta) {
                        // Format tanggal menggunakan moment.js
                        return moment(data).format('DD MMMM YYYY');
                    }
                },
                {
                    data: 'status',
                    name: 'Status',
                    render: function(data, type, row) {
                        return data.charAt(0).toUpperCase() + data.slice(1);
                    }
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    render: function(data, type, row) {
                        // Mengubah format tanggal dan waktu
                        var date = new Date(data);
                        var formattedDate = date
                            .toLocaleString(); // Sesuaikan format sesuai kebutuhan

                        return formattedDate;
                    }
                },
                {
                    data: 'aksi',
                    name: 'Aksi',
                    visible: isAdmin
                }
            ],
            columnDefs: [{
                targets: -1,
                visible: isAdmin
            }, ]
        });
        // Fungsi untuk memberi warna pada pagination
        const setTableColor = () => {
            document.querySelectorAll('.dataTables_paginate .pagination').forEach(dt => {
                dt.classList.add('pagination-primary')
            })
        }
        // Memanggil fungsi setTableColor pada awal dan setiap kali DataTable digambar ulang
        setTableColor();
        myTable.on('draw', setTableColor);


    });


    // GLOBAL SETUP
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // 02_PROSES SIMPAN
    $('body').on('click', '.tombol-tambah', function(e) {
        e.preventDefault();
        $('#exampleModal').modal('show');
        if (typeof semesterSelect !== 'undefined') {
            semesterSelect.destroy();
        }
        semesterSelect = new Choices('#semester', {
            searchEnabled: false,
            itemSelectText: '',
            allowHTML: true,
        });
        if (typeof statusSelect !== 'undefined') {
            statusSelect.destroy();
        }
        statusSelect = new Choices('#status', {
            searchEnabled: false,
            itemSelectText: '',
            allowHTML: true,
        });
        $('.tombol-simpan').off('click').on('click', function() {
            simpan();
        });
    });

    // 03_PROSES EDIT
    $('body').on('click', '.tombol-edit', function(e) {
        var id = $(this).data('id');
        $.ajax({
            url: 'tahunajaranAjax/' + id + '/edit',
            type: 'GET',
            success: function(response) {
                $('#exampleModal').modal('show');
                $('#name').val(response.result.name);
                // Hapus objek Choices.js sebelum membuat yang baru
                if (typeof semesterSelect !== 'undefined') {
                    semesterSelect.destroy();
                }
                $('#semester').val(response.result.semester);

                // Set nilai kolom "mulai" dan "selesai" ke elemen #daterange
                var dateRangeValue = response.result.mulai + ' to ' + response.result.selesai;
                $('#daterange').val(dateRangeValue);

                if (typeof statusSelect !== 'undefined') {
                    statusSelect.destroy();
                }
                $('#status').val(response.result.status);

                console.log(dateRangeValue);
                console.log(response.result);
                $('.tombol-simpan').off('click').on('click', function() {
                    simpan(id);
                });

                // Inisialisasi objek Choices.js baru
                semesterSelect = new Choices('#semester', {
                    searchEnabled: false,
                    itemSelectText: '',
                    allowHTML: true,
                });
                statusSelect = new Choices('#status', {
                    searchEnabled: false,
                    itemSelectText: '',
                    allowHTML: true,
                });
            }
        });
    });


    // 04_PROSES Delete
    $('body').on('click', '.tombol-del', function(e) {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var semester = $(this).data('semester');

        Swal.fire({
            title: `Yakin mau hapus <b>${name} - ${semester}</b>?`,
            text: "Anda tidak akan dapat mengembalikan data ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika pengguna menekan tombol "Hapus", kirim permintaan DELETE
                $.ajax({
                    url: 'tahunajaranAjax/' + id,
                    type: 'DELETE',
                    success: function(response) {
                        $('#myTable').DataTable().ajax.reload();
                        Swal.fire('Sukses!', 'Berhasil hapus prestasi.', 'info');
                    },
                    error: function(response) {
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus prestasi.',
                            'error');
                    }
                });
            }
        });
    });

    // fungsi simpan dan update
    function simpan(id = '') {
        let var_url, var_type, successMessage;

        if (id === '') {
            var_url = 'tahunajaranAjax';
            var_type = 'POST';
            successMessage = 'Berhasil tambah tahunajaran.';
        } else {
            var_url = 'tahunajaranAjax/' + id;
            var_type = 'PUT';
            successMessage = 'Berhasil update tahunajaran.';
        }

        $.ajax({
            url: var_url,
            type: var_type,
            data: {
                name: $('#name').val(),
                semester: $('#semester').val(),
                dateRange: $('#dateRange').val(),
                status: $('#status').val(),
            },
            success: function(response) {
                if (response.errors) {
                    console.log(response.errors);
                    console.log('tahun ajaran:', $('#name').val());
                    console.log('semester:', $('#semester').val());
                    console.log('dateRange:', $('#dateRange').val());
                    console.log('status:', $('#status').val());
                    $('.alert-danger').removeClass('d-none');
                    $('.alert-danger').html("<ul>");
                    $.each(response.errors, function(key, value) {
                        $('.alert-danger').find('ul').append("<li>" + value + "</li>");
                    });
                    $('.alert-danger').append("</ul>");
                } else {
                    $('.alert-success').removeClass('d-none');
                    $('.alert-success').html(response.success);
                    console.log('tahun ajaran:', $('#name').val());
                    console.log('semester:', $('#semester').val());
                    console.log('dateRange:', $('#dateRange').val());
                    console.log('status:', $('#status').val());
                    Swal.fire('Sukses!', successMessage, 'success');
                    $('#myTable').DataTable().ajax.reload();
                }
            }
        });
    }

    $('#exampleModal').on('hidden.bs.modal', function() {
        $('#name').val('');
        $('#semester').val('');


        $('.alert-danger').addClass('d-none');
        $('.alert-danger').html('');

        $('.alert-success').addClass('d-none');
        $('.alert-success').html('');
    });
</script>
