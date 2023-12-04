<?php

namespace App\Http\Controllers;

use App\Models\JadwalMataPelajaran;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\TahunAjaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class JadwalMataPelajaranController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Mendapatkan roles dari user
        $roles = $user->getRoleNames();
        // Mendapatkan daftar user
        // Menentukan apakah user adalah admin
        $isAdmin = $user->hasRole('admin');
        $kelas=Kelas::all();
        $matpel=MataPelajaran::all();
        $tahunajaran=TahunAjaran::all();

        return view('admin.jadwalmatapelajaran.index', [
            'roles' => $roles,
            'isAdmin' => $isAdmin,
            'kelas' => $kelas,
            'matpel' => $matpel,
            'tahunajaran' => $tahunajaran,

        ]);
    }
}
