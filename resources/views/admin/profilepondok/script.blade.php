<script>
        $(document).ready(function() {
            // Menangani pengiriman formulir ketika tombol submit ditekan
            $('#profileForm').submit(function(e) {
                e.preventDefault(); // Mencegah formulir untuk melakukan submit standar

                // Mendapatkan data formulir
                var formData = new FormData($(this)[0]);

                // Mengirim data formulir ke server menggunakan AJAX
                $.ajax({
                    type: 'POST',
                    url: '/qwe/profilepondok',
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Menanggapi keberhasilan dari server
                        console.log(response);

                        // Tambahkan logika atau tindakan tambahan di sini sesuai kebutuhan
                        // Misalnya, perbarui tampilan data di halaman
                        updateView(response);
                        Swal.fire('Sukses!',
                            'Berhasil update profile Pondok Pesantren.',
                            'success');
                    },
                    error: function(error) {
                        // Menanggapi kesalahan dari server
                        console.log('Error:', error);

                        // Tambahkan logika atau tindakan tambahan di sini sesuai kebutuhan
                    }
                });
            });

            // Fungsi untuk memperbarui tampilan data di halaman
            function updateView(response) {
                // Lakukan perubahan pada elemen HTML sesuai kebutuhan
                // Misalnya, perbarui daftar data atau tampilkan pesan sukses
                $('#namaPondok').text(response.nama_pondok);
                $('#kepalaPondok').text(response.kepala_pondok);
                $('#alamatPondok').text(response.alamat);
                $('#teleponPondok').text(response.telepon);
                $('#emailPondok').text(response.email);
                $('#deskripsiPondok').text(response.deskripsi);
                $('#visi_misiPondok').text(response.visi_misi);
                $('#fotoPondok').attr('src', response.foto_pondok);
            }
        });
    </script>
