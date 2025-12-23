<div class="accordion" id="accordionObservasiVentilator">
    <div class="card shadow-sm">
        <div class="card-header py-2 px-3" id="headingObservasiVentilator">
            <h5 class="mb-0" style="font-size: 1rem;">
                <button class="btn btn-link w-100 text-left text-dark" type="button"
                    data-toggle="collapse" data-target="#collapseObservasiVentilator"
                    aria-expanded="false" aria-controls="collapseObservasiVentilator">
                    <strong>Catatan Observasi Ventilator</strong>
                    <i class="fas fa-chevron-down ml-2 rotate-icon"></i>
                </button>
            </h5>
        </div>

        <div id="collapseObservasiVentilator" class="collapse"
            aria-labelledby="headingObservasiVentilator"
            data-parent="#accordionObservasiVentilator">

            <div class="card-body p-2">

                @if ($catatanObservasiVentilator && count($catatanObservasiVentilator) > 0)

                    <div style="max-height: 300px; overflow-y: auto;">

                        <table class="table table-bordered table-sm mb-0" style="font-size: 0.8rem;">
                            <thead class="thead-light text-center">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Mode</th>
                                    <th>VT</th>
                                    <th>Pakar</th>
                                    <th>RR</th>
                                    <th>REE / FPS</th>
                                    <th>EE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($catatanObservasiVentilator as $item)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($item->tgl_perawatan)->format('d-m-Y') }}</td>
                                        <td>{{ $item->jam_rawat }}</td>
                                        <td>{{ $item->mode ?? '-' }}</td>
                                        <td>{{ $item->vt ?? '-' }}</td>
                                        <td>{{ $item->pakar ?? '-' }}</td>
                                        <td>{{ $item->rr ?? '-' }}</td>
                                        <td>{{ $item->reefps ?? '-' }}</td>
                                        <td>{{ $item->ee ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>

                @else
                    <div class="alert alert-info m-0">
                        <i class="fas fa-info-circle"></i> Belum ada catatan observasi ventilator untuk pasien ini.
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
