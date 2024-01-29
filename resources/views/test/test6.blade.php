<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapor Peserta Didik</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            padding: 30px;
            /* Memberikan padding 10px dari batas halaman */
        }

        .border-container {
            border: 5px solid black;
            /* Menambah border di dalam 10px dari batas halaman */
            padding: 10px;
            Memberikan padding di dalam border
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="content-wrapper">
            <section class="content">
                <div class="row">
                    <div class="col-lg-4 pull-left">
                        <h4>Daftar Nilai Raport Siswa</h4>
                    </div>
                    <div class="col-lg-8 pull-right" style="text-align:right">
                        <h4>
                            <button id="cmd" class="btn btn-success">Save PDF</button>
                            <a href=""><button class="btn btn-success"><i class="glyphicon glyphicon-plus"></i>
                                    Kembali</button></a>
                        </h4>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <div id="ini">
                            <div>
                                <div class="row text-center">
                                    <div class="col-lg-12">
                                        {{-- <img src="{{ asset('compiled/png/logodarunnajah.png') }}" class="img-fluid mt-4"style="max-width: 100%; height: auto;"> --}}
                                        <h1>Laporan Hasil Penilaian</h1>
                                        <h1>UTS / UAS</h2>
                                        <h2>MI Pondok Pesantren Darunnajah Kabupaten Malang</h2>
                                        <h5>Jl. Pesantren No.51, Kendalsari, Karangploso, Malang, Kabupaten Malang, Jawa Timur 65152</h5>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="col-lg-4">NIS</div>
                                        <div class="col-lg-1">:</div>
                                        <div class="col-lg-7">9999</div>
                                        <div class="col-lg-4">Nama Siswa</div>
                                        <div class="col-lg-1">:</div>
                                        <div class="col-lg-7">baher</div>
                                        <div class="col-lg-4">Nama Sekolah</div>
                                        <div class="col-lg-1">:</div>
                                        <div class="col-lg-7">SMP Negeri x Surakarta</div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="col-lg-4">Kelas</div>
                                        <div class="col-lg-1">:</div>
                                        <div class="col-lg-7">2A3</div>
                                        <div class="col-lg-4">Semester</div>
                                        <div class="col-lg-1">:</div>
                                        <div class="col-lg-7">I (satu)</div>
                                        <div class="col-lg-4">Tahun Ajaran</div>
                                        <div class="col-lg-1">:</div>
                                        <div class="col-lg-7">2023/2024</div>
                                    </div>
                                </div><br>
                                <label>A. Nilai Pengetahuan</label>
                                <table border="1" id="ss" width="100%">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">
                                                <center>No
                                            </th>
                                            <th rowspan="2">
                                                <center>Mata Pelajaran
                                            </th>
                                            <th rowspan="2">
                                                <center>KKM
                                            </th>
                                            <th colspan="2">
                                                <center>Nilai UTS
                                            </th>
                                            <th rowspan="2">
                                                <center>Keterangan
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                                <center>Angka
                                            </th>
                                            <th>
                                                <center>Huruf
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><center>1</td>
                                            <td>Math</td>
                                            <td><center>75</td>
                                            <td><center>89</td>
                                            <td>Lapan Sembilan</td>
                                            <td><center>TUNTAS</td>
                                        </tr>

                                    </tbody>
                                    <tfooter>
                                        <tr>
                                            <th colspan="3">
                                                <center>Jumlah Nilai
                                            </th>
                                            <th><center>88</th>
                                        </tr>
                                        <tr>
                                            <th colspan="3">
                                                <center>Rata-Rata Nilai
                                            </th>
                                            <th><center>21</th>
                                        </tr>
                                    </tfooter>
                                </table>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label>B. Absensi Kelas</label>
                                        <table border="1" width="100%">
                                            <tr>
                                                <td>Tanpa Keterangan</td>
                                                <td><center>2 hari</td>
                                            </tr>
                                            <tr>
                                                <td>Izin</td>
                                                <td><center>4 hari</td>
                                            </tr>
                                            <tr>
                                                <td>Sakit</td>
                                                <td><center>5 hari</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-lg-4">

                                    </div>
                                    <div class="col-lg-4">
                                        <label>C. Lain - Lain</label>
                                        <table border="1" width="100%">
                                            <tr>
                                                <td>Budi Pekerti</td>
                                                <td>A (Baik Sekali)</td>
                                            </tr>
                                            <tr>
                                                <td>Pramuka</td>
                                                <td>B (Baik)</td>
                                            </tr>
                                            <tr>
                                                <td>Ekstrakulikuler</td>
                                                <td>B (Baik)</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                                <div class="row">
                                    <div class="col-lg-6" align="center">
                                        <br>
                                        Orang Tua Siswa
                                        <br><br><br><br>
                                        Untari
                                    </div>
                                    <div class="col-lg-6" align="center">
                                        Jumat, 26 Januari 2024
                                        <br> Guru Wali Kelas
                                        <br><br><br><br>
                                        Ppapin
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
