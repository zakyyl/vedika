<div class="accordion" id="accordionOperasi">
    <div class="card shadow-sm">
        <div class="card-header py-2 px-3" id="headingOperasi">
            <h5 class="mb-0" style="font-size: 1rem;">
                <button class="btn btn-link w-100 text-left text-dark collapsed" type="button" data-toggle="collapse"
                    data-target="#collapseOperasi" aria-expanded="false" aria-controls="collapseOperasi">
                    <strong>Data Operasi & Laporan</strong>
                    <i class="fas fa-chevron-down ml-2 rotate-icon"></i>
                </button>
            </h5>
        </div>
        <div id="collapseOperasi" class="collapse" aria-labelledby="headingOperasi" data-parent="#accordionOperasi">
            <div class="card-body p-2" style="font-size: 0.875rem;">

                <h6 class="fw-bold mb-2">Data Operasi</h6>
                @if ($operasi->count())
                <ul class="list-group mb-3">
                    @foreach ($operasi as $op)
                    <li class="list-group-item">
                        <div><strong>Tanggal:</strong>
                            {{ \Carbon\Carbon::parse($op->tgl_operasi)->format('d M Y') }}</div>
                        <div><strong>Waktu:</strong> {{ $op->jam_mulai_operasi ?? '-' }} -
                            {{ $op->jam_selesai_operasi ?? '-' }}</div>
                        <div><strong>Paket:</strong> {{ $op->nm_perawatan }}</div>
                        <div><strong>Status:</strong> {{ $op->status ?? '-' }}</div>
                    </li>
                    @endforeach
                </ul>
                @else
                <div class="alert alert-info m-0"><i class="fas fa-info-circle"></i> Tidak ada data operasi.</div>
                @endif

                <hr class="my-2">

                <h6 class="fw-bold mb-2">Laporan Operasi</h6>
                @if ($laporanOperasi->count())
                @foreach ($laporanOperasi as $lap)
                <table class="table table-sm table-bordered mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th colspan="2" class="text-center">Informasi Operasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Tanggal Operasi</th>
                            <td>{{ \Carbon\Carbon::parse($lap->tanggal)->format('d M Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Selesai Operasi</th>
                            <td>{{ \Carbon\Carbon::parse($lap->selesaioperasi)->format('d M Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Diagnosa Pre-op</th>
                            <td>{{ $lap->diagnosa_preop }}</td>
                        </tr>
                        <tr>
                            <th>Diagnosa Post-op</th>
                            <td>{{ $lap->diagnosa_postop }}</td>
                        </tr>
                        <tr>
                            <th>Jaringan Dieksekusi</th>
                            <td>{{ $lap->jaringan_dieksekusi }}</td>
                        </tr>
                        <tr>
                            <th>Permintaan PA</th>
                            <td>{{ $lap->permintaan_pa }}</td>
                        </tr>
                    </tbody>
                </table>

                <table class="table table-sm table-bordered mb-3">
                    <thead class="bg-light">
                        <tr>
                            <th colspan="2" class="text-center">Laporan Operasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2">{!! nl2br(e($lap->laporan_operasi)) !!}</td>
                        </tr>
                    </tbody>
                </table>
                @endforeach
                @else
                <div class="alert alert-info m-0"><i class="fas fa-info-circle"></i> Tidak ada laporan operasi.
                </div>
                @endif

                <hr class="my-2">

                <h6 class="fw-bold mb-2">Catatan Anestesi & Sedasi</h6>

                {{-- @if (!empty($catatanAnestesiSedasi) && $catatanAnestesiSedasi->count()) --}}
                @if (!empty($catatanAnestesiSedasi) && count($catatanAnestesiSedasi) > 0)
                @foreach ($catatanAnestesiSedasi as $sedasi)

                @php
                function row($label, $value) {
                return "
                <tr>
                    <th class='w-25 align-top'>$label</th>
                    <td class='w-75 align-top'>$value</td>
                </tr>
                ";
                }
                @endphp

                <table class="table table-sm table-bordered mb-3">
                    <thead class="bg-light">
                        <tr>
                            <th colspan="2" class="text-center">Informasi Sedasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {!! row('Tanggal', \Carbon\Carbon::parse($sedasi->tanggal)->format('d M Y H:i')) !!}
                        {!! row('Dokter Bedah', $sedasi->kd_dokter_bedah) !!}
                        {!! row('Dokter Anestesi', $sedasi->kd_dokter_anestesi) !!}
                        {!! row('Diagnosa Pre-Bedah', $sedasi->diagnosa_pre_bedah) !!}
                        {!! row('Jenis Pembedahan', $sedasi->tindakan_jenis_pembedahan) !!}
                        {!! row('Diagnosa Pasca Bedah', $sedasi->diagnosa_pasca_bedah) !!}
                    </tbody>
                </table>

                <table class="table table-sm table-bordered mb-3">
                    <thead class="bg-light">
                        <tr>
                            <th colspan="2" class="text-center">Pre Induksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {!! row('Jam', $sedasi->pre_induksi_jam) !!}
                        {!! row('Kesadaran', $sedasi->pre_induksi_kesadaran) !!}
                        {!! row('TD', $sedasi->pre_induksi_td) !!}
                        {!! row('Nadi', $sedasi->pre_induksi_nadi) !!}
                        {!! row('RR', $sedasi->pre_induksi_rr) !!}
                        {!! row('Suhu', $sedasi->pre_induksi_suhu) !!}
                        {!! row('O₂', $sedasi->pre_induksi_o2) !!}
                        {!! row('TB / BB', $sedasi->pre_induksi_tb.' / '.$sedasi->pre_induksi_bb) !!}
                        {!! row('Rhesus', $sedasi->pre_induksi_rhesus) !!}
                        {!! row('HB', $sedasi->pre_induksi_hb) !!}
                        {!! row('HT', $sedasi->pre_induksi_ht) !!}
                        {!! row('Leukosit', $sedasi->pre_induksi_leko) !!}
                        {!! row('Trombosit', $sedasi->pre_induksi_trombo) !!}
                        {!! row('BT/CT', $sedasi->pre_induksi_btct) !!}
                        {!! row('GDS', $sedasi->pre_induksi_gds) !!}
                        {!! row('Lain-lain', $sedasi->pre_induksi_lainlain) !!}
                    </tbody>
                </table>

                <table class="table table-sm table-bordered mb-3">
                    <thead class="bg-light">
                        <tr>
                            <th colspan="2" class="text-center">Teknik & Alat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $teknik = [
                        'Hiopotensi' => $sedasi->teknik_alat_hiopotensi,
                        'TCI' => $sedasi->teknik_alat_tci,
                        'CPB' => $sedasi->teknik_alat_cpb,
                        'Ventilasi' => $sedasi->teknik_alat_ventilasi,
                        'Broncoskopy' => $sedasi->teknik_alat_broncoskopy,
                        'Glidescopi' => $sedasi->teknik_alat_glidescopi,
                        'USG' => $sedasi->teknik_alat_usg,
                        'Stimulator Saraf' => $sedasi->teknik_alat_stimulator_saraf,
                        ];
                        @endphp

                        @foreach ($teknik as $label => $val)
                        {!! row($label, $val ?? '-') !!}
                        @endforeach

                        {!! row('Lain-lain', $sedasi->teknik_alat_lainlain) !!}
                    </tbody>
                </table>

                <table class="table table-sm table-bordered mb-3">
                    <thead class="bg-light">
                        <tr>
                            <th colspan="2" class="text-center">Monitoring</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $monitor = [
                        'EKG' => $sedasi->monitoring_ekg,
                        'Arteri' => $sedasi->monitoring_arteri,
                        'CVP' => $sedasi->monitoring_cvp,
                        'EtCO₂' => $sedasi->monitoring_etco,
                        'Stetoskop' => $sedasi->monitoring_stetoskop,
                        'NIBP' => $sedasi->monitoring_nibp,
                        'NGT' => $sedasi->monitoring_ngt,
                        'BIS' => $sedasi->monitoring_bis,
                        'Cath A. Pulmo' => $sedasi->monitoring_cath_a_pulmo,
                        'SpO₂' => $sedasi->monitoring_spo2,
                        'Kateter' => $sedasi->monitoring_kateter,
                        'Suhu' => $sedasi->monitoring_temp,
                        ];
                        @endphp

                        @foreach ($monitor as $label => $val)
                        {!! row($label, $val ?? '-') !!}
                        @endforeach

                        {!! row('Lain-lain', $sedasi->monitoring_lainlain) !!}
                    </tbody>
                </table>

                <table class="table table-sm table-bordered mb-3">
                    <thead class="bg-light">
                        <tr>
                            <th colspan="2" class="text-center">Status Fisik & Perencanaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        {!! row('ASA', $sedasi->status_fisik_asa) !!}
                        {!! row('Alergi', $sedasi->status_fisik_alergi.' ('.$sedasi->status_fisik_alergi_keterangan.')')
                        !!}
                        {!! row('Penyulit Sedasi', $sedasi->status_fisik_penyulit_sedasi) !!}
                        {!! row('Perencanaan Lanjut', $sedasi->perencanaan_lanjut) !!}
                        {!! row('Jenis Sedasi', $sedasi->perencanaan_lanjut_sedasi.'
                        ('.$sedasi->perencanaan_lanjut_sedasi_keterangan.')') !!}
                        {!! row('Spinal', $sedasi->perencanaan_lanjut_spinal) !!}
                        {!! row('Anestesi Umum', $sedasi->perencanaan_lanjut_anestesi_umum.'
                        ('.$sedasi->perencanaan_lanjut_anestesi_umum_keterangan.')') !!}
                        {!! row('Blok Perifer', $sedasi->perencanaan_lanjut_blok_perifer.'
                        ('.$sedasi->perencanaan_lanjut_blok_perifer_keterangan.')') !!}
                        {!! row('Epidural', $sedasi->perencanaan_lanjut_epidural) !!}
                        {!! row('Status Batal', $sedasi->perencanaan_batal.' — '.$sedasi->perencanaan_batal_alasan) !!}
                        {!! row('Perawat OK', $sedasi->nip_perawat_ok) !!}
                        {!! row('Perawat Anestesi', $sedasi->nip_perawat_anestesi) !!}
                    </tbody>
                </table>

                @endforeach
                @else
                <div class="alert alert-info m-0"><i class="fas fa-info-circle"></i> Tidak ada catatan anestesi/sedasi.
                </div>
                @endif



            </div>
        </div>
    </div>
</div>