<script>
    $(document).ready(function() {
        var isAdmin = {{ $isAdmin ? 'true' : 'false' }};
        var myTable= $('#myTable').DataTable({
            processing: true,
            serverside: true,
            ajax: "{{ url('/qwe/guruAjax') }}",
            columns: [
                {data: 'DT_RowIndex',
    name: 'DT_RowIndex',
    orderable: false,
    searchable: false,
    render: function (data, type, row, meta) {
        if (type === 'display') {
            return '<center>' + (meta.row + 1) + '</center>';
        }
        return meta.row + 1;
    }},
                {data: 'nuptk',name: 'nuptk'},
                {data: 'name',name: 'Nama'},
                {data: 'username',name: 'Username'},
                {data: 'email',name: 'Email'},
                {data: 'nohp',name: 'No Hp'},
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
                {data: 'aksi',name: 'Aksi',visible: isAdmin}
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
                $('#password').val(response.result.password);
                console.log(response.result);
                $('.tombol-simpan').click(function() {
                    simpan(id);
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
        $('#password').val('');

        $('.alert-danger').addClass('d-none');
        $('.alert-danger').html('');

        $('.alert-success').addClass('d-none');
        $('.alert-success').html('');
    });
</script>
