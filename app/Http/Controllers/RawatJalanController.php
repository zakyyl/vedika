<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class RawatJalanController extends Controller
{

    // public function index(Request $request)
    // {
    //     $page = $request->get('page', 1);
    //     $isFiltered = $request->filled('search') || ($request->filled('tgl_dari') && $request->filled('tgl_sampai'));

    //     $cacheKey = 'rawatjalan_index_' . md5(serialize($request->except('page'))) . '_page_' . $page;

    //     $rawatJalan = Cache::remember($cacheKey, 10, function () use ($request, $isFiltered) {
    //         $query = DB::table('reg_periksa')
    //             ->join('dokter', 'reg_periksa.kd_dokter', '=', 'dokter.kd_dokter')
    //             ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
    //             ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
    //             ->leftJoin('bridging_sep', 'reg_periksa.no_rawat', '=', 'bridging_sep.no_rawat')
    //             ->select(
    //                 'reg_periksa.no_rawat',
    //                 'reg_periksa.tgl_registrasi',
    //                 'dokter.nm_dokter',
    //                 'reg_periksa.no_rkm_medis',
    //                 'pasien.nm_pasien',
    //                 'poliklinik.nm_poli',
    //                 'bridging_sep.no_sep'
    //             )
    //             ->where('reg_periksa.kd_pj', 'BP1')
    //             ->where('reg_periksa.status_lanjut', 'ralan')
    //             ->where('reg_periksa.status_bayar', 'Sudah Bayar');

    //         if ($request->filled('search')) {
    //             $search = $request->search;
    //             $query->where(function ($q) use ($search) {
    //                 $q->where('reg_periksa.no_rawat', 'like', "%{$search}%")
    //                     ->orWhere('bridging_sep.no_sep', 'like', "%{$search}%");
    //             });
    //         }

    //         if ($request->filled('tgl_dari') && $request->filled('tgl_sampai')) {
    //             $query->whereBetween('reg_periksa.tgl_registrasi', [$request->tgl_dari, $request->tgl_sampai]);
    //         } elseif (!$request->filled('search')) {
    //             $query->whereMonth('reg_periksa.tgl_registrasi', now()->month)
    //                 ->whereYear('reg_periksa.tgl_registrasi', now()->year);
    //         }

    //         return $query->orderBy('reg_periksa.tgl_registrasi', 'desc')
    //             ->orderBy('reg_periksa.jam_reg', 'desc')
    //             ->paginate(25)
    //             ->withQueryString();
    //     });

    //     $total = Cache::remember("rawatjalan_total_" . md5(serialize($request->only(['search', 'tgl_dari', 'tgl_sampai']))), 300, function () use ($request) {
    //         $query = DB::table('reg_periksa')
    //             ->leftJoin('bridging_sep', 'reg_periksa.no_rawat', '=', 'bridging_sep.no_rawat')
    //             ->where('kd_pj', 'BP1')
    //             ->where('status_lanjut', 'ralan')
    //             ->where('reg_periksa.status_bayar', 'Sudah Bayar');

    //         if ($request->filled('search')) {
    //             $search = $request->search;
    //             $query->where(function ($q) use ($search) {
    //                 $q->where('reg_periksa.no_rawat', 'like', "%{$search}%")
    //                     ->orWhere('bridging_sep.no_sep', 'like', "%{$search}%");
    //             });
    //         }

    //         if ($request->filled('tgl_dari') && $request->filled('tgl_sampai')) {
    //             $query->whereBetween('tgl_registrasi', [$request->tgl_dari, $request->tgl_sampai]);
    //         } elseif (!$request->filled('search')) {
    //             $query->whereMonth('tgl_registrasi', now()->month)
    //                 ->whereYear('tgl_registrasi', now()->year);
    //         }

    //         return $query->count();
    //     });

    //     return view('rawatjalan.index', [
    //         'rawatJalan' => $rawatJalan,
    //         'total' => $total,
    //     ]);
    // }

    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $isFiltered = $request->filled('search') || ($request->filled('tgl_dari') && $request->filled('tgl_sampai'));

        $queryKey = 'rawatjalan_index_' . md5(serialize($request->except('page'))) . '_page_' . $page;

        $rawatJalan = $isFiltered
            ? $this->getRawatJalanData($request) // ambil langsung tanpa cache
            : Cache::remember($queryKey, 60, fn() => $this->getRawatJalanData($request));

        $totalKey = 'rawatjalan_total_' . md5(serialize($request->only(['search', 'tgl_dari', 'tgl_sampai'])));
        $total = $isFiltered
            ? $this->getRawatJalanTotal($request)
            : Cache::remember($totalKey, 60, fn() => $this->getRawatJalanTotal($request));

        return view('rawatjalan.index', [
            'rawatJalan' => $rawatJalan,
            'total' => $total,
        ]);
    }

    private function getRawatJalanData(Request $request)
    {
        $query = DB::table('reg_periksa')
            ->join('dokter', 'reg_periksa.kd_dokter', '=', 'dokter.kd_dokter')
            ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->leftJoin('bridging_sep', 'reg_periksa.no_rawat', '=', 'bridging_sep.no_rawat')
            ->select(
                'reg_periksa.no_rawat',
                'reg_periksa.tgl_registrasi',
                'dokter.nm_dokter',
                'reg_periksa.no_rkm_medis',
                'pasien.nm_pasien',
                'poliklinik.nm_poli',
                'bridging_sep.no_sep'
            )
            ->where('reg_periksa.kd_pj', 'BP1')
            ->where('reg_periksa.status_lanjut', 'ralan')
            ->where('reg_periksa.status_bayar', 'Sudah Bayar');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('reg_periksa.no_rawat', 'like', "%{$search}%")
                    ->orWhere('bridging_sep.no_sep', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tgl_dari') && $request->filled('tgl_sampai')) {
            $query->whereBetween('reg_periksa.tgl_registrasi', [$request->tgl_dari, $request->tgl_sampai]);
        } elseif (!$request->filled('search')) {
            $query->whereMonth('reg_periksa.tgl_registrasi', now()->month)
                ->whereYear('reg_periksa.tgl_registrasi', now()->year);
        }

        return $query->orderBy('reg_periksa.tgl_registrasi', 'desc')
            ->orderBy('reg_periksa.jam_reg', 'desc')
            ->paginate(25)
            ->withQueryString();
    }

    private function getRawatJalanTotal(Request $request)
    {
        $query = DB::table('reg_periksa')
            ->leftJoin('bridging_sep', 'reg_periksa.no_rawat', '=', 'bridging_sep.no_rawat')
            ->where('reg_periksa.kd_pj', 'BP1')
            ->where('reg_periksa.status_lanjut', 'ralan')
            ->where('reg_periksa.status_bayar', 'Sudah Bayar');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('reg_periksa.no_rawat', 'like', "%{$search}%")
                    ->orWhere('bridging_sep.no_sep', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tgl_dari') && $request->filled('tgl_sampai')) {
            $query->whereBetween('reg_periksa.tgl_registrasi', [$request->tgl_dari, $request->tgl_sampai]);
        } elseif (!$request->filled('search')) {
            $query->whereMonth('reg_periksa.tgl_registrasi', now()->month)
                ->whereYear('reg_periksa.tgl_registrasi', now()->year);
        }

        return $query->count();
    }




    public function indexBpjs(Request $request)
    {
        $page = $request->get('page', 1);
        $isFiltered = $request->filled('search') || ($request->filled('tgl_dari') && $request->filled('tgl_sampai'));
        $cacheKey = 'bpjs_ralan_index_' . md5(serialize($request->except('page'))) . '_page_' . $page;

        $bpjs = Cache::remember($cacheKey, 300, function () use ($request, $isFiltered) {
            $query = DB::table('mlite_vedika')
                ->select(
                    'id',
                    'tanggal',
                    'no_rkm_medis',
                    'no_rawat',
                    'tgl_registrasi',
                    'nosep',
                    'jenis',
                    'status',
                    'username',
                    'catatan'
                )
                ->where('jenis', '2');

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('no_rawat', 'like', "%{$search}%")
                        ->orWhere('nosep', 'like', "%{$search}%")
                        ->orWhere('no_rkm_medis', 'like', "%{$search}%");
                });
            }

            if ($request->filled('tgl_dari') && $request->filled('tgl_sampai')) {
                $query->whereBetween('tanggal', [$request->tgl_dari, $request->tgl_sampai]);
            } elseif (!$request->filled('search')) {
                $query->whereMonth('tanggal', now()->month)
                    ->whereYear('tanggal', now()->year);
            }

            return $query->orderBy('tanggal', 'desc')
                ->orderBy('id', 'desc')
                ->paginate(25)
                ->withQueryString();
        });

        $total = Cache::remember('bpjs_ralan_total_' . md5(serialize($request->only(['search', 'tgl_dari', 'tgl_sampai']))), 300, function () use ($request) {
            $query = DB::table('mlite_vedika')
                ->where('jenis', '2');

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('no_rawat', 'like', "%{$search}%")
                        ->orWhere('nosep', 'like', "%{$search}%")
                        ->orWhere('no_rkm_medis', 'like', "%{$search}%");
                });
            }

            if ($request->filled('tgl_dari') && $request->filled('tgl_sampai')) {
                $query->whereBetween('tanggal', [$request->tgl_dari, $request->tgl_sampai]);
            } elseif (!$request->filled('search')) {
                $query->whereMonth('tanggal', now()->month)
                    ->whereYear('tanggal', now()->year);
            }

            return $query->count();
        });

        return view('bpjs.rawatjalan.index', [
            'bpjs' => $bpjs,
            'total' => $total,
        ]);
    }



    //     public function detail($no_rawat)
    //     {
    //         $data = Cache::remember("rawatjalan_detail_$no_rawat", 300, function () use ($no_rawat) {
    //             return DB::table('reg_periksa')
    //                 ->join('dokter', 'reg_periksa.kd_dokter', '=', 'dokter.kd_dokter')
    //                 ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
    //                 ->join('penjab', 'reg_periksa.kd_pj', '=', 'penjab.kd_pj')
    //                 ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
    //                 ->leftJoin(DB::raw('(SELECT no_rawat, MAX(no_sep) as no_sep FROM bridging_sep GROUP BY no_rawat) as bridging_sep'), 'reg_periksa.no_rawat', '=', 'bridging_sep.no_rawat')
    //                 ->where('reg_periksa.no_rawat', $no_rawat)
    //                 ->select(
    //                     'reg_periksa.*',
    //                     'dokter.nm_dokter',
    //                     'pasien.nm_pasien',
    //                     'pasien.jk',
    //                     'pasien.umur',
    //                     'poliklinik.nm_poli',
    //                     'penjab.png_jawab',
    //                     'bridging_sep.no_sep'

    //                 )
    //                 ->first();
    //         });

    //         if (!$data) {
    //             abort(404, 'Data rawat jalan tidak ditemukan');
    //         }

    //         $kategori = Cache::remember('master_berkas_digital', 3600, function () {
    //             return DB::table('master_berkas_digital')->get();
    //         });

    //         $berkas = Cache::remember("berkas_digital_$no_rawat", 300, function () use ($no_rawat) {
    //             return DB::table('berkas_digital_perawatan')
    //                 ->join('master_berkas_digital', 'berkas_digital_perawatan.kode', '=', 'master_berkas_digital.kode')
    //                 ->where('berkas_digital_perawatan.no_rawat', $no_rawat)
    //                 ->select('berkas_digital_perawatan.*', 'master_berkas_digital.nama as nama_kategori')
    //                 ->get();
    //         });

    //         $pemeriksaan = DB::table('pemeriksaan_ralan')
    //             ->join('reg_periksa', 'pemeriksaan_ralan.no_rawat', '=', 'reg_periksa.no_rawat')
    //             ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
    //             ->join('dokter', 'reg_periksa.kd_dokter', '=', 'dokter.kd_dokter')
    //             ->select(
    //                 'pemeriksaan_ralan.*',
    //                 'reg_periksa.no_rkm_medis',
    //                 'pasien.nm_pasien',
    //                 'dokter.nm_dokter'
    //             )
    //             ->where('pemeriksaan_ralan.no_rawat', $no_rawat)
    //             ->orderBy('pemeriksaan_ralan.tgl_perawatan', 'desc')
    //             ->orderBy('pemeriksaan_ralan.jam_rawat', 'desc')
    //             ->get();

    //         $no_rkm_medis = DB::table('reg_periksa')
    //             ->where('no_rawat', $no_rawat)
    //             ->value('no_rkm_medis');

    //         $suratKontrol = DB::table('skdp_bpjs')
    //             ->join('dokter', 'dokter.kd_dokter', '=', 'skdp_bpjs.kd_dokter')
    //             ->where('skdp_bpjs.no_rkm_medis', $no_rkm_medis)
    //             ->orderByDesc('skdp_bpjs.tanggal_datang')
    //             ->limit(8)
    //             ->get();

    //         $rawatDr = DB::table('rawat_jl_dr')
    //             ->join('jns_perawatan', 'rawat_jl_dr.kd_jenis_prw', '=', 'jns_perawatan.kd_jenis_prw')
    //             ->join('dokter', 'rawat_jl_dr.kd_dokter', '=', 'dokter.kd_dokter')
    //             ->where('rawat_jl_dr.no_rawat', $no_rawat)
    //             ->select('rawat_jl_dr.*', 'jns_perawatan.nm_perawatan', 'dokter.nm_dokter')
    //             ->get();

    //         $rawatPr = DB::table('rawat_jl_pr')
    //             ->join('jns_perawatan', 'rawat_jl_pr.kd_jenis_prw', '=', 'jns_perawatan.kd_jenis_prw')
    //             ->join('petugas', 'rawat_jl_pr.nip', '=', 'petugas.nip')
    //             ->where('rawat_jl_pr.no_rawat', $no_rawat)
    //             ->select('rawat_jl_pr.*', 'jns_perawatan.nm_perawatan', 'petugas.nama as nama_petugas')
    //             ->get();

    //         $rawatDrPr = DB::table('rawat_jl_drpr')
    //             ->join('jns_perawatan', 'rawat_jl_drpr.kd_jenis_prw', '=', 'jns_perawatan.kd_jenis_prw')
    //             ->join('dokter', 'rawat_jl_drpr.kd_dokter', '=', 'dokter.kd_dokter')
    //             ->join('petugas', 'rawat_jl_drpr.nip', '=', 'petugas.nip')
    //             ->where('rawat_jl_drpr.no_rawat', $no_rawat)
    //             ->select('rawat_jl_drpr.*', 'jns_perawatan.nm_perawatan', 'dokter.nm_dokter', 'petugas.nama as nama_petugas')
    //             ->get();

    //         $operasi = DB::table('operasi')
    //             ->join('paket_operasi', 'operasi.kode_paket', '=', 'paket_operasi.kode_paket')
    //             ->where('operasi.no_rawat', $no_rawat)
    //             ->select('operasi.*', 'paket_operasi.nm_perawatan')
    //             ->get();

    //         $laporanOperasi = DB::table('laporan_operasi')
    //             ->where('no_rawat', $no_rawat)
    //             ->get();

    //         $tindakan_radiologi = DB::table('periksa_radiologi')
    //             ->join('jns_perawatan_radiologi', 'periksa_radiologi.kd_jenis_prw', '=', 'jns_perawatan_radiologi.kd_jenis_prw')
    //             ->join('dokter', 'periksa_radiologi.kd_dokter', '=', 'dokter.kd_dokter')
    //             ->join('petugas', 'periksa_radiologi.nip', '=', 'petugas.nip')
    //             ->where('periksa_radiologi.no_rawat', $no_rawat)
    //             ->select('periksa_radiologi.*', 'jns_perawatan_radiologi.nm_perawatan', 'dokter.nm_dokter', 'petugas.nama')
    //             ->get();

    //         $hasil_radiologi = DB::table('hasil_radiologi')
    //             ->where('no_rawat', $no_rawat)
    //             ->get();

    //             $no_sep = DB::table('bridging_sep')
    //     ->where('no_rawat', $no_rawat)
    //     ->value('no_sep');

    //     $vedikaData = Cache::remember("vedika_data_$no_rawat", 300, function () use ($no_rawat) {
    //     return DB::table('mlite_vedika')->where('no_rawat', $no_rawat)->first();
    // });

    // $sepData = Cache::remember("sep_data_$no_rawat", 300, function () use ($no_rawat) {
    //     return DB::table('bridging_sep')->where('no_rawat', $no_rawat)->first();
    // });


    // $readonly = Auth::user()->roles === 'bpjs';



    //         return view('rawatjalan.detail', compact(
    //             'data',
    //             'kategori',
    //             'berkas',
    //             'pemeriksaan',
    //             'suratKontrol',
    //             'rawatDr',
    //             'rawatPr',
    //             'rawatDrPr',
    //             'operasi',
    //             'laporanOperasi',
    //             'tindakan_radiologi',
    //             'hasil_radiologi',
    //             'no_sep',
    //             'vedikaData',
    //             'readonly',
    //             'sepData',
    //         ));
    //     }

    public function detail($no_rawat)
    {
        $data = $this->getRegistrationData($no_rawat);

        if (!$data) {
            abort(404, 'Data rawat jalan tidak ditemukan');
        }

        $kategori = $this->getMasterBerkasDigital();
        $berkas = $this->getBerkasDigital($no_rawat);
        $pemeriksaan = $this->getPemeriksaanData($no_rawat);
        $suratKontrol = $this->getSuratKontrol($data->no_rkm_medis);

        $rawatDr = $this->getRawatDokter($no_rawat);
        $rawatPr = $this->getRawatPerawat($no_rawat);
        $rawatDrPr = $this->getRawatDokterPerawat($no_rawat);

        $operasi = $this->getOperasiData($no_rawat);
        $laporanOperasi = $this->getLaporanOperasi($no_rawat);

        $tindakan_radiologi = $this->getTindakanRadiologi($no_rawat);
        $hasil_radiologi = $this->getHasilRadiologi($no_rawat);

        $no_sep = $this->getNoSep($no_rawat);
        $vedikaData = $this->getVedikaData($no_rawat);
        $sepData = $this->getSepData($no_rawat);

        $billing = $this->getBillingData($no_rawat);

        $totalBilling = $billing->sum(function ($item) {
            return (float) $item->totalbiaya;
        });

        $readonly = Auth::user()->roles === 'bpjs';

        return view('rawatjalan.detail', compact(
            'data',
            'kategori',
            'berkas',
            'pemeriksaan',
            'suratKontrol',
            'rawatDr',
            'rawatPr',
            'rawatDrPr',
            'operasi',
            'laporanOperasi',
            'tindakan_radiologi',
            'hasil_radiologi',
            'no_sep',
            'vedikaData',
            'readonly',
            'sepData',
            'billing',
            'totalBilling'
        ));
    }

    private function getBillingData($no_rawat)
    {
        return DB::table('billing')
            ->select(
                'no',
                'nm_perawatan',
                'pemisah',
                DB::raw("IF(biaya=0,'',biaya) as biaya"),
                DB::raw("IF(jumlah=0,'',jumlah) as jumlah"),
                DB::raw("IF(tambahan=0,'',tambahan) as tambahan"),
                DB::raw("IF(totalbiaya=0,'',totalbiaya) as totalbiaya")
            )
            ->where('no_rawat', $no_rawat)
            ->get();
    }


    private function getRegistrationData($no_rawat)
    {
        return Cache::remember("rawatjalan_detail_$no_rawat", 300, function () use ($no_rawat) {
            return DB::table('reg_periksa')
                ->join('dokter', 'reg_periksa.kd_dokter', '=', 'dokter.kd_dokter')
                ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
                ->join('penjab', 'reg_periksa.kd_pj', '=', 'penjab.kd_pj')
                ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
                ->leftJoin(DB::raw('(SELECT no_rawat, MAX(no_sep) as no_sep FROM bridging_sep GROUP BY no_rawat) as bridging_sep'), 'reg_periksa.no_rawat', '=', 'bridging_sep.no_rawat')
                ->where('reg_periksa.no_rawat', $no_rawat)
                ->select(
                    'reg_periksa.*',
                    'dokter.nm_dokter',
                    'pasien.nm_pasien',
                    'pasien.jk',
                    'pasien.umur',
                    'poliklinik.nm_poli',
                    'penjab.png_jawab',
                    'bridging_sep.no_sep'
                )
                ->first();
        });
    }


    private function getMasterBerkasDigital()
    {
        return Cache::remember('master_berkas_digital', 3600, function () {
            return DB::table('master_berkas_digital')->get();
        });
    }


    private function getBerkasDigital($no_rawat)
    {
        return Cache::remember("berkas_digital_$no_rawat", 300, function () use ($no_rawat) {
            return DB::table('berkas_digital_perawatan')
                ->join('master_berkas_digital', 'berkas_digital_perawatan.kode', '=', 'master_berkas_digital.kode')
                ->where('berkas_digital_perawatan.no_rawat', $no_rawat)
                ->select('berkas_digital_perawatan.*', 'master_berkas_digital.nama as nama_kategori')
                ->get();
        });
    }


    private function getPemeriksaanData($no_rawat)
    {
        return DB::table('pemeriksaan_ralan')
            ->join('reg_periksa', 'pemeriksaan_ralan.no_rawat', '=', 'reg_periksa.no_rawat')
            ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
            ->join('dokter', 'reg_periksa.kd_dokter', '=', 'dokter.kd_dokter')
            ->select(
                'pemeriksaan_ralan.*',
                'reg_periksa.no_rkm_medis',
                'pasien.nm_pasien',
                'dokter.nm_dokter'
            )
            ->where('pemeriksaan_ralan.no_rawat', $no_rawat)
            ->orderBy('pemeriksaan_ralan.tgl_perawatan', 'desc')
            ->orderBy('pemeriksaan_ralan.jam_rawat', 'desc')
            ->get();
    }


    private function getSuratKontrol($no_rkm_medis)
    {
        return DB::table('skdp_bpjs')
            ->join('dokter', 'dokter.kd_dokter', '=', 'skdp_bpjs.kd_dokter')
            ->where('skdp_bpjs.no_rkm_medis', $no_rkm_medis)
            ->orderByDesc('skdp_bpjs.tanggal_datang')
            ->limit(8)
            ->get();
    }


    private function getRawatDokter($no_rawat)
    {
        return DB::table('rawat_jl_dr')
            ->join('jns_perawatan', 'rawat_jl_dr.kd_jenis_prw', '=', 'jns_perawatan.kd_jenis_prw')
            ->join('dokter', 'rawat_jl_dr.kd_dokter', '=', 'dokter.kd_dokter')
            ->where('rawat_jl_dr.no_rawat', $no_rawat)
            ->select('rawat_jl_dr.*', 'jns_perawatan.nm_perawatan', 'dokter.nm_dokter')
            ->get();
    }


    private function getRawatPerawat($no_rawat)
    {
        return DB::table('rawat_jl_pr')
            ->join('jns_perawatan', 'rawat_jl_pr.kd_jenis_prw', '=', 'jns_perawatan.kd_jenis_prw')
            ->join('petugas', 'rawat_jl_pr.nip', '=', 'petugas.nip')
            ->where('rawat_jl_pr.no_rawat', $no_rawat)
            ->select('rawat_jl_pr.*', 'jns_perawatan.nm_perawatan', 'petugas.nama as nama_petugas')
            ->get();
    }


    private function getRawatDokterPerawat($no_rawat)
    {
        return DB::table('rawat_jl_drpr')
            ->join('jns_perawatan', 'rawat_jl_drpr.kd_jenis_prw', '=', 'jns_perawatan.kd_jenis_prw')
            ->join('dokter', 'rawat_jl_drpr.kd_dokter', '=', 'dokter.kd_dokter')
            ->join('petugas', 'rawat_jl_drpr.nip', '=', 'petugas.nip')
            ->where('rawat_jl_drpr.no_rawat', $no_rawat)
            ->select('rawat_jl_drpr.*', 'jns_perawatan.nm_perawatan', 'dokter.nm_dokter', 'petugas.nama as nama_petugas')
            ->get();
    }


    private function getOperasiData($no_rawat)
    {
        return DB::table('operasi')
            ->join('paket_operasi', 'operasi.kode_paket', '=', 'paket_operasi.kode_paket')
            ->where('operasi.no_rawat', $no_rawat)
            ->select('operasi.*', 'paket_operasi.nm_perawatan')
            ->get();
    }


    private function getLaporanOperasi($no_rawat)
    {
        return DB::table('laporan_operasi')
            ->where('no_rawat', $no_rawat)
            ->get();
    }

    private function getTindakanRadiologi($no_rawat)
    {
        return DB::table('periksa_radiologi')
            ->join('jns_perawatan_radiologi', 'periksa_radiologi.kd_jenis_prw', '=', 'jns_perawatan_radiologi.kd_jenis_prw')
            ->join('dokter', 'periksa_radiologi.kd_dokter', '=', 'dokter.kd_dokter')
            ->join('petugas', 'periksa_radiologi.nip', '=', 'petugas.nip')
            ->where('periksa_radiologi.no_rawat', $no_rawat)
            ->select('periksa_radiologi.*', 'jns_perawatan_radiologi.nm_perawatan', 'dokter.nm_dokter', 'petugas.nama')
            ->get();
    }

    private function getHasilRadiologi($no_rawat)
    {
        return DB::table('hasil_radiologi')
            ->where('no_rawat', $no_rawat)
            ->get();
    }

    private function getNoSep($no_rawat)
    {
        return DB::table('bridging_sep')
            ->where('no_rawat', $no_rawat)
            ->value('no_sep');
    }


    private function getVedikaData($no_rawat)
    {
        return Cache::remember("vedika_data_$no_rawat", 300, function () use ($no_rawat) {
            return DB::table('mlite_vedika')->where('no_rawat', $no_rawat)->first();
        });
    }


    private function getSepData($no_rawat)
    {
        return DB::table('bridging_sep')->where('no_rawat', $no_rawat)->first();
        // return Cache::remember("sep_data_$no_rawat", 10, function () use ($no_rawat) {
        //     return DB::table('bridging_sep')->where('no_rawat', $no_rawat)->first();
        // });
    }

    public function uploadResume(Request $request, $no_rawat)
    {
        $request->validate([
            'kode' => 'required|exists:master_berkas_digital,kode',
            'file' => 'required|file|mimes:pdf,jpg,jpeg|max:2048',
        ]);

        try {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $timestamp = now()->format('YmdHis');
                $extension = $file->getClientOriginalExtension();
                $kode = $request->kode;

                $berkas = DB::table('master_berkas_digital')->where('kode', $kode)->first();
                $namaKode = $berkas ? $berkas->nama : $kode;

                $rawFilename = "{$namaKode}_{$no_rawat}_{$timestamp}.{$extension}";

                $safeFilename = str_replace('/', '__', $rawFilename);


                $postData = [
                    'file' => new \CURLFile($file->getPathname(), $file->getMimeType(), $safeFilename),
                    'filename' => $rawFilename, 
                    'kode' => $kode,
                    'no_rawat' => $no_rawat,
                ];

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'http://192.168.1.33/ERMV1/berkasrawat/pages/upload/upload.php');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $curlError = curl_error($ch);
                curl_close($ch);

                if ($httpCode === 200 && str_contains($response, 'Upload sukses')) {
                    $relativePath = 'berkasrawat/pages/upload/' . $safeFilename;

                    DB::table('berkas_digital_perawatan')->insert([
                        'no_rawat' => $no_rawat,
                        'kode' => $kode,
                        'lokasi_file' => $relativePath,
                    ]);

                    Cache::forget("berkas_digital_$no_rawat");
                    Cache::forget("rawatjalan_detail_$no_rawat");

                    return back()->with('success', 'Resume keperawatan berhasil diunggah ke server: ' . $rawFilename);
                } else {
                    return back()->with('error', 'Gagal mengunggah ke server. Respon: ' . $response . ' | Error: ' . $curlError);
                }
            }

            return back()->with('error', 'File tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Upload error: ' . $e->getMessage(), [
                'no_rawat' => $no_rawat,
                'file_info' => $request->hasFile('file') ? [
                    'original_name' => $request->file('file')->getClientOriginalName(),
                    'size' => $request->file('file')->getSize(),
                    'mime_type' => $request->file('file')->getMimeType()
                ] : 'No file'
            ]);

            return back()->with('error', 'Gagal mengunggah file: ' . $e->getMessage());
        }
    }




    public function hapusResume($id)
    {
        $berkas = DB::table('berkas_digital_perawatan')->where('id', $id)->first();

        if (!$berkas) {
            return back()->with('error', 'Berkas tidak ditemukan.');
        }

        $filePath = public_path($berkas->lokasi_file);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        DB::table('berkas_digital_perawatan')->where('id', $id)->delete();

        Cache::forget("berkas_digital_{$berkas->no_rawat}");
        Cache::forget("rawatjalan_detail_{$berkas->no_rawat}");

        return back()->with('success', 'Berkas berhasil dihapus.');
    }


    public function updateStatus(Request $request, $no_rawat)
    {
        $request->validate([
            'status' => 'required|in:Pengajuan,Perbaiki,Disetujui',
            'catatan' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();
            DB::table('mlite_vedika')->updateOrInsert(
                ['no_rawat' => $no_rawat],
                [
                    'status' => $request->status,
                    'catatan' => $request->catatan,

                ]
            );

            DB::commit();
            Cache::forget("vedika_data_$no_rawat");

            return back()->with('success', 'Status klaim berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal memperbarui status klaim: ' . $e->getMessage());
        }
    }

    public function lihatResume($no_rawat)
    {
        $berkas = DB::table('berkas_digital_perawatan')
            ->join('master_berkas_digital', 'berkas_digital_perawatan.kode', '=', 'master_berkas_digital.kode')
            ->where('berkas_digital_perawatan.no_rawat', $no_rawat)
            ->select('berkas_digital_perawatan.*', 'master_berkas_digital.nama as nama_kategori')
            ->get();

        return view('rawatjalan.statusklaim', compact('berkas', 'no_rawat'));
    }

    public function lihatPemeriksaan($no_rawat)
    {
        $data = DB::table('pemeriksaan_ralan')
            ->join('reg_periksa', 'pemeriksaan_ralan.no_rawat', '=', 'reg_periksa.no_rawat')
            ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
            ->join('dokter', 'reg_periksa.kd_dokter', '=', 'dokter.kd_dokter')
            ->select(
                'pemeriksaan_ralan.*',
                'reg_periksa.no_rkm_medis',
                'pasien.nm_pasien',
                'dokter.nm_dokter'
            )
            ->where('pemeriksaan_ralan.no_rawat', $no_rawat)
            ->orderBy('pemeriksaan_ralan.tgl_perawatan', 'desc')
            ->orderBy('pemeriksaan_ralan.jam_rawat', 'desc')
            ->get();

        return view('rawatjalan.pemeriksaan', [
            'data' => $data,
            'no_rawat' => $no_rawat,
        ]);
    }
}
