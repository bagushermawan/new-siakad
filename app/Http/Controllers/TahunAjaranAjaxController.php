<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class TahunAjaranAjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        // Mendapatkan roles dari user
        $roles = $user->getRoleNames();
        $data = TahunAjaran::orderBy('name', 'asc');
        $isAdmin = $user->hasRole('admin');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($data) use ($isAdmin) {
                return view('admin.tahunajaran.tombol', ['data' => $data, 'isAdmin' => $isAdmin]);
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validasi = Validator::make(
            $request->all(),
            [
                'name' => ['required', 'string', 'max:255'],
                'semester' => ['required', 'string', 'max:255'],
                'dateRange' => ['required', 'string'], // Validasi untuk input dateRange
                'status' => ['required', 'string', 'max:255'],
            ],
            [
                'name.required' => 'Tahun ajaran wajib diisi',
                'semester.required' => 'Semester wajib diisi',
                'dateRange.required' => 'Rentang tanggal wajib diisi',
                'status.required' => 'Status wajib diisi',
            ],
        );

        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        } else {
            // Memisahkan tanggal mulai dan selesai dari rentang dateRange
            $dateRangeArray = explode(' to ', $request->dateRange);

            // Memeriksa apakah array memiliki setidaknya dua elemen
            if (count($dateRangeArray) >= 2) {
                [$mulai, $selesai] = $dateRangeArray;

                // Mengonversi tanggal menjadi objek Carbon
                $mulai = Carbon::parse($mulai);
                $selesai = Carbon::parse($selesai);

                $data = [
                    'name' => $request->name,
                    'semester' => $request->semester,
                    'mulai' => $mulai,
                    'selesai' => $selesai,
                    'status' => $status,
                ];

                // Membuat tahun ajaran baru
                $tahunAjaran = TahunAjaran::create($data);

                return response()->json(['success' => 'Berhasil menyimpan data', 'data' => $tahunAjaran]);
            } else {
                return response()->json(['errors' => ['dateRange' => 'Format rentang tanggal tidak valid']]);
            }
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $data = TahunAjaran::where('id', $id)->first();
        return response()->json(['result' => $data]);
    }

    public function update(Request $request, string $id)
    {
        $data = [
            'name' => ['required', 'string', 'max:255'],
            'semester' => ['required', 'string', 'max:255'],
            'dateRange' => ['required', 'string'],
            'status' => ['required', 'string', 'max:255'],
        ];
        $dateRangeArray = explode(' to ', $request->dateRange);

        // Memeriksa apakah array memiliki setidaknya dua elemen
        if (count($dateRangeArray) >= 2) {
            [$mulai, $selesai] = $dateRangeArray;

            // Mengonversi tanggal menjadi objek Carbon
            $mulai = Carbon::parse($mulai);
            $selesai = Carbon::parse($selesai);

            $data = [
                'name' => $request->name,
                'semester' => $request->semester,
                'mulai' => $mulai,
                'selesai' => $selesai,
                'status' => $request->status,
            ];

            // Membuat tahun ajaran baru
            $tahunAjaran = TahunAjaran::where('id', $id)->update($data);

            return response()->json(['success' => 'Berhasil melakukan update data', 'data' => $tahunAjaran]);
        } else {
            return response()->json(['errors' => ['dateRange' => 'Format rentang tanggal tidak valid']]);
        }
    }

    public function destroy(string $id)
    {
        TahunAjaran::where('id', $id)->delete();
    }

    public function deleteAll()
    {
        try {
            // Tambahkan logika penghapusan data di sini
            // Contoh: Hapus semua data dari tabel 'users'
            DB::table('tahun_ajarans')->delete();

            return response()->json(['success' => true, 'message' => 'All data deleted successfully.']);
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            return response()->json(['success' => false, 'message' => 'Failed to delete data: ' . $e->getMessage()]);
        }
    }
}
