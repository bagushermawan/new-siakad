<script>
        $(document).ready(function() {
            $('#myTable').DataTable();
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
