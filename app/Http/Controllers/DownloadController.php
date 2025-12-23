<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Exports\VedikaExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Mpdf\Mpdf; // TAMBAHKAN INI

class DownloadController extends Controller
{
    public function index(Request $request)
    {
        $tanggal_awal  = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;
        $jenis         = $request->jenis;

        $data = new LengthAwarePaginator([], 0, 10);

        if ($request->filled('jenis')) {

            $query = DB::table('mlite_vedika')
                ->join('reg_periksa', 'mlite_vedika.no_rawat', '=', 'reg_periksa.no_rawat')
                ->join('dokter', 'reg_periksa.kd_dokter', '=', 'dokter.kd_dokter')
                ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
                ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
                ->where('mlite_vedika.STATUS', 'pengajuan');

            if ($tanggal_awal && $tanggal_akhir) {
                $query->whereBetween('mlite_vedika.tgl_registrasi', [
                    $tanggal_awal,
                    $tanggal_akhir
                ]);
            }

            if ($jenis === 'ranap') {
                $query->whereIn('mlite_vedika.jenis', ['ranap', '1']);
            } elseif ($jenis === 'ralan') {
                $query->whereIn('mlite_vedika.jenis', ['ralan', '2']);
            }

            $data = $query->select([
                'mlite_vedika.tanggal as tglpengajuan',
                'mlite_vedika.tgl_registrasi',
                'mlite_vedika.no_rkm_medis',
                'mlite_vedika.no_rawat',
                'mlite_vedika.nosep',
                DB::raw("
                        CASE
                            WHEN mlite_vedika.jenis IN ('ranap','1') THEN 'Rawat Inap'
                            WHEN mlite_vedika.jenis IN ('ralan','2') THEN 'Rawat Jalan'
                            ELSE 'Tidak Diketahui'
                        END as jenis
                    "),
                'dokter.nm_dokter',
                'poliklinik.nm_poli',
                'pasien.no_peserta'
            ])
                ->paginate(10)
                ->withQueryString();
        }

        return view('download.index', compact('data'));
    }

    public function export(Request $request)
    {
        $tanggal_awal  = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;
        $jenis         = $request->jenis;

        if (!$jenis) {
            return redirect()->back()->with('error', 'Jenis layanan wajib dipilih');
        }

        $query = DB::table('mlite_vedika')
            ->join('reg_periksa', 'mlite_vedika.no_rawat', '=', 'reg_periksa.no_rawat')
            ->join('dokter', 'reg_periksa.kd_dokter', '=', 'dokter.kd_dokter')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
            ->where('mlite_vedika.STATUS', 'pengajuan');

        if ($tanggal_awal && $tanggal_akhir) {
            $query->whereBetween('mlite_vedika.tgl_registrasi', [
                $tanggal_awal,
                $tanggal_akhir
            ]);
        }

        if ($jenis === 'ranap') {
            $query->whereIn('mlite_vedika.jenis', ['ranap', '1']);
        } elseif ($jenis === 'ralan') {
            $query->whereIn('mlite_vedika.jenis', ['ralan', '2']);
        }

        $data = $query->select([
            'mlite_vedika.tanggal',
            'mlite_vedika.tgl_registrasi',
            'mlite_vedika.no_rkm_medis',
            'mlite_vedika.no_rawat',
            'mlite_vedika.nosep',
            'mlite_vedika.jenis',
            'dokter.nm_dokter',
            'poliklinik.nm_poli',
            'pasien.no_peserta'
        ])->get();

        $filename = "vedika_" . now()->format('Ymd_His') . ".csv";

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename={$filename}",
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Tanggal Pengajuan',
                'Tanggal Registrasi',
                'No RM',
                'No Rawat',
                'No SEP',
                'Jenis',
                'Dokter',
                'Poli',
                'No Peserta'
            ]);

            foreach ($data as $row) {
                fputcsv($file, [
                    $row->tanggal,
                    $row->tgl_registrasi,
                    $row->no_rkm_medis,
                    $row->no_rawat,
                    $row->nosep,
                    in_array($row->jenis, ['ranap', '1']) ? 'Rawat Inap' : 'Rawat Jalan',
                    $row->nm_dokter,
                    $row->nm_poli,
                    $row->no_peserta,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function getFilteredData(Request $request)
    {
        $query = DB::table('mlite_vedika')
            ->join('reg_periksa', 'mlite_vedika.no_rawat', '=', 'reg_periksa.no_rawat')
            ->join('dokter', 'reg_periksa.kd_dokter', '=', 'dokter.kd_dokter')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
            ->where('mlite_vedika.STATUS', 'pengajuan');

        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('mlite_vedika.tgl_registrasi', [
                $request->tanggal_awal,
                $request->tanggal_akhir
            ]);
        }

        if ($request->jenis === 'ranap') {
            $query->whereIn('mlite_vedika.jenis', ['ranap', '1']);
        } elseif ($request->jenis === 'ralan') {
            $query->whereIn('mlite_vedika.jenis', ['ralan', '2']);
        }

        return $query->select(
            'mlite_vedika.tanggal',
            'mlite_vedika.tgl_registrasi',
            'mlite_vedika.no_rkm_medis',
            'mlite_vedika.no_rawat',
            'mlite_vedika.nosep',
            'mlite_vedika.jenis',
            'dokter.nm_dokter',
            'poliklinik.nm_poli',
            'pasien.no_peserta'
        )->get();
    }

    private function getFilteredQuery(Request $request)
    {
        $query = DB::table('mlite_vedika')
            ->join('reg_periksa', 'mlite_vedika.no_rawat', '=', 'reg_periksa.no_rawat')
            ->join('dokter', 'reg_periksa.kd_dokter', '=', 'dokter.kd_dokter')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
            ->where('mlite_vedika.STATUS', 'pengajuan');

        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('mlite_vedika.tgl_registrasi', [
                $request->tanggal_awal,
                $request->tanggal_akhir
            ]);
        }

        if ($request->jenis === 'ranap') {
            $query->whereIn('mlite_vedika.jenis', ['ranap', '1']);
        } elseif ($request->jenis === 'ralan') {
            $query->whereIn('mlite_vedika.jenis', ['ralan', '2']);
        }

        return $query->select(
            'mlite_vedika.tanggal',
            'mlite_vedika.tgl_registrasi',
            'mlite_vedika.no_rkm_medis',
            'mlite_vedika.no_rawat',
            'mlite_vedika.nosep',
            'mlite_vedika.jenis',
            'dokter.nm_dokter',
            'poliklinik.nm_poli',
            'pasien.no_peserta'
        );
    }

    public function printView(Request $request)
    {
        $data = $this->getFilteredData($request);

        return view('download.print', compact('data'));
    }

    public function exportExcel(Request $request)
    {
        ini_set('pcre.backtrack_limit', '10000000');
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '512M');

        $data = $this->getFilteredData($request);

        return Excel::download(
            new VedikaExport($data),
            'vedika_' . now()->format('Ymd_His') . '.xlsx'
        );
    }

//     public function exportPdf(Request $request)
// {
//     ini_set('memory_limit', '512M');
//     ini_set('max_execution_time', 300);

//     $data = $this->getFilteredData($request);
    
//     // Kirim data filter ke view
//     $filterData = [
//         'tanggal_awal' => $request->tanggal_awal,
//         'tanggal_akhir' => $request->tanggal_akhir,
//         'jenis' => $request->jenis,
//     ];
    
//     // Render view ke HTML
//     $html = view('download.pdf', compact('data', 'filterData'))->render();
    
//     // Konfigurasi mPDF
//     $mpdf = new Mpdf([
//         'mode' => 'utf-8',
//         'format' => 'A4-L',
//         'margin_top' => 10,
//         'margin_right' => 10,
//         'margin_bottom' => 10,
//         'margin_left' => 10,
//         'default_font_size' => 9,
//         'default_font' => 'arial',
//     ]);
    
//     $mpdf->SetTitle('Data Vedika');
//     $mpdf->WriteHTML($html);
    
//     $filename = 'vedika_' . now()->format('Ymd_His') . '.pdf';
//     return $mpdf->Output($filename, 'D');
// }

// public function exportPdf(Request $request)
// {
//     ini_set('memory_limit', '512M');
//     ini_set('max_execution_time', 300);

//     $data = $this->getFilteredData($request);
    
//     // Kirim data filter ke view
//     $filterData = [
//         'tanggal_awal' => $request->tanggal_awal,
//         'tanggal_akhir' => $request->tanggal_akhir,
//         'jenis' => $request->jenis,
//     ];
    
//     // Render view ke HTML
//     $html = view('download.pdf', compact('data', 'filterData'))->render();
    
//     // Konfigurasi mPDF (TANPA tempDir, biar pakai default system)
//     $mpdf = new Mpdf([
//         'mode' => 'utf-8',
//         'format' => 'A4-L',
//         'margin_top' => 10,
//         'margin_right' => 10,
//         'margin_bottom' => 10,
//         'margin_left' => 10,
//         'default_font_size' => 9,
//         'default_font' => 'arial',
//         // HAPUS baris ini: 'tempDir' => storage_path('app/temp'),
//     ]);
    
//     $mpdf->SetTitle('Data Vedika');
//     $mpdf->WriteHTML($html);
    
//     $filename = 'vedika_' . now()->format('Ymd_His') . '.pdf';
//     return $mpdf->Output($filename, 'D');
// }

public function exportPdf(Request $request)
{
    ini_set('memory_limit', '512M');
    ini_set('max_execution_time', 300);

    $data = $this->getFilteredData($request);

    $filterData = [
        'tanggal_awal' => $request->tanggal_awal,
        'tanggal_akhir' => $request->tanggal_akhir,
        'jenis' => $request->jenis,
    ];

    // ===== TEXT PERIODE UNTUK FOOTER =====
    $periodeText = 'Semua Periode';
    if (!empty($request->tanggal_awal) && !empty($request->tanggal_akhir)) {
        $periodeText = 
            \Carbon\Carbon::parse($request->tanggal_awal)->format('d/m/Y')
            . ' s/d ' .
            \Carbon\Carbon::parse($request->tanggal_akhir)->format('d/m/Y');
    }

    $html = view('download.pdf', compact('data', 'filterData'))->render();

    $mpdf = new \Mpdf\Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4-L',
        'margin_top' => 10,
        'margin_right' => 10,
        'margin_bottom' => 15, // agak diperbesar biar footer aman
        'margin_left' => 10,
        'default_font_size' => 9,
        'default_font' => 'arial',
    ]);

    $mpdf->SetTitle('Data Vedika');

    // ===== FOOTER =====
   $mpdf->SetHTMLFooter('
    <table width="100%" cellpadding="0" cellspacing="0"
        style="font-size:8px; border:0; border-collapse:collapse;">
        <tr>
            <td width="50%" align="left" style="border:0;">
                Periode: ' . $periodeText . '
            </td>
            <td width="50%" align="right" style="border:0;">
                Halaman {PAGENO} / {nbpg}
            </td>
        </tr>
    </table>
');



    $mpdf->WriteHTML($html);

    $filename = 'vedika_' . now()->format('Ymd_His') . '.pdf';
    return $mpdf->Output($filename, 'D');
}


}
