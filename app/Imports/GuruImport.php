<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\User;
use Spatie\Permission\Traits\HasRoles;

class GuruImport implements ToModel
{
    use HasRoles;

    public function model(array $row)
    {
        $user = new User([
            'nuptk' => $row[0],
            'nohp' => $row[1],
            'name' => $row[2],
            'username' => $row[3],
            'email' => $row[4],
        ]);

        // Simpan user
        $user->save();

        // Setelah menyimpan user, berikan peran 'guru'
        $user->assignRole('guru');

        return $user;
    }
}
