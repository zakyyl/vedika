<div class="accordion" id="accordionPemeriksaanTanggal">
    <div class="card shadow-sm">
        <div class="card-header py-2 px-3" id="headingPemeriksaan">
            <h5 class="mb-0" style="font-size: 1rem;">
                <button class="btn btn-link w-100 text-left text-dark" type="button" data-toggle="collapse"
                    data-target="#collapsePemeriksaan" aria-expanded="false" aria-controls="collapsePemeriksaan">
                    <strong>Data Pemeriksaan Pasien</strong>
                    <i class="fas fa-chevron-down ml-2 rotate-icon"></i>
                </button>
            </h5>
        </div>

        <div id="collapsePemeriksaan" class="collapse" aria-labelledby="headingPemeriksaan"
            data-parent="#accordionPemeriksaanTanggal">
            <div class="card-body p-2">
                @if ($data && count($data) > 0)
                    <div class="accordion" id="pemeriksaanPerTanggalAccordion">
                        @foreach ($data as $index => $item)
                            @php
                                $collapseId = 'collapseTanggal' . $index;
                                $headingId = 'headingTanggal' . $index;
                            @endphp
                            <div class="card mb-2">
                                <div class="card-header py-2 px-3" id="{{ $headingId }}">
                                    <h6 class="mb-0">
                                        <button class="btn btn-link btn-sm w-100 text-left collapsed" type="button"
                                            data-toggle="collapse" data-target="#{{ $collapseId }}"
                                            aria-expanded="false" aria-controls="{{ $collapseId }}">
                                            <strong>{{ \Carbon\Carbon::parse($item->tgl_perawatan)->format('d M Y') }}</strong> - {{ $item->jam_rawat ?? '-' }}
                                            <span class="float-right text-muted"><i class="fas fa-user-md"></i> {{ $item->nm_dokter }}</span>
                                        </button>
                                    </h6>
                                </div>
                                <div id="{{ $collapseId }}" class="collapse"
                                    aria-labelledby="{{ $headingId }}" data-parent="#pemeriksaanPerTanggalAccordion">
                                    <div class="card-body p-2">
                                        <p><strong>{{ $item->nm_pasien }}</strong> | RM: {{ $item->no_rkm_medis }}</p>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <table class="table table-sm table-bordered">
                                                    <thead class="bg-light">
                                                        <tr><th colspan="2" class="text-center">Tanda Vital</th></tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr><th>Suhu</th><td>{{ $item->suhu_tubuh ?? '-' }} °C</td></tr>
                                                        <tr><th>Tensi</th><td>{{ $item->tensi ?? '-' }} mmHg</td></tr>
                                                        <tr><th>Nadi</th><td>{{ $item->nadi ?? '-' }} x/menit</td></tr>
                                                        <tr><th>Respirasi</th><td>{{ $item->respirasi ?? '-' }} x/menit</td></tr>
                                                        <tr><th>Tinggi</th><td>{{ $item->tinggi ?? '-' }} cm</td></tr>
                                                        <tr><th>Berat</th><td>{{ $item->berat ?? '-' }} kg</td></tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-6">
                                                <table class="table table-sm table-bordered">
                                                    <tbody>
                                                        <tr><th>Keluhan</th><td>{{ $item->keluhan ?? '-' }}</td></tr>
                                                        <tr><th>Pemeriksaan</th><td>{{ $item->pemeriksaan ?? '-' }}</td></tr>
                                                        <tr><th>Penilaian</th><td>{{ $item->penilaian ?? '-' }}</td></tr>
                                                        <tr><th>Instruksi</th><td>{{ $item->rtl ?? '-' }}</td></tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
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
