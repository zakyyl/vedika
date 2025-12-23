<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HapusController extends Controller
{

    public function index()
    {
        return view('hapus.index');
    }

    // public function confirmByForm(Request $request)
    // {
    //     $request->validate([
    //         'no_sep' => 'required'
    //     ]);

    //     $data = DB::table('mlite_vedika')
    //         ->join('reg_periksa', 'mlite_vedika.no_rawat', '=', 'reg_periksa.no_rawat')
    //         ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
    //         ->select(
    //             'mlite_vedika.nosep',
    //             'mlite_vedika.no_rawat',
    //             'mlite_vedika.no_rkm_medis',
    //             'pasien.nm_pasien'
    //         )
    //         ->where('mlite_vedika.nosep', $request->no_sep)
    //         ->first();

    //     if (!$data) {
    //         return response()->json([
    //             'message' => 'Data pasien tidak ditemukan'
    //         ], 404);
    //     }

    //     return response()->json($data);
    // }

    public function confirmByForm(Request $request)
{
    if (!$request->filled('no_sep') || trim($request->no_sep) === '-') {
        return response()->json([
            'message' => 'Data pasien tidak ditemukan'
        ], 404);
    }

    $data = DB::table('mlite_vedika')
        ->join('reg_periksa', 'mlite_vedika.no_rawat', '=', 'reg_periksa.no_rawat')
        ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
        ->select(
            'mlite_vedika.nosep',
            'mlite_vedika.no_rawat',
            'mlite_vedika.no_rkm_medis',
            'pasien.nm_pasien'
        )
        ->where('mlite_vedika.nosep', $request->no_sep)
        ->first();

    if (!$data) {
        return response()->json([
            'message' => 'Data pasien tidak ditemukan'
        ], 404);
    }

    return response()->json($data);
}


    public function destroy(Request $request)
    {
        $request->validate([
            'no_sep' => 'required'
        ]);

        DB::table('mlite_vedika')
            ->where('nosep', $request->no_sep)
            ->delete();

        return response()->json([
            'message' => 'Data Vedika berhasil dihapus'
        ]);
    }
}
