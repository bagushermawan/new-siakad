<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raport</title>
</head>
<body>
    <h1>Raport</h1>

    <!-- Tambahkan link atau tombol untuk membuka PDF di tab baru -->
    <a href="{{ route('show.pdf', ['pdf_path' => $pdf_path]) }}" target="_blank">Buka PDF di Tab Baru</a>

    <table border="1">
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
</body>
</html>
