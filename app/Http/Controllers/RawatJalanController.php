<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache; 
use Illuminate\Support\Facades\DB;

class RawatJalanController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('reg_periksa')
            ->join('dokter', 'reg_periksa.kd_dokter', '=', 'dokter.kd_dokter')
            ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
            ->join('penjab', 'reg_periksa.kd_pj', '=', 'penjab.kd_pj')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->select(
                'reg_periksa.no_reg',
                'reg_periksa.no_rawat',
                'reg_periksa.tgl_registrasi',
                'reg_periksa.jam_reg',
                'dokter.nm_dokter',
                'reg_periksa.no_rkm_medis',
                'pasien.nm_pasien',
                DB::raw("IF(pasien.jk = 'L', 'Laki-Laki', 'Perempuan') as jk"),
                'pasien.umur',
                'poliklinik.nm_poli',
                'reg_periksa.status_lanjut',
                'reg_periksa.umurdaftar',
                'reg_periksa.sttsumur',
                'reg_periksa.p_jawab',
                'reg_periksa.almt_pj',
                'reg_periksa.hubunganpj',
                'reg_periksa.biaya_reg',
                'reg_periksa.stts_daftar',
                'penjab.png_jawab'
            )
            ->where('reg_periksa.kd_pj', 'BP1')
            ->where('reg_periksa.status_lanjut', 'ralan');

        if ($request->filled('search')) {
            $query->where('reg_periksa.no_rawat', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('tgl_dari') && $request->filled('tgl_sampai')) {
            $query->whereBetween('reg_periksa.tgl_registrasi', [$request->tgl_dari, $request->tgl_sampai]);
        }

        $total = $query->count();
        $rawatJalan = $query->paginate(25)->withQueryString();

        return view('rawatjalan.index', compact('rawatJalan', 'total'));
    }

public function detail($no_rawat)
{
    $data = Cache::remember("rawatjalan_detail_$no_rawat", 60, function () use ($no_rawat) {
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

    $kategori = DB::table('master_berkas_digital')->get();

    return view('rawatjalan.detail', compact('data', 'kategori'));
}

public function uploadResume(Request $request, $no_rawat)
{
    $request->validate([
        'kode' => 'required|exists:master_berkas_digital,kode',
        'file' => 'required|file|mimes:pdf,jpg,jpeg|max:2048',
    ]);

    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/pages/upload', $filename); // simpan ke storage/app/public/pages/upload

        DB::table('berkas_digital_perawatan')->insert([
            'no_rawat' => $no_rawat,
            'kode' => $request->kode,
            'lokasi_file' => 'pages/upload/' . $filename, // simpan path relatif dari public/storage
        ]);

        return back()->with('success', 'Resume keperawatan berhasil diunggah.');
    }

    return back()->with('error', 'Gagal mengunggah file.');
}



}
