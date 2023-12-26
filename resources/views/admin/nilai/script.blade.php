<script>
    $(document).ready(function() {
        var isAdmin = {{ $isAdmin ? 'true' : 'false' }};
        $('#myTable thead tr')
            .clone(true)
            .addClass('filters')
            .appendTo('#myTable thead');
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
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    },
                },
                {
                    extend: 'csv',
                    className: 'btn btn-outline-success',
                    text: '<i class="fas fa-file-csv"></i>',
                    titleAttr: 'Download CSV',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    },
                },
                {
                    extend: 'excel',
                    className: 'btn btn-outline-success',
                    text: '<i class="far fa-file-excel"></i>',
                    titleAttr: 'Download Excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    },
                },
                {
                    extend: 'pdf',
                    className: 'btn btn-outline-danger',
                    text: '<i class="far fa-file-pdf"></i>',
                    titleAttr: 'Download PDF',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    },
                },
                {
                    extend: 'print',
                    className: 'btn btn-outline-info',
                    text: '<i class="fas fa-print"></i>',
                    titleAttr: 'Print Data',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
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
                        var totalNilai = parseInt($('#totalNilai').data('total'));
                        console.log(totalNilai);

                        if (totalNilai > 0) {
                        // Tambahkan kondisi JavaScript berdasarkan nilai total_prestasi
                            Swal.fire({
                                title: 'Apa kamu yakin?',
                                text: 'Data yang sudah dihapus tidak bisa dikembalikan!',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: 'Ya, Hapus Semua!',
                                cancelButtonText: 'Batal'
                            }).then((result) => {
                                // Jika pengguna mengkonfirmasi
                                if (result.isConfirmed) {
                                    // Kirim permintaan AJAX ke backend untuk menghapus data
                                    $.ajax({
                                        url: "/delete-all-nilai", // Ganti dengan URL backend Anda
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
            ],
            initComplete: function() {
                var api = this.api();
                // For each column
                api
                    .columns()
                    .eq(0)
                    .each(function(colIdx) {
                        // Set the header cell to contain the input element
                        var cell = $('.filters th').eq(
                            $(api.column(colIdx).header()).index()
                        );
                        var title = $(cell).text();
                        // Tambahkan kondisi untuk mengecek apakah kolom No
                        if (colIdx === 0 || colIdx === 7 || colIdx === 5 || colIdx === 6) {
                            // Jika kolom No, tidak tambahkan input filter
                            $(cell).html('');
                        } else {
                            // Jika bukan kolom No, tambahkan input filter seperti biasa
                            $(cell).html(
                                '<input type="text" class="form-control" placeholder="' +
                                title + '" />');
                        }
                        // On every keypress in this input
                        $(
                                'input',
                                $('.filters th').eq($(api.column(colIdx).header()).index())
                            )
                            .off('keyup change')
                            .on('change', function(e) {
                                // Get the search value
                                $(this).attr('title', $(this).val());
                                var regexr =
                                    '({search})'; //$(this).parents('th').find('select').val();

                                cursorPosition = this.selectionStart;
                                // Search the column for that value
                                api
                                    .column(colIdx)
                                    .search(
                                        this.value != '' ?
                                        regexr.replace('{search}', '(((' + this.value +
                                            ')))') :
                                        '',
                                        this.value != '',
                                        this.value == ''
                                    )
                                    .draw();
                            })
                            .on('keyup', function(e) {
                                e.stopPropagation();

                                $(this).trigger('change');
                                $(this)
                                    .focus()[0]
                                    .setSelectionRange(cursorPosition, cursorPosition);
                            });
                    });
            },
            ajax: "{{ url('/qwe/nilaiAjax') }}",
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
                    data: 'user_id',
                    name: 'Users'
                },
                {
                    data: 'mata_pelajaran_id',
                    name: 'Mata Pelajaran',
                },
                {
                    data: 'kelas_id',
                    name: 'Kelas'
                },
                {
                    data: 'tahun_ajaran_id',
                    name: 'Tahun Ajaran',
                },
                {
                    data: 'nilai',
                    name: 'Nilai',
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
                    name: 'Action',
                    orderable: false,
                    searchable: false,
                    visible: isAdmin
                }
            ],
            columnDefs: [{
                targets: -1,
                visible: isAdmin
            }, ],
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
        // Hancurkan Choices.js sebelum inisialisasi jika sudah ada
        if (typeof userSelect !== 'undefined') {
            userSelect.destroy();
        }

        if (typeof kelasSelect !== 'undefined') {
            kelasSelect.destroy();
        }

        if (typeof matpelSelect !== 'undefined') {
            matpelSelect.destroy();
        }

        if (typeof tahunajaranSelect !== 'undefined') {
            tahunajaranSelect.destroy();
        }
        // Inisialisasi Choices.js
        userSelect = new Choices('#user_id', {
            searchEnabled: true,
            itemSelectText: '',
            allowHTML: true,
        });

        kelasSelect = new Choices('#kelas_id', {
            searchEnabled: true,
            itemSelectText: '',
            allowHTML: true,
        });

        matpelSelect = new Choices('#mata_pelajaran_id', {
            searchEnabled: true,
            itemSelectText: '',
            allowHTML: true,
        });

        tahunajaranSelect = new Choices('#tahun_ajaran_id', {
            searchEnabled: true,
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
        // Hancurkan Choices.js sebelum inisialisasi jika sudah ada
        if (typeof userSelect !== 'undefined') {
            userSelect.destroy();
        }

        if (typeof kelasSelect !== 'undefined') {
            kelasSelect.destroy();
        }

        if (typeof matpelSelect !== 'undefined') {
            matpelSelect.destroy();
        }

        if (typeof hariSelect !== 'undefined') {
            hariSelect.destroy();
        }

        if (typeof tahunajaranSelect !== 'undefined') {
            tahunajaranSelect.destroy();
        }

        $.ajax({
            url: 'nilai/' + id + '/edit',
            type: 'GET',
            success: function(response) {
                $('#exampleModal').modal('show');
                $('#user_id').val(response.result.user_id);
                $('#kelas_id').val(response.result.kelas_id);
                $('#mata_pelajaran_id').val(response.result.mata_pelajaran_id);
                $('#tahun_ajaran_id').val(response.result.tahun_ajaran_id);
                $('#nilai').val(response.result.nilai);
                console.log(response.result);
                $('.tombol-simpan').off('click').on('click', function() {
                    simpan(id);
                });

                // Inisialisasi Choices.js
                userSelect = new Choices('#user_id', {
                    searchEnabled: true,
                    itemSelectText: '',
                    allowHTML: true,
                });

                kelasSelect = new Choices('#kelas_id', {
                    searchEnabled: true,
                    itemSelectText: '',
                    allowHTML: true,
                });

                matpelSelect = new Choices('#mata_pelajaran_id', {
                    searchEnabled: true,
                    itemSelectText: '',
                    allowHTML: true,
                });

                tahunajaranSelect = new Choices('#tahun_ajaran_id', {
                    searchEnabled: true,
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

        Swal.fire({
            title: `Yakin mau hapus nilai dari <b>${name}</b>?`,
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
                    url: 'nilai/' + id,
                    type: 'DELETE',
                    success: function(response) {
                        $('#myTable').DataTable().ajax.reload();
                        Swal.fire('Sukses!', 'Berhasil hapus data nilai.', 'info');
                    },
                    error: function(response) {
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data nilai.',
                            'error');
                    }
                });
            }
        });
    });

    // Proses Delete All
    $("#deleteAllButton").on("click", function () {
    // Tampilkan SweetAlert untuk konfirmasi pengguna
    Swal.fire({
      title: "Apa kamu yakin?",
      text: "Data yang sudah dihapus tidak bisa dikembalikan!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Ya, Hapus Semua!",
      cancelButtonText: "Batal",
    }).then((result) => {
      // Jika pengguna mengkonfirmasi
      if (result.isConfirmed) {
        // Kirim permintaan AJAX ke backend untuk menghapus data
        $.ajax({
          url: "/delete-all-nilai", // Ganti dengan URL backend Anda
          method: "DELETE", // Sesuaikan dengan metode yang digunakan di backend
          success: function (response) {
            // Jika penghapusan dari database berhasil
            if (response.success) {
              // Hapus semua data dari DataTables
              $('#myTable').DataTable().ajax.reload();
              Swal.fire("Deleted!", "Your data has been deleted.", "success");
            } else {
              Swal.fire(
                "Error!",
                "Failed to delete data from database.",
                "error"
              );
            }
          },
          error: function (error) {
            console.error("Error deleting data:", error);
            Swal.fire(
              "Error!",
              "Failed to delete data from database.",
              "error"
            );
          },
        });
      }
    });
  });

    // fungsi simpan dan update
    function simpan(id = '') {
        let var_url, var_type, successMessage;

        if (id === '') {
            var_url = 'nilai';
            var_type = 'POST';
            successMessage = 'Berhasil tambah nilai.';
        } else {
            var_url = 'nilai/' + id;
            var_type = 'PUT';
            successMessage = 'Berhasil update nilai.';
        }

        $.ajax({
            url: var_url,
            type: var_type,
            data: {
                user_id: $('#user_id').val(),
                kelas_id: $('#kelas_id').val(),
                mata_pelajaran_id: $('#mata_pelajaran_id').val(),
                tahun_ajaran_id: $('#tahun_ajaran_id').val(),
                nilai: $('#nilai').val(),
            },
            success: function(response) {
                if (response.errors) {
                    console.log(response.errors);
                    console.log('user_id:', $('#user_id').val());
                    console.log('kelas_id:', $('#kelas_id').val());
                    console.log('mata_pelajaran_id:', $('#mata_pelajaran_id').val());
                    console.log('tahun_ajaran_id:', $('#tahun_ajaran_id').val());
                    console.log('nilai:', $('#nilai').val());
                    $('.alert-danger').removeClass('d-none');
                    $('.alert-danger').html("<ul>");
                    $.each(response.errors, function(key, value) {
                        $('.alert-danger').find('ul').append("<li>" + value + "</li>");
                    });
                    $('.alert-danger').append("</ul>");
                } else {
                    $('.alert-success').removeClass('d-none');
                    $('.alert-success').html(response.success);
                    console.log(response.result);
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
