<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\KelasImport;
use Illuminate\Support\Facades\Storage;

class KelasAjaxController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $roles = $user->getRoleNames();
        $isAdmin = $user->hasRole('admin');
        $total_kelas=Kelas::count();

        // Mengambil daftar guru
        $walikelas = User::whereHas('roles', function ($query) {
            $query->where('name', 'guru');
        })->get();

        return view('admin.kelas.index', [
            'roles' => $roles,
            'isAdmin' => $isAdmin,
            'walikelas' => $walikelas, // Menyertakan daftar guru ke dalam view
            'total_kelas' => $total_kelas,
        ]);
    }

    public function indexKelas()
    {
        $user = Auth::user();
        $isAdmin = $user->hasRole('admin');

        $data = Kelas::select(['kelas.*', DB::raw('COUNT(users.id) as users_count')])
            ->leftJoin('users', 'kelas.id', '=', 'users.kelas_id')
            ->groupBy('kelas.id')
            ->orderBy('name', 'asc');

        if (!$isAdmin) {
            $data->where(function ($query) {
                $query
                    ->whereHas('users', function ($subquery) {
                        $subquery->whereHas('roles', function ($rolesQuery) {
                            $rolesQuery->where('name', 'guru');
                        });
                    })
                    ->orWhereNull('users.id');
            });
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('users_count', function ($data) {
                return $data->users_count ?? 0;
            })
            ->addColumn('walikelas_info', function ($data) {
                $walikelas = $data->walikelas;

                if ($walikelas) {
                    // If "walikelas" is available, return both ID and name
                    return ['id' => $walikelas->id, 'name' => $walikelas->name];
                } else {
                    // If "walikelas" is not available, return null
                    return null;
                }
            })
            ->addColumn('aksi', function ($data) use ($isAdmin) {
                return view('admin.tombol', ['data' => $data, 'isAdmin' => $isAdmin]);
            })
            ->make(true);
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
                'walikelas_id' => ['nullable', 'exists:users,id'],
            ],
            [
                'name.required' => 'Nama wajib diisi',
                // 'walikelas_id.exists' => 'Wali kelas tidak valid',
            ],
        );

        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        } else {
            $data = [
                'name' => $request->name,
                'walikelas_id' => $request->walikelas_id,
                'event' => $request->event,
            ];
            // Membuat user baru
            $kelas = Kelas::create($data);

            // Memberikan role 'kelas' pada kelas yang baru dibuat
            return response()->json(['success' => 'Berhasil menyimpan data']);
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $data = Kelas::where('id', $id)->first();
        return response()->json(['result' => $data]);
    }

    public function update(Request $request, string $id)
    {
        $data = [
            'name' => $request->name,
            'walikelas_id' => $request->walikelas_id,
            'event' => $request->event,
        ];

        Kelas::where('id', $id)->update($data);
        return response()->json(['success' => 'Berhasil melakukan update data']);
    }

    public function destroy(string $id)
    {
        Kelas::where('id', $id)->delete();
    }

    public function importKelas()
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

            // Simpan file ke penyimpanan 'Import Kelas' dengan nama yang telah diubah
            Storage::disk('local')->putFileAs('Import Kelas', $file, $filename);

            try {
                // Impor data menggunakan KelasImport
                Excel::import(new KelasImport, storage_path("app/Import Kelas/{$filename}"));

                // Hapus file setelah diimpor
                // Storage::disk('local')->delete("Import kelas/{$filename}");

                return redirect()->back()->with('success', 'Data imported successfully.');
            } catch (\Exception $e) {
                // Jika terjadi kesalahan saat impor, tangani kesalahan di sini
                Storage::disk('local')->delete("Import Kelas/{$filename}"); // Hapus file jika impor gagal
                return redirect()->back()->with('error', 'Error during import: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('error', 'No file selected.');
    }

    public function deleteAll()
    {
        try {
            // Tambahkan logika penghapusan data di sini
            // Contoh: Hapus semua data dari tabel 'users'
            DB::table('kelas')->delete();

            return response()->json(['success' => true, 'message' => 'All data deleted successfully.']);
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            return response()->json(['success' => false, 'message' => 'Failed to delete data: ' . $e->getMessage()]);
        }
    }
}
