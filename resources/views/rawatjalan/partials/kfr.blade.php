<div class="accordion" id="accordionKFR">
    <div class="card shadow-sm">
        <div class="card-header py-2 px-3" id="headingKFR">
            <h5 class="mb-0" style="font-size: 1rem;">
                <button class="btn btn-link w-100 text-left text-dark" type="button" data-toggle="collapse"
                    data-target="#collapseKFR" aria-expanded="false" aria-controls="collapseKFR">
                    <strong>Pemeriksaan KFR</strong>
                    <i class="fas fa-chevron-down ml-2 rotate-icon"></i>
                </button>
            </h5>
        </div>

        <div id="collapseKFR" class="collapse" aria-labelledby="headingKFR" data-parent="#accordionKFR">
            <div class="card-body px-2 py-3">
                <div class="accordion" id="kfrAccordion">

                    {{-- Uji Fungsi KFR --}}
                    <div class="card shadow-sm">
                        <div class="card-header py-2 px-3" id="headingUjiFungsiKFR">
                            <h5 class="mb-0" style="font-size: 1rem;">
                                <button class="btn btn-link p-0 w-100 text-left" type="button" data-toggle="collapse"
                                    data-target="#collapseUjiFungsiKFR" aria-expanded="false"
                                    aria-controls="collapseUjiFungsiKFR">
                                    Uji Fungsi KFR
                                </button>
                            </h5>
                        </div>
                        <div id="collapseUjiFungsiKFR" class="collapse" aria-labelledby="headingUjiFungsiKFR"
                            data-parent="#kfrAccordion">
                            <div class="card-body py-2 px-3" style="font-size: 0.875rem;">
                                @if (!empty($uji_fungsi_kfr) && count($uji_fungsi_kfr))
                                    <ul class="list-group">
                                        @foreach ($uji_fungsi_kfr as $item)
                                            <li class="list-group-item">
                                                <div><strong>Diagnosis Fungsional:</strong> {{ $item->diagnosis_fungsional }}</div>
                                                <div><strong>Diagnosis Medis:</strong> {{ $item->diagnosis_medis }}</div>
                                                <div><strong>Hasil Didapat:</strong> {{ $item->hasil_didapat }}</div>
                                                <div><strong>Kesimpulan:</strong> {{ $item->kesimpulan }}</div>
                                                <div><strong>Rekomedasi:</strong> {{ $item->rekomedasi }}</div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="alert alert-info mb-0"><i class="fas fa-info-circle"></i> Tidak ada data Uji Fungsi KFR.</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Layanan Kedokteran Fisik Rehabilitasi --}}
                    <div class="card shadow-sm mt-2">
                        <div class="card-header py-2 px-3" id="headingLayananKFR">
                            <h5 class="mb-0" style="font-size: 1rem;">
                                <button class="btn btn-link p-0 w-100 text-left collapsed" type="button"
                                    data-toggle="collapse" data-target="#collapseLayananKFR" aria-expanded="false"
                                    aria-controls="collapseLayananKFR">
                                    Layanan Kedokteran Fisik Rehabilitasi
                                </button>
                            </h5>
                        </div>
                        <div id="collapseLayananKFR" class="collapse" aria-labelledby="headingLayananKFR"
                            data-parent="#kfrAccordion">
                            <div class="card-body py-2 px-3" style="font-size: 0.875rem;">
                                @if (!empty($layanan_kfr) && count($layanan_kfr))
                                    <ul class="list-group">
                                        @foreach ($layanan_kfr as $item)
                                            <li class="list-group-item">
                                                <div><strong>Kode Dokter:</strong> {{ $item->kd_dokter }}</div>
                                                <div><strong>Pendamping:</strong> {{ $item->pendamping }}</div>
                                                @if ($item->keterangan_pendamping)
                                                    <div class="mb-2"><strong>Keterangan Pendamping:</strong> {{ $item->keterangan_pendamping }}</div>
                                                @endif
                                                <div class="mb-2"><strong>Anamnesa:</strong><br>{{ $item->anamnesa }}</div>
                                                <div class="mb-2"><strong>Pemeriksaan Fisik:</strong><br>{{ $item->pemeriksaan_fisik }}</div>
                                                <div class="mb-2"><strong>Diagnosa Medis:</strong> {{ $item->diagnosa_medis }}</div>
                                                <div class="mb-2"><strong>Diagnosa Fungsi:</strong> {{ $item->diagnosa_fungsi }}</div>
                                                <div class="mb-2"><strong>Tatalaksana:</strong><br>{{ $item->tatalaksana }}</div>
                                                <div class="mb-2"><strong>Anjuran:</strong> {{ $item->anjuran }}</div>
                                                <div class="mb-2"><strong>Evaluasi:</strong> {{ $item->evaluasi }}</div>
                                                <div><strong>Suspek Penyakit Kerja:</strong> {{ $item->suspek_penyakit_kerja }}</div>
                                                @if ($item->keterangan_suspek_penyakit_kerja)
                                                    <div><strong>Keterangan:</strong> {{ $item->keterangan_suspek_penyakit_kerja }}</div>
                                                @endif
                                                <div><strong>Status Program:</strong> {{ $item->status_program }}</div>
                                                <div><strong>Goals:</strong> {{ $item->goals }}</div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="alert alert-info mb-0"><i class="fas fa-info-circle"></i> Tidak ada data Layanan Kedokteran Fisik Rehabilitasi.</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Layanan Program KFR --}}
                    <div class="card shadow-sm mt-2">
                        <div class="card-header py-2 px-3" id="headingLayananProgramKFR">
                            <h5 class="mb-0" style="font-size: 1rem;">
                                <button class="btn btn-link p-0 w-100 text-left collapsed" type="button"
                                    data-toggle="collapse" data-target="#collapseLayananProgramKFR"
                                    aria-expanded="false" aria-controls="collapseLayananProgramKFR">
                                    Layanan Program KFR
                                </button>
                            </h5>
                        </div>
                        <div id="collapseLayananProgramKFR" class="collapse" aria-labelledby="headingLayananProgramKFR"
                            data-parent="#kfrAccordion">
                            <div class="card-body py-2 px-3" style="font-size: 0.8rem;">
                                <div class="mb-2">
                                    <button id="toggleDataKFR" class="btn btn-sm btn-primary">
                                        Lihat Berdasarkan No Rawat Layanan
                                    </button>
                                </div>

                                {{-- Data Berdasarkan No Rawat --}}
                                <div id="dataByNoRawat">
                                    @if (!empty($layanan_program_kfr['byNoRawat']) && count($layanan_program_kfr['byNoRawat']))
                                        @include('partials.kfr-list', ['items' => $layanan_program_kfr['byNoRawat']])
                                    @else
                                        <div class="alert alert-info mb-0" style="font-size: 0.8rem;">
                                            <i class="fas fa-info-circle"></i> Tidak ada data Layanan Program KFR berdasarkan No Rawat.
                                        </div>
                                    @endif
                                </div>

                                {{-- Data Berdasarkan No Rawat Layanan --}}
                                <div id="dataByNoRawatLayanan" style="display: none;">
                                    @if (!empty($layanan_program_kfr['byNoRawatLayanan']) && count($layanan_program_kfr['byNoRawatLayanan']))
                                        @include('partials.kfr-list', ['items' => $layanan_program_kfr['byNoRawatLayanan']])
                                    @else
                                        <div class="alert alert-info mb-0" style="font-size: 0.8rem;">
                                            <i class="fas fa-info-circle"></i> Tidak ada data Layanan Program KFR berdasarkan No Rawat Layanan.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div> {{-- end inner accordion --}}
            </div>
        </div>
    </div>
</div>

{{-- Script Toggle --}}
<script>
document.getElementById('toggleDataKFR').addEventListener('click', function() {
    let byNoRawat = document.getElementById('dataByNoRawat');
    let byNoRawatLayanan = document.getElementById('dataByNoRawatLayanan');

    if (byNoRawat.style.display === 'none') {
        byNoRawat.style.display = 'block';
        byNoRawatLayanan.style.display = 'none';
        this.textContent = 'Lihat Berdasarkan No Rawat Layanan';
    } else {
        byNoRawat.style.display = 'none';
        byNoRawatLayanan.style.display = 'block';
        this.textContent = 'Lihat Berdasarkan No Rawat';
    }
});
</script>
