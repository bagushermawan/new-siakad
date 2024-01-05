<script>
    $(document).ready(function() {
        // Mengambil data tahun ajaran dari server
        $.ajax({
            url: "{{ url('/get_tahunajaran_optionss') }}",
            method: 'GET',
            dataType: 'json',
            success: function(tahunAjaranOptions) {
                var selectTahunAjaran = document.getElementById('filterTahunAjaran');

                tahunAjaranOptions.forEach(function(tahunAjaran, index) {
                    var option = document.createElement('option');
                    option.value = tahunAjaran.name + ' (' + tahunAjaran.semester + ')';
                    option.text = tahunAjaran.semester;
                    selectTahunAjaran.add(option);

                    // Menandai option pertama sebagai yang terpilih
                    if (index === 0) {
                        option.selected = true;
                        $(selectTahunAjaran).trigger('change');
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
        // Mendeteksi perubahan pada elemen <select> tahun ajaran
        $('#filterTahunAjaran').on('change', function() {
            var selectedTahunAjaranId = $(this).val();
            myTable.column(3).search(selectedTahunAjaranId).draw();
        });
        $('#myTable')
        var myTable = $('#myTable').DataTable({
            orderCellsTop: false,
            processing: true,
            serverside: true,
            ordering: false,
            sDom: 't',
            ajax: "{{ url('/dataNilaiSiswa') }}",
            columns: [{
                    data: 'user_id',
                    name: 'Users',
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
            ],
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
</script>

<script>
function refreshDataTable() {
    var dataTable = $('#yourDataTableId').DataTable();
    var refreshIcon = $('#refreshIcon');
    var refreshText = $('#refreshText');

    // Menampilkan ikon spinner dan menyembunyikan teks
    refreshIcon.removeClass('d-none');
    refreshText.addClass('d-none');

    // Memuat ulang data DataTable setelah sedikit waktu (misalnya, 1 detik dalam contoh ini)
    setTimeout(function() {
        dataTable.ajax.reload();

        // Sembunyikan ikon spinner dan menampilkan teks kembali setelah memuat ulang
        refreshIcon.addClass('d-none');
        refreshText.removeClass('d-none');
    }, 1000);
}
</script>
