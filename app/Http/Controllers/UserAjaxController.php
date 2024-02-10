<?php

namespace App\Http\Controllers;

use App\Imports\GuruImport;
use App\Imports\SiswaImport;
use App\Models\User;
use App\Models\Kelas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UserImport;
use App\Imports\WaliImport;
use Illuminate\Support\Facades\Storage;
use App\Models\WaliSantri;
use Illuminate\Support\Facades\DB;

class UserAjaxController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isAdmin = $user->hasRole('admin');

        $userData = User::select('id', 'name', 'username', 'email', 'nohp', 'created_at', 'user_type', 'foto_user');
        $waliSantriData = WaliSantri::select('id', 'name', 'username', 'email', 'nohp', 'created_at', 'user_type', 'foto_user');

        $unionData = $userData->unionAll($waliSantriData);

        // asc name
        // $data = DB::table(DB::raw("({$unionData->toSql()}) as union_data"))
        //     ->mergeBindings($unionData->getQuery())
        //     ->leftJoin('model_has_roles', 'union_data.id', '=', 'model_has_roles.model_id')
        //     ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
        //     ->select('union_data.id', 'union_data.name', 'union_data.username', 'union_data.email', 'union_data.nohp', 'union_data.created_at')
        //     ->addSelect(DB::raw('GROUP_CONCAT(DISTINCT roles.name) as role'))
        //     ->groupBy('union_data.id', 'union_data.name', 'union_data.username', 'union_data.email', 'union_data.nohp', 'union_data.created_at')
        //     ->orderBy('union_data.name', 'asc')
        //     ->get();

        // acs role name
        $data = DB::table(DB::raw("({$unionData->toSql()}) as union_data"))
            ->mergeBindings($unionData->getQuery())
            ->leftJoin('model_has_roles', 'union_data.id', '=', 'model_has_roles.model_id')
            ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('union_data.id', 'union_data.name', 'union_data.username', 'union_data.email', 'union_data.nohp', 'union_data.created_at', 'union_data.user_type', 'union_data.foto_user', 'roles.name as role')
            ->groupBy('union_data.id', 'union_data.name', 'union_data.username', 'union_data.email', 'union_data.nohp', 'union_data.created_at', 'union_data.user_type', 'union_data.foto_user', 'roles.name') // Sertakan 'roles.name' dalam GROUP BY
            ->orderBy('roles.name', 'asc') // Urutkan berdasarkan 'roles.name' secara ascending
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($data) use ($isAdmin) {
                return view('admin.tombol', ['data' => $data, 'isAdmin' => $isAdmin]);
            })
            ->make(true);
    }

    public function indexGuru()
    {
        $user = Auth::user();
        $roles = $user->getRoleNames();
        $isAdmin = $user->hasRole('admin');

        $data = User::with('roles')
            ->when(function ($query) {
                $query->whereHas('roles', function ($q) {
                    $q->whereIn('name', ['guru', 'wali kelas']);
                });
            })
            ->orderBy('name', 'asc');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($data) use ($isAdmin) {
                return view('admin.tombol', ['data' => $data, 'isAdmin' => $isAdmin]);
            })
            ->make(true);
    }

    public function getSantriOptions()
    {
        $santriOptions = User::with(['roles'])
            ->whereHas('roles', function ($q) {
                $q->where('name', 'user');
            })
            ->orderBy('name', 'asc')
            ->get(['id', 'name']);

        return response()->json($santriOptions);
    }

    public function getSantriInfo($id)
    {
        // function for modal santri_id at wali
        $santri = User::with('kelas')->findOrFail($id);

        // Kembalikan informasi santri dalam format JSON
        return response()->json($santri);
    }

    public function getWaliKelasInfo($id)
    {
        // function for modal santri_id at wali
        $guru = User::with('kelas')->findOrFail($id);

        // Kembalikan informasi santri dalam format JSON
        return response()->json($guru);
    }

    public function indexSiswa()
    {
        $user = Auth::user();
        $roles = $user->getRoleNames();
        $isAdmin = $user->hasRole('admin');

        $data = User::with(['roles', 'kelas'])
            ->orderBy('name', 'asc')
            ->when(function ($query) {
                $query->whereHas('roles', function ($q) {
                    $q->where('name', 'user');
                });
            })
            ->orderBy('name', 'asc');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('kelas_name', function ($data) {
                return $data->kelas->name ?? ''; // Pastikan menangani kasus jika tidak ada kelas terkait
            })
            ->addColumn('aksi', function ($data) use ($isAdmin) {
                return view('admin.tombol', ['data' => $data, 'isAdmin' => $isAdmin]);
            })
            ->make(true);
    }

    public function getUserRoleCountChartjs()
    {
        $adminCount = User::role('admin')->count();
        $guruCount = User::role('guru')->count();
        $userCount = User::role('user')->count();
        $waliCount = WaliSantri::count();

        return response()->json([
            'series' => [$adminCount, $guruCount, $userCount, $waliCount],
            'labels' => ['Admin', 'Guru', 'User', 'Wali'],
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validasi = Validator::make(
            $request->all(),
            [
                'name' => ['required', 'string', 'max:255'],
                'status_siswa' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['nullable', Rules\Password::defaults()],
                'kelas_id' => ['nullable', 'exists:kelas,id'],
                'tanggal_lahir' => ['nullable', 'date'],
            ],
            [
                'name.required' => 'Nama wajib diisi',
                'status_siswa.required' => 'Status santri wajib diisi',
                'email.required' => 'Email wajib diisi',
                'password.required' => 'Password wajib diisi',
                'kelas_id.exists' => 'Kelas tidak valid',
                'tanggal_lahir.date' => 'Format tanggal_lahir tidak valid',
            ],
        );

        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        } else {
            $username = $request->username;
            $nameParts = explode(' ', $request->name);
            $namePart1 = $nameParts[0];
            $namePart2 = count($nameParts) > 1 ? $nameParts[1] : null;

            if (count($nameParts) === 1) {
                $username = strtolower(str_replace('.', '', $namePart1)) . rand(10, 99);
            } else {
                $username = strtolower(str_replace('.', '', $namePart1 . $namePart2));
            }

            $data = [
                'nohp' => $request->nohp,
                'nisn' => $request->nisn,
                'nis' => $request->nis,
                'nuptk' => $request->nuptk,
                'name' => $request->name,
                'username' => $username,
                'tanggal_lahir' => $request->tanggal_lahir,
                'email' => $request->email,
                'kelas_id' => $request->kelas_id,
                'status_siswa' => $request->status_siswa,
                'role' => $request->role,
                'password' => $request->password ? Hash::make($request->password) : Hash::make($username),
                'email_verified_at' => Carbon::now(),
            ];

            $user = User::create($data);
            $user->assignRole($request->role);

            return response()->json(['success' => 'Berhasil menyimpan data']);
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        // Cek apakah data berasal dari tabel User atau WaliSantri
        $userData = User::find($id);
        $waliSantriData = WaliSantri::find($id);

        if ($userData) {
            $data = $userData;
            $role = $userData->getRoleNames();
        } elseif ($waliSantriData) {
            $data = $waliSantriData;
            $role = $waliSantriData->getRoleNames();
        } else {
            // Data tidak ditemukan
            return response()->json(['error' => 'Data not found'], 404);
        }

        return response()->json(['result' => $data, 'role' => $role]);
    }

    public function update(Request $request, string $id)
    {
        $data = [
            'nisn' => $request->nisn,
            'nis' => $request->nis,
            'nuptk' => $request->nuptk,
            'nohp' => $request->nohp,
            'name' => $request->name,
            'username' => $request->username,
            'tanggal_lahir' => $request->tanggal_lahir,
            'kelas_id' => $request->kelas_id,
            'status_siswa' => $request->status_siswa,
            'email' => $request->email,
        ];

        // Check if the password field is filled
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Update user data
        User::where('id', $id)->update($data);

        // Update roles
        if ($request->filled('role')) {
            $user = User::findOrFail($id);

            // Remove existing roles
            $user->roles()->detach();

            // Add new roles
            $user->assignRole($request->role);
        }

        return response()->json(['success' => 'Berhasil melakukan update data']);
    }

    public function destroy(string $id)
    {
        User::where('id', $id)->delete();
    }

    public function importAlluser()
    {
        // Pastikan file ada sebelum melanjutkan
        if (request()->hasFile('excel_file')) {
            $file = request()->file('excel_file');

            // Dapatkan timestamp saat ini
            $timestamp = time();

            // Dapatkan nama asli file
            $originalName = $file->getClientOriginalName();

            // Ubah nama file dengan menambahkan timestamp
            $filename = pathinfo($originalName, PATHINFO_FILENAME) . "_{$timestamp}." . $file->getClientOriginalExtension();

            // Simpan file ke penyimpanan 'Import User' dengan nama yang telah diubah
            Storage::disk('local')->putFileAs('Import User', $file, $filename);

            try {
                // Impor data menggunakan UserImport
                Excel::import(new UserImport(), storage_path("app/Import User/{$filename}"));

                // Hapus file setelah diimpor
                // Storage::disk('local')->delete("Import User/{$filename}");

                return redirect()
                    ->back()
                    ->with('success', 'Data imported successfully.');
            } catch (\Exception $e) {
                // Jika terjadi kesalahan saat impor, tangani kesalahan di sini
                Storage::disk('local')->delete("Import User/{$filename}"); // Hapus file jika impor gagal
                return redirect()
                    ->back()
                    ->with('error', 'Error during import: ' . $e->getMessage());
            }
        }

        return redirect()
            ->back()
            ->with('error', 'No file selected.');
    }

    public function importGuru()
    {
        // Pastikan file ada sebelum melanjutkan
        if (request()->hasFile('excel_file')) {
            $file = request()->file('excel_file');

            // Dapatkan timestamp saat ini
            $timestamp = time();

            // Dapatkan nama asli file
            $originalName = $file->getClientOriginalName();

            // Ubah nama file dengan menambahkan timestamp
            $filename = pathinfo($originalName, PATHINFO_FILENAME) . "_{$timestamp}." . $file->getClientOriginalExtension();

            // Simpan file ke penyimpanan 'Import User' dengan nama yang telah diubah
            Storage::disk('local')->putFileAs('Import Guru', $file, $filename);

            try {
                // Impor data menggunakan UserImport
                Excel::import(new GuruImport(), storage_path("app/Import Guru/{$filename}"));

                // Hapus file setelah diimpor
                // Storage::disk('local')->delete("Import User/{$filename}");

                return redirect()
                    ->back()
                    ->with('success', 'Data imported successfully.');
            } catch (\Exception $e) {
                // Jika terjadi kesalahan saat impor, tangani kesalahan di sini
                Storage::disk('local')->delete("Import Guru/{$filename}"); // Hapus file jika impor gagal
                return redirect()
                    ->back()
                    ->with('error', 'Error during import: ' . $e->getMessage());
            }
        }

        return redirect()
            ->back()
            ->with('error', 'No file selected.');
    }

    public function importSiswa()
    {
        // Pastikan file ada sebelum melanjutkan
        if (request()->hasFile('excel_file')) {
            $file = request()->file('excel_file');

            // Dapatkan timestamp saat ini
            $timestamp = time();

            // Dapatkan nama asli file
            $originalName = $file->getClientOriginalName();

            // Ubah nama file dengan menambahkan timestamp
            $filename = pathinfo($originalName, PATHINFO_FILENAME) . "_{$timestamp}." . $file->getClientOriginalExtension();

            // Simpan file ke penyimpanan 'Import User' dengan nama yang telah diubah
            Storage::disk('local')->putFileAs('Import Siswa', $file, $filename);

            try {
                // Impor data menggunakan UserImport
                Excel::import(new SiswaImport(), storage_path("app/Import Siswa/{$filename}"));

                // Hapus file setelah diimpor
                // Storage::disk('local')->delete("Import User/{$filename}");

                return redirect()
                    ->back()
                    ->with('success', 'Data imported successfully.');
            } catch (\Exception $e) {
                // Jika terjadi kesalahan saat impor, tangani kesalahan di sini
                Storage::disk('local')->delete("Import Siswa/{$filename}"); // Hapus file jika impor gagal
                return redirect()
                    ->back()
                    ->with('error', 'Error during import: ' . $e->getMessage());
            }
        }

        return redirect()
            ->back()
            ->with('error', 'No file selected.');
    }

    public function importWali()
    {
        // Pastikan file ada sebelum melanjutkan
        if (request()->hasFile('excel_file')) {
            $file = request()->file('excel_file');

            // Dapatkan timestamp saat ini
            $timestamp = time();

            // Dapatkan nama asli file
            $originalName = $file->getClientOriginalName();

            // Ubah nama file dengan menambahkan timestamp
            $filename = pathinfo($originalName, PATHINFO_FILENAME) . "_{$timestamp}." . $file->getClientOriginalExtension();

            // Simpan file ke penyimpanan 'Import User' dengan nama yang telah diubah
            Storage::disk('local')->putFileAs('Import Wali', $file, $filename);

            try {
                // Impor data menggunakan UserImport
                Excel::import(new WaliImport(), storage_path("app/Import Wali/{$filename}"));

                // Hapus file setelah diimpor
                // Storage::disk('local')->delete("Import User/{$filename}");

                return redirect()
                    ->back()
                    ->with('success', 'Data imported successfully.');
            } catch (\Exception $e) {
                // Jika terjadi kesalahan saat impor, tangani kesalahan di sini
                Storage::disk('local')->delete("Import Wali/{$filename}"); // Hapus file jika impor gagal
                return redirect()
                    ->back()
                    ->with('error', 'Error during import: ' . $e->getMessage());
            }
        }

        return redirect()
            ->back()
            ->with('error', 'No file selected.');
    }

    public function deleteAllUser()
    {
        try {
            User::role('user')->delete();

            return response()->json(['success' => true, 'message' => 'All users with role "user" deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete users: ' . $e->getMessage()]);
        }
    }

    public function deleteAllGuru()
    {
        try {
            User::role('guru')->delete();

            return response()->json(['success' => true, 'message' => 'All users with role "guru" deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete users: ' . $e->getMessage()]);
        }
    }
}
