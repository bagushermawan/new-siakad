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
                    className: 'btn btn-outline-success',
                    text: '<i class="fas fa-file-import"></i> Import Excel',
                    titleAttr: 'Reload Data',
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
                                                    Contoh struktur kolom excell import guru
                                                </button>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                                data-bs-parent="#accordionExample" style="">
                                                <div class="accordion-body">
                                                    <img src="/storage/guru.png">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     `,
                            showCancelButton: true,
                            confirmButtonText: 'Import',
                            cancelButtonText: 'Batal',
                            footer: 'Download file sample excell <a href="/storage/guru_import_sample.xlsx" download>disini</a>.',
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
                                    url: '{{ route('import.guru') }}',
                                    method: 'POST',
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(response) {
                                        $('#myTable').DataTable().ajax
                                            .reload();
                                        Swal.fire('Sukses!',
                                            'Berhasil import data guru.',
                                            'success');
                                    },
                                    error: function(error) {
                                        Swal.fire('Gagal!',
                                            'Gagal import data guru.',
                                            'error');
                                    }
                                });
                            }
                        });
                    }
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
                        if (colIdx === 0 || colIdx === 6 || colIdx === 7) {
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
            ajax: "{{ url('/qwe/guruAjax') }}",
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
                    data: 'nuptk',
                    name: 'nuptk',
                    render: function(data, type, row) {
                        if (type === 'display') {
                            return data ? data :
                                '<a style="color:#6c757d;">NUPTK tidak tersedia</a>';
                        }
                        return data;
                    }
                },
                {
                    data: 'name',
                    name: 'Nama'
                },
                {
                    data: 'username',
                    name: 'Username'
                },
                {
                    data: 'email',
                    name: 'Email'
                },
                {
                    data: 'nohp',
                    name: 'No Hp',
                    render: function(data, type, row) {
                        if (type === 'display') {
                            return data ? data :
                                '<a style="color:#6c757d;">No HP tidak tersedia</a>';
                        }
                        return data;
                    }
                },
                {
                    data: 'roles',
                    name: 'Status',
                    render: function(data, type, row) {
                        if (isAdmin) {
                            if (Array.isArray(data) && data.length > 0) {
                                // Capitalize the first letter of each role
                                var formattedRoles = data.map(function(role) {
                                    return role.name.charAt(0).toUpperCase() + role.name
                                        .slice(1);
                                }).join(', ');

                                return formattedRoles;
                            }

                            return 'No roles assigned';
                        }
                        return '';
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
                },
                {
                    targets: -2,
                    visible: isAdmin
                } // Menyembunyikan/menampilkan kolom 'Roles' berdasarkan isAdmin
            ]
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
        $('.tombol-simpan').off('click').on('click', function() {
            simpan();
        });
    });

    // 03_PROSES EDIT
    $('body').on('click', '.tombol-edit', function(e) {
        var id = $(this).data('id');
        $.ajax({
            url: 'userAjax/' + id + '/edit',
            type: 'GET',
            success: function(response) {
                $('#exampleModal').modal('show');
                $('#nuptk').val(response.result.nuptk);
                $('#name').val(response.result.name);
                $('#username').val(response.result.username);
                $('#email').val(response.result.email);
                $('#nohp').val(response.result.nohp);
                $('#role').val(response.result.role);
                $('#password').val(response.result.password);
                console.log(response.result);
                console.log('Roles yang dimiliki:', response.role);
                $('.tombol-simpan').off('click').on('click', function() {
                    simpan(id);
                });

            }
        });

    });

    // 04_PROSES Delete
    $('body').on('click', '.tombol-del', function(e) {
        var id = $(this).data('id');
        var name = $(this).data('name');

        Swal.fire({
            title: `Yakin mau hapus <b>${name}</b>?`,
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
                    url: 'userAjax/' + id,
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
            var_url = 'userAjax';
            var_type = 'POST';
            successMessage = 'Berhasil tambah user.';
        } else {
            var_url = 'userAjax/' + id;
            var_type = 'PUT';
            successMessage = 'Berhasil update user.';
        }

        $.ajax({
            url: var_url,
            type: var_type,
            data: {
                nuptk: $('#nuptk').val(),
                name: $('#name').val(),
                username: $('#username').val(),
                email: $('#email').val(),
                nohp: $('#nohp').val(),
                role: $('#role').val(),
                password: $('#password').val()
            },
            success: function(response) {
                if (response.errors) {
                    console.log(response.errors);
                    $('.alert-danger').removeClass('d-none');
                    $('.alert-danger').html("<ul>");
                    $.each(response.errors, function(key, value) {
                        $('.alert-danger').find('ul').append("<li>" + value + "</li>");
                    });
                    $('.alert-danger').append("</ul>");
                } else {
                    $('.alert-success').removeClass('d-none');
                    $('.alert-success').html(response.success);
                    $('#myTable').DataTable().ajax.reload();
                    Swal.fire('Sukses!', successMessage, 'success');
                }
            }
        });
    }

    $('#exampleModal').on('hidden.bs.modal', function() {
        $('#nuptk').val('');
        $('#name').val('');
        $('#username').val('');
        $('#email').val('');
        $('#nohp').val('');
        $('#role').val('');
        $('#password').val('');

        $('.alert-danger').addClass('d-none');
        $('.alert-danger').html('');

        $('.alert-success').addClass('d-none');
        $('.alert-success').html('');
    });
</script>
