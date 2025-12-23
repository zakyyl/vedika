<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TriaseSekunderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $triase = DB::table('data_triase_igdsekunder')
            ->join('reg_periksa', 'data_triase_igdsekunder.no_rawat', '=', 'reg_periksa.no_rawat')
            ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
            ->join('dokter', 'reg_periksa.kd_dokter', '=', 'dokter.kd_dokter')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->select(
                'reg_periksa.no_rkm_medis',
                'pasien.nm_pasien',
                'dokter.nm_dokter',
                'poliklinik.nm_poli',
                'data_triase_igdsekunder.no_rawat',
                'data_triase_igdsekunder.anamnesa_singkat',
                'data_triase_igdsekunder.catatan',
                'data_triase_igdsekunder.plan',
                'data_triase_igdsekunder.tanggaltriase'
            )
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('pasien.nm_pasien', 'like', "%{$search}%")
                      ->orWhere('data_triase_igdsekunder.no_rawat', 'like', "%{$search}%")
                      ->orWhere('reg_periksa.no_rkm_medis', 'like', "%{$search}%")
                      ->orWhere('dokter.nm_dokter', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('data_triase_igdsekunder.tanggaltriase')
            ->paginate(10)
            ->withQueryString();

        return view('triase_sekunder.index', compact('triase'));
    }

    public function update(Request $request, $no_rawat)
{
    $request->validate(
    [
        'anamnesa_singkat' => 'required|string',
        'catatan'          => 'required|string',
        'plan'             => 'required|in:Zona Kuning,Zona Hijau',
    ],
    [
        'anamnesa_singkat.required' => 'Anamnesa singkat wajib diisi.',
        'catatan.required'          => 'Catatan tidak boleh kosong.',
        'plan.required'             => 'Plan triase wajib dipilih.',
        'plan.in'                   => 'Plan triase tidak valid.',
    ]
);


    DB::table('data_triase_igdsekunder')
        ->where('no_rawat', $no_rawat)
        ->update([
            'anamnesa_singkat' => $request->anamnesa_singkat,
            'catatan'          => $request->catatan,
            'plan'             => $request->plan,
        ]);

    return redirect()
        ->route('triase-sekunder.index')
        ->with('success', 'Data triase sekunder berhasil diperbarui.');
}

}
