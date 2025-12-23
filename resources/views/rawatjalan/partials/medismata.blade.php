<div class="accordion" id="accordionMedisMata">
    <div class="card shadow-sm">
        <div class="card-header py-2 px-3" id="headingMedisMata">
            <h5 class="mb-0" style="font-size: 1rem;">
                <button class="btn btn-link w-100 text-left text-dark" type="button"
                    data-toggle="collapse" data-target="#collapseMedisMata"
                    aria-expanded="false" aria-controls="collapseMedisMata">
                    <strong>Penilaian Awal Medis Mata</strong>
                    <i class="fas fa-chevron-down ml-2 rotate-icon"></i>
                </button>
            </h5>
        </div>

        <div id="collapseMedisMata" class="collapse" aria-labelledby="headingMedisMata"
            data-parent="#accordionMedisMata">
            <div class="card-body p-2">
                @if (!empty($medis_mata) && $medis_mata->count() > 0)

                    <div class="accordion" id="pemeriksaanMedisMata">

                        @foreach ($medis_mata as $index => $item)
                            @php
                                $headingId = "headingMedisMata_" . $index;
                                $collapseId = "collapseMedisMata_" . $index;
                            @endphp

                            <div class="card mb-2">
                                <div class="card-header py-2 px-3" id="{{ $headingId }}">
                                    <h6 class="mb-0">
                                        <button class="btn btn-link btn-sm w-100 text-left collapsed"
                                            type="button" data-toggle="collapse"
                                            data-target="#{{ $collapseId }}"
                                            aria-expanded="false"
                                            aria-controls="{{ $collapseId }}">
                                            <strong>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y H:i') }}</strong>
                                            <span class="float-right text-muted">
                                                <i class="fas fa-user-md"></i> {{ $item->nm_dokter ?? $item->kd_dokter }}
                                            </span>
                                        </button>
                                    </h6>
                                </div>

                                <div id="{{ $collapseId }}" class="collapse"
                                    aria-labelledby="{{ $headingId }}" data-parent="#pemeriksaanMedisMata">
                                    <div class="card-body p-2">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-sm table-bordered mb-3">
                                                    <thead class="bg-light">
                                                        <tr><th colspan="4" class="text-center">Identitas Pemeriksaan</th></tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <th style="width:25%">Tanggal</th><td>{{ $item->tanggal }}</td>
                                                            <th style="width:25%">Dokter</th><td>{{ $item->nm_dokter ?? $item->kd_dokter }}</td>
                                                        </tr>
                                                        <tr><th>No. Rawat</th><td colspan="3">{{ $item->no_rawat }}</td></tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="col-md-12">
                                                <table class="table table-sm table-bordered mb-3">
                                                    <thead class="bg-light"><tr><th colspan="2" class="text-center">Anamnesis</th></tr></thead>
                                                    <tbody>
                                                        <tr><th>Jenis Anamnesis</th><td>{{ $item->anamnesis }}</td></tr>
                                                        <tr><th>Hubungan</th><td>{{ $item->hubungan }}</td></tr>
                                                        <tr><th>Keluhan Utama</th><td>{{ $item->keluhan_utama }}</td></tr>
                                                        <tr><th>RPS</th><td>{{ $item->rps }}</td></tr>
                                                        <tr><th>RPD</th><td>{{ $item->rpd }}</td></tr>
                                                        <tr><th>RPO</th><td>{{ $item->rpo }}</td></tr>
                                                        <tr><th>Alergi</th><td>{{ $item->alergi }}</td></tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-12">
                                                <table class="table table-sm table-bordered mb-3">
                                                    <thead class="bg-light"><tr><th colspan="6" class="text-center">Tanda Vital</th></tr></thead>
                                                    <tbody>
                                                        <tr>
                                                            <th>Status</th><td>{{ $item->status }}</td>
                                                            <th>TD</th><td>{{ $item->td }}</td>
                                                            <th>Nadi</th><td>{{ $item->nadi }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>RR</th><td>{{ $item->rr }}</td>
                                                            <th>Suhu</th><td>{{ $item->suhu }}</td>
                                                            <th>Nyeri</th><td>{{ $item->nyeri }}</td>
                                                        </tr>
                                                        <tr><th>Berat Badan</th><td colspan="5">{{ $item->bb }}</td></tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-12">
                                                <table class="table table-sm table-bordered mb-3">
                                                    <thead class="bg-light"><tr><th colspan="4" class="text-center">Pemeriksaan Mata</th></tr></thead>
                                                    <tbody>
                                                        <tr><th>Visus Kanan</th><td>{{ $item->visuskanan }}</td><th>Visus Kiri</th><td>{{ $item->visuskiri }}</td></tr>
                                                        <tr><th>Koreksi Kanan</th><td>{{ $item->koreksikanan }}</td><th>Koreksi Kiri</th><td>{{ $item->koreksikiri }}</td></tr>
                                                        <tr><th>CC Kanan</th><td>{{ $item->cckanan }}</td><th>CC Kiri</th><td>{{ $item->cckiri }}</td></tr>
                                                        <tr><th>PAL Kanan</th><td>{{ $item->palkanan }}</td><th>PAL Kiri</th><td>{{ $item->palkiri }}</td></tr>
                                                        <tr><th>Conjunctiva Kanan</th><td>{{ $item->conkanan }}</td><th>Conjunctiva Kiri</th><td>{{ $item->conkiri }}</td></tr>
                                                        <tr><th>Cornea Kanan</th><td>{{ $item->corneakanan }}</td><th>Cornea Kiri</th><td>{{ $item->corneakiri }}</td></tr>
                                                        <tr><th>COA Kanan</th><td>{{ $item->coakanan }}</td><th>COA Kiri</th><td>{{ $item->coakiri }}</td></tr>
                                                        <tr><th>Pupil Kanan</th><td>{{ $item->pupilkanan }}</td><th>Pupil Kiri</th><td>{{ $item->pupilkiri }}</td></tr>
                                                        <tr><th>Iris Kanan</th><td>{{ $item->iriskanan }}</td><th>Iris Kiri</th><td>{{ $item->iriskiri }}</td></tr>
                                                        <tr><th>Lensa Kanan</th><td>{{ $item->lensakanan }}</td><th>Lensa Kiri</th><td>{{ $item->lensakiri }}</td></tr>
                                                        <tr><th>Fundus Kanan</th><td>{{ $item->funduskanan }}</td><th>Fundus Kiri</th><td>{{ $item->funduskiri }}</td></tr>
                                                        <tr><th>Papil Kanan</th><td>{{ $item->papilkanan }}</td><th>Papil Kiri</th><td>{{ $item->papilkiri }}</td></tr>
                                                        <tr><th>Retina Kanan</th><td>{{ $item->retinakanan }}</td><th>Retina Kiri</th><td>{{ $item->retinakiri }}</td></tr>
                                                        <tr><th>Makula Kanan</th><td>{{ $item->makulakanan }}</td><th>Makula Kiri</th><td>{{ $item->makulakiri }}</td></tr>
                                                        <tr><th>TIO Kanan</th><td>{{ $item->tiokanan }}</td><th>TIO Kiri</th><td>{{ $item->tiokiri }}</td></tr>
                                                        <tr><th>MBO Kanan</th><td>{{ $item->mbokanan }}</td><th>MBO Kiri</th><td>{{ $item->mbokiri }}</td></tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-12">
                                                <table class="table table-sm table-bordered mb-3">
                                                    <thead class="bg-light"><tr><th class="text-center">Penunjang</th></tr></thead>
                                                    <tbody><tr><td>{!! nl2br(e($item->penunjang)) !!}</td></tr></tbody>
                                                </table>

                                                <table class="table table-sm table-bordered mb-3">
                                                    <thead class="bg-light"><tr><th colspan="3" class="text-center">Hasil Penunjang Lain</th></tr></thead>
                                                    <tbody>
                                                        <tr><th style="width:20%">Lab</th><td colspan="2">{!! nl2br(e($item->lab)) !!}</td></tr>
                                                        <tr><th>Radiologi</th><td colspan="2">{!! nl2br(e($item->rad)) !!}</td></tr>
                                                        <tr><th>Tes</th><td colspan="2">{!! nl2br(e($item->tes)) !!}</td></tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-12">
                                                <table class="table table-sm table-bordered mb-3">
                                                    <thead class="bg-light"><tr><th colspan="2" class="text-center">Diagnosis</th></tr></thead>
                                                    <tbody>
                                                        <tr><th>Diagnosis Utama</th><td>{{ $item->diagnosis }}</td></tr>
                                                        <tr><th>Diagnosis Banding</th><td>{{ $item->diagnosisbdg }}</td></tr>
                                                        <tr><th>Permasalahan</th><td>{!! nl2br(e($item->permasalahan)) !!}</td></tr>
                                                    </tbody>
                                                </table>

                                                <table class="table table-sm table-bordered mb-3">
                                                    <thead class="bg-light"><tr><th colspan="2" class="text-center">Terapi & Tindakan</th></tr></thead>
                                                    <tbody>
                                                        <tr><th>Terapi</th><td>{!! nl2br(e($item->terapi)) !!}</td></tr>
                                                        <tr><th>Tindakan</th><td>{!! nl2br(e($item->tindakan)) !!}</td></tr>
                                                        <tr><th>Edukasi</th><td>{{ $item->edukasi }}</td></tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        
@if (!empty($item->photos) && count($item->photos) > 0)
<div class="col-md-12 mb-3">

    <table class="table table-sm table-bordered mb-3">
        <thead class="bg-light">
            <tr>
                <th class="text-center">Gambar Pemeriksaan</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>

                    <div class="d-flex flex-wrap justify-content-center" style="gap: 15px;">
                        @foreach ($item->photos as $photo)
                            <div style="max-width: 700px; width: 100%;">
                                <img src="{{ $photo }}"
                                     class="img-thumbnail shadow-sm"
                                     style="width: 100%; height: auto; border-radius: 6px;">
                            </div>
                        @endforeach
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endif
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>

                @else
                    <div class="alert alert-info m-0">
                        <i class="fas fa-info-circle"></i> Belum ada data pemeriksaan untuk pasien ini.
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
