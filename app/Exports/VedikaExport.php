<?php
namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VedikaExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data->map(function ($row) {
            return [
                $row->tanggal,
                $row->tgl_registrasi,
                $row->no_rkm_medis,
                $row->no_rawat,
                $row->nosep,
                in_array($row->jenis, ['ranap','1']) ? 'Rawat Inap' : 'Rawat Jalan',
                $row->nm_dokter,
                $row->nm_poli,
                $row->no_peserta,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Tanggal Pengajuan',
            'Tanggal Registrasi',
            'No RM',
            'No Rawat',
            'No SEP',
            'Jenis',
            'Dokter',
            'Poli',
            'No Peserta',
        ];
    }
}
