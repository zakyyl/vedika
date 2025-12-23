<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TriasePrimerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $triase = DB::table('data_triase_igdprimer')
            ->join('reg_periksa', 'data_triase_igdprimer.no_rawat', '=', 'reg_periksa.no_rawat')
            ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
            ->join('dokter', 'reg_periksa.kd_dokter', '=', 'dokter.kd_dokter')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->select(
                'reg_periksa.no_rkm_medis',
                'pasien.nm_pasien',
                'dokter.nm_dokter',
                'poliklinik.nm_poli',
                'data_triase_igdprimer.no_rawat',
                'data_triase_igdprimer.keluhan_utama',
                'data_triase_igdprimer.kebutuhan_khusus',
                'data_triase_igdprimer.catatan',
                'data_triase_igdprimer.plan',
                'data_triase_igdprimer.tanggaltriase'
            )
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('pasien.nm_pasien', 'like', "%{$search}%")
                      ->orWhere('data_triase_igdprimer.no_rawat', 'like', "%{$search}%")
                      ->orWhere('reg_periksa.no_rkm_medis', 'like', "%{$search}%")
                      ->orWhere('dokter.nm_dokter', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('data_triase_igdprimer.tanggaltriase')
            ->paginate(10)
            ->withQueryString();

        return view('triase_primer.index', compact('triase'));
    }

public function update(Request $request, $no_rawat)
{
    $rules = [
        'keluhan_utama'    => 'required|string',
        'kebutuhan_khusus' => 'nullable|string',
        'catatan'          => 'nullable|string',
        'plan'             => 'required|in:Ruang Kritis,Ruang Resusitasi',
    ];

    $messages = [
        'required' => ':attribute wajib diisi.',
        'plan.in'  => 'Plan triase tidak valid.',
    ];

    $attributes = [
        'keluhan_utama'    => 'Keluhan utama',
        'kebutuhan_khusus' => 'Kebutuhan khusus',
        'catatan'          => 'Catatan',
        'plan'             => 'Plan triase',
    ];

    $validated = $request->validate($rules, $messages, $attributes);

    DB::table('data_triase_igdprimer')
        ->where('no_rawat', $no_rawat)
        ->update($validated);

    return redirect()
        ->route('triase-primer.index')
        ->with('success', 'Data triase primer berhasil diperbarui');
}

}
