<div class="accordion" id="accordionPenilaianIgd">
    <div class="card shadow-sm">
        <div class="card-header py-2 px-3" id="headingPenilaianIgd">
            <h5 class="mb-0" style="font-size: 1rem;">
                <button class="btn btn-link w-100 text-left text-dark" type="button" data-toggle="collapse"
                    data-target="#collapsePenilaianIgd" aria-expanded="false" aria-controls="collapsePenilaianIgd">
                    <strong>Penilaian Medis IGD</strong>
                    <i class="fas fa-chevron-down ml-2 rotate-icon"></i>
                </button>
            </h5>
        </div>

        <div id="collapsePenilaianIgd" class="collapse" aria-labelledby="headingPenilaianIgd"
            data-parent="#accordionPenilaianIgd">
            <div class="card-body p-2">
                @if ($penilaianIgd && count($penilaianIgd) > 0)

                    @php
                        // Label khusus untuk beberapa field
                        $customLabels = [
                            'rpd' => 'Riawat Penyakit Dahulu',
                            'rps' => 'Riwayat Penyakit Sekarang',
                            'rpk' => 'Riwayat Penyakit Keluarga',
                            'rpo' => 'Riwayat Pengobatan',
                            'td' => 'Tekanan Darah',
                            'rr' => 'Pernapasan',
                            'gcs' => 'GCS (Glasgow Coma Scale)',
                            'hubungan' => 'Hubungan Pasien',
                            'keluhan_utama' => 'Keluhan Utama',
                        ];
                        $hiddenFields = ['no_rawat']; // field yang tidak ditampilkan
                    @endphp

                    <div class="accordion" id="penilaianIgdAccordion">
                        @foreach ($penilaianIgd as $index => $item)
                            @php
                                $collapseId = 'collapsePenilaian' . $index;
                                $headingId = 'headingPenilaian' . $index;
                            @endphp
                            <div class="card mb-2">
                                <div class="card-header py-2 px-3" id="{{ $headingId }}">
                                    <h6 class="mb-0">
                                        <button class="btn btn-link btn-sm w-100 text-left collapsed" type="button"
                                            data-toggle="collapse" data-target="#{{ $collapseId }}"
                                            aria-expanded="false" aria-controls="{{ $collapseId }}">
                                            <strong>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</strong>
                                            -
                                            {{ \Carbon\Carbon::parse($item->tanggal)->format('H:i') }}
                                        </button>
                                    </h6>
                                </div>

                                <div id="{{ $collapseId }}" class="collapse" aria-labelledby="{{ $headingId }}"
                                    data-parent="#penilaianIgdAccordion">
                                    <div class="card-body p-2">
                                        <div class="pl-2">
                                            @foreach ((array) $item as $field => $value)
                                                @continue(in_array($field, $hiddenFields))
                                                <div class="d-flex small mb-1">
                                                    <div class="text-muted" style="min-width: 150px;">
                                                        {{ $customLabels[$field] ?? ucwords(str_replace('_', ' ', $field)) }}
                                                    </div>
                                                    <div class="text-dark">: {{ $value ?? '-' }}</div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info m-0">
                        <i class="fas fa-info-circle"></i> Belum ada data penilaian medis IGD untuk pasien ini.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
