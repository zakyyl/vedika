<div class="accordion" id="accordionObservasiKebidanan">
    <div class="card shadow-sm">
        <div class="card-header py-2 px-3" id="headingObservasiKebidanan">
            <h5 class="mb-0" style="font-size: 1rem;">
                <button class="btn btn-link w-100 text-left text-dark" type="button"
                    data-toggle="collapse" data-target="#collapseObservasiKebidanan"
                    aria-expanded="false" aria-controls="collapseObservasiKebidanan">
                    <strong>Catatan Observasi Kebidanan</strong>
                    <i class="fas fa-chevron-down ml-2 rotate-icon"></i>
                </button>
            </h5>
        </div>

        <div id="collapseObservasiKebidanan" class="collapse"
            aria-labelledby="headingObservasiKebidanan"
            data-parent="#accordionObservasiKebidanan">

            <div class="card-body p-2">

                @if ($catatanObservasiKebidanan && count($catatanObservasiKebidanan) > 0)

                    <div style="max-height: 300px; overflow-y: auto;">

                        <table class="table table-bordered table-sm mb-0" style="font-size: 0.8rem;">
                            <thead class="thead-light text-center">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>GCS</th>
                                    <th>TD</th>
                                    <th>HR</th>
                                    <th>RR</th>
                                    <th>Suhu</th>
                                    <th>SPO2</th>
                                    <th>Kontraksi</th>
                                    <th>BJJ</th>
                                    <th>PPV</th>
                                    <th>VT</th>
                                    <th>NIP</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($catatanObservasiKebidanan as $item)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($item->tgl_perawatan)->format('d-m-Y') }}</td>
                                        <td>{{ $item->jam_rawat }}</td>
                                        <td>{{ $item->gcs ?? '-' }}</td>
                                        <td>{{ $item->td ?? '-' }}</td>
                                        <td>{{ $item->hr ?? '-' }}</td>
                                        <td>{{ $item->rr ?? '-' }}</td>
                                        <td>{{ $item->suhu ?? '-' }}</td>
                                        <td>{{ $item->spo2 ?? '-' }}</td>
                                        <td>{{ $item->kontraksi ?? '-' }}</td>
                                        <td>{{ $item->bjj ?? '-' }}</td>
                                        <td>{{ $item->ppv ?? '-' }}</td>
                                        <td>{{ $item->vt ?? '-' }}</td>
                                        <td>{{ $item->nip ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>

                @else
                    <div class="alert alert-info m-0">
                        <i class="fas fa-info-circle"></i> Belum ada catatan observasi Kebidanan.
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
