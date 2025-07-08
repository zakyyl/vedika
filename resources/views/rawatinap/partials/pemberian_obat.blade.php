<div class="accordion mt-3" id="accordionPemberianObat">
    <div class="card shadow-sm">
        <div class="card-header py-2 px-3" id="headingPemberianObat">
            <h5 class="mb-0" style="font-size: 1rem;">
                <button class="btn btn-link w-100 text-left text-dark" type="button" data-toggle="collapse"
                    data-target="#collapsePemberianObat" aria-expanded="false" aria-controls="collapsePemberianObat">
                    <strong>Riwayat Pemberian Obat</strong>
                    <i class="fas fa-chevron-down ml-2 rotate-icon"></i>
                </button>
            </h5>
        </div>

        <div id="collapsePemberianObat" class="collapse" aria-labelledby="headingPemberianObat"
            data-parent="#accordionPemberianObat">
            <div class="card-body p-2">
                @if (!empty($pemberian_obat) && count($pemberian_obat) > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama Obat</th>
                                    <th>Jumlah</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pemberian_obat as $obat)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($obat->tgl_perawatan)->format('d M Y') }} |
                                            {{ $obat->jam ?? '-' }}</td>
                                        <td>{{ $obat->nama_brng ?? '-' }}</td>
                                        <td>{{ $obat->jml ?? '-' }}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info m-0">
                        <i class="fas fa-info-circle"></i> Tidak ada riwayat pemberian obat.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
