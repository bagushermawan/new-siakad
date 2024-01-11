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

@if(request()->routeIs('search-santri'))

@else
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

        // Ganti ikon fas fa-compress-arrows-alt menjadi far fa-window-maximize atau sebaliknya
        var iconElement = $('#minimizeBtn i');
        if ($('#cardi').hasClass('minimized')) {
            iconElement.removeClass('fas fa-compress-arrows-alt').addClass('far fa-window-maximize');
            // Jika kartu diminimalkan, atur tinggi kartu ke tinggi card-header dengan animasi
            $('#cardi').animate({
                height: $('#cardi .card-header').outerHeight(),
            }, 500); // Sesuaikan durasi animasi
        } else {
            iconElement.removeClass('far fa-window-maximize').addClass('fas fa-compress-arrows-alt');
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
    $(document).ready(function() {
        // Inisialisasi Perfect Scrollbar
        const ps = new PerfectScrollbar('#tebel', {
            wheelSpeed: 1,
            wheelPropagation: false,
            minScrollbarLength: 20,
        });
    });
</script>

@endif
