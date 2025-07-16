<div class="accordion" id="accordionDataTindakan">
    <div class="card shadow-sm">
        <div class="card-header py-2 px-3" id="headingDataTindakan">
            <h5 class="mb-0" style="font-size: 1rem;">
                <button class="btn btn-link w-100 text-left text-dark" type="button" data-toggle="collapse"
                    data-target="#collapseDataTindakan" aria-expanded="false" aria-controls="collapseDataTindakan">
                    <strong>Data Tindakan</strong>
                    <i class="fas fa-chevron-down ml-2 rotate-icon"></i>
                </button>
            </h5>
        </div>

        <div id="collapseDataTindakan" class="collapse" aria-labelledby="headingDataTindakan"
            data-parent="#accordionDataTindakan">
            <div class="card-body px-2 py-3">
                <div class="accordion" id="tindakanAccordion">

                    <div class="card shadow-sm">
                        <div class="card-header py-2 px-3" id="headingDokter">
                            <h5 class="mb-0" style="font-size: 1rem;">
                                <button class="btn btn-link p-0 w-100 text-left" type="button" data-toggle="collapse"
                                    data-target="#collapseDokter" aria-expanded="false" aria-controls="collapseDokter">
                                    Tindakan oleh Dokter
                                </button>
                            </h5>
                        </div>
                        <div id="collapseDokter" class="collapse show" aria-labelledby="headingDokter"
                            data-parent="#tindakanAccordion">
                            <div class="card-body py-2 px-3" style="font-size: 0.875rem;">
                                @if ($rawat_inap_dr->count())
                                    <ul class="list-group">
                                        @foreach ($rawat_inap_dr as $item)
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div>
                                                    <div><strong>{{ $item->nm_dokter }}</strong> - {{ $item->nm_perawatan }}</div>
                                                    <small class="text-muted">{{ $item->tgl_perawatan }} {{ $item->jam_rawat }}</small>
                                                </div>
                                                <span class="badge bg-success">Rp{{ number_format($item->biaya_rawat, 0, ',', '.') }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="alert alert-info mb-0"><i class="fas fa-info-circle"></i> Tidak ada tindakan dokter.</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm mt-2">
                        <div class="card-header py-2 px-3" id="headingPetugas">
                            <h5 class="mb-0" style="font-size: 1rem;">
                                <button class="btn btn-link p-0 w-100 text-left collapsed" type="button"
                                    data-toggle="collapse" data-target="#collapsePetugas"
                                    aria-expanded="false" aria-controls="collapsePetugas">
                                    Tindakan oleh Petugas
                                </button>
                            </h5>
                        </div>
                        <div id="collapsePetugas" class="collapse" aria-labelledby="headingPetugas"
                            data-parent="#tindakanAccordion">
                            <div class="card-body py-2 px-3" style="font-size: 0.875rem;">
                                @if ($rawat_inap_pr->count())
                                    <ul class="list-group">
                                        @foreach ($rawat_inap_pr as $item)
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div>
                                                    <div><strong>{{ $item->nama }}</strong> - {{ $item->nm_perawatan }}</div>
                                                    <small class="text-muted">{{ $item->tgl_perawatan }} {{ $item->jam_rawat }}</small>
                                                </div>
                                                <span class="badge bg-primary">Rp{{ number_format($item->biaya_rawat, 0, ',', '.') }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="alert alert-info mb-0"><i class="fas fa-info-circle"></i> Tidak ada tindakan petugas.</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm mt-2">
                        <div class="card-header py-2 px-3" id="headingGabungan">
                            <h5 class="mb-0" style="font-size: 1rem;">
                                <button class="btn btn-link p-0 w-100 text-left collapsed" type="button"
                                    data-toggle="collapse" data-target="#collapseGabungan"
                                    aria-expanded="false" aria-controls="collapseGabungan">
                                    Tindakan oleh Dokter dan Petugas
                                </button>
                            </h5>
                        </div>
                        <div id="collapseGabungan" class="collapse" aria-labelledby="headingGabungan"
                            data-parent="#tindakanAccordion">
                            <div class="card-body py-2 px-3" style="font-size: 0.875rem;">
                                @if ($rawat_inap_drpr->count())
                                    <ul class="list-group">
                                        @foreach ($rawat_inap_drpr as $item)
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div>
                                                    <div>
                                                        <strong>{{ $item->nm_dokter }}</strong> & <strong>{{ $item->nama }}</strong>
                                                        <br>{{ $item->nm_perawatan }}
                                                    </div>
                                                    <small class="text-muted">{{ $item->tgl_perawatan }} {{ $item->jam_rawat }}</small>
                                                </div>
                                                <span class="badge bg-warning text-dark">Rp{{ number_format($item->biaya_rawat, 0, ',', '.') }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="alert alert-info mb-0"><i class="fas fa-info-circle"></i> Tidak ada tindakan dokter & petugas.</div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
