<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Ekskul;

class EkskulImport implements ToModel
{
    public function model(array $row)
    {
        return new Ekskul([
            'name' => $row[0],
            // Sesuaikan dengan struktur file Excel Anda
        ]);
    }
}
