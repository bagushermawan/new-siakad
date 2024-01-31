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
    </style>
</head>

<body>
    <div class="rapot">
        <div class="header">
            <h1>Rapot Siswa</h1>
        </div>

        <div class="student-info">
            <h2>Informasi Siswa</h2>
            <p><strong>Nama:</strong> {{ $namaSantri }}</p>
            <p><strong>Kelas:</strong> {{ $kelasSantri }}</p>
            <!-- Tambahkan informasi lainnya sesuai kebutuhan -->
        </div>
        <table class="subject-table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Mata Pelajaran</th>
                    <th>Kelas</th>
                    <th>Tahun Ajaran</th>
                    <th>Nilai</th>
                    <th>Tahun Ajaran Semester</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{!! html_entity_decode($item['user_id']) !!}</td>
                        <td>{{ $item['mata_pelajaran_id'] ?: 'Data Mata Pelajaran tidak tersedia' }}</td>
                        <td>{{ $item['kelas_id'] }}</td>
                        <td>{{ $item['tahun_ajaran_id'] }}</td>
                        <td>{{ $item['nilai'] }}</td>
                        <td>{{ $item['tahun_ajaran_semester'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Sekolah XYZ</p>
        </div>
    </div>
</body>

</html>
