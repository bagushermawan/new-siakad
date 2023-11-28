<script>
    $(document).ready(function() {
        var isAdmin = {{ $isAdmin ? 'true' : 'false' }};
        $('#myTable').DataTable({
            processing: true,
            serverside: true,
            ajax: "{{ url('/qwe/userAjax') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
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
                    visible: isAdmin, // Menyembunyikan/menampilkan kolom 'Aksi' berdasarkan isAdmin
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
            table1.on('draw', setTableColor);
            table2.on('draw', setTableColor);

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
        $('.tombol-simpan').click(function() {
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
                $('#name').val(response.result.name);
                $('#username').val(response.result.username);
                $('#email').val(response.result.email);
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
        if (confirm('Yakin mau hapus data ini?') == true) {
            var id = $(this).data('id');
            $.ajax({
                url: 'userAjax/' + id,
                type: 'DELETE',
            });
            Swal.fire('Sukses!', 'Berhasil hapus user.', 'info');
            $('#myTable').DataTable().ajax.reload();
        }
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
                name: $('#name').val(),
                username: $('#username').val(),
                email: $('#email').val(),
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
                    Swal.fire('Sukses!', successMessage, 'success');
                    $('#myTable').DataTable().ajax.reload();
                }
            }
        });
    }

    $('#exampleModal').on('hidden.bs.modal', function() {
        $('#name').val('');
        $('#username').val('');
        $('#email').val('');
        $('#password').val('');

        $('.alert-danger').addClass('d-none');
        $('.alert-danger').html('');

        $('.alert-success').addClass('d-none');
        $('.alert-success').html('');
    });
</script>
