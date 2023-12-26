<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PrestasiImport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PrestasiAjaxController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Mendapatkan roles dari user
        $roles = $user->getRoleNames();
        $data = Prestasi::orderBy('name', 'asc');
        $isAdmin = $user->hasRole('admin');

        return DataTables::of($data)
            ->addIndexColumn()
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
            ],
            [
                'name.required' => 'Nama wajib diisi',
            ],
        );

        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        } else {
            $data = [
                'name' => $request->name,
            ];
            // Membuat user baru
            $prestasi = Prestasi::create($data);

            // Memberikan role 'prestasi' pada prestasi yang baru dibuat
            return response()->json(['success' => 'Berhasil menyimpan data']);
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $data = Prestasi::where('id', $id)->first();
        return response()->json(['result' => $data]);
    }

    public function update(Request $request, string $id)
    {
        $data = [
            'name' => $request->name,
        ];

        Prestasi::where('id', $id)->update($data);
        return response()->json(['success' => 'Berhasil melakukan update data']);
    }

    public function destroy(string $id)
    {
        Prestasi::where('id', $id)->delete();
    }

    public function importPrestasi()
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

            // Simpan file ke penyimpanan 'Import Prestasi' dengan nama yang telah diubah
            Storage::disk('local')->putFileAs('Import Prestasi', $file, $filename);

            try {
                // Impor data menggunakan PrestasiImport
                Excel::import(new PrestasiImport, storage_path("app/Import Prestasi/{$filename}"));

                // Hapus file setelah diimpor
                // Storage::disk('local')->delete("Import prestasi/{$filename}");

                return redirect()->back()->with('success', 'Data imported successfully.');
            } catch (\Exception $e) {
                // Jika terjadi kesalahan saat impor, tangani kesalahan di sini
                Storage::disk('local')->delete("Import Prestasi/{$filename}"); // Hapus file jika impor gagal
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
            DB::table('prestasis')->delete();

            return response()->json(['success' => true, 'message' => 'All data deleted successfully.']);
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            return response()->json(['success' => false, 'message' => 'Failed to delete data: ' . $e->getMessage()]);
        }
    }
}
