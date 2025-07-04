<div class="accordion" id="accordionDataPasien">
    <div class="card shadow-sm">
        <div class="card-header py-2 px-3" id="headingSuratKontrol">
            <h5 class="mb-0" style="font-size: 1rem;">
                <button class="btn btn-link w-100 text-left text-dark" type="button" data-toggle="collapse"
                    data-target="#collapseSuratKontrol" aria-expanded="false" aria-controls="collapseSuratKontrol">
                    <strong>Surat Kontrol Terakhir</strong>
                    <i class="fas fa-chevron-down ml-2 rotate-icon"></i>
                </button>
            </h5>
        </div>
        <div id="collapseSuratKontrol" class="collapse" aria-labelledby="headingSuratKontrol"
            data-parent="#accordionDataPasien">
            <div class="card-body py-2 px-3" style="font-size: 0.875rem;">
                @if ($suratKontrol->count())
                    <div class="accordion" id="suratKontrolAccordion">
                        @foreach ($suratKontrol as $index => $skdp)
                            <div class="card mb-2">
                                <div class="card-header py-2 px-3" id="skdpHeading{{ $index }}">
                                    <h6 class="mb-0" style="font-size: 0.875rem;">
                                        <button class="btn btn-link p-0 w-100 text-left collapsed" type="button"
                                            data-toggle="collapse" data-target="#skdpCollapse{{ $index }}"
                                            aria-expanded="false" aria-controls="skdpCollapse{{ $index }}">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span><strong>{{ $skdp->tanggal_datang }}</strong> -
                                                    {{ $skdp->no_antrian }}</span>
                                                <span class="text-muted">{{ $skdp->nm_dokter }}</span>
                                            </div>
                                        </button>
                                    </h6>
                                </div>
                                <div id="skdpCollapse{{ $index }}" class="collapse"
                                    aria-labelledby="skdpHeading{{ $index }}"
                                    data-parent="#suratKontrolAccordion">
                                    <div class="card-body py-2 px-3" style="font-size: 0.875rem;">
                                        <p class="mb-1"><strong>Diagnosa:</strong> {{ $skdp->diagnosa }}</p>
                                        <p class="mb-1"><strong>Terapi:</strong> {{ $skdp->terapi }}</p>
                                        <p class="mb-1"><br>
                                            <strong>Belum dapat dikembalikan ke Fasilitas Perujuk dengan alasan</strong><br>
                                            1. {{ $skdp->alasan1 ?? '-' }}<br>
                                            2. {{ $skdp->alasan2 ?? '-' }}
                                        </p>

                                        <p class="mb-0"><strong>Rencana tindak lanjut yang akan diberikan pada
                                                kunjungan berikutnya</strong><br>
                                            1. {{ $skdp->rtl1 ?? '-' }}<br>
                                            2. {{ $skdp->rtl2 ?? '-' }}
                                        </p>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info py-2 px-3 mb-0">
                        <i class="fas fa-info-circle"></i> Belum ada data pemeriksaan untuk pasien ini.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
