<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        $totalRawatJalan = $this->getTotal($bulanIni, $tahunIni, 'ralan');
        $totalRawatInap  = $this->getTotal($bulanIni, $tahunIni, 'ranap');

        $pengajuanRawatJalan = $this->getTotalPengajuan($bulanIni, $tahunIni, 'Ralan');
        $pengajuanRawatInap  = $this->getTotalPengajuan($bulanIni, $tahunIni, 'Ranap');

        $monthlyData = $this->getMonthlyData($tahunIni);

        return view('dashboard.index', compact(
            'totalRawatJalan',
            'totalRawatInap',
            'pengajuanRawatJalan',
            'pengajuanRawatInap',
            'monthlyData'
        ));
    }

    private function getTotal($bulan, $tahun, $jenis)
    {
        return DB::table('reg_periksa')
            ->select('reg_periksa.no_rawat')
            ->leftJoin('bridging_sep', 'reg_periksa.no_rawat', '=', 'bridging_sep.no_rawat')
            ->leftJoin('mlite_vedika', 'reg_periksa.no_rawat', '=', 'mlite_vedika.no_rawat')
            ->where('reg_periksa.kd_pj', 'BP1')
            ->where('reg_periksa.status_lanjut', $jenis)
            ->where('reg_periksa.status_bayar', 'Sudah Bayar')
            ->whereMonth('reg_periksa.tgl_registrasi', $bulan)
            ->whereYear('reg_periksa.tgl_registrasi', $tahun)
            ->distinct()
            ->count('reg_periksa.no_rawat');
    }

    private function getTotalPengajuan($bulan, $tahun, $jenis)
    {
        if ($jenis === 'Ranap') {
            $latestKamarInap = DB::table('kamar_inap')
                ->select('no_rawat', DB::raw('MAX(tgl_keluar) as tgl_keluar'))
                ->groupBy('no_rawat');

            return DB::table('mlite_vedika as v')
                ->joinSub($latestKamarInap, 'ki', function ($join) {
                    $join->on('v.no_rawat', '=', 'ki.no_rawat');
                })
                ->where('v.jenis', 'Ranap')
                ->where('v.status', 'Pengajuan')
                ->whereMonth('ki.tgl_keluar', $bulan)
                ->whereYear('ki.tgl_keluar', $tahun)
                ->count();
        } else {
            return DB::table('mlite_vedika')
                ->where(function ($q) {
                    $q->where('jenis', 'Ralan')
                        ->orWhere('jenis', '2');
                })
                ->where('status', 'Pengajuan')
                ->whereMonth('tgl_registrasi', $bulan)
                ->whereYear('tgl_registrasi', $tahun)
                ->count();
        }
    }

    private function getMonthlyData($tahun)
    {
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
        $rawatJalanData = [];
        $rawatInapData = [];
        $pengajuanRalanData = [];
        $pengajuanRanapData = [];

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $rawatJalanData[] = $this->getTotal($bulan, $tahun, 'ralan');
            $rawatInapData[]  = $this->getTotal($bulan, $tahun, 'ranap');
            $pengajuanRalanData[] = $this->getTotalPengajuan($bulan, $tahun, 'Ralan');
            $pengajuanRanapData[] = $this->getTotalPengajuan($bulan, $tahun, 'Ranap');
        }

        return [
            'labels' => $months,
            'rawatJalan' => $rawatJalanData,
            'rawatInap' => $rawatInapData,
            'pengajuanRalan' => $pengajuanRalanData,
            'pengajuanRanap' => $pengajuanRanapData,
            'tahun' => $tahun
        ];
    }
}