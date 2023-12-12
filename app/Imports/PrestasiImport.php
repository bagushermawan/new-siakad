<?php

namespace App\Imports;

use App\Models\Prestasi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;

class PrestasiImport implements ToModel
{
    public function model(array $row)
    {
        return new Prestasi([
            'name' => $row[0],
            // Sesuaikan dengan struktur file Excel Anda
        ]);
    }
}
