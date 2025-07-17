<div class="accordion" id="accordionObservasiIgd">
    <div class="card shadow-sm">
        <div class="card-header py-2 px-3" id="headingObservasiIgd">
            <h5 class="mb-0" style="font-size: 1rem;">
                <button class="btn btn-link w-100 text-left text-dark" type="button"
                    data-toggle="collapse" data-target="#collapseObservasiIgd"
                    aria-expanded="false" aria-controls="collapseObservasiIgd">
                    <strong>Catatan Observasi IGD</strong>
                    <i class="fas fa-chevron-down ml-2 rotate-icon"></i>
                </button>
            </h5>
        </div>

        <div id="collapseObservasiIgd" class="collapse" aria-labelledby="headingObservasiIgd"
            data-parent="#accordionObservasiIgd">
            <div class="card-body p-2">
                @if ($catatanObservasiIgd && count($catatanObservasiIgd) > 0)

                    @php
                        $customLabels = [
                            'td' => 'Tekanan Darah',
                            'nadi' => 'Nadi',
                            'spo2' => 'Saturasi Oksigen',
                            'kesadaran' => 'Kesadaran',
                            'pernafasan' => 'Pernafasan',
                            'suhu' => 'Suhu',
                            'catatan' => 'Catatan Observasi',
                            // tambahkan label custom sesuai field database
                        ];
                        $hiddenFields = ['no_rawat', 'kd_dokter']; // sembunyikan jika perlu
                    @endphp

                    <div class="accordion" id="observasiIgdAccordion">
                        @foreach ($catatanObservasiIgd as $index => $item)
                            @php
                                $collapseId = 'collapseObservasi' . $index;
                                $headingId = 'headingObservasi' . $index;
                            @endphp
                            <div class="card mb-2">
                                <div class="card-header py-2 px-3" id="{{ $headingId }}">
                                    <h6 class="mb-0">
                                        <button class="btn btn-link btn-sm w-100 text-left collapsed" type="button"
                                            data-toggle="collapse" data-target="#{{ $collapseId }}"
                                            aria-expanded="false" aria-controls="{{ $collapseId }}">
                                            <strong>{{ \Carbon\Carbon::parse($item->tgl_perawatan)->format('d M Y') }}</strong> -
                                            {{ $item->jam_rawat ?? '-' }}
                                        </button>
                                    </h6>
                                </div>

                                <div id="{{ $collapseId }}" class="collapse"
                                    aria-labelledby="{{ $headingId }}" data-parent="#observasiIgdAccordion">
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
                        <i class="fas fa-info-circle"></i> Belum ada catatan observasi IGD untuk pasien ini.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
