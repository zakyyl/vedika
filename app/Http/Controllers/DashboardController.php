<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $bulanIni = Carbon::now()->format('Y-m');

        $totalRawatJalan = Cache::remember("total_rawat_jalan_$bulanIni", 10, function () use ($bulanIni) {
            return DB::table('reg_periksa')
                ->where('kd_pj', 'BP1')
                ->where('status_lanjut', 'ralan')
                ->where('tgl_registrasi', 'like', "$bulanIni%")
                ->count();
        });

        $totalRawatInap = Cache::remember("total_rawat_inap_$bulanIni", 10, function () use ($bulanIni) {
            return DB::table('reg_periksa')
                ->where('kd_pj', 'BP1')
                ->where('status_lanjut', 'ranap')
                ->where('tgl_registrasi', 'like', "$bulanIni%")
                ->count();
        });

        $pengajuanRawatJalan = Cache::remember("pengajuan_ralan_$bulanIni", 10, function () use ($bulanIni) {
            return DB::table('mlite_vedika')
                ->where('jenis', 'ralan')
                ->where('status', 'Pengajuan')
                ->where('tanggal', 'like', "$bulanIni%")
                ->count();
        });

        $pengajuanRawatInap = Cache::remember("pengajuan_ranap_$bulanIni", 10, function () use ($bulanIni) {
            return DB::table('mlite_vedika')
                ->where('jenis', 'ranap')
                ->where('status', 'Pengajuan')
                ->where('tanggal', 'like', "$bulanIni%")
                ->count();
        });

        return view('dashboard.index', compact(
            'totalRawatJalan',
            'totalRawatInap',
            'pengajuanRawatJalan',
            'pengajuanRawatInap'
        ));
    }
}
