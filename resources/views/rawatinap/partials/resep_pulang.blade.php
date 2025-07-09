<div class="accordion mt-3" id="accordionResepPulang">
    <div class="card shadow-sm">
        <div class="card-header py-2 px-3" id="headingResepPulang">
            <h5 class="mb-0" style="font-size: 1rem;">
                <button class="btn btn-link w-100 text-left text-dark" type="button" data-toggle="collapse"
                    data-target="#collapseResepPulang" aria-expanded="false" aria-controls="collapseResepPulang">
                    <strong>Resep Pulang</strong>
                    <i class="fas fa-chevron-down ml-2 rotate-icon"></i>
                </button>
            </h5>
        </div>

        <div id="collapseResepPulang" class="collapse" aria-labelledby="headingResepPulang"
            data-parent="#accordionResepPulang">
            <div class="card-body p-2">
                @if (!empty($resep_pulang) && count($resep_pulang) > 0)
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
                                @foreach ($resep_pulang as $obat)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($obat->tanggal)->format('d M Y') }} |
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
                        <i class="fas fa-info-circle"></i> Tidak ada resep pulang untuk pasien ini.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
