@if ($santriId != null)
    <script>
        $(document).ready(function() {
            $.ajax({
                url: "{{ url('/get_alltahunajaran_options') }}",
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    var allTahunAjaranOptions = response.allTahunAjaranOptions;
                    var tahunAjaranOptions = response.tahunAjaranOptions;
                    var selectTahunAjaran = document.getElementById('filterAllTahunAjaran');

                    allTahunAjaranOptions.forEach(function(tahunAjaran, index) {
                        var option = document.createElement('option');
                        option.value = tahunAjaran.name;
                        option.text = tahunAjaran.name;
                        selectTahunAjaran.add(option);

                        // Cek apakah kelas_id dari opsi sama dengan tahunAjaranOptions
                        if (tahunAjaran.name === tahunAjaranOptions) {
                            option.selected = true; // Set sebagai terpilih jika sesuai
                            $(selectTahunAjaran).trigger('change');
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
            $.ajax({
                url: "{{ url('/get_tahunajaranAktif_options') }}",
                method: 'GET',
                dataType: 'json',
                success: function(tahunAjaranOptions) {
                    var selectTahunAjaran = document.getElementById('filterSemester');

                    tahunAjaranOptions.forEach(function(tahunAjaran, index) {
                        var option = document.createElement('option');
                        option.value = tahunAjaran.semester;
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
            $.ajax({
                url: "{{ url('/get_kelas_optionss') }}",
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    var kelasOptions = response.kelasOptions;
                    var kelasSantri = response.kelasSantri;
                    var selectKelas = document.getElementById('filterKelas');

                    kelasOptions.forEach(function(kelas, index) {
                        var option = document.createElement('option');
                        option.value = kelas.name; // Gunakan ID kelas sebagai nilai
                        option.text = kelas.name;
                        selectKelas.add(option);

                        // Cek apakah kelas_id dari opsi sama dengan kelasSantri
                        if (kelas.id === kelasSantri) {
                            option.selected = true; // Set sebagai terpilih jika sesuai
                            $(selectKelas).trigger('change');
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
            $('#filterAllTahunAjaran').on('change', function() {
                var selecterTAid = $(this).val();
                // $('#filterSemester').val('').trigger('change');
                $('#filterKelas').val('').trigger('change');
                myTable.column(3).search(selecterTAid).draw();
            });
            $('#filterSemester').on('change', function() {
                var selectedTahunAjaranId = $(this).val();
                myTable.column(5).search(selectedTahunAjaranId).draw();
            });
            $('#filterKelas').on('change', function() {
                var selectedKelasId = $(this).val();
                myTable.column(2).search(selectedKelasId).draw();
            });
            var myTable = $('#myTable').DataTable({
                orderCellsTop: false,
                processing: true,
                serverside: true,
                ordering: false,
                sDom: 'tpi',
                ajax: "{{ url('/dataNilaiForWali') }}",
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
                },
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
                    {
                        data: 'tahun_ajaran_semester',
                        name: 'Tahun Ajaran Semester',
                    },
                ],
            });
            // Menunggu inisialisasi DataTables selesai
            myTable.on('init.dt', function() {
                var currentPageData = myTable.rows({
                    page: 'current'
                }).data().toArray();
                console.log('ini isinya', currentPageData);
            }).draw();
            // Fungsi untuk memberi warna pada pagination
            const setTableColor = () => {
                document.querySelectorAll('.dataTables_paginate .pagination').forEach(dt => {
                    dt.classList.add('pagination-primary')
                })
                document.querySelectorAll('.dataTables_info').forEach(dt => {
                    // Dapatkan teks dari elemen .dataTables_info
                    var infoText = dt.textContent.trim();

                    // Buat elemen <code> dan tambahkan teks ke dalamnya
                    var codeElement = document.createElement('code');
                    codeElement.textContent = infoText;

                    // Ganti elemen .dataTables_info dengan elemen <code>
                    dt.innerHTML = '';
                    dt.appendChild(codeElement);
                });
            }
            // Memanggil fungsi setTableColor pada awal dan setiap kali DataTable digambar ulang
            setTableColor();
            myTable.on('draw', setTableColor);


        });
    </script>
@endif

<script>
    function refreshDataTable() {
        var dataTable = $('#myTable').DataTable();
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
