<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use App\Models\User;

class UserImport implements ToModel

{
    public function model(array $row)
    {
        return new User([
            'nisn' => $row[0],
            'nuptk' => $row[1],
            'nohp' => $row[2],
            'name' => $row[3],
            'username' => $row[4],
            'email' => $row[5],
            // Sesuaikan dengan struktur file Excel Anda
        ]);
    }
}
