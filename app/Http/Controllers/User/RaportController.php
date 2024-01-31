<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\WaliSantri;
use App\Models\TahunAjaran;

class RaportController extends Controller
{
    public function generateRaport(Request $request)
    {
        try {
            $currentPageData = $request->input('currentPageData');
            $date = Carbon::now()->format('d-m-Y');

            $loggedInUserId = Auth::user()->id;
            // $santriId = WaliSantri::where('id', $loggedInUserId)->value('santri_id');

            $waliSantri = WaliSantri::with(['santri.kelas:id,name'])->find($loggedInUserId);
            $thaktif = TahunAjaran::where('status', 'aktif')->first();

            if ($waliSantri && $waliSantri->santri) {
                $santriData = $waliSantri->santri;
                $nisnSantri = $santriData->nisn ?? 'NISN Santri Tidak Tersedia';
                $namaSantri = $santriData->name ?? 'Nama Santri Tidak Tersedia';
                $usernameSantri = $santriData->username ?? 'Username Santri Tidak Tersedia';
                $nohpSantri = $santriData->nohp ?? 'No HP Santri Tidak Tersedia';
                $kelasSantri = $santriData->kelas ? $santriData->kelas->name : '';
            } else {
                $nisnSantri = 'NISN Santri Tidak Tersedia';
                $namaSantri = 'Nama Santri Tidak Tersedia';
                $usernameSantri = 'Username Santri Tidak Tersedia';
                $nohpSantri = 'No HP Santri Tidak Tersedia';
            }
            $userId = $usernameSantri ? explode(' ', $usernameSantri)[0] : null;

            // Render view PDF dengan menggunakan data yang dikirim dari client
            $pdf = PDF::loadView('test.data2', [
                'data' => $currentPageData,
                'nisnSantri' => $nisnSantri,
                'namaSantri' => $namaSantri,
                'kelasSantri' => $kelasSantri,
                'nohpSantri' => $nohpSantri,
                'thaktif' => $thaktif,
            ]);

            // Simpan PDF ke penyimpanan (opsional, bisa dihapus jika tidak diperlukan)
            $pdfPath = 'pdfs/raport_' . $userId . '_' . $date . '.pdf';
            Storage::disk('public')->put($pdfPath, $pdf->output());

            // Kirim URL PDF sebagai respons
            return response()->json(['pdfUrl' => route('show.pdf', ['pdf_path' => $pdfPath])]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function showPdf($pdfPath)
    {
        $pdfFullPath = Storage::disk('public')->path($pdfPath);

        // Baca konten file PDF
        $pdfContent = file_get_contents($pdfFullPath);

        // Tampilkan PDF di tab baru dengan header untuk membuka di tab baru
        return response($pdfContent, 200, [
            'Content-Type' => 'octet-stream',
            'Content-Disposition' => 'inline; filename="raport.pdf"',
        ]);
    }

    public function showRaport()
    {
        return view('test.data');
    }
}
