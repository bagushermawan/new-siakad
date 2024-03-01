<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raport</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .rapot {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .student-info {
            margin-bottom: 20px;
        }

        .subject-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .subject-table th,
        .subject-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .footer {
            text-align: center;
        }

        /* Styling untuk row */
        .row::after {
            content: "";
            clear: both;
            display: table;
        }

        /* Styling untuk col-md-6 */
        .col-md-6 {
            float: left;
            width: 50%;
            padding: 0 15px;
            /* Sesuaikan dengan padding default Bootstrap */
            box-sizing: border-box;
        }

        /* Clearfix untuk mengatasi float */
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        /* Styling untuk .table */
        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
            border-collapse: collapse;
        }

        /* Styling untuk .table-striped */
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }

        /* Styling untuk .table th dan .table td */
        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
            text-align: left;
        }

        /* Styling untuk .table thead th */
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        /* Styling untuk .table tbody + tbody */
        .table tbody,
        .table tfoot {
            border-top: 2px solid #dee2e6;
        }
    </style>
</head>

<body>
    <div class="rapot">
        <div class="header">
            <h1>Rapot Santri</h1>
        </div>

        <div class="student-info">
            <h2>Informasi Santri</h2>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>NISN:</strong> {{ $nisnSantri }}</p>
                    <p><strong>Nama:</strong> {{ $namaSantri }}</p>
                    <p><strong>No HP:</strong> {{ $nohpSantri }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Tahun Ajaran:</strong> {{ $thaktif }}</p>
                    <p><strong>Kelas:</strong> {{ $kelasSantri }}</p>
                    {{-- <p><strong>Semester:</strong> {{ $thaktif }}</p> --}}
                </div>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nama Santri</th>
                    <th>Mata Pelajaran</th>
                    <th>Kelas</th>
                    {{-- <th>Tahun Ajaran</th> --}}
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{!! html_entity_decode($item['user_id']) !!}</td>
                        <td>{{ $item['mata_pelajaran_id'] ?: 'Data Mata Pelajaran tidak tersedia' }}</td>
                        <td>{{ $item['kelas_id'] }}</td>
                        {{-- <td>{{ $item['tahun_ajaran_id'] }}</td> --}}
                        <td>{{ $item['nilai'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Pondok Pesantren Darunnajah</p>
        </div>
    </div>
</body>

</html>
