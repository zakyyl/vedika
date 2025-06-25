<div class="card shadow-sm">
    <div class="card-header py-2 px-3">
        <h5 class="card-title mb-0" style="font-size: 1rem;">Surat Kontrol Terakhir</h5>
    </div>
    <div class="card-body py-2 px-3" style="font-size: 0.875rem;">
        @if($suratKontrol->count())
            <div class="accordion" id="suratKontrolAccordion">
                @foreach ($suratKontrol as $index => $skdp)
                    <div class="card mb-2">
                        <div class="card-header py-2 px-3" id="skdpHeading{{ $index }}">
                            <h6 class="mb-0" style="font-size: 0.875rem;">
                                <button class="btn btn-link p-0 w-100 text-left collapsed" type="button"
                                        data-toggle="collapse"
                                        data-target="#skdpCollapse{{ $index }}"
                                        aria-expanded="false"
                                        aria-controls="skdpCollapse{{ $index }}">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span><strong>{{ $skdp->tanggal_datang }}</strong> - {{ $skdp->no_antrian }}</span>
                                        <span class="text-muted">{{ $skdp->nm_dokter }}</span>
                                    </div>
                                </button>
                            </h6>
                        </div>
                        <div id="skdpCollapse{{ $index }}"
                             class="collapse"
                             aria-labelledby="skdpHeading{{ $index }}"
                             data-parent="#suratKontrolAccordion">
                            <div class="card-body py-2 px-3" style="font-size: 0.875rem;">
                                <p class="mb-1"><strong>Diagnosa:</strong> {{ $skdp->diagnosa }}</p>
                                <p class="mb-1"><strong>Terapi:</strong> {{ $skdp->terapi }}</p>
                                <p class="mb-1"><strong>Alasan 1:</strong> {{ $skdp->alasan1 }}</p>
                                <p class="mb-1"><strong>RTL 1:</strong> {{ $skdp->rtl1 }}</p>
                                <p class="mb-1"><strong>RTL 2:</strong> {{ $skdp->rtl2 }}</p>
                                <p class="mb-0"><strong>Alasan 2:</strong> {{ $skdp->alasan2 }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info py-2 px-3 mb-0" style="font-size: 0.875rem;">
                <i class="fas fa-info-circle"></i> Belum ada data pemeriksaan untuk pasien ini.
            </div>
        @endif
    </div>
</div>
