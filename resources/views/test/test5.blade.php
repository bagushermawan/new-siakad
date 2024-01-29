<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapor Peserta Didik</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            padding: 30px; /* Memberikan padding 10px dari batas halaman */
        }

        .border-container {
            border: 5px solid black; /* Menambah border di dalam 10px dari batas halaman */
            padding: 10px; Memberikan padding di dalam border
        }
    </style>
</head>
<body>

    <div class="border-container">
<!-- Halaman Cover -->
<div class="container text-center mt-5" style="color:black;">
    <div class="text-center">
    </div>
    <br><br>
    <h1><strong>RAPOR PESERTA DIDIK</strong></h1>
    <h1><strong>SEKOLAH DASAR</strong></h1>
    <br>
    <h1><strong>PONDOK PESANTREN DARUNNAJAH KABUPATEN MALANG</strong></h1>
    <img src="{{ asset('compiled/png/logodarunnajah.png') }}" class="img-fluid mt-4" style="max-width: 100%; height: auto;">
</div>

<!-- Halaman Identitas Cover -->
<div class="container mt-5">
    <div class="text-center">
        <p style="margin:auto;">Nama Peserta Didik</p>
        <p style="border: 1px solid black;width:50%;height:3rem;margin: 0 auto;font-size:1.5rem;"><strong>bahah</strong></p>
        <br>
        <p style="margin:auto;">NIS / NISN</p>
        <p style="border: 1px solid black;width:50%;height:3rem;margin: 0 auto;font-size:1.5rem;"><strong>190899</strong></p>
    </div>
    <br>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
