<div class="accordion" id="accordionDataPasien">
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
            data-parent="#accordionDataPasien">
            <div class="card-body p-2">
                @if ($data && count($data) > 0)
                    <div class="accordion" id="pemeriksaanAccordion">
                        @foreach ($data as $index => $item)
                            <div class="card mb-1">
                                <div class="card-header py-2 px-3" id="heading{{ $index }}">
                                    <h6 class="mb-0">
                                        <button
                                            class="btn btn-link btn-sm text-left w-100 d-flex justify-content-between align-items-center p-1 collapsed"
                                            type="button" data-toggle="collapse" data-target="#collapse{{ $index }}"
                                            aria-expanded="false" aria-controls="collapse{{ $index }}">
                                            <span><strong>{{ $item->no_rawat }}</strong> - {{ $item->nm_pasien }} - {{ $item->no_rkm_medis }}</span>
                                            <small class="text-muted">Dr. {{ $item->nm_dokter }} |
                                                {{ \Carbon\Carbon::parse($item->tgl_perawatan)->format('d/m/Y H:i') }} |
                                                {{ $item->jam_rawat ?? '-' }}</small>
                                        </button>
                                    </h6>
                                </div>
                                <div id="collapse{{ $index }}" class="collapse"
                                    aria-labelledby="heading{{ $index }}" data-parent="#pemeriksaanAccordion">
                                    <div class="card-body p-2">
                                        <table class="table table-sm table-bordered mb-0">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th colspan="2" class="text-center">Tanda Vital</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr><th>Suhu</th><td>{{ $item->suhu_tubuh ?? '-' }} °C</td></tr>
                                                <tr><th>Tensi</th><td>{{ $item->tensi ?? '-' }} mmHg</td></tr>
                                                <tr><th>Nadi</th><td>{{ $item->nadi ?? '-' }} x/menit</td></tr>
                                                <tr><th>Respirasi</th><td>{{ $item->respirasi ?? '-' }} x/menit</td></tr>
                                                <tr><th>Tinggi Badan</th><td>{{ $item->tinggi ?? '-' }} cm</td></tr>
                                                <tr><th>Berat Badan</th><td>{{ $item->berat ?? '-' }} kg</td></tr>
                                            </tbody>
                                        </table>
                                        <table class="table table-sm table-bordered mb-2">
                                            <tbody>
                                                <tr><th>Keluhan</th><td>{{ $item->keluhan ?? '-' }}</td></tr>
                                                <tr><th>Pemeriksaan</th><td>{{ $item->pemeriksaan ?? '-' }}</td></tr>
                                                <tr><th>Penilaian</th><td>{{ $item->penilaian ?? '-' }}</td></tr>
                                                <tr><th>Rtl/Instruksi</th><td>{{ $item->rtl ?? '-' }}</td></tr>
                                            </tbody>
                                        </table>
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
