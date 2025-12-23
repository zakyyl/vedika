<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TriaseController extends Controller
{
    
    public function index(Request $request)
    {
        $search = $request->search;

        $triase = DB::table('data_triase_igd')
            ->join('reg_periksa', 'data_triase_igd.no_rawat', '=', 'reg_periksa.no_rawat')
            ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
            ->join('dokter', 'reg_periksa.kd_dokter', '=', 'dokter.kd_dokter')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->select(
                'reg_periksa.no_rkm_medis',
                'pasien.nm_pasien',
                'dokter.nm_dokter',
                'poliklinik.nm_poli',
                'data_triase_igd.no_rawat',
                'data_triase_igd.tgl_kunjungan',
                'data_triase_igd.cara_masuk',
                'data_triase_igd.alat_transportasi',
                'data_triase_igd.alasan_kedatangan',
                'data_triase_igd.keterangan_kedatangan',
                'data_triase_igd.kode_kasus',
                'data_triase_igd.tekanan_darah',
                'data_triase_igd.nadi',
                'data_triase_igd.pernapasan',
                'data_triase_igd.suhu',
                'data_triase_igd.saturasi_o2',
                'data_triase_igd.nyeri'
            )
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('pasien.nm_pasien', 'like', "%{$search}%")
                      ->orWhere('data_triase_igd.no_rawat', 'like', "%{$search}%")
                      ->orWhere('reg_periksa.no_rkm_medis', 'like', "%{$search}%")
                      ->orWhere('dokter.nm_dokter', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('data_triase_igd.tgl_kunjungan')
            ->paginate(10)
            ->withQueryString();

        return view('triase.index', compact('triase'));
    }

   
    // public function update(Request $request, $no_rawat)
    // {
    //     $request->validate([
    //         'tekanan_darah' => 'nullable|string',
    //         'nadi'          => 'nullable|string',
    //         'pernapasan'    => 'nullable|string',
    //         'suhu'          => 'nullable|string',
    //         'saturasi_o2'   => 'nullable|string',
    //         'nyeri'         => 'nullable|string',
    //     ]);

    //     DB::table('data_triase_igd')
    //         ->where('no_rawat', $no_rawat)
    //         ->update([
    //             'tekanan_darah' => $request->tekanan_darah,
    //             'nadi'          => $request->nadi,
    //             'pernapasan'    => $request->pernapasan,
    //             'suhu'          => $request->suhu,
    //             'saturasi_o2'   => $request->saturasi_o2,
    //             'nyeri'         => $request->nyeri,
    //         ]);

    //     return redirect()
    //         ->route('triase.index')
    //         ->with('success', 'Data triase berhasil diperbarui');
    // }

    public function update(Request $request, $no_rawat)
{
    $rules = [
        'tekanan_darah' => 'required|string',
        'nadi'          => 'required|string',
        'pernapasan'    => 'required|string',
        'suhu'          => 'required|string',
        'saturasi_o2'   => 'required|string',
        'nyeri'         => 'required|string',
    ];

    $messages = [
        'required' => ':attribute wajib diisi.',
        'string'   => ':attribute harus berupa teks.',
    ];

    $attributes = [
        'tekanan_darah' => 'Tekanan darah',
        'nadi'          => 'Nadi',
        'pernapasan'    => 'Pernapasan',
        'suhu'          => 'Suhu',
        'saturasi_o2'   => 'Saturasi O₂',
        'nyeri'         => 'Skala nyeri',
    ];

    $request->validate($rules, $messages, $attributes);

    DB::table('data_triase_igd')
        ->where('no_rawat', $no_rawat)
        ->update($request->only(array_keys($rules)));

    return redirect()
        ->route('triase.index')
        ->with('success', 'Data triase berhasil diperbarui');
}


}
