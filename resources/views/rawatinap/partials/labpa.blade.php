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
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Dokter</th>
                                    <th>Pemeriksaan</th>
                                    <th>Diagnosa Klinik</th>
                                    <th>Makroskopik</th>
                                    <th>Mikroskopik</th>
                                    <th>Kesan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($laboratorium_pa as $row)
                                    <tr>
                                        <td>{{ $row->tgl_periksa ?? '-' }}</td>
                                        <td>{{ $row->jam ?? '-' }}</td>
                                        <td>{{ $row->dokter_perujuk ?? '-' }}</td>
                                        <td>{{ $row->pemeriksaan ?? '-' }}</td>
                                        <td>{{ $row->diag_klinik ?? '-' }}</td>
                                        <td>{{ $row->makroskopik ?? '-' }}</td>
                                        <td>{{ $row->mikroskopik ?? '-' }}</td>
                                        <td>{{ $row->kesan ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
