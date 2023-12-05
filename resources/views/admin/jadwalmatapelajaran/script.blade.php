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
                    className: 'btn btn-outline-secondary',
                    text: '<i class="fas fa-file-csv"></i>',
                    titleAttr: 'Download CSV',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    },
                },
                {
                    extend: 'excel',
                    className: 'btn btn-outline-secondary',
                    text: '<i class="far fa-file-excel"></i>',
                    titleAttr: 'Download Excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    },
                },
                {
                    extend: 'pdf',
                    className: 'btn btn-outline-secondary',
                    text: '<i class="far fa-file-pdf"></i>',
                    titleAttr: 'Download PDF',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    },
                },
                {
                    extend: 'print',
                    className: 'btn btn-outline-secondary',
                    text: '<i class="fas fa-print"></i>',
                    titleAttr: 'Print Data',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
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
                        if (colIdx === 0 || colIdx === 7) {
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
            ajax: "{{ url('/qwe/jadwalmatapelajaranAjax') }}",
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
                    data: 'kelas_id',
                    name: 'Kelas'
                },
                {
                    data: 'mata_pelajaran_id',
                    name: 'Mata Pelajaran',
                    render: function(data, type, row) {
                        if (type === 'display') {
                            return data ? data :
                                '<a style="color:#6c757d;">Data Mata Pelajaran tidak tersedia</a>';
                        }
                        return data;
                    }
                },
                {
                    data: 'hari',
                    name: 'Hari'
                },
                {
                    data: 'jam',
                    name: 'Jam'
                },
                {
                    data: 'tahun_ajaran_id',
                    name: 'Tahun Ajaran',
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
        if (typeof kelasSelect !== 'undefined') {
            kelasSelect.destroy();
        }

        // Hancurkan Choices.js sebelum inisialisasi jika sudah ada
        if (typeof matpelSelect !== 'undefined') {
            matpelSelect.destroy();
        }

        // Hancurkan Choices.js sebelum inisialisasi jika sudah ada
        if (typeof hariSelect !== 'undefined') {
            hariSelect.destroy();
        }

        // Hancurkan Choices.js sebelum inisialisasi jika sudah ada
        if (typeof tahunajaranSelect !== 'undefined') {
            tahunajaranSelect.destroy();
        }
        // Inisialisasi Choices.js
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

        hariSelect = new Choices('#hari', {
            searchEnabled: true,
            itemSelectText: '',
            shouldSort: false,
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
        if (typeof kelasSelect !== 'undefined') {
            kelasSelect.destroy();
        }

        // Hancurkan Choices.js sebelum inisialisasi jika sudah ada
        if (typeof matpelSelect !== 'undefined') {
            matpelSelect.destroy();
        }

        // Hancurkan Choices.js sebelum inisialisasi jika sudah ada
        if (typeof hariSelect !== 'undefined') {
            hariSelect.destroy();
        }

        // Hancurkan Choices.js sebelum inisialisasi jika sudah ada
        if (typeof tahunajaranSelect !== 'undefined') {
            tahunajaranSelect.destroy();
        }

        $.ajax({
            url: 'jadwalmatapelajaran/' + id + '/edit',
            type: 'GET',
            success: function(response) {
                $('#exampleModal').modal('show');
                $('#kelas_id').val(response.result.kelas_id);
                $('#mata_pelajaran_id').val(response.result.mata_pelajaran_id);
                $('#hari').val(response.result.hari);
                $('#jam').val(response.result.jam);
                $('#tahun_ajaran_id').val(response.result.tahun_ajaran_id);
                console.log(response.result);
                $('.tombol-simpan').off('click').on('click', function() {
                    simpan(id);
                });

                // Inisialisasi Choices.js
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

                hariSelect = new Choices('#hari', {
                    searchEnabled: true,
                    itemSelectText: '',
                    shouldSort: false,
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

        Swal.fire({
            title: 'Yakin mau hapus data ini?',
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
                    url: 'jadwalmatapelajaran/' + id,
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
            var_url = 'jadwalmatapelajaran';
            var_type = 'POST';
            successMessage = 'Berhasil tambah tahunajaran.';
        } else {
            var_url = 'jadwalmatapelajaran/' + id;
            var_type = 'PUT';
            successMessage = 'Berhasil update tahunajaran.';
        }

        $.ajax({
            url: var_url,
            type: var_type,
            data: {
                kelas_id: $('#kelas_id').val(),
                mata_pelajaran_id: $('#mata_pelajaran_id').val(),
                hari: $('#hari').val(),
                jam: $('#jam').val(),
                tahun_ajaran_id: $('#tahun_ajaran_id').val(),
            },
            success: function(response) {
                if (response.errors) {
                    console.log(response.errors);
                    console.log('kelas_id:', $('#kelas_id').val());
                    console.log('mata_pelajaran_id:', $('#mata_pelajaran_id').val());
                    console.log('hari:', $('#hari').val());
                    console.log('jam:', $('#jam').val());
                    console.log('tahun_ajaran_id:', $('#tahun_ajaran_id').val());
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
