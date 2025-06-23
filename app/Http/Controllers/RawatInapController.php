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
        $cacheKey = 'rawatinap_index_' . md5(serialize($request->all()));

        $result = Cache::remember($cacheKey, 300, function () use ($request) {
            $query = DB::table('reg_periksa')
                ->join('dokter', 'reg_periksa.kd_dokter', '=', 'dokter.kd_dokter')
                ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
                ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
                ->select(
                    'reg_periksa.no_rawat',
                    'reg_periksa.tgl_registrasi',
                    'dokter.nm_dokter',
                    'reg_periksa.no_rkm_medis',
                    'pasien.nm_pasien',
                    'poliklinik.nm_poli'
                )
                ->where('reg_periksa.kd_pj', 'BP1')
                ->where('reg_periksa.status_lanjut', 'ranap');

            if ($request->filled('search')) {
                $query->where('reg_periksa.no_rawat', 'like', '%' . $request->search . '%');
            }

            if ($request->filled('tgl_dari') && $request->filled('tgl_sampai')) {
                $query->whereBetween('reg_periksa.tgl_registrasi', [$request->tgl_dari, $request->tgl_sampai]);
            }


            $total = DB::table('reg_periksa')
                ->where('kd_pj', 'BP1')
                ->where('status_lanjut', 'ranap')
                ->when($request->filled('search'), function ($q) use ($request) {
                    return $q->where('no_rawat', 'like', '%' . $request->search . '%');
                })
                ->when($request->filled('tgl_dari') && $request->filled('tgl_sampai'), function ($q) use ($request) {
                    return $q->whereBetween('tgl_registrasi', [$request->tgl_dari, $request->tgl_sampai]);
                })
                ->count();


            $rawatInap = $query->orderBy('reg_periksa.tgl_registrasi', 'desc')
                ->orderBy('reg_periksa.jam_reg', 'desc')
                ->simplePaginate(25)
                ->withQueryString();

            return compact('rawatInap', 'total');
        });

        return view('rawatinap.index', $result);
    }

    public function detail($no_rawat)
    {
        $data = Cache::remember("rawatinap_detail_$no_rawat", 300, function () use ($no_rawat) { 
            return DB::table('reg_periksa')
                ->join('dokter', 'reg_periksa.kd_dokter', '=', 'dokter.kd_dokter')
                ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
                ->join('penjab', 'reg_periksa.kd_pj', '=', 'penjab.kd_pj')
                ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
                ->where('reg_periksa.no_rawat', $no_rawat)
                ->select(
                    'reg_periksa.*',
                    'dokter.nm_dokter',
                    'pasien.nm_pasien',
                    'pasien.jk',
                    'pasien.umur',
                    'poliklinik.nm_poli',
                    'penjab.png_jawab'
                )
                ->first();
        });

        if (!$data) {
            abort(404, 'Data rawat inap tidak ditemukan');
        }

        $vedikaData = Cache::remember("vedika_data_$no_rawat", 180, function () use ($no_rawat) {
            return DB::table('mlite_vedika')
                ->where('no_rawat', $no_rawat)
                ->select('nosep', 'status', 'catatan')
                ->first();
        });

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

        return view('rawatinap.detail', compact('data', 'vedikaData', 'kategori', 'berkas'));
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

        return view('statusklaimranap.index', compact('berkas', 'no_rawat'));
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
