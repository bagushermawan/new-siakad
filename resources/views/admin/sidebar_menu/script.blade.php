<script>
    $(document).ready(function() {
        var isAdmin = {{ $isAdmin ? 'true' : 'false' }};
        $('#myTable thead tr')
            .addClass('filters')
            .appendTo('#myTable thead');
        var myTable = $('#myTable').DataTable({
            orderCellsTop: true,
            processing: true,
            serverside: true,
            ajax: "{{ url('/qwe/sidebarmenuajax') }}",
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
                    data: 'title',
                    name: 'Tama'
                },
                {
                    data: 'route_name',
                    name: 'Route Name'
                },
                {
                    data: 'icon',
                    name: 'Icon'
                },
                {
                    data: 'group',
                    name: 'Group'
                },
                {
                    data: 'order',
                    name: 'Order'
                },
                {
                    data: 'is_submenu',
                    name: 'Is Submenu'
                },
                {
                    data: 'parent_name',
                    name: 'Parent'
                },
                {
                    data: 'roles',
                    name: 'Roles'
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
        if (typeof parent_idSelect !== 'undefined') {
            parent_idSelect.destroy();
        }
        parent_idSelect = new Choices('#parent_id', {
            searchEnabled: true,
            itemSelectText: '',
            allowHTML: true,
        });
        if (typeof roles_select !== 'undefined') {
            roles_select.destroy();
        }
        roles_select = new Choices('#roles', {
            searchEnabled: true,
            itemSelectText: '',
            allowHTML: true,
            removeItemButton: true,
        });

        $('.tombol-simpan').off('click').on('click', function() {
            simpan();
        });
    });

    // PROSES EDIT
    $('body').on('click', '.tombol-edit', function(e) {
        e.preventDefault();
        var id = $(this).data('id');

        $.ajax({
            url: 'sidebarmenu/' + id + '/edit',
            type: 'GET',
            success: function(response) {
                $('#exampleModal').modal('show');

                $('#title').val(response.result.title);
                $('#route_name').val(response.result.route_name);
                $('#icon').val(response.result.icon);
                $('#group').val(response.result.group);
                $('#order').val(response.result.order);
                $('#is_submenu_checkbox').prop('checked', response.result.is_submenu == 1);

                if (typeof parent_idSelect !== 'undefined') {
                    parent_idSelect.destroy();
                }
                parent_idSelect = new Choices('#parent_id', {
                    searchEnabled: true,
                    itemSelectText: '',
                    allowHTML: true,
                });
                if (response.result.parent_id) {
                    parent_idSelect.setChoiceByValue(response.result.parent_id.toString());
                }
                if (typeof rolesSelect !== 'undefined') {
                    rolesSelect.destroy();
                }
                $('#roles option').prop('selected', false);

                if (response.result.roles && Array.isArray(response.result.roles)) {
                    response.result.roles.forEach(function(role) {
                        const option = document.querySelector(
                            `#roles option[value="${role}"]`);
                        if (option) {
                            option.selected = true;
                        }
                    });
                }

                rolesSelect = new Choices('#roles', {
                    searchEnabled: true,
                    itemSelectText: '',
                    allowHTML: true,
                    removeItemButton: true,
                });

                console.log("Parent dari response:", response.result.parent_id);
                console.log("Roles dari response:", response.result.roles);

                $('.tombol-simpan').off('click').on('click', function() {
                    simpan(id);
                });
            }
        });
    });


    // 04_PROSES Delete
    $('body').on('click', '.tombol-del', function(e) {
        var id = $(this).data('id');
        var title = $(this).data('title');
        console.log(title);

        Swal.fire({
            title: `Yakin mau hapus <b>${title}</b>?`,
            text: "Anda tidak akan dapat mengembalikan data ini!",
            icon: 'warning',
            width: 600,
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika pengguna menekan tombol "Hapus", kirim permintaan DELETE
                $.ajax({
                    url: '/qwe/sidebarmenu/' + id,
                    type: 'DELETE',
                    success: function(response) {
                        $('#myTable').DataTable().ajax.reload();
                        Swal.fire('Sukses!', 'Berhasil hapus SidebarMenu.', 'info').then(
                            () => {
                                window.location.reload();
                            });
                    },
                    error: function(response) {
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus SidebarMenu.',
                            'error');
                    }
                });
            }
        });
    });

    // Proses Delete All
    $("#deleteAllButton").on("click", function() {
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
                    url: "/delete-all-prestasi", // Ganti dengan URL backend Anda
                    method: "DELETE", // Sesuaikan dengan metode yang digunakan di backend
                    success: function(response) {
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
                    error: function(error) {
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

    // fungsi simpan dan update sidebarmenu
    function simpan(id = '') {
        let var_url, var_type, successMessage;

        if (id === '') {
            var_url = '/qwe/sidebarmenu';
            var_type = 'POST';
            successMessage = 'Berhasil tambah sidebarmenu.';
        } else {
            var_url = '/qwe/sidebarmenu/' + id;
            var_type = 'PUT';
            successMessage = 'Berhasil update sidebarmenu.';
        }
        // if (typeof rolesSelect !== 'undefined') {
        //     rolesSelect.destroy();
        // }
        if (typeof parent_idSelect !== 'undefined') {
            parent_idSelect.destroy();
        }
        var parent_idSelect = new Choices('#parent_id', {
            searchEnabled: false,
            itemSelectText: '',
            allowHTML: true,
        });
        // rolesSelect = new Choices('#roles', {
        //     searchEnabled: true,
        //     itemSelectText: '',
        //     allowHTML: true,
        //     removeItemButton: true
        // });

        let is_submenu = $('#is_submenu_checkbox').prop('checked') ? 1 : 0;

        $.ajax({
            url: var_url,
            type: var_type,
            data: {
                title: $('#title').val(),
                route_name: $('#route_name').val(),
                icon: $('#icon').val(),
                group: $('#group').val(),
                order: $('#order').val(),
                is_submenu: is_submenu,
                parent_id: $('#parent_id').val(),
                roles: $('#roles').val(),
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
                    console.log(response.data);
                    $('.alert-success').removeClass('d-none');
                    $('.alert-success').html(response.success);
                    Swal.fire('Sukses!', successMessage, 'success').then(
                        () => {
                            window.location.reload();
                        });
                }
            }
        });
    }


    $('#exampleModal').on('hidden.bs.modal', function() {
        $('#title').val('');
        $('#route_name').val('');
        $('#icon').val('');
        $('#group').val('');
        $('#order').val('');
        $('#is_submenu').val('');
        $('#parent_id').val('');
        $('#roles').val('');


        $('.alert-danger').addClass('d-none');
        $('.alert-danger').html('');

        $('.alert-success').addClass('d-none');
        $('.alert-success').html('');
    });
</script>
