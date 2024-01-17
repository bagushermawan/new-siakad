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
    // Fetch data user role count dari endpoint '/userd-role-count'
    fetch('/user-role-count')
        .then(response => response.json())
        .then(userData => {
            // Gunakan data yang diperoleh untuk mengupdate series dan labels
            optionsVisitorsProfile.series = userData.series;
            optionsVisitorsProfile.labels = userData.labels;

            // Buat instance chart baru dengan data yang diperbarui
            var chartVisitorsProfile = new ApexCharts(
                document.getElementById("chart-visitors-profile"),
                optionsVisitorsProfile
            );

            // Render chart
            chartVisitorsProfile.render();
            console.log('Success fetching user Total Users');
        })
        .catch(error => {
            console.error('Error fetching user role count:', error);
        });

    // Options awal untuk chart (akan diperbarui setelah mendapatkan data)
    let optionsVisitorsProfile = {
        series: [70, 30], // Data awal, dapat diubah
        labels: ["Admin", "Guru", "User", "Wali"], // Label awal, dapat diubah
        colors: ["#219EBC", "#023047", "#FFB703", "#FB8500"],
        chart: {
            type: "donut",
            width: "100%",
            height: "350px",
        },
        legend: {
            position: "bottom",
        },
        plotOptions: {
            pie: {
                donut: {
                    size: "30%",
                },
            },
        }
    };
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var dataRiwayatLogin = {!! json_encode($data_riwayat_login) !!};

        if (Array.isArray(dataRiwayatLogin) && dataRiwayatLogin.length > 0) {
            console.log("Riwayat login berhasil dimuat.");
        } else {
            console.log("Data riwayat login kosong atau tidak berhasil dimuat.");
        }
    });
</script>
