<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use App\Models\Kelas;

class KelasImport implements ToModel
{
    public function model(array $row)
    {
        return new Kelas([
            'name' => $row[0],
            // Sesuaikan dengan struktur file Excel Anda
        ]);
    }
}
