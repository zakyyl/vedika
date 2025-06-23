@extends('layouts.materio')

@section('content')
    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-primary mb-0">
                <i class="ti ti-clipboard-list me-2"></i>
                Data Pemeriksaan Rawat Jalan
            </h4>
        </div>

        @if ($data->isEmpty())
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="ti ti-clipboard-off display-4 text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak Ada Data Pemeriksaan</h5>
                    <p class="text-muted mb-0">Belum ada data pemeriksaan untuk No. Rawat:
                        <strong>{{ $no_rawat }}</strong>
                    </p>
                </div>
            </div>
        @else
            <div class="accordion accordion-flush" id="accordionPemeriksaan">
                @foreach ($data as $index => $item)
                    <div class="accordion-item border-0 mb-3 shadow-sm rounded-3 overflow-hidden">
                        <h2 class="accordion-header" id="heading{{ $index }}">
                            <button class="accordion-button collapsed bg-light-primary text-primary fw-semibold"
                                type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}"
                                aria-expanded="false" aria-controls="collapse{{ $index }}">
                                <div class="d-flex align-items-center w-100 flex-column flex-md-row text-start">

                                    {{-- Baris Info Utama --}}
                                    <div class="flex-grow-1 mb-2 mb-md-0">
                                        <div class="fw-bold text-dark">
                                            {{ $item->no_rawat }} | {{ $item->no_rkm_medis }} | {{ $item->nm_pasien }} |
                                            {{ $item->nm_dokter }}
                                        </div>
                                        <div class="small text-muted">
                                            {{ \Carbon\Carbon::parse($item->tgl_perawatan)->format('d M Y') }}
                                        </div>
                                        <div class="small text-muted">
                                            Petugas: {{ $item->nip }}
                                        </div>
                                    </div>

                                    {{-- Label kanan --}}
                                    <div class="text-end ms-md-3">
                                        <span class="badge bg-light-success text-White">
                                            <i class="ti ti-stethoscope me-1"></i>
                                            Selengkapnya
                                        </span>
                                    </div>

                                </div>
                            </button>
                        </h2>


                        <div id="collapse{{ $index }}" class="accordion-collapse collapse"
                            aria-labelledby="heading{{ $index }}" data-bs-parent="#accordionPemeriksaan">
                            <div class="accordion-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover table-sm mb-0" style="font-size: 0.8rem;">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Parameter</th>
                                                <th>Nilai</th>
                                                <th>Parameter</th>
                                                <th>Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="fw-semibold">Tekanan Darah</td>
                                                <td>{{ $item->tensi ?: '-' }}</td>
                                                <td class="fw-semibold">Suhu Tubuh</td>
                                                <td>{{ $item->suhu_tubuh ?: '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Nadi</td>
                                                <td>{{ $item->nadi ?: '-' }}</td>
                                                <td class="fw-semibold">Respirasi</td>
                                                <td>{{ $item->respirasi ?: '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">SpO2</td>
                                                <td>{{ $item->spo2 ?: '-' }}</td>
                                                <td class="fw-semibold">GCS</td>
                                                <td>{{ $item->gcs ?: '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Tinggi Badan</td>
                                                <td>{{ $item->tinggi ?: '-' }}</td>
                                                <td class="fw-semibold">Berat Badan</td>
                                                <td>{{ $item->berat ?: '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Lingkar Perut</td>
                                                <td>{{ $item->lingkar_perut ?: '-' }}</td>
                                                <td class="fw-semibold">Kesadaran</td>
                                                <td>{{ $item->kesadaran ?: '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Keluhan</td>
                                                <td colspan="3">{{ $item->keluhan ?: '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Pemeriksaan</td>
                                                <td colspan="3">{{ $item->pemeriksaan ?: '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Alergi</td>
                                                <td colspan="3">{{ $item->alergi ?: '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Penilaian</td>
                                                <td colspan="3">{{ $item->penilaian ?: '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">RTL</td>
                                                <td colspan="3">{{ $item->rtl ?: '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Instruksi</td>
                                                <td colspan="3">{{ $item->instruksi ?: '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Evaluasi</td>
                                                <td colspan="3">{{ $item->evaluasi ?: '-' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mt-4">
            <a href="{{ route('rawatjalan.index') }}" class="btn btn-outline-primary rounded-pill">
                <i class="ti ti-arrow-left me-2"></i>Kembali ke Daftar
            </a>
        </div>
    </div>

@endsection
