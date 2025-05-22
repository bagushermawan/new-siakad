<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfilePondok;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilePondokAjaxController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Mendapatkan roles dari user
        $roles = $user->getRoleNames();
        // Mendapatkan daftar user
        // Menentukan apakah user adalah admin
        $isAdmin = $user->hasRole('admin');
        $a = ProfilePondok::first();

        return view('admin.profilepondok.index', ['roles' => $roles, 'isAdmin' => $isAdmin, 'a' => $a]);
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima dari formulir
        $request->validate([
            'nama_pondok' => 'required|string|max:255',
            'kepala_pondok' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'deskripsi' => 'nullable|string',
            'visi_misi' => 'nullable|string',
            'foto_pondok' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // tambahkan aturan validasi untuk bidang lainnya
        ]);

        // Ambil ID dari formulir (jika ada)
        $id = $request->input('id');

        // Jika ada ID, lakukan pembaruan data
        if ($id) {
            $profilePondok = ProfilePondok::find($id);

            if ($profilePondok) {
                // Lakukan proses pembaruan data di sini
                $profilePondok->update([
                    // Atur kolom-kolom yang ingin diperbarui
                    'nama_pondok' => $request->input('nama_pondok'),
                    'kepala_pondok' => $request->input('kepala_pondok'),
                    'alamat' => $request->input('alamat'),
                    'telepon' => $request->input('telepon'),
                    'email' => $request->input('email'),
                    'deskripsi' => $request->input('deskripsi'),
                    'visi_misi' => $request->input('visi_misi'),
                    // tambahkan kolom lainnya sesuai kebutuhan
                ]);

                // Proses gambar jika diunggah
                if ($request->hasFile('foto_pondok')) {
                    // Hapus gambar lama (jika ada)
                    if ($profilePondok->foto_pondok) {
                        Storage::delete($profilePondok->foto_pondok);
                    }

                    // Simpan gambar baru
                    $fotoPath = $request->file('foto_pondok')->store('foto_pondok', 'public');
                    $profilePondok->update(['foto_pondok' => $fotoPath]);
                }

                return response()->json([
                    'nama_pondok' => $profilePondok->nama_pondok,
                    'kepala_pondok' => $profilePondok->kepala_pondok,
                    'alamat' => $profilePondok->alamat,
                    'telepon' => $profilePondok->telepon,
                    'email' => $profilePondok->email,
                    'deskripsi' => $profilePondok->deskripsi,
                    'visi_misi' => $profilePondok->visi_misi,
                    'foto_pondok' => asset('storage/' . $profilePondok->foto_pondok),
                    'message' => 'Data berhasil diperbarui'], 200);
            } else {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }
        }

        // Jika tidak ada ID, lakukan proses penyimpanan baru
        $profilePondok = new ProfilePondok([
            'nama_pondok' => $request->input('nama_pondok'),
            'kepala_pondok' => $request->input('kepala_pondok'),
            'alamat' => $request->input('alamat'),
            'telepon' => $request->input('telepon'),
            'email' => $request->input('email'),
            'deskripsi' => $request->input('deskripsi'),
            'visi_misi' => $request->input('visi_misi'),
            // tambahkan bidang lainnya sesuai kebutuhan
        ]);

        // Simpan data ke database
        $profilePondok->save();

        // Proses gambar jika diunggah
        if ($request->hasFile('foto_pondok')) {
            // Simpan gambar baru
            $fotoPath = $request->file('foto_pondok')->store('foto_pondok', 'public');
            $profilePondok->update(['foto_pondok' => $fotoPath]);
        }

        // Jika Anda ingin memberikan respons JSON
        return response()->json([
            'nama_pondok' => $profilePondok->nama_pondok,
            'kepala_pondok' => $profilePondok->kepala_pondok,
            'alamat' => $profilePondok->alamat,
            'telepon' => $profilePondok->telepon,
            'email' => $profilePondok->email,
            'deskripsi' => $profilePondok->deskripsi,
            'visi_misi' => $profilePondok->visi_misi,
            'foto_pondok' => asset('storage/' . $profilePondok->foto_pondok),
            'message' => 'Data berhasil disimpan'], 200);

        // Atau, jika ingin meredirect ke halaman tertentu
        // return redirect()->route('nama_rute_yang_diinginkan')->with('success', 'Data berhasil disimpan');
    }
}
