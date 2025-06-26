<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class RawatInapController extends Controller
{

    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $cacheKey = 'rawatinap_index_' . md5(serialize($request->except('page'))) . '_page_' . $page;

        $rawatInap = Cache::remember($cacheKey, 300, function () use ($request) {
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
                ->where('reg_periksa.status_lanjut', 'ralan');

                if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('reg_periksa.no_rawat', 'like', "%{$search}%")
                        ->orWhere('bridging_sep.no_sep', 'like', "%{$search}%");
                });
            }

            if ($request->filled('tgl_dari') && $request->filled('tgl_sampai')) {
                $query->whereBetween('reg_periksa.tgl_registrasi', [$request->tgl_dari, $request->tgl_sampai]);
            }

            return $query->orderBy('reg_periksa.tgl_registrasi', 'desc')
                ->orderBy('reg_periksa.jam_reg', 'desc')
                ->paginate(25)
                ->withQueryString();
        });

        $total = DB::table('reg_periksa')
            ->leftJoin('bridging_sep', 'reg_periksa.no_rawat', '=', 'bridging_sep.no_rawat')
            ->where('kd_pj', 'BP1')
            ->where('status_lanjut', 'ranap')
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->search;
                return $q->where(function ($q) use ($search) {
                    $q->where('reg_periksa.no_rawat', 'like', "%{$search}%")
                        ->orWhere('bridging_sep.no_sep', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('tgl_dari') && $request->filled('tgl_sampai'), function ($q) use ($request) {
                return $q->whereBetween('tgl_registrasi', [$request->tgl_dari, $request->tgl_sampai]);
            })
            ->count();

        return view('rawatinap.index', [
            'rawatInap' => $rawatInap,
            'total' => $total,
        ]);
    }

    public function detail($no_rawat)
    {
        $data = Cache::remember("rawatinap_detail_$no_rawat", 300, function () use ($no_rawat) {
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

        if (!$data) {
            abort(404, 'Data rawat inap tidak ditemukan');
        }

        $kategori = Cache::remember('master_berkas_digital', 3600, function () {
            return DB::table('master_berkas_digital')->get();
        });

        $berkas = Cache::remember("berkas_digital_$no_rawat", 300, function () use ($no_rawat) {
            return DB::table('berkas_digital_perawatan')
                ->join('master_berkas_digital', 'berkas_digital_perawatan.kode', '=', 'master_berkas_digital.kode')
                ->where('berkas_digital_perawatan.no_rawat', $no_rawat)
                ->select('berkas_digital_perawatan.*', 'master_berkas_digital.nama as nama_kategori')
                ->get();
        });

        $pemeriksaan = DB::table('pemeriksaan_ralan')
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

        $no_rkm_medis = DB::table('reg_periksa')
            ->where('no_rawat', $no_rawat)
            ->value('no_rkm_medis');

        $suratKontrol = DB::table('skdp_bpjs')
            ->join('dokter', 'dokter.kd_dokter', '=', 'skdp_bpjs.kd_dokter')
            ->where('skdp_bpjs.no_rkm_medis', $no_rkm_medis)
            ->orderByDesc('skdp_bpjs.tanggal_datang')
            ->limit(8)
            ->get();

        $rawatDr = DB::table('rawat_inap_dr')
            ->join('jns_perawatan', 'rawat_inap_dr.kd_jenis_prw', '=', 'jns_perawatan.kd_jenis_prw')
            ->join('dokter', 'rawat_inap_dr.kd_dokter', '=', 'dokter.kd_dokter')
            ->where('rawat_inap_dr.no_rawat', $no_rawat)
            ->select('rawat_inap_dr.*', 'jns_perawatan.nm_perawatan', 'dokter.nm_dokter')
            ->get();

        $rawatPr = DB::table('rawat_inap_pr')
            ->join('jns_perawatan', 'rawat_inap_pr.kd_jenis_prw', '=', 'jns_perawatan.kd_jenis_prw')
            ->join('petugas', 'rawat_inap_pr.nip', '=', 'petugas.nip')
            ->where('rawat_inap_pr.no_rawat', $no_rawat)
            ->select('rawat_inap_pr.*', 'jns_perawatan.nm_perawatan', 'petugas.nama as nama_petugas')
            ->get();

        $rawatDrPr = DB::table('rawat_inap_drpr')
            ->join('jns_perawatan', 'rawat_inap_drpr.kd_jenis_prw', '=', 'jns_perawatan.kd_jenis_prw')
            ->join('dokter', 'rawat_inap_drpr.kd_dokter', '=', 'dokter.kd_dokter')
            ->join('petugas', 'rawat_inap_drpr.nip', '=', 'petugas.nip')
            ->where('rawat_inap_drpr.no_rawat', $no_rawat)
            ->select('rawat_inap_drpr.*', 'jns_perawatan.nm_perawatan', 'dokter.nm_dokter', 'petugas.nama as nama_petugas')
            ->get();

        $operasi = DB::table('operasi')
            ->join('paket_operasi', 'operasi.kode_paket', '=', 'paket_operasi.kode_paket')
            ->where('operasi.no_rawat', $no_rawat)
            ->select('operasi.*', 'paket_operasi.nm_perawatan')
            ->get();

        $laporanOperasi = DB::table('laporan_operasi')
            ->where('no_rawat', $no_rawat)
            ->get();

        $tindakan_radiologi = DB::table('periksa_radiologi')
            ->join('jns_perawatan_radiologi', 'periksa_radiologi.kd_jenis_prw', '=', 'jns_perawatan_radiologi.kd_jenis_prw')
            ->join('dokter', 'periksa_radiologi.kd_dokter', '=', 'dokter.kd_dokter')
            ->join('petugas', 'periksa_radiologi.nip', '=', 'petugas.nip')
            ->where('periksa_radiologi.no_rawat', $no_rawat)
            ->select('periksa_radiologi.*', 'jns_perawatan_radiologi.nm_perawatan', 'dokter.nm_dokter', 'petugas.nama')
            ->get();

        $hasil_radiologi = DB::table('hasil_radiologi')
            ->where('no_rawat', $no_rawat)
            ->get();

            $no_sep = DB::table('bridging_sep')
    ->where('no_rawat', $no_rawat)
    ->value('no_sep');

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
            'no_sep'
        ));
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

                if (!Storage::disk('public')->exists('pages/upload')) {
                    Storage::disk('public')->makeDirectory('pages/upload');
                }

                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                $path = $file->storeAs('pages/upload', $filename, 'public');

                if (!Storage::disk('public')->exists($path)) {
                    throw new \Exception('File gagal disimpan ke storage');
                }


                Log::info('File uploaded successfully', [
                    'filename' => $filename,
                    'path' => $path,
                    'full_path' => Storage::disk('public')->path($path),
                    'no_rawat' => $no_rawat
                ]);
                DB::table('berkas_digital_perawatan')->insert([
                    'no_rawat' => $no_rawat,
                    'kode' => $request->kode,
                    'lokasi_file' => $path,

                ]);

                Cache::forget("berkas_digital_$no_rawat");
                Cache::forget("rawatinap_detail_$no_rawat");

                return back()->with('success', 'Resume keperawatan berhasil diunggah ke: ' . $path);
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
        ]);

        try {
            DB::beginTransaction();
            DB::table('mlite_vedika')->updateOrInsert(
                ['no_rawat' => $no_rawat],
                [
                    'status' => $request->status,
                    'catatan' => $request->catatan,
                    'updated_at' => now()
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
