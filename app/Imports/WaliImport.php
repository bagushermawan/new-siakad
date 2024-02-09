<?php

namespace App\Imports;

use App\Models\WaliSantri;
use Maatwebsite\Excel\Concerns\ToModel;
use Spatie\Permission\Traits\HasRoles;

class WaliImport implements ToModel
{
    use HasRoles;
    public function model(array $row)
    {
        $wali = new WaliSantri([
            'name' => $row[0],
            'username' => $row[1],
            'nik' => $row[2],
            'tanggal_lahir' => $row[3],
            'alamat' => $row[4],
            'nohp' => $row[5],
            'email' => $row[6],
        ]);

        // Simpan wali
        $wali->save();

        // Setelah menyimpan wali, berikan peran 'wali'
        $wali->assignRole('wali santri');

        return $wali;
    }
}
