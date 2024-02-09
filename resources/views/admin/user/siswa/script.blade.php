<script>
    function showSwal() {
        Swal.fire({
            icon: 'info',
            title: 'Foto tidak tersedia',
            text: 'Silahkan login, lalu setting manual di akun terkait',
            confirmButtonText: 'Tutup'
        });
    }
    $(document).ready(function() {
        const baseUrl = "{{ asset('storage/') }}";
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
                        var totalSantri = parseInt($('#totalSantri').data('total'));
                        console.log(totalSantri);

                        if (totalSantri > 0) {
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
                                        url: "/delete-all-user", // Ganti dengan URL backend Anda
                                        method: "DELETE", // Sesuaikan dengan metode yang digunakan di backend
                                        success: function(response) {
                                            // Jika penghapusan dari database berhasil
                                            if (response.success) {
                                                // Hapus semua data dari DataTables
                                                $('#myTable').DataTable()
                                                    .ajax.reload();
                                                Swal.fire("Deleted!",
                                                    "All users with role 'user' deleted successfully.",
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
                    titleAttr: 'Reload Data',
                    action: function(e, dt, node, config) {
                        Swal.fire({
                            html: `
                                    <input type="file" id="excel_file" class="swal2-file" accept=".xlsx, .xls, .csv">
                                    <br><br><br>
                                    
                                     `,
                            showCancelButton: true,
                            confirmButtonText: 'Import',
                            cancelButtonText: 'Batal',
                            footer: 'Download file sample excell <a href="/storage/siswa_import_sample.xlsx" download>disini</a>.',
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
                                    url: '{{ route('import.siswa') }}',
                                    method: 'POST',
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(response) {
                                        $('#myTable').DataTable().ajax
                                            .reload();
                                        Swal.fire('Sukses!',
                                            'Berhasil import data siswa.',
                                            'success');
                                    },
                                    error: function(error) {
                                        Swal.fire('Gagal!',
                                            'Gagal import data siswa.',
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
                        if (colIdx === 0 || colIdx === 7 || colIdx === 8 || colIdx === 9 || colIdx === 5 || colIdx === 6) {
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
            ajax: "{{ url('/qwe/siswaAjax') }}",
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
                    data: 'nisn',
                    name: 'nisn',
                    render: function(data, type, row) {
                        if (type === 'display') {
                            return data ? data :
                                '<a style="color:#6c757d;">NISN tidak tersedia</a>';
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
                    data: 'tanggal_lahir',
                    name: 'Tanggal Lahir'
                },
                {
                    data: 'kelas_name',
                    name: 'kelas_name',
                    render: function(data, type, row) {
                        if (type === 'display') {
                            return data ? data :
                                '<a style="color:#6c757d;">Kelas tidak tersedia</a>';
                        }
                        return data;
                    }
                },
                // {
                //     data: 'email',
                //     name: 'Email'
                // },
                // {
                //     data: 'nohp',
                //     name: 'No Hp',
                //     render: function(data, type, row) {
                //         if (type === 'display') {
                //             return data ? data :
                //                 '<a style="color:#6c757d;">No HP tidak tersedia</a>';
                //         }
                //         return data;
                //     }
                // },
                {
                    data: 'roles',
                    name: 'Roles',
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
                    data: 'foto_user',
                    name: 'Foto user',
                    render: function(data, type, row) {
                        if (type === 'display') {
                            if (data) {
                                return '<div class="avatar avatar-xl"><img src="' + baseUrl +
                                    '/' +
                                    data + '" alt="Foto Pengguna"></div>';
                            } else {
                                // Tambahkan event handler untuk menampilkan swal saat foto tidak tersedia di klik
                                return '<a style="color:rgba(var(--bs-link-color-rgb),var(--bs-link-opacity, 1)); cursor: pointer;" onclick="showSwal()">Foto tidak tersedia</a>';
                            }
                        }
                        return data;
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
        resetPasswordPlaceholder();
        if (typeof kelasSelect !== 'undefined') {
            kelasSelect.destroy();
        }
        kelasSelect = new Choices('#kelas_id', {
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
        resetPasswordPlaceholder();
        $.ajax({
            url: 'userAjax/' + id + '/edit',
            type: 'GET',
            success: function(response) {
                $('#exampleModal').modal('show');
                $('#nisn').val(response.result.nisn);
                $('#name').val(response.result.name);
                $('#username').val(response.result.username);
                $('#tanggal_lahir').val(response.result.tanggal_lahir);

                // Hapus objek Choices.js sebelum membuat yang baru
                if (typeof kelasSelect !== 'undefined') {
                    kelasSelect.destroy();
                }

                $('#kelas_id').val(response.result.kelas_id);
                $('#email').val(response.result.email);
                $('#nohp').val(response.result.nohp);
                $('#role').val(response.result.role);
                $('#password').val(response.result.password);
                console.log(response.result);
                console.log('Roles yang dimiliki:', response.role);
                $('.tombol-simpan').off('click').on('click', function() {
                    simpan(id);
                });

                // Set placeholder for password field
                setDynamicPasswordPlaceholder(id);

                // Inisialisasi objek Choices.js baru
                kelasSelect = new Choices('#kelas_id', {
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
                nisn: $('#nisn').val(),
                name: $('#name').val(),
                username: $('#username').val(),
                tanggal_lahir: $('#tanggal_lahir').val(),
                kelas_id: $('#kelas_id').val() || null,
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

    // Fungsi untuk menetapkan placeholder dinamis pada input password
    function setDynamicPasswordPlaceholder(id) {
        const passwordInput = $('#password');

        // Jika id tidak kosong (edit data), biarkan placeholder kosong
        // Jika id kosong (tambah data), atur placeholder sama dengan nilai pada input username
        passwordInput.attr('placeholder', id ? 'Biarkan kosong jika tidak ingin ganti password' : $('#username').val());
    }

    // Fungsi untuk mereset placeholder pada input password
    function resetPasswordPlaceholder() {
        const passwordInput = $('#password');
        passwordInput.attr('placeholder', 'Password default sama dengan Username'); // Reset placeholder menjadi kosong
    }

    $('#exampleModal').on('hidden.bs.modal', function() {
        $('#nisn').val('');
        $('#name').val('');
        $('#username').val('');
        $('#tanggal_lahir').val('');
        $('#kelas_id').val('');
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
