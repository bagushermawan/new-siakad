<?php

namespace App\Http\Controllers;

use App\Models\Ekskul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EkskulImport;
use Illuminate\Support\Facades\Storage;

class EkskulAjaxController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Mendapatkan roles dari user
        $roles = $user->getRoleNames();
        // Mendapatkan daftar user
        // Menentukan apakah user adalah admin
        $isAdmin = $user->hasRole('admin');
        $total_ekskul = Ekskul::count();

        return view('admin.ekskul.index', ['roles' => $roles, 'isAdmin' => $isAdmin, 'total_ekskul' => $total_ekskul]);
    }

    public function indexEkskul()
    {
        $user = Auth::user();
        // Mendapatkan roles dari user
        $roles = $user->getRoleNames();
        $data = Ekskul::orderBy('name', 'asc');
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
            $ekskul = Ekskul::create($data);

            // Memberikan role 'ekskul' pada ekskul yang baru dibuat
            return response()->json(['success' => 'Berhasil menyimpan data ekskul']);
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $data = Ekskul::where('id', $id)->first();
        return response()->json(['result' => $data]);
    }

    public function update(Request $request, string $id)
    {
        $data = [
            'name' => $request->name,
        ];

        Ekskul::where('id', $id)->update($data);
        return response()->json(['success' => 'Berhasil melakukan update data']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Ekskul::where('id', $id)->delete();
    }

    public function importEkskul()
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

            // Simpan file ke penyimpanan 'Import Ekskul' dengan nama yang telah diubah
            Storage::disk('local')->putFileAs('Import Ekskul', $file, $filename);

            try {
                // Impor data menggunakan EkskulImport
                Excel::import(new EkskulImport(), storage_path("app/Import Ekskul/{$filename}"));

                // Hapus file setelah diimpor
                // Storage::disk('local')->delete("Import ekskul/{$filename}");

                return redirect()
                    ->back()
                    ->with('success', 'Data imported successfully.');
            } catch (\Exception $e) {
                // Jika terjadi kesalahan saat impor, tangani kesalahan di sini
                Storage::disk('local')->delete("Import Ekskul/{$filename}"); // Hapus file jika impor gagal
                return redirect()
                    ->back()
                    ->with('error', 'Error during import: ' . $e->getMessage());
            }
        }

        return redirect()
            ->back()
            ->with('error', 'No file selected.');
    }

    public function deleteAll()
    {
        try {
            // Tambahkan logika penghapusan data di sini
            // Contoh: Hapus semua data dari tabel 'users'
            DB::table('ekskuls')->delete();

            return response()->json(['success' => true, 'message' => 'All data deleted successfully.']);
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            return response()->json(['success' => false, 'message' => 'Failed to delete data: ' . $e->getMessage()]);
        }
    }
}
