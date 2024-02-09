<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Spatie\Permission\Traits\HasRoles;

class SiswaImport implements ToModel
{
    use HasRoles;

    public function model(array $row)
    {
        $user = new User([
            'nisn' => $row[0],
            'tanggal_lahir' => $row[1],
            'name' => $row[2],
            'username' => $row[3],
            'email' => $row[4],
        ]);

        // Simpan user
        $user->save();

        // Setelah menyimpan user, berikan peran 'user'
        $user->assignRole('user');

        return $user;
    }
}
