<div class="accordion" id="accordionHasilLabor">
    <div class="card shadow-sm">
        <div class="card-header py-2 px-3" id="headingHasilLabor">
            <h5 class="mb-0" style="font-size: 1rem;">
                <button class="btn btn-link w-100 text-left text-dark" type="button" data-toggle="collapse"
                    data-target="#collapseHasilLabor" aria-expanded="false" aria-controls="collapseHasilLabor">
                    <strong>Hasil Pemeriksaan Laboratorium</strong>
                    <i class="fas fa-chevron-down ml-2 rotate-icon"></i>
                </button>
            </h5>
        </div>

        <div id="collapseHasilLabor" class="collapse" aria-labelledby="headingHasilLabor"
            data-parent="#accordionHasilLabor">
            <div class="card-body p-2">
                @if (!empty($laboratorium) && count($laboratorium) > 0)
                    <div class="accordion" id="hasilLaborAccordion">
                        @foreach ($laboratorium as $index => $lab)
                            @php
                                $collapseId = 'collapseLab' . $index;
                                $headingId = 'headingLab' . $index;
                            @endphp
                            <div class="card mb-2">
                                <div class="card-header py-2 px-3" id="{{ $headingId }}">
                                    <h6 class="mb-0">
                                        <button class="btn btn-link btn-sm w-100 text-left collapsed" type="button"
                                            data-toggle="collapse" data-target="#{{ $collapseId }}"
                                            aria-expanded="false" aria-controls="{{ $collapseId }}">
                                            <strong>{{ \Carbon\Carbon::parse($lab['tgl_periksa'])->format('d M Y') }}</strong>
                                            - {{ $lab['jam'] ?? '-' }}
                                            <span class="float-right text-muted">
                                                <i class="fas fa-user-md"></i> {{ $lab['nm_dokter'] ?? '-' }}
                                            </span>
                                        </button>
                                    </h6>
                                </div>
                                <div id="{{ $collapseId }}" class="collapse"
                                    aria-labelledby="{{ $headingId }}" data-parent="#hasilLaborAccordion">
                                    <div class="card-body p-2">
                                        <p><strong>Jenis Pemeriksaan:</strong> {{ $lab['nm_perawatan'] ?? '-' }}</p>
                                        @if (!empty($lab['detail_periksa_lab']))
                                            <div class="table-responsive">
                                                <table class="table table-sm table-bordered mb-0">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th>Nama Pemeriksaan</th>
                                                            <th>Hasil</th>
                                                            <th>Satuan</th>
                                                            <th>Nilai Rujukan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($lab['detail_periksa_lab'] as $detail)
                                                        <tr>
                                                            <td>{{ $detail->Pemeriksaan ?? '-' }}</td>
                                                            <td>{{ $detail->nilai ?? '-' }}</td>
                                                            <td>{{ $detail->satuan ?? '-' }}</td>
                                                            <td>{{ $detail->nilai_rujukan ?? '-' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <p class="text-muted">Tidak ada detail pemeriksaan laboratorium.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info m-0">
                        <i class="fas fa-info-circle"></i> Tidak ada data laboratorium untuk pasien ini.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
