<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        
        $totalRawatJalan = Cache::remember('total_rawat_jalan', 300, function () {
            return DB::table('reg_periksa')
                ->where('kd_pj', 'BP1')
                ->where('status_lanjut', 'ralan')
                ->count();
        });

        $totalRawatInap = Cache::remember('total_rawat_inap', 300, function () {
            return DB::table('reg_periksa')
                ->where('kd_pj', 'BP1')
                ->where('status_lanjut', 'ranap')
                ->count();
        });

        $totalPasien = Cache::remember('total_pasien', 300, function () {
            return DB::table('pasien')->count();
        });

        $totalDokter = Cache::remember('total_dokter', 300, function () {
            return DB::table('dokter')->count();
        });

        return view('dashboard.index', compact(
            'totalRawatJalan',
            'totalRawatInap',
            'totalPasien',
            'totalDokter'
        ));
    }
}
