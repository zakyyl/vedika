<div class="accordion" id="accordionLabPA">
    <div class="card shadow-sm">
        <div class="card-header py-2 px-3" id="headingLabPA">
            <h5 class="mb-0" style="font-size: 1rem;">
                <button class="btn btn-link w-100 text-left text-dark" type="button" data-toggle="collapse"
                    data-target="#collapseLabPA" aria-expanded="false" aria-controls="collapseLabPA">
                    <strong>Hasil Laboratorium PA</strong>
                    <i class="fas fa-chevron-down ml-2 rotate-icon"></i>
                </button>
            </h5>
        </div>

        <div id="collapseLabPA" class="collapse" aria-labelledby="headingLabPA" data-parent="#accordionLabPA">
            <div class="card-body p-2">
                @if (!empty($laboratorium_pa) && count($laboratorium_pa) > 0)
                    <div class="accordion" id="hasilLabPAAccordion">
                        @foreach ($laboratorium_pa as $index => $pa)
                            @php
                                $collapseId = 'collapseLabPA_' . $index;
                                $headingId = 'headingLabPA_' . $index;
                            @endphp
                            <div class="card mb-2">
                                <div class="card-header py-2 px-3" id="{{ $headingId }}">
                                    <h6 class="mb-0">
                                        <button class="btn btn-link btn-sm w-100 text-left collapsed" type="button"
                                            data-toggle="collapse" data-target="#{{ $collapseId }}"
                                            aria-expanded="false" aria-controls="{{ $collapseId }}">
                                            <strong>{{ $pa->tgl_periksa ? \Carbon\Carbon::parse($pa->tgl_periksa)->format('d M Y') : '-' }}</strong>
                                            - {{ $pa->jam ?? '-' }}
                                            <span class="float-right text-muted">
                                                <i class="fas fa-vial"></i> No Lab: {{ $pa->nolab ?? '-' }}
                                            </span>
                                        </button>
                                    </h6>
                                </div>
                                <div id="{{ $collapseId }}" class="collapse"
                                    aria-labelledby="{{ $headingId }}" data-parent="#hasilLabPAAccordion">
                                    <div class="card-body p-2">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered mb-0">
                                                <tbody>
                                                    <tr>
                                                        <th width="20%">Cara</th>
                                                        <td>{{ $pa->cara ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Lokasi</th>
                                                        <td>{{ $pa->lokasi ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Diagnosa Klinik</th>
                                                        <td>{{ $pa->diagnosa_klinik ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Makroskopik</th>
                                                        <td>{{ $pa->makroskopik ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Mikroskopik</th>
                                                        <td>{{ $pa->mikroskopik ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Kesan</th>
                                                        <td>{{ $pa->kesan ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Kesimpulan</th>
                                                        <td>{{ $pa->kesimpulan ?? '-' }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info m-0">
                        <i class="fas fa-info-circle"></i> Tidak ada data Laboratorium PA untuk pasien ini.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
