<script>
    $(document).ready(function() {
        $('#send-verification-btn').on('click', function(e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: $('#send-verification').attr('action'),
                data: $('#send-verification').serialize(),
                success: function(response) {
                    console.log('Sukses mengirim email verifikasi')
                    // Tampilkan pesan sukses di dalam elemen dengan ID tertentu
                    $('#success-message').text(
                        'Tautan verifikasi baru telah dikirimkan ke alamat email Anda.');
                },
                error: function(error) {
                    // Tambahkan logika atau tindakan yang sesuai dengan kesalahan
                    console.error(error);

                    // Misalnya, tampilkan pesan kesalahan
                    alert('Terjadi kesalahan saat mengirim email verifikasi.');
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Inisialisasi Perfect Scrollbar
        const ps = new PerfectScrollbar('#cardi', {
            wheelSpeed: 1,
            wheelPropagation: false,
            minScrollbarLength: 20,
        });

        // Simpan tinggi kartu dalam variabel
        var originalHeight = $('#cardi').height();

        // Fungsi untuk meminimalkan dan memaksimalkan kartu dengan animasi
        $('#minimizeBtn').on('click', function() {
            $('#cardi').toggleClass('minimized');

            // Jika kartu diminimalkan, atur tinggi kartu ke tinggi card-header dengan animasi
            if ($('#cardi').hasClass('minimized')) {
                $('#cardi').animate({
                    height: $('#cardi .card-header').outerHeight(),
                }, 500); // Sesuaikan durasi animasi
            } else {
                // Jika kartu tidak diminimalkan, kembalikan ke tinggi aslinya dengan animasi
                $('#cardi').animate({
                    height: originalHeight,
                }, 500); // Sesuaikan durasi animasi
            }

            // Perbarui Perfect Scrollbar setelah animasi selesai
            setTimeout(function() {
                ps.update();
            }, 500); // Sesuaikan dengan durasi animasi
        });

        // Fungsi untuk menutup elemen
        $('#closeBtn').on('click', function() {
            // Animasi CSS dari Animate.css
            $('#cardi').addClass('animate__animated animate__slideOutUp');

            // Sembunyikan kartu setelah animasi selesai
            setTimeout(function() {
                $('#cardi').hide();
            }, 500); // Sesuaikan dengan durasi animasi
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Panggil endpoint untuk mendapatkan data pengguna berdasarkan rolenya
        fetch('/user-role-count')
            .then(response => response.json())
            .then(userData => {
                // Gunakan data yang diperoleh untuk menggambar Pie Chart
                drawPieChart(userData);
            })
            .catch(error => {
                console.error('Error fetching user role count:', error);
            });

        // Fungsi untuk menggambar Pie Chart
        function drawPieChart(userData) {
            var ctx = document.getElementById('roleDistributionChart').getContext('2d');

            // Gambar Pie Chart
            var roleDistributionChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Admin', 'Guru', 'Santri', 'Wali Santri'],
                    datasets: [{
                        data: Object.values(userData),
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.8)',
                            'rgba(54, 162, 235, 0.8)',
                            'rgba(180, 180, 180, 0.8)',
                            'rgba(240, 162, 235, 0.8)',
                        ],
                        borderColor: [
                            'rgba(179, 255, 255, 0.8)',
                            'rgba(179, 255, 255, 0.8)',
                            'rgba(179, 255, 255, 0.8)',
                            'rgba(179, 255, 255, 0.8)',
                        ],
                        hoverOffset: 10,
                        // hoverBackgroundColor: 'red'
                    }]
                },
                options: {
                    responsive: true,
                    title: {
                        display: true,
                        text: 'Total Users'
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                boxWidth: 30,
                                padding: 20,
                            }
                        },
                        datalabels: {
                            display: true,
                        },
                    },
                    animation: {
                        easing: 'easeOutBounce',
                        duration: 1000, // durasi animasi dalam milidetik
                    },
                },
            });
        }
    });
</script>
