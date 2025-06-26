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
                    <div class="alert alert-info py-2 px-3 mb-0"><i class="fas fa-info-circle"></i> Tidak ada laporan operasi.
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
