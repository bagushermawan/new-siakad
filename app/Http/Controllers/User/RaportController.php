<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RaportController extends Controller
{
    // public function generateRaport(Request $request)
    // {
    //     $currentPageData = $request->input('currentPageData');
    //     dd($currentPageData);

    //     return view('test.data', ['data' => $currentPageData]);
    // }
    public function generateRaport(Request $request)
    {
        try {
            $currentPageData = $request->input('currentPageData');
            // dd($currentPageData);

            return view('test.data', ['data' => $currentPageData]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function showRaport()
    {
        return view('test.data');
    }
}
