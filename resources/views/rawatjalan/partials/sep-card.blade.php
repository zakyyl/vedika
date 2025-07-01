@if ($sepData)
    <div class="card border mt-4 shadow-sm">
        <div class="card-header bg-white p-3" style="border-bottom: 2px solid #000;">
            <div class="row align-items-center">
                <div class="col-md-2">
                    <img src="{{ asset('assets/img/logo/bpjs.png') }}" alt="BPJS Kesehatan" style="height: 40px;">
                </div>
                <div class="col-md-6 text-center">
                    <h4 class="mb-1 font-weight-bold">SURAT ELIGIBILITAS PESERTA</h4>
                    <h5 class="mb-1 font-weight-bold">RUMAH SAKIT BHAYANGKARA JAMBI</h5>
                    {{-- <p class="mb-0">No Rawat : {{ $sepData->no_rawat ?? '2025/06/26/000109' }}</p> --}}
                </div>
            </div>
        </div>

        <div class="card-body p-4 small-content">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td width="25%"><strong>No. SEP</strong></td>
                            <td width="5%">:</td>
                            <td>{{ $sepData->no_sep }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tgl. SEP</strong></td>
                            <td>:</td>
                            <td>{{ \Carbon\Carbon::parse($sepData->tglsep)->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td><strong>No. Kartu</strong></td>
                            <td>:</td>
                            <td>{{ $sepData->no_kartu }} / RM : {{ $data->no_rkm_medis ?? '089322' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Nama Peserta</strong></td>
                            <td>:</td>
                            <td>{{ $sepData->nama_pasien }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tgl. Lahir</strong></td>
                            <td>:</td>
                            <td>{{ \Carbon\Carbon::parse($sepData->tanggal_lahir)->format('d/m/Y') }} &nbsp;&nbsp;&nbsp;
                                JK : {{ $sepData->jkel }}</td>
                        </tr>
                        <tr>
                            <td><strong>No.Telepon</strong></td>
                            <td>:</td>
                            <td>{{ $sepData->notelep }}</td>
                        </tr>
                        <tr>
                            <td><strong>Sub/Spesialis</strong></td>
                            <td>:</td>
                            <td>{{ $sepData->nmpolitujuan }}</td>
                        </tr>
                        <tr>
                            <td><strong>Dokter</strong></td>
                            <td>:</td>
                            <td>{{ $sepData->nmdpdjp }}</td>
                        </tr>
                        <tr>
                            <td><strong>Faskes Perujuk</strong></td>
                            <td>:</td>
                            <td>{{ $sepData->nmppkrujukan }}</td>
                        </tr>
                        <tr>
                            <td><strong>Diagnosa Awal</strong></td>
                            <td>:</td>
                            <td>{{ $sepData->nmdiagnosaawal }}</td>
                        </tr>
                        <tr>
                            <td><strong>Catatan</strong></td>
                            <td>:</td>
                            <td>{{ $sepData->catatan ?? '-' }}</td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-6">
                    <table class="table table-sm table-borderless">
                        @if ($sepData->katarak === '1.Ya')
                            <tr>
                                <td colspan="3" class="text-primary font-weight-bold">
                                    Pasien Operasi Katarak
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td width="25%"><strong>Peserta</strong></td>
                            <td width="5%">:</td>
                            <td>{{ $sepData->peserta }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jns. Rawat</strong></td>
                            <td>:</td>
                            <td>{{ $sepData->jnspelayanan == '1' ? 'Rawat Inap' : 'Rawat Jalan' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jns.Kunjungan</strong></td>
                            <td>:</td>
                            <td>{{ $sepData->tujuankunjungan == '0' ? 'Normal' : 'Kunjungan Kontrol (Ulangan)' }}</td>
                        </tr>
                        <tr>
                            <td colspan="3">&nbsp;</td>
                        </tr>
                        <tr>
                            <td><strong>Poli Perujuk</strong></td>
                            <td>:</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td><strong>Kls. Hak</strong></td>
                            <td>:</td>
                            <td>Kelas {{ $sepData->klsrawat ?? '3' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Kls. Rawat</strong></td>
                            <td>:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><strong>Penjamin</strong></td>
                            <td>:</td>
                            <td></td>
                        </tr>
                    </table>

                    {{-- <!-- Persetujuan Pasien/Keluarga Pasien -->
                    <div class="mt-3">
                        <p class="mb-1"><strong>Persetujuan Pasien/Keluarga Pasien</strong></p>
                        <div
                            style="border: 1px solid #000; width: 80px; height: 80px; display: inline-block; margin-bottom: 10px;">
                        </div>
                        <p class="mb-0 small">{{ $sepData->nama_pasien }}</p>
                    </div> --}}
                </div>
            </div>

            <div class="row">
    <div class="col-12">
        <div style="border-top: 1px solid #ccc; padding-top: 8px;">
            <p style="font-size: 10px; margin-bottom: 4px;">
                <strong>* Saya menyetujui BPJS Kesehatan untuk :</strong><br>
                a. membuka dan atau menggunakan informasi medis Pasien untuk keperluan administrasi,
                pembayaran asuransi atau jaminan pembiayaan kesehatan<br>
                b. memberikan akses informasi medis atau riwayat pelayanan kepada dokter/tenaga medis pada
                RS. BHAYANGKARA JAMBI untuk kepentingan pemeliharaan kesehatan, pengobatan, penyembuhan, dan
                perawatan Pasien
            </p>
            <p style="font-size: 10px; margin-bottom: 4px;">
                <strong>* Saya mengetahui dan memahami :</strong><br>
                a. Rumah Sakit dapat melakukan koordinasi dengan PT. Jasa Raharja / PT. Taspen / PT. ASABRI
                / BPJS Ketenagakerjaan atau Penjamin lainnya,<br>
                Jika Peserta merupakan pasien yang mengalami kecelakaan lalu lintas dan Pasien akan dirujuk
            </p>
            <p style="font-size: 10px; margin-bottom: 4px;">
                <strong>** Dengan tampilnya luaran SEP elektronik ini merupakan hasil validasi terhadap
                    eligibilitas Pasien secara elektronik (validasi finger print atau biometrik / sistem
                    validasi lain) dan selanjutnya Pasien dapat memperoleh pelayanan kesehatan rujukan
                    sesuai ketentuan berlaku. Kebenaran dan keabsahan atas informasi data Pasien menjadi
                    tanggung jawab penuh FKRTL</strong>
            </p>
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="col-12 text-left">
        <p style="font-size: 10px; margin-bottom: 2px;">
            Cetakan ke 1 &nbsp;&nbsp; {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}<br>
            Histori Kasus KLL/KK/PAK: {{ $sepData->keterangankkl ?? 'KOSONG' }}
        </p>
    </div>
</div>

        </div>
    </div>

    <!-- Custom CSS untuk print -->
    <style>
        @media print {
            .card {
                border: 2px solid #000 !important;
                box-shadow: none !important;
            }

            .card-header {
                border-bottom: 2px solid #000 !important;
                background-color: white !important;
            }

            .table td {
                padding: 2px 4px !important;
                vertical-align: top;
            }

            .small {
                font-size: 10px !important;
            }

            body {
                font-family: Arial, sans-serif;
                font-size: 12px;
            }
        }
        <style>
    .small-content {
        font-size: 12px;
    }

    .small-content .table td,
    .small-content .table th {
        font-size: 12px;
        padding: 4px 6px;
    }

    .small-content h4,
    .small-content h5,
    .small-content p {
        font-size: 13px;
        margin-bottom: 4px;
    }

    .small-content strong {
        font-size: 12px;
    }

    /* Optional: Untuk header teks tengah di atas logo */
    .card-header h4,
    .card-header h5 {
        font-size: 14px;
    }
</style>

    </style>
@endif
