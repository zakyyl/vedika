<div class="accordion" id="accordionObservasiPostpartum">
    <div class="card shadow-sm">
        <div class="card-header py-2 px-3" id="headingObservasiPostpartum">
            <h5 class="mb-0" style="font-size: 1rem;">
                <button class="btn btn-link w-100 text-left text-dark" type="button"
                    data-toggle="collapse" data-target="#collapseObservasiPostpartum"
                    aria-expanded="false" aria-controls="collapseObservasiPostpartum">
                    <strong>Catatan Observasi Postpartum</strong>
                    <i class="fas fa-chevron-down ml-2 rotate-icon"></i>
                </button>
            </h5>
        </div>

        <div id="collapseObservasiPostpartum" class="collapse"
            aria-labelledby="headingObservasiPostpartum"
            data-parent="#accordionObservasiPostpartum">

            <div class="card-body p-2">

                @if ($catatanObservasiPostpartum && count($catatanObservasiPostpartum) > 0)

                    <div style="max-height: 300px; overflow-y: auto;">

                        <table class="table table-bordered table-sm mb-0" style="font-size: 0.8rem;">
                            <thead class="thead-light text-center">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Tekanan Darah</th>
                                    <th>Nadi</th>
                                    <th>Saturasi Oksigen</th>
                                    <th>Kesadaran</th>
                                    <th>Pernafasan</th>
                                    <th>Suhu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($catatanObservasiPostpartum as $item)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($item->tgl_perawatan)->format('d-m-Y') }}</td>
                                        <td>{{ $item->jam_rawat ?? '-' }}</td>
                                        <td>{{ $item->td ?? '-' }}</td>
                                        <td>{{ $item->nadi ?? '-' }}</td>
                                        <td>{{ $item->spo2 ?? '-' }}</td>
                                        <td>{{ $item->kesadaran ?? '-' }}</td>
                                        <td>{{ $item->pernafasan ?? '-' }}</td>
                                        <td>{{ $item->suhu ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>

                @else
                    <div class="alert alert-info m-0">
                        <i class="fas fa-info-circle"></i> Belum ada catatan observasi Postpartum untuk pasien ini.
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
