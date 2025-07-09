<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class RawatInapController extends Controller
{

    public function index(Request $request)
    {
        $page = $request->get('page', 1);

        if (!$request->filled('tgl_dari') && !$request->filled('tgl_sampai') && !$request->filled('search')) {
            $request->merge([
                'tgl_dari' => now()->toDateString(),
                'tgl_sampai' => now()->toDateString(),
            ]);
        }

        $isFiltered = $request->filled('search') || ($request->filled('tgl_dari') && $request->filled('tgl_sampai'));

        $queryKey = 'rawatinap_index_' . md5(serialize($request->except('page'))) . '_page_' . $page;

        $rawatInap = $isFiltered
            ? $this->getRawatInapData($request)
            : Cache::remember($queryKey, 60, fn() => $this->getRawatInapData($request));

        $totalKey = 'rawatinap_total_' . md5(serialize($request->only(['search', 'tgl_dari', 'tgl_sampai'])));

        $total = $isFiltered
            ? $this->getRawatInapTotal($request)
            : Cache::remember($totalKey, 60, fn() => $this->getRawatInapTotal($request));

        return view('rawatinap.index', [
            'rawatInap' => $rawatInap,
            'total' => $total,
        ]);
    }

    private function getRawatInapData(Request $request)
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
            ->where('reg_periksa.status_lanjut', 'ranap')
            ->where('reg_periksa.status_bayar', 'Sudah Bayar');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('reg_periksa.no_rawat', 'like', "%{$search}%")
                    ->orWhere('reg_periksa.no_rkm_medis', 'like', "%{$search}%")
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

    private function getRawatInapTotal(Request $request)
    {
        $query = DB::table('reg_periksa')
            ->leftJoin('bridging_sep', 'reg_periksa.no_rawat', '=', 'bridging_sep.no_rawat')
            ->where('reg_periksa.kd_pj', 'BP1')
            ->where('reg_periksa.status_lanjut', 'ranap')
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
            ->where('jenis', '1')
            ->where('status', 'Pengajuan');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_rawat', 'like', "%{$search}%")
                    ->orWhere('nosep', 'like', "%{$search}%")
                    ->orWhere('no_rkm_medis', 'like', "%{$search}%");
            });
        } elseif ($request->filled('tgl_dari') && $request->filled('tgl_sampai')) {
            $query->whereBetween('tanggal', [$request->tgl_dari, $request->tgl_sampai]);
        } else {
            $query->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year);
        }

        $bpjs = $query->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(25)
            ->withQueryString();

        $totalKey = 'bpjs_ranap_total_' . md5(serialize($request->only(['search', 'tgl_dari', 'tgl_sampai'])) . '_jenis_2');
        $total = Cache::remember($totalKey, 60, function () use ($request) {
            $query = DB::table('mlite_vedika')
                ->where('jenis', '1')
                ->where('status', 'Pengajuan');

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('no_rawat', 'like', "%{$search}%")
                        ->orWhere('nosep', 'like', "%{$search}%")
                        ->orWhere('no_rkm_medis', 'like', "%{$search}%");
                });
            } elseif ($request->filled('tgl_dari') && $request->filled('tgl_sampai')) {
                $query->whereBetween('tanggal', [$request->tgl_dari, $request->tgl_sampai]);
            } else {
                $query->whereMonth('tanggal', now()->month)
                    ->whereYear('tanggal', now()->year);
            }

            return $query->count();
        });

        return view('bpjs.rawatinap.index', [
            'bpjs' => $bpjs,
            'total' => $total,
        ]);
    }

    // public function detail($no_rawat)
    // {
    //     $data = $this->getRegistrationData($no_rawat);

    //     if (!$data) {
    //         abort(404, 'Data rawat inap tidak ditemukan');
    //     }

    //     $kategori = $this->getMasterBerkasDigital();
    //     $berkas = $this->getBerkasDigital($no_rawat);
    //     $pemeriksaan = $this->getPemeriksaanData($no_rawat);
    //     $suratKontrol = $this->getSuratKontrol($data->no_rkm_medis);

    //     $rawatDr = $this->getRawatDokter($no_rawat);
    //     $rawatPr = $this->getRawatPerawat($no_rawat);
    //     $rawatDrPr = $this->getRawatDokterPerawat($no_rawat);

    //     $operasi = $this->getOperasiData($no_rawat);
    //     $laporanOperasi = $this->getLaporanOperasi($no_rawat);

    //     $tindakan_radiologi = $this->getTindakanRadiologi($no_rawat);
    //     $hasil_radiologi = $this->getHasilRadiologi($no_rawat);

    //     $no_sep = $this->getNoSep($no_rawat);
    //     $vedikaData = $this->getVedikaData($no_rawat);
    //     $sepData = $this->getSepData($no_rawat);


    //     $billing = $this->getBillingData($no_rawat);

    //     $totalBilling = $billing->sum(function ($item) {
    //         return (float) $item->totalbiaya;
    //     });

    //     $readonly = Auth::check() && Auth::user()->roles === 'bpjs';

    //     $laboratorium = $this->getPemeriksaanLaboratorium($no_rawat);

    //     $pemberian_obat = $this->getPemberianObat($no_rawat);

    //     $dpjp_ranap = $this->getDpjp($no_rawat);

    //     $laboratorium_pa = $this->getLaboratoriumPA($no_rawat);

    //     $resep_pulang = $this->getResepPulang($no_rawat);

    //     $hasil_usg = $this->getHasilUSG($no_rawat);
    //     $hasil_usg_gynecologi = $this->getHasilUSGGynecologi($no_rawat);
    //     $hasil_echo = $this->getHasilEcho($no_rawat);

    //     return view('rawatinap.detail', compact(
    //         'data',
    //         'kategori',
    //         'berkas',
    //         'pemeriksaan',
    //         'suratKontrol',
    //         'rawatDr',
    //         'rawatPr',
    //         'rawatDrPr',
    //         'operasi',
    //         'laporanOperasi',
    //         'tindakan_radiologi',
    //         'hasil_radiologi',
    //         'no_sep',
    //         'vedikaData',
    //         'readonly',
    //         'sepData',
    //         'billing',
    //         'totalBilling',
    //         'laboratorium',
    //         'pemberian_obat',
    //         'dpjp_ranap',
    //         'laboratorium_pa',
    //         'resep_pulang',
    //         'hasil_usg',
    //         'hasil_usg_gynecologi',
    //         'hasil_echo',
            
    //     ));
    // }

    public function detail($no_rawat)
    {
        $data = $this->getRegistrationData($no_rawat);

        if (!$data) {
            abort(404, 'Data rawat inap tidak ditemukan');
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

        // Ambil data SEP terbaru untuk konsistensi
        $sepData = $this->getSepData($no_rawat);
        $no_sep = $sepData ? $sepData->no_sep : null;
        
        $vedikaData = $this->getVedikaData($no_rawat);

        $billing = $this->getBillingData($no_rawat);

        $totalBilling = $billing->sum(function ($item) {
            return (float) $item->totalbiaya;
        });

        $readonly = Auth::check() && Auth::user()->roles === 'bpjs';

        $laboratorium = $this->getPemeriksaanLaboratorium($no_rawat);
        $pemberian_obat = $this->getPemberianObat($no_rawat);
        $dpjp_ranap = $this->getDpjp($no_rawat);
        $laboratorium_pa = $this->getLaboratoriumPA($no_rawat);
        $resep_pulang = $this->getResepPulang($no_rawat);
        $hasil_usg = $this->getHasilUSG($no_rawat);
        $hasil_usg_gynecologi = $this->getHasilUSGGynecologi($no_rawat);
        $hasil_echo = $this->getHasilEcho($no_rawat);

        return view('rawatinap.detail', compact(
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
            'totalBilling',
            'laboratorium',
            'pemberian_obat',
            'dpjp_ranap',
            'laboratorium_pa',
            'resep_pulang',
            'hasil_usg',
            'hasil_usg_gynecologi',
            'hasil_echo',
        ));
    }


        private function getHasilUSG($no_rawat)
    {
        return DB::table('hasil_pemeriksaan_usg')
            ->where('no_rawat', $no_rawat)
            ->orderBy('tanggal', 'asc')
            ->get();
    }

    private function getHasilUSGGynecologi($no_rawat)
    {
        return DB::table('hasil_pemeriksaan_usg_gynecologi')
            ->where('no_rawat', $no_rawat)
            ->orderBy('tanggal', 'asc')
            ->get();
    }

    private function getHasilEcho($no_rawat)
    {
        return DB::table('hasil_pemeriksaan_echo')
            ->join('dokter', 'dokter.kd_dokter', '=', 'hasil_pemeriksaan_echo.kd_dokter')
            ->select('hasil_pemeriksaan_echo.*', 'dokter.nm_dokter')
            ->where('hasil_pemeriksaan_echo.no_rawat', $no_rawat)
            ->orderBy('tanggal', 'asc')
            ->get();
    }


    private function getResepPulang($no_rawat)
    {
        return DB::table('resep_pulang')
            ->join('databarang', 'resep_pulang.kode_brng', '=', 'databarang.kode_brng')
            ->select(
                'resep_pulang.tanggal',
                'resep_pulang.jam',
                'databarang.nama_brng',
                'resep_pulang.jml_barang as jml'
            )
            ->where('resep_pulang.no_rawat', $no_rawat)
            ->orderBy('resep_pulang.tanggal', 'desc')
            ->orderBy('resep_pulang.jam', 'desc')
            ->get();
    }



    private function getLaboratoriumPA($no_rawat)
    {
        return DB::table('detail_periksa_labpa')
            ->where('no_rawat', $no_rawat)
            ->orderBy('tgl_periksa', 'desc')
            ->orderBy('jam', 'desc')
            ->get();
    }


    private function getDpjp($no_rawat)
    {
        $rows_dpjp_ranap = DB::table('dpjp_ranap')
            ->join('dokter', 'dokter.kd_dokter', '=', 'dpjp_ranap.kd_dokter')
            ->where('dpjp_ranap.no_rawat', $no_rawat)
            ->select('dpjp_ranap.kd_dokter', 'dokter.nm_dokter')
            ->get();

        $dpjp_i = 1;
        $dpjp_ranap = [];

        foreach ($rows_dpjp_ranap as $row) {
            $dpjp_ranap[] = [
                'nomor' => $dpjp_i++,
                'kd_dokter' => $row->kd_dokter,
                'nm_dokter' => $row->nm_dokter,
            ];
        }

        return $dpjp_ranap;
    }

    private function getPemberianObat($no_rawat)
    {
        return DB::table('detail_pemberian_obat')
            ->join('databarang', 'detail_pemberian_obat.kode_brng', '=', 'databarang.kode_brng')
            ->select(
                'detail_pemberian_obat.tgl_perawatan',
                'detail_pemberian_obat.jam',
                'databarang.nama_brng',
                'detail_pemberian_obat.jml',
                'detail_pemberian_obat.total'
            )
            ->where('detail_pemberian_obat.no_rawat', $no_rawat)
            ->orderBy('detail_pemberian_obat.tgl_perawatan', 'desc')
            ->orderBy('detail_pemberian_obat.jam', 'desc')
            ->get();
    }

    private function getPemeriksaanLaboratorium($no_rawat)
    {

        $pasien = DB::table('reg_periksa')
            ->join('pasien', 'pasien.no_rkm_medis', '=', 'reg_periksa.no_rkm_medis')
            ->where('reg_periksa.no_rawat', $no_rawat)
            ->select('pasien.jk', 'pasien.tgl_lahir')
            ->first();

        if (!$pasien) {
            return [];
        }


        $umur = \Carbon\Carbon::parse($pasien->tgl_lahir)->age;

        $hasilLab = DB::table('periksa_lab')
            ->join('jns_perawatan_lab', 'jns_perawatan_lab.kd_jenis_prw', '=', 'periksa_lab.kd_jenis_prw')
            ->join('dokter', 'dokter.kd_dokter', '=', 'periksa_lab.kd_dokter')
            ->select(
                'periksa_lab.no_rawat',
                'periksa_lab.tgl_periksa',
                'periksa_lab.jam',
                'jns_perawatan_lab.nm_perawatan',
                'jns_perawatan_lab.kd_jenis_prw',
                'dokter.nm_dokter'
            )
            ->where('periksa_lab.no_rawat', $no_rawat)
            ->orderBy('periksa_lab.tgl_periksa', 'desc')
            ->orderBy('periksa_lab.jam', 'desc')
            ->get();

        $pemeriksaan_laboratorium = [];

        foreach ($hasilLab as $row) {
            $detail = DB::table('detail_periksa_lab')
                ->join('template_laboratorium', 'template_laboratorium.id_template', '=', 'detail_periksa_lab.id_template')
                ->select(
                    'template_laboratorium.Pemeriksaan',
                    'detail_periksa_lab.nilai',
                    'template_laboratorium.satuan',
                    'template_laboratorium.nilai_rujukan_ld',
                    'template_laboratorium.nilai_rujukan_la',
                    'template_laboratorium.nilai_rujukan_pd',
                    'template_laboratorium.nilai_rujukan_pa'
                )
                ->where('detail_periksa_lab.no_rawat', $no_rawat)
                ->where('detail_periksa_lab.kd_jenis_prw', $row->kd_jenis_prw)
                ->whereDate('detail_periksa_lab.tgl_periksa', $row->tgl_periksa)
                ->whereTime('detail_periksa_lab.jam', $row->jam)
                ->get()
                ->map(function ($item) use ($pasien, $umur) {
                    if ($umur <= 12) {
                        $item->nilai_rujukan = $pasien->jk === 'L' ? $item->nilai_rujukan_pd : $item->nilai_rujukan_pa;
                    } else {
                        $item->nilai_rujukan = $pasien->jk === 'L' ? $item->nilai_rujukan_ld : $item->nilai_rujukan_la;
                    }
                    return $item;
                })
                ->toArray();

            $pemeriksaan_laboratorium[] = [
                'no_rawat' => $row->no_rawat,
                'tgl_periksa' => $row->tgl_periksa,
                'jam' => $row->jam,
                'nm_perawatan' => $row->nm_perawatan,
                'nm_dokter' => $row->nm_dokter,
                'detail_periksa_lab' => $detail,
            ];
        }

        return $pemeriksaan_laboratorium;
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
        return Cache::remember("rawatinap_detail_$no_rawat", 300, function () use ($no_rawat) {
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
        return DB::table('pemeriksaan_ranap')
            ->join('reg_periksa', 'pemeriksaan_ranap.no_rawat', '=', 'reg_periksa.no_rawat')
            ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
            ->join('dokter', 'reg_periksa.kd_dokter', '=', 'dokter.kd_dokter')
            ->select(
                'pemeriksaan_ranap.*',
                'reg_periksa.no_rkm_medis',
                'pasien.nm_pasien',
                'dokter.nm_dokter'
            )
            ->where('pemeriksaan_ranap.no_rawat', $no_rawat)
            ->orderBy('pemeriksaan_ranap.tgl_perawatan', 'desc')
            ->orderBy('pemeriksaan_ranap.jam_rawat', 'desc')
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
        return DB::table('bridging_sep')
            ->where('no_rawat', $no_rawat)
            ->orderByDesc('no_sep') 
            ->first();
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
                    Cache::forget("rawatinap_detail_$no_rawat");

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


    public function updateStatus(Request $request, $no_rawat)
    {
        $request->validate([
            'status' => 'required|in:Pengajuan,Perbaiki,Disetujui',
            'catatan' => 'nullable|string',
            'no_rkm_medis' => 'required|string',
            'tgl_registrasi' => 'required|date',
            'nosep' => 'nullable|string',
            'jenis' => 'required|in:Ralan,Ranap',
        ]);

        try {
            DB::beginTransaction();

            $existing = DB::table('mlite_vedika')->where('no_rawat', $no_rawat)->first();

            if (!$existing) {
                DB::table('mlite_vedika')->insert([
                    'tanggal' => now()->format('Y-m-d'),
                    'no_rkm_medis' => $request->no_rkm_medis,
                    'no_rawat' => $no_rawat,
                    'tgl_registrasi' => $request->tgl_registrasi,
                    'nosep' => $request->nosep,
                    'jenis' => $request->jenis,
                    'status' => $request->status,
                    'catatan' => $request->catatan,
                    'username' => Auth::user()->username ?? 'system',
                ]);
            } else {
                DB::table('mlite_vedika')->where('no_rawat', $no_rawat)->update([
                    'status' => $request->status,
                    'catatan' => $request->catatan,
                    'tanggal' => now()->format('Y-m-d'),
                ]);
            }

            $latestNosep = DB::table('bridging_sep')
            ->where('no_rawat', $no_rawat)
            ->orderByDesc('no_sep') 
            ->value('no_sep') ?? $request->nosep;


            DB::table('mlite_vedika_feedback')->insert([
                'nosep' => $latestNosep,
                'tanggal' => now()->format('Y-m-d'),
                'catatan' => $request->catatan,
                'username' => Auth::user()->username ?? 'system',
            ]);


            DB::commit();
            Cache::forget("vedika_data_$no_rawat");

            return back()->with('success', 'Status klaim berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
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

        return view('rawatinap.statusklaim', compact('berkas', 'no_rawat'));
    }
    public function lihatPemeriksaan($no_rawat)
    {
        $data = DB::table('pemeriksaan_ranap')
            ->join('reg_periksa', 'pemeriksaan_ranap.no_rawat', '=', 'reg_periksa.no_rawat')
            ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
            ->join('dokter', 'reg_periksa.kd_dokter', '=', 'dokter.kd_dokter')
            ->select(
                'pemeriksaan_ranap.*',
                'reg_periksa.no_rkm_medis',
                'pasien.nm_pasien',
                'dokter.nm_dokter'
            )
            ->where('pemeriksaan_ranap.no_rawat', $no_rawat)
            ->orderBy('pemeriksaan_ranap.tgl_perawatan', 'desc')
            ->orderBy('pemeriksaan_ranap.jam_rawat', 'desc')
            ->get();

        return view('rawatinap.pemeriksaan', [
            'data' => $data,
            'no_rawat' => $no_rawat,
        ]);
    }
}
