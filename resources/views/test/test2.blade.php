<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapot Siswa</title>
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

        .subject-table th, .subject-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .footer {
            text-align: center;
        }
    </style>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
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
                    <p><strong>NISN:</strong> awfawgp>
                    <p><strong>Nama:</strong> awfawgp>
                    <p><strong>No HP:</strong> awfawgp>
                </div>
                <div class="col-md-6">
                    <p><strong>Tahun Ajaran:</strong> awfawg</p>
                    <p><strong>Kelas:</strong> awfawgp>
                    <p><strong>Semester:</strong> awfawg</p>
                </div>
            </div>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Mata Pelajaran</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                    <tr>
                        <td>math</td>
                        <td>55</td>
                    </tr>
                    <tr>
                        <td>math</td>
                        <td>55</td>
                    </tr>
                    <tr>
                        <td>math</td>
                        <td>55</td>
                    </tr>
                    <tr>
                        <td>math</td>
                        <td>55</td>
                    </tr>
            </tbody>
        </table>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Sekolah XYZ</p>
        </div>
    </div>
</body>
</html>
