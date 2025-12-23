<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SoapController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $soap = DB::table('pemeriksaan_ralan')
            ->join('reg_periksa', 'pemeriksaan_ralan.no_rawat', '=', 'reg_periksa.no_rawat')
            ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
            ->join('pegawai', 'pemeriksaan_ralan.nip', '=', 'pegawai.nik')
            ->select(
                'pemeriksaan_ralan.no_rawat',
                'reg_periksa.no_rkm_medis',
                'pasien.nm_pasien',
                'pemeriksaan_ralan.tgl_perawatan',
                'pemeriksaan_ralan.jam_rawat',
                'pemeriksaan_ralan.suhu_tubuh',
                'pemeriksaan_ralan.tensi',
                'pemeriksaan_ralan.nadi',
                'pemeriksaan_ralan.respirasi',
                'pemeriksaan_ralan.tinggi',
                'pemeriksaan_ralan.berat',
                'pemeriksaan_ralan.spo2',
                'pemeriksaan_ralan.gcs',
                'pemeriksaan_ralan.kesadaran',
                'pemeriksaan_ralan.keluhan',
                'pemeriksaan_ralan.pemeriksaan',
                'pemeriksaan_ralan.alergi',
                'pemeriksaan_ralan.lingkar_perut',
                'pemeriksaan_ralan.rtl',
                'pemeriksaan_ralan.penilaian',
                'pemeriksaan_ralan.instruksi',
                'pemeriksaan_ralan.evaluasi',
                'pegawai.nama as nama_petugas',
                'pegawai.jbtn'
            )
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('pasien.nm_pasien', 'like', "%{$search}%")
                        ->orWhere('pemeriksaan_ralan.no_rawat', 'like', "%{$search}%")
                        ->orWhere('reg_periksa.no_rkm_medis', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('pemeriksaan_ralan.tgl_perawatan')
            ->orderByDesc('pemeriksaan_ralan.jam_rawat')
            ->paginate(9)
            ->withQueryString();

        return view('soap.index', compact('soap'));
    }

    //old
    // public function update(Request $request, $no_rawat)
    // {
    //     $request->validate([
    //         'suhu_tubuh'     => 'nullable|string|max:10',
    //         'tensi'          => 'nullable|string|max:20',
    //         'nadi'           => 'nullable|string|max:10',
    //         'respirasi'      => 'nullable|string|max:10',
    //         'tinggi'         => 'nullable|string|max:10',
    //         'berat'          => 'nullable|string|max:10',
    //         'spo2'           => 'nullable|string|max:10',
    //         'gcs'            => 'nullable|string|max:10',
    //         'kesadaran'      => 'nullable|string|max:50',
    //         'keluhan'        => 'nullable|string',
    //         'pemeriksaan'    => 'nullable|string',
    //         'alergi'         => 'nullable|string',
    //         'lingkar_perut'  => 'nullable|string|max:10',
    //         'rtl'            => 'nullable|string',
    //         'penilaian'      => 'nullable|string',
    //         'instruksi'      => 'nullable|string',
    //         'evaluasi'       => 'nullable|string',
    //     ]);

    //     DB::table('pemeriksaan_ralan')
    //         ->where('no_rawat', $no_rawat)
    //         ->update([
    //             'suhu_tubuh'    => $request->suhu_tubuh,
    //             'tensi'         => $request->tensi,
    //             'nadi'          => $request->nadi,
    //             'respirasi'     => $request->respirasi,
    //             'tinggi'        => $request->tinggi,
    //             'berat'         => $request->berat,
    //             'spo2'          => $request->spo2,
    //             'gcs'           => $request->gcs,
    //             'kesadaran'     => $request->kesadaran,
    //             'keluhan'       => $request->keluhan,
    //             'pemeriksaan'   => $request->pemeriksaan,
    //             'alergi'        => $request->alergi,
    //             'lingkar_perut' => $request->lingkar_perut,
    //             'rtl'           => $request->rtl,
    //             'penilaian'     => $request->penilaian,
    //             'instruksi'     => $request->instruksi,
    //             'evaluasi'      => $request->evaluasi,
    //         ]);

    //     return redirect()
    //         ->route('soap.index')
    //         ->with('success', 'Data SOAP berhasil diperbarui');
    // }

    public function update(Request $request, $no_rawat)
    {
        $rules = [
            'suhu_tubuh' => 'required|string|max:10',
            'tensi'      => 'required|string|max:20',
            'nadi'       => 'required|string|max:10',
            'respirasi'  => 'required|string|max:10',
            'tinggi'     => 'required|string|max:10',
            'berat'      => 'required|string|max:10',
            'spo2'       => 'required|string|max:10',
            'gcs'        => 'required|string|max:10',
            'kesadaran'  => 'required|string|max:50',
            'keluhan'    => 'required|string',
            'pemeriksaan' => 'required|string',
            'alergi'     => 'nullable|string',
            'rtl'        => 'nullable|string',
            'instruksi'  => 'nullable|string',
            'evaluasi'   => 'nullable|string',
        ];


        $messages = [
            'required' => ':attribute wajib diisi.',
            'max' => ':attribute terlalu panjang.',
            'string' => ':attribute harus berupa teks.',
        ];

        $attributes = [
            'suhu_tubuh' => 'Suhu tubuh',
            'tensi' => 'Tensi',
            'nadi' => 'Nadi',
            'respirasi' => 'Respirasi',
            'tinggi' => 'Tinggi badan',
            'berat' => 'Berat badan',
            'spo2' => 'SpO₂',
            'gcs' => 'GCS',
            'kesadaran' => 'Kesadaran',
            'keluhan' => 'Keluhan',
            'pemeriksaan' => 'Pemeriksaan',
            'alergi' => 'Alergi',
            'lingkar_perut' => 'Lingkar perut',
            'rtl' => 'RTL',
            'penilaian' => 'Penilaian',
            'instruksi' => 'Instruksi',
            'evaluasi' => 'Evaluasi',
        ];

        $request->validate($rules, $messages, $attributes);

        DB::table('pemeriksaan_ralan')
            ->where('no_rawat', $no_rawat)
            ->update($request->only(array_keys($rules)));

        return redirect()
            ->route('soap.index')
            ->with('success', 'Data SOAP berhasil diperbarui');
    }
}
