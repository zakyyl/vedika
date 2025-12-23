@extends('layouts.master')

@section('content')
<div class="container-fluid px-4">

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Gagal Mengedit Data Periksa kembali input Anda:</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="font-weight-bold mb-0">Data S.O.A.P Ralan</h3>

        <form method="GET" action="{{ route('soap.index') }}" class="form-inline">
            <input type="text" name="search" class="form-control form-control-sm mr-2" placeholder="Cari no_rawat"
                value="{{ request('search') }}" style="width: 200px;">
            <button class="btn btn-primary btn-sm px-3">Cari</button>
        </form>
    </div>

    <div class="row">
        @forelse ($soap as $item)
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card soap-card h-100 border-0 shadow-sm">

                <div class="card-header bg-white border-0 pb-2">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="font-weight-bold text-primary mb-1">
                                {{ strtoupper($item->nm_pasien) }}
                            </h5>
                            <small class="text-muted d-block">
                                RM: {{ $item->no_rkm_medis }} | Rawat: {{ $item->no_rawat }}
                            </small>
                        </div>

                        <span class="badge badge-secondary">
                            {{ $item->tgl_perawatan }}
                        </span>
                    </div>
                </div>

                <div class="card-body pt-2">
                    <div class="mb-3">
                        <h6 class="section-title text-dark font-weight-semibold">Vital Sign</h6>
                        <p class="soap-text mb-1">
                            Suhu: {{ $item->suhu_tubuh ?? '-' }} °C • Tensi: {{ $item->tensi ?? '-' }} • Nadi: {{
                            $item->nadi ?? '-' }} • Respirasi: {{ $item->respirasi ?? '-' }}
                        </p>
                        <p class="soap-text mb-0">
                            Berat: {{ $item->berat ?? '-' }} kg • Tinggi: {{ $item->tinggi ?? '-' }} cm • SpO₂: {{
                            $item->spo2 ?? '-' }}% • GCS: {{ $item->gcs ?? '-' }}
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="section-title text-dark font-weight-semibold">Subjektif</h6>
                        <p class="soap-text mb-0">
                            {{ $item->keluhan ?? '-' }}
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="section-title text-dark font-weight-semibold">Objektif</h6>
                        <p class="soap-text mb-0">
                            {{ $item->pemeriksaan ?? '-' }}
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="section-title text-dark font-weight-semibold">Alergi / Kesadaran</h6>
                        <p class="soap-text mb-0">
                            {{ $item->alergi ?? '-' }} • Kesadaran: {{ $item->kesadaran ?? '-' }}
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="section-title text-dark font-weight-semibold">Asesmen & Plan</h6>
                        <p class="soap-text mb-1">
                            <strong>Penilaian:</strong> {{ $item->penilaian ?? '-' }}
                        </p>
                        <p class="soap-text mb-1">
                            <strong>RTL:</strong> {{ $item->rtl ?? '-' }}
                        </p>
                        <p class="soap-text mb-1">
                            <strong>Instruksi:</strong> {{ $item->instruksi ?? '-' }}
                        </p>
                        <p class="soap-text mb-0">
                            <strong>Evaluasi:</strong> {{ $item->evaluasi ?? '-' }}
                        </p>
                    </div>
                </div>

                <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center pt-2">
                    <small class="text-muted">
                        👤 {{ $item->nama_petugas }} ({{ $item->jbtn }})
                    </small>

                    <button class="btn btn-outline-primary btn-sm" data-toggle="modal"
                        data-target="#editModal{{ $loop->index }}">
                        ✏️ Edit
                    </button>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editModal{{ $loop->index }}" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"
                style="max-width: 600px;">
                <div class="modal-content">
                    <form method="POST" action="{{ route('soap.update', $item->no_rawat) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-header bg-light">
                            <h5 class="modal-title font-weight-bold">Edit Data S.O.A.P Ralan</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>

                        <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                            <div class="form-group">
                                <label class="small text-muted mb-1">No Rawat</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $item->no_rawat }}"
                                    readonly>
                            </div>

                            <div class="form-group">
                                <label class="small text-muted mb-1">No Rekam Medis</label>
                                <input type="text" class="form-control form-control-sm"
                                    value="{{ $item->no_rkm_medis }}" readonly>
                            </div>

                            <div class="form-group">
                                <label class="small text-muted mb-1">Nama Pasien</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $item->nm_pasien }}"
                                    readonly>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small text-muted mb-1">Keluhan</label>
                                        <textarea name="keluhan" class="form-control form-control-sm"
                                            rows="3">{{ $item->keluhan }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small text-muted mb-1">Pemeriksaan</label>
                                        <textarea name="pemeriksaan" class="form-control form-control-sm"
                                            rows="3">{{ $item->pemeriksaan }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small text-muted mb-1">Alergi</label>
                                        <input type="text" name="alergi" class="form-control form-control-sm"
                                            value="{{ $item->alergi }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small text-muted mb-1">Kesadaran</label>
                                        <input type="text" name="kesadaran" class="form-control form-control-sm"
                                            value="{{ $item->kesadaran }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="small text-muted mb-1">Suhu Tubuh (°C)</label>
                                        <input type="text" name="suhu_tubuh" class="form-control form-control-sm"
                                            value="{{ $item->suhu_tubuh }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="small text-muted mb-1">Tensi</label>
                                        <input type="text" name="tensi" class="form-control form-control-sm"
                                            value="{{ $item->tensi }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="small text-muted mb-1">Nadi</label>
                                        <input type="text" name="nadi" class="form-control form-control-sm"
                                            value="{{ $item->nadi }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="small text-muted mb-1">Respirasi</label>
                                        <input type="text" name="respirasi" class="form-control form-control-sm"
                                            value="{{ $item->respirasi }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="small text-muted mb-1">Berat Badan (kg)</label>
                                        <input type="text" name="berat" class="form-control form-control-sm"
                                            value="{{ $item->berat }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="small text-muted mb-1">Tinggi Badan (cm)</label>
                                        <input type="text" name="tinggi" class="form-control form-control-sm"
                                            value="{{ $item->tinggi }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="small text-muted mb-1">Lingkar Perut (cm)</label>
                                        <input type="text" name="lingkar_perut" class="form-control form-control-sm"
                                            value="{{ $item->lingkar_perut }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="small text-muted mb-1">SpO₂ (%)</label>
                                        <input type="text" name="spo2" class="form-control form-control-sm"
                                            value="{{ $item->spo2 }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="small text-muted mb-1">GCS</label>
                                        <input type="text" name="gcs" class="form-control form-control-sm"
                                            value="{{ $item->gcs }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small text-muted mb-1">RTL</label>
                                        <input type="text" name="rtl" class="form-control form-control-sm"
                                            value="{{ $item->rtl }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small text-muted mb-1">Penilaian</label>
                                        <input type="text" name="penilaian" class="form-control form-control-sm"
                                            value="{{ $item->penilaian }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <label class="small text-muted mb-1">Instruksi</label>
                                        <input type="text" name="instruksi" class="form-control form-control-sm"
                                            value="{{ $item->instruksi }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <label class="small text-muted mb-1">Evaluasi</label>
                                        <input type="text" name="evaluasi" class="form-control form-control-sm"
                                            value="{{ $item->evaluasi }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer bg-light">
                            <button type="submit" class="btn btn-primary btn-sm px-4">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @empty
        <div class="col-12">
            <div class="alert alert-warning text-center">
                Data SOAP tidak ditemukan
            </div>
        </div>
        @endforelse
    </div>

    @if ($soap->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $soap->links('pagination::simple-bootstrap-4') }}
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .soap-card {
        border-radius: 12px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .soap-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
    }

    .section-title {
        font-size: 13px;
        margin-bottom: 6px;
        color: #333;
    }

    .soap-text {
        font-size: 12.5px;
        color: #555;
        line-height: 1.5;
    }

    .card-header {
        padding: 1rem 1rem 0.5rem 1rem;
    }

    .card-body {
        padding: 0.75rem 1rem;
    }

    .card-footer {
        padding: 0.5rem 1rem 1rem 1rem;
    }

    .badge {
        font-size: 11px;
        padding: 0.35em 0.65em;
    }

    .btn-sm {
        font-size: 12px;
        padding: 0.25rem 0.75rem;
    }

    label.small {
        font-size: 13px;
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .font-weight-semibold {
        font-weight: 600;
    }
</style>
@endpush