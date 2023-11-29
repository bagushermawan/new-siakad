<script>
    $(document).ready(function() {
        var isAdmin = {{ $isAdmin ? 'true' : 'false' }};
        var myTable= $('#myTable').DataTable({
            processing: true,
            serverside: true,
            ajax: "{{ url('/qwe/prestasiAjax') }}",
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
                {data: 'name',name: 'Nama'},
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
                {data: 'aksi',name: 'Aksi',visible: isAdmin}
            ],
            columnDefs: [{
                    targets: -1,
                    visible: isAdmin
                },
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
            url: 'prestasiAjax/' + id + '/edit',
            type: 'GET',
            success: function(response) {
                $('#exampleModal').modal('show');
                $('#name').val(response.result.name);
                console.log(response.result);
                $('.tombol-simpan').off('click').on('click', function() {
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
                url: 'prestasiAjax/' + id,
                type: 'DELETE',
            });
            Swal.fire('Sukses!', 'Berhasil hapus prestasi.', 'info');
            $('#myTable').DataTable().ajax.reload();
        }
    });

    // fungsi simpan dan update
    function simpan(id = '') {
        let var_url, var_type, successMessage;

        if (id === '') {
            var_url = 'prestasiAjax';
            var_type = 'POST';
            successMessage = 'Berhasil tambah prestasi.';
        } else {
            var_url = 'prestasiAjax/' + id;
            var_type = 'PUT';
            successMessage = 'Berhasil update prestasi.';
        }

        $.ajax({
            url: var_url,
            type: var_type,
            data: {
                name: $('#name').val(),
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


        $('.alert-danger').addClass('d-none');
        $('.alert-danger').html('');

        $('.alert-success').addClass('d-none');
        $('.alert-success').html('');
    });
</script>
