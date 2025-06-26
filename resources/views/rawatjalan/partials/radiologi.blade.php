<div class="accordion" id="accordionRadiologi">
    <div class="card shadow-sm">
        <div class="card-header py-2 px-3" id="headingRadiologi">
            <h5 class="mb-0" style="font-size: 1rem;">
                <button class="btn btn-link w-100 text-left text-dark collapsed" type="button"
                    data-toggle="collapse" data-target="#collapseRadiologi" aria-expanded="false"
                    aria-controls="collapseRadiologi">
                    <strong>Data Radiologi</strong>
                    <i class="fas fa-chevron-down ml-2 rotate-icon"></i>
                </button>
            </h5>
        </div>
        <div id="collapseRadiologi" class="collapse" aria-labelledby="headingRadiologi"
            data-parent="#accordionRadiologi">
            <div class="card-body p-2" style="font-size: 0.875rem;">
                <h6 class="fw-bold mb-2">Tindakan Radiologi</h6>
                @if ($tindakan_radiologi->count())
                    <table class="table table-sm table-bordered mb-3">
                        <thead class="bg-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Jenis Perawatan</th>
                                <th>Dokter</th>
                                <th>Petugas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tindakan_radiologi as $tr)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($tr->tgl_periksa)->format('d/m/Y H:i') }}</td>
                                    <td>{{ $tr->nm_perawatan }}</td>
                                    <td>{{ $tr->nm_dokter }}</td>
                                    <td>{{ $tr->nama }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-info m-0"><i class="fas fa-info-circle"></i> Tidak ada data tindakan radiologi.</div>
                @endif
                <h6 class="fw-bold mb-2">Hasil Radiologi</h6>
                @if ($hasil_radiologi->count())
                    @foreach ($hasil_radiologi as $hasil)
                        <table class="table table-sm table-bordered mb-3">
                            <tbody>
                                <tr>
                                    <th style="width: 30%">Tanggal</th>
                                    <td>{{ \Carbon\Carbon::parse($hasil->tgl_periksa)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Hasil</th>
                                    <td>{!! nl2br(e($hasil->hasil)) !!}</td>
                                </tr>
                            </tbody>
                        </table>
                    @endforeach
                @else
                    <div class="alert alert-info py-2 px-3 mb-0"><i class="fas fa-info-circle"></i> Tidak ada hasil radiologi.</div>
                @endif
            </div>
        </div>
    </div>
</div>
