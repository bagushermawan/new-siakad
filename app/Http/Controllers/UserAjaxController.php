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
use Illuminate\Support\Facades\Storage;
use App\Models\WaliSantri;
use Illuminate\Support\Facades\DB;

class UserAjaxController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isAdmin = $user->hasRole('admin');

        $userData = User::select('id', 'name', 'username', 'email', 'nohp', 'created_at');
        $waliSantriData = WaliSantri::select('id', 'name', 'username', 'email', 'nohp', 'created_at');

        $unionData = $userData->unionAll($waliSantriData);

        $data = DB::table(DB::raw("({$unionData->toSql()}) as union_data"))
            ->mergeBindings($unionData->getQuery())
            ->leftJoin('model_has_roles', 'union_data.id', '=', 'model_has_roles.model_id')
            ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('union_data.id', 'union_data.name', 'union_data.username', 'union_data.email', 'union_data.nohp', 'union_data.created_at')
            ->addSelect(DB::raw('GROUP_CONCAT(DISTINCT roles.name) as roles'))
            ->groupBy('union_data.id', 'union_data.name', 'union_data.username', 'union_data.email', 'union_data.nohp', 'union_data.created_at')
            ->orderBy('union_data.name', 'asc')
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
                // Jika bukan admin, filter hanya user dengan role 'guru'
                $query->whereHas('roles', function ($q) {
                    $q->where('name', 'guru');
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

        return response()->json([
            'admin' => $adminCount,
            'guru' => $guruCount,
            'user' => $userCount,
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
                'username' => ['required', 'string', 'max:255', 'unique:users,username', 'alpha_num'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', Rules\Password::defaults()],
                'kelas_id' => ['nullable', 'exists:kelas,id'],
            ],
            [
                'name.required' => 'Nama wajib diisi',
                'username.required' => 'Username wajib diisi',
                'email.required' => 'Email wajib diisi',
                'password.required' => 'Password wajib diisi',
                'kelas_id.exists' => 'Kelas tidak valid',
            ],
        );

        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        } else {
            $data = [
                'nohp' => $request->nohp,
                'nisn' => $request->nisn,
                'nuptk' => $request->nuptk,
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'kelas_id' => $request->kelas_id,
                'role' => $request->role,
                'password' => Hash::make($request->password),
                'email_verified_at' => Carbon::now(),
            ];

            // Membuat user baru
            // print_r($request->role);
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
        $data = User::where('id', $id)->first();
        $role = $data->getRoleNames();
        return response()->json(['result' => $data, 'role' => $role]);
    }

    public function update(Request $request, string $id)
    {
        $data = [
            'nisn' => $request->nisn,
            'nuptk' => $request->nuptk,
            'nohp' => $request->nohp,
            'name' => $request->name,
            'username' => $request->username,
            'kelas_id' => $request->kelas_id,
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
}
