<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>E-Rapor </title>

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="{{ asset('/extensions/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link rel="stylesheet" href="{{ asset('compiled/css/app.css') }}">
    <style type="text/css">
        .tg {
            border-collapse: collapse;
            border-spacing: 0;
            margin-left: 100px;
        }

        .tg td {
            font-family: Arial, sans-serif;
            font-size: 12px;
            padding: 5px 5px;
            border-style: solid;
            border-width: 0px;
            overflow: hidden;
            word-break: normal;
            border-color: black;
        }

        .tg th {
            font-family: Arial, sans-serif;
            font-size: 12px;
            font-weight: normal;
            padding: 5px 5px;
            border-style: solid;
            border-width: 1px;
            overflow: hidden;
            word-break: normal;
            border-color: black;
        }

        .tg .tg-s268 {
            text-align: left;
            text-justify: auto;
        }

        .tg .tg-baqh {
            text-align: center;
            vertical-align: middle;
        }

        .tg .tg-c3ow {
            border-color: inherit;
            text-align: center;
            vertical-align: top;
        }

        .tg .tg-0lax {
            text-align: center;
            vertical-align: middle;
        }

        .tg .tg-73oq {
            border-color: #000000;
            text-align: left;
            vertical-align: top
        }

        .tg .tg-textarea {

            text-align: center;
            vertical-align: middle;
            height: 80px;
        }

        .no {
            width: -10px;
        }
    </style>
</head>

<!-- Tombol download -->

<div class='alert alert-warning' role='alert'>
    <center>
        <a href='javascript:if(window.print)window.print()'>
            <button type='button' id="tombolCetak" class='btn btn-success'>
                <span class='glyphicon glyphicon-print' aria-hidden='true'></span>
                Cetak halaman ini
            </button>
        </a>
        <a href="index.php?kls=1" class="btn btn-warning" id="tombolKembali">Kembali</a>
    </center>
</div>


<!-- Halaman Cover -->
<div class="container text-center mt-5" style="color:black;">
    <div class="text-center">
    </div>
    <br><br>
    <h1> <strong> RAPOR PESERTA DIDIK </strong></h1>
    <h1><strong>  SEKOLAH DASAR</strong></h1>
    <br>
    <h1><strong> PONDOK PESANTREN DARUNNAJAH KABUPATEN MALANG</strong></h1>
    <img src="{{ asset('compiled/png/logodarunnajah.png') }}" class="img-fluid mt-4"  style="max-width:100%;height:auto;margin:50px;">
    {{-- <img src="" class="img-fluid mt-4" style="max-width: 100%; height: auto;"> --}}
</div>
<!-- Halaman Identitas Cover -->
<div class="container mt-5">
    <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td><strong>Nama Siswa</strong></td>
                    <td><strong>:</strong></td>
                    <td><strong>aaaaxaxaxa</strong></td>
                </tr>
                <tr>
                    <td><strong>NIS</strong></td>
                    <td><strong>:</strong></td>
                    <td><strong>aaaaxaxaxa</strong></td>
                </tr>

                <tr>
                    <td><strong>NISN</strong></td>
                    <td><strong>:</strong></td>
                    <td><strong>aaaaxaxaxa</strong></td>
                </tr>
                <tr>
                    <td><strong>Semester</strong></td>
                    <td><strong>:</strong></td>
                    <td><strong>aaaaxaxaxa</strong></td>
                </tr>
                <tr>
                    <td><strong>Kelas</strong></td>
                    <td><strong>:</strong></td>
                    <td><strong>aaaaxaxaxa</strong></td>
                </tr>
                <tr>
                    <td><strong>Nama Sekolah</strong></td>
                    <td><strong>:</strong></td>
                    <td><strong>aaaaxaxaxa</strong></td>
                </tr>

                <tr>
                    <td><strong>Tahun Ajar</strong></td>
                    <td><strong>:</strong></td>
                    <td><strong>aaaaxaxaxa</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div style="height: 200px;"></div>
<div class="container text-center mt-5" style="color:black;">
    <h1><strong> KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN </strong></h1>
    <h1><strong> REPUBLIK INDONESIA</strong></h1>
    <h2>2024</h2>
</div>
<div style="height: 170px;"></div>


<!-- Halaman Identitas Cover -->
<div class="container mt-5" style="color:black;">
    <div class="text-center">
        <h2> <strong> RAPOR </strong></h2>
        <h2><strong> PESERTA DIDIK</strong></h2>
        <h2><strong> SEKOLAH DASAR</strong></h2>
    </div>
    <br><br>
    <table class="table table-bordered"
        style="margin-left: 150px;margin: right 250px;max-width: 700px;border: none;color:black;">
        <tbody>
            <tr>
                <td style=" width: 200px;"><strong>Nama Sekolah</strong></td>
                <td style="width: 50px;text-align:center;"><strong>:</strong></td>
                <td style="">gagaga</td>
            </tr>
            <tr>
                <td style=" width: 200px;"><strong>Alamat Sekolah</strong></td>
                <td style="width: 50px;text-align:center;"><strong>:</strong></td>
                <td style="">gagaga</td>
            </tr>
            <tr>
                <td style=" width: 200px;"><strong>Kelurahan/ Desa </strong></td>
                <td style="width: 50px;text-align:center;"><strong>:</strong></td>
                <td>gagaga</td>
            </tr>
            <tr>
                <td style=" width: 200px;"><strong>Kecamatan </strong></td>
                <td style="width: 50px;text-align:center;"><strong>:</strong></td>
                <td>gagaga</td>
            </tr>
            <tr>
                <td style=" width: 200px;"><strong>Kabupaten </strong></td>
                <td style="width: 50px;text-align:center;"><strong>:</strong></td>
                <td>gagaga</td>
            </tr>
            <tr>
                <td style=" width: 200px;"><strong>Provinsi </strong></td>
                <td style="width: 50px;text-align:center;"><strong>:</strong></td>
                <td>gagaga</td>
            </tr>
            <tr>
                <td style=" width: 200px;"><strong>Kode Pos</strong></td>
                <td style="width: 50px;text-align:center;"><strong>:</strong></td>
                <td>gagaga</td>
            </tr>
            <tr>
                <td style=" width: 200px;"><strong>Tahun Ajar</strong></td>
                <td style="width: 50px;text-align:center;"><strong>:</strong></td>
                <td>gagaga</td>
            </tr>
        </tbody>
    </table>
    <br><br><br>
</div>



<div style="height: 1000px;"></div>
<!-- Halaman Identitas Siswa -->
<div class='container mt-5' style="color:black;">
    <div class=" text-center">
        <h2><strong>Rapor Peseta dan Profil Peserta Didik</strong></h2><br>
        <p style='text-align: left; width:30%; display: inline-block;'>Nama : fefefefe</p>
        <p style='text-align: right; width: 30%;  display: inline-block;'>Semester : fefefefe</p><br>
        <p style='text-align: left; width:30%; display: inline-block;'>NIS : fefefefe</p>
        <p style='text-align: right; width: 30%;  display: inline-block;'>Tahun : fefefefe</p><br>
        <p style='text-align: left; width:30%; display: inline-block;'>NISN : fefefefe</p>
        <p style='text-align: right; width: 30%;  display: inline-block;'>Kelas : fefefefe</p><br>
        <p style='text-align: right; width: 60%;  display: inline-block;'>Kode Raport : fefefefe</p><br><br>
    </div>
</div>

<div class='container'>
    <div class='col-md-3' style='margin-left: 200px;border-color: black;color:black'><br>
        <h5 style="text-align: left;"><strong>A. Sikap </strong></h5>
    </div>
    <br>
    <table class=' tg' style='table-layout: fixed; width: 790px; border-color: black;color:black'>
        <colgroup>
            <col style=' width: 10%'>
            <col style='width: 45%'>
            <col style='width: 55%'>
        </colgroup>
        <tr>
            <th class='tg-c3ow' colspan="3"><strong> Deskripsi</strong>
            </th>
        </tr>
        <tr>
            <td class='tg-baqh'>1</td>
            <td class='tg-c3ow'>Sikap Spriritual</td>
            <td class='tg-baqh'>oawfowa</td>

        </tr>
        <tr>
            <td class='tg-baqh'> 2 </td>
            <td class='tg-c3ow'>Sikap Sosial</td>
            <td class='tg-baqh'>oawfowa</td>
        </tr>
    </table>
    <br>
</div>
<div class='container'>
    <div class='col-md-6' style='margin-left: 200px;border-color: black;color:black'><br>
        <h5 style="text-align: left;"><strong>B. Pengetahuan dan Keterampilan <br> KKM = 70</strong></h5>
    </div>
    <br>
    <table class='tg' style='table-layout: fixed; width: 790px;border-color: black;color:black'>
        <colgroup>
            <col style='width: 40px'>
            <col style='width: 80px'>
            <col style='width: 80px'>
            <col style='width: 80px'>
        </colgroup>
        <tr>
            <th class='tg-s268' rowspan="2" style="vertical-align:middle; text-align:center;font-weight:bold">
                No
            </th>
            <th class='tg-s268' rowspan="2" style="vertical-align:middle; text-align:center;font-weight:bold">Mata
                Pelajaran
            </th>
            <th class='tg-s268' colspan="3" style="vertical-align:middle; text-align:center;font-weight:bold">
                Nilai Pengetahuan
            </th>
            <th class='tg-s268' colspan="3" style="vertical-align:middle; text-align:center;font-weight:bold">
                Nilai Ketrampilan
            </th>
        </tr>
        <tr>
            <!-- <td style="border-top:0px;"> </td>
            <td style="border-top:0px;"> </td> -->
            <th style='width: 80px;font-weight:bold'>Nilai</th>
            <th style='width: 80px;font-weight:bold'>Predikat</th>
            <th style='width: 150px;font-weight:bold'>Keterangan</th>
            <th style='width: 80px;font-weight:bold'>Nilai</th>
            <th style='width: 80px;font-weight:bold'>Predikat</th>
            <th style='width: 150px;font-weight:bold'>Keterangan</th>
        </tr>
        <tr>
            <td class='tg-0lax'>wowowo</td>
            <td class='tg-s268'>wowowo</td>
            <td class='tg-0lax'>wowowo</td>
            <td class='tg-0lax'>
            </td>
            <td class='tg-s268'>wppwwp</td>
            <td class='tg-0lax'>wppwwp</td>
            <td class='tg-0lax'></td>
            <td class='tg-s268'>wfwfw</td>
        </tr>
        <!-- <tr>
        <td colspan='2'>Jumlah Nilai </td>
        <td>120941</td>
        <td>120941</td>
        <td>120941</td>
        <td></td>
      </tr>
      <tr>
        <td colspan='2'>Nilai Rata-rata</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr> -->
        <div class='row'>
    </table>
</div>
<br>
</div>
<div class='container'>
    <div class='col-md-3' style='margin-left: 200px; border-color: black;color:black'><br>
        <h5 style="text-align: left;"><strong>C. Ekstra Kulikuler</strong></h5>
    </div>
    <br>
    <table class='tg' style='table-layout: fixed; width: 790px;border-color: black;color:black'>
        <colgroup>
            <col style='width: 10%'>
            <col style='width: 45%'>
            <col style='width: 45%'>
        </colgroup>
        <tr>
            <th class='tg-baqh' style="font-weight:bold">No</th>
            <th class='tg-c3ow' style="font-weight:bold">Jenis Pengembangan Diri</th>
            <th class='tg-baqh' style="font-weight:bold">Keterangan</th>
        </tr>
        <tr>
            <td class='tg-baqh'> 2p2p2p</td>
            <td class='tg-baqh'>2p2p2p</td>
            <td class='tg-baqh'>2p2p2p</td>
        </tr>
    </table>
    <br>
</div>
<div class='container'>
    <div class='col-md-3' style='margin-left: 200px;border-color: black;color:black'><br>
        <h5 style="text-align: left;"><strong>D. Saran- saran</strong></h5>
    </div>
    <br>
    <table class='tg' style='table-layout: fixed; width: 790px;height:auto; border-color: black;color:black'>
        <tr>
            <th class='tg-baqh' style="font-weight:bold">Saran</th>
        </tr>
        <tr>
            <td class='tg-textarea'>gggaegaesaran</td>
        </tr>
    </table>
    <br>
</div>


<div class='container'>
    <div class='col-md-3' style='margin-left: 200px; border-color: black;color:black'><br>
        <h5 style="text-align: left;"><strong>E. Tinggi dan Berat Badan</strong></h5>
    </div>
    <br>
    <table class='tg' style='table-layout: fixed; width: 790px; border-color: black;color:black'>
        <colgroup>
            <col style=' width: 10%'>
            <col style='width: 40%'>
            <col style='width: 25%'>
            <col style='width: 25%'>
        </colgroup>
        <tr>
        <tr>
            <th class='tg-s268' rowspan="2" style="vertical-align:middle; text-align:center;font-weight:bold">No
            </th>
            <th class='tg-s268' rowspan="2" style="vertical-align:middle; text-align:center;font-weight:bold">
                Aspek yang Dinilai
            </th>
            <th class='tg-s268' colspan="2" style="vertical-align:middle; text-align:center;font-weight:bold">
                Semester
            </th>
        </tr>
        <tr>
            <th style='width: 20px ; text-align:center;font-weight:bold'>1</th>
            <th style='width: 20px ; text-align:center;font-weight:bold'>2</th>
        </tr>
        <tr>
            <td class='tg-baqh'> 1</td>
            <td class='tg-c3ow'>Tinggi Badan ( cm )</td>
            <td class='tg-baqh'>180</td>
            <td class='tg-baqh'>180</td>
        </tr>
        <tr>
            <td class='tg-baqh'> 2</td>
            <td class='tg-baqh'>Berat ( kg ) </td>
            <td class='tg-baqh'>180</td>
            <td class='tg-baqh'>180</td>
        </tr>
    </table>
    <br>
</div>



<div class='container'>
    <div class='col-md-3' style='margin-left: 200px;border-color: black;color:black'><br>
        <h5 style="text-align: left;"><strong>F. Kondisi Kesehatan</strong></h5>
    </div>
    <br>
    <table class=' tg' style='table-layout: fixed; width: 790px; border-color: black;color:black'>
        <colgroup>
            <col style=' width: 10%'>
            <col style='width: 45%'>
            <col style='width: 55%'>
        </colgroup>
        <tr>
            <th class='tg-baqh' style="font-weight:bold">No</th>
            <th class='tg-c3ow' style="font-weight:bold">Aspek Fisik</th>
            <th class='tg-c3ow' style="font-weight:bold">Keterangan</th>
        </tr>
        <tr>
            <td class='tg-baqh'> 1</td>
            <td class='tg-c3ow'>Pendengaran</td>
            <td class='tg-baqh'>oowowo002</td>
        </tr>
        <tr>
            <td class='tg-baqh'> 2</td>
            <td class='tg-c3ow'>Penglihatan</td>
            <td class='tg-baqh'>oowowo002</td>
        </tr>
        <tr>
            <td class='tg-baqh'> 3 </td>
            <td class='tg-c3ow'>Gigi</td>
            <td class='tg-baqh'>oowowo002</td>
        </tr>
    </table>
    <br>
</div>

<div class='container'>
    <div class='col-md-3' style='margin-left: 200px;border-color: black;color:black'><br>
        <h5 style="text-align: left;"><strong>G. Prestasi</strong></h5>
    </div>
    <br>

    <table class=' tg' style='table-layout: fixed; width: 790px; border-color: black;color:black'>
        <colgroup>
            <col style=' width: 10%'>
            <col style='width: 45%'>
            <col style='width: 55%'>
        </colgroup>
        <tr>
            <th class='tg-baqh' style="font-weight:bold">No</th>
            <th class='tg-c3ow' style="font-weight:bold">Jenis Prestasi</th>
            <th class='tg-c3ow' style="font-weight:bold">Keterangan</th>
        </tr>
        <tr>
            <td class='tg-baqh'>1</td>
            <td class='tg-c3ow'>Kesenian</td>
            <td class='tg-baqh'>oowa0r221</td>
        </tr>
        <tr>
            <td class='tg-baqh'> 2 </td>
            <td class='tg-c3ow'>Olahraga</td>
            <td class='tg-baqh'>oowa0r221</td>
        </tr>
    </table>
    <br>
</div>



<div class='container ' style="width:100%">
    <div class='col-md-3' style='margin-left: 200px;border-color: black;color:black;width:50%'><br>
        <h5 style="text-align: left;"><strong>H. Ketidakhadiran</strong></h5>
    </div>
    <br>
    <table class='tg' style='table-layout: fixed; width: 50%; height: 150px;border-color: black;color:black'>
        <colgroup>
            <col style='width: 50px'>
            <col style='width: 200px'>
            <col style='width: 100px'>
        </colgroup>
        <tr>
            <th class='tg-c3ow' style="font-weight:bold">No</th>
            <th class='tg-c3ow' style="font-weight:bold">Alasan Ketidakhadiran</th>
            <th class='tg-baqh' style="font-weight:bold">Keterangan</th>
        </tr>
        <tr>
            <td class='tg-baqh'>1</td>
            <td class='tg-baqh'>Sakit</td>
            <td class='tg-baqh'> ooa2pr91</td>

        </tr>
        <tr>
            <td class='tg-baqh'>2</td>
            <td class='tg-baqh'>Izin</td>
            <td class='tg-baqh'>ooa2pr91</td>

        </tr>
        <tr>
            <td class='tg-baqh'>3</td>
            <td class='tg-baqh'>Tanpa Keterangan</td>
            <td class='tg-baqh'>ooa2pr91</td>
        </tr>
    </table>
    <br>
</div>
<div class='container'>
</div>
</div>
<br>
</div>
</div>
<div style="height: 50px;color:black"></div>
<table style="width:100%;color:black">
    <tr>
        <td style="width:50%; text-align:center">
            Mengetahui,<br>
            Orang Tua/Wali Murid<br>
            <br>
            <br>
            <br>
            (..............................................)
        </td>
        <td style="width:50%; text-align:center">
            Sragen, 101020120<br>
            Wali Kelas<br>
            <br>
            <br>
            <br>
            gawgaw <br>
            NIP. 9994634
        </td>
    </tr>
</table>
<table style="width:100%; color:black ">
    <tr>
        <td style="width:100%; text-align:center">
            Mengetahui,<br>
            Kepala Sekolah<br>
            <br>
            <br>
            <br>
            ArawAWr <br>
            NIP. 8325235
        </td>
    </tr>
</table>
</div>
</div>
</div>



<!-- Bootstrap core JavaScript-->
<script src="{{ asset('extensions/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('compiled/js/app.js') }}"></script>
<script type="text/javascript">
    window.onbeforeprint = function() {
        document.getElementById("tombolCetak").style.display = "none";
        document.getElementById("tombolKembali").style.display = "none";
    }
    window.onafterprint = function() {
        document.getElementById("tombolCetak").style.display = "none";
        document.getElementById("tombolKembali").style.display = "block";
    }
</script>
</body>

</html>
