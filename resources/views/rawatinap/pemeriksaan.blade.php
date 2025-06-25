@extends('layouts.master')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        <i class="fas fa-clipboard-list mr-2"></i>
                        Data Pemeriksaan Rawat Jalan
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('rawatjalan.index') }}">Rawat Jalan</a></li>
                        <li class="breadcrumb-item active">Data Pemeriksaan</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @if ($data->isEmpty())
                <!-- Empty State Card -->
                <div class="card card-outline card-primary">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-clipboard-check fa-5x text-muted mb-3"></i>
                        <h4 class="text-muted">Tidak Ada Data Pemeriksaan</h4>
                        <p class="text-muted mb-4">
                            Belum ada data pemeriksaan untuk No. Rawat: 
                            <strong class="text-primary">{{ $no_rawat }}</strong>
                        </p>
                        <a href="{{ route('rawatjalan.index') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
                        </a>
                    </div>
                </div>
            @else
                <!-- Accordion for Examination Data -->
                <div class="row">
                    <div class="col-12">
                        @foreach ($data as $index => $item)
                            <div class="card card-outline card-primary collapsed-card mb-3">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <div class="d-flex flex-column">
                                            <div class="font-weight-bold text-dark">
                                                <i class="fas fa-user-injured mr-1"></i>
                                                {{ $item->no_rawat }} | {{ $item->no_rkm_medis }} | {{ $item->nm_pasien }}
                                            </div>
                                            <div class="small text-muted mt-1">
                                                <i class="fas fa-user-md mr-1"></i>
                                                Dr. {{ $item->nm_dokter }} | 
                                                <i class="fas fa-calendar-alt mr-1"></i>
                                                {{ \Carbon\Carbon::parse($item->tgl_perawatan)->format('d M Y') }} |
                                                <i class="fas fa-user-nurse mr-1"></i>
                                                Petugas: {{ $item->nip }}
                                            </div>
                                        </div>
                                    </h3>
                                    <div class="card-tools">
                                        <span class="badge badge-success mr-2">
                                            <i class="fas fa-stethoscope mr-1"></i>Pemeriksaan
                                        </span>
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body" style="display: none;">
                                    <div class="row">
                                        <!-- Vital Signs -->
                                        <div class="col-md-6">
                                            <div class="info-box bg-light">
                                                <span class="info-box-icon bg-danger">
                                                    <i class="fas fa-heartbeat"></i>
                                                </span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Tekanan Darah</span>
                                                    <span class="info-box-number">{{ $item->tensi ?: '-' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-box bg-light">
                                                <span class="info-box-icon bg-warning">
                                                    <i class="fas fa-thermometer-half"></i>
                                                </span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Suhu Tubuh</span>
                                                    <span class="info-box-number">{{ $item->suhu_tubuh ?: '-' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-box bg-light">
                                                <span class="info-box-icon bg-info">
                                                    <i class="fas fa-heart"></i>
                                                </span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Nadi</span>
                                                    <span class="info-box-number">{{ $item->nadi ?: '-' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-box bg-light">
                                                <span class="info-box-icon bg-success">
                                                    <i class="fas fa-lungs"></i>
                                                </span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Respirasi</span>
                                                    <span class="info-box-number">{{ $item->respirasi ?: '-' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Additional Measurements -->
                                    <div class="row">
                                        <div class="col-md-3 col-sm-6">
                                            <div class="small-box bg-light">
                                                <div class="inner">
                                                    <h4>{{ $item->spo2 ?: '-' }}</h4>
                                                    <p>SpO2</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-percentage"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6">
                                            <div class="small-box bg-light">
                                                <div class="inner">
                                                    <h4>{{ $item->gcs ?: '-' }}</h4>
                                                    <p>GCS</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-brain"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6">
                                            <div class="small-box bg-light">
                                                <div class="inner">
                                                    <h4>{{ $item->tinggi ?: '-' }}</h4>
                                                    <p>Tinggi (cm)</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-ruler-vertical"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6">
                                            <div class="small-box bg-light">
                                                <div class="inner">
                                                    <h4>{{ $item->berat ?: '-' }}</h4>
                                                    <p>Berat (kg)</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-weight"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Clinical Information -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card card-outline card-secondary">
                                                <div class="card-header">
                                                    <h3 class="card-title">
                                                        <i class="fas fa-info-circle mr-1"></i>
                                                        Informasi Klinis
                                                    </h3>
                                                </div>
                                                <div class="card-body p-2">
                                                    <table class="table table-sm table-borderless">
                                                        <tr>
                                                            <td class="font-weight-bold" width="40%">Lingkar Perut:</td>
                                                            <td>{{ $item->lingkar_perut ?: '-' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="font-weight-bold">Kesadaran:</td>
                                                            <td>{{ $item->kesadaran ?: '-' }}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card card-outline card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">
                                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                                        Alergi
                                                    </h3>
                                                </div>
                                                <div class="card-body">
                                                    <p class="mb-0">{{ $item->alergi ?: 'Tidak ada alergi yang tercatat' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Detailed Examination -->
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card card-outline card-info">
                                                <div class="card-header">
                                                    <h3 class="card-title">
                                                        <i class="fas fa-clipboard-list mr-1"></i>
                                                        Detail Pemeriksaan
                                                    </h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="font-weight-bold">
                                                                    <i class="fas fa-comment-medical mr-1"></i>
                                                                    Keluhan:
                                                                </label>
                                                                <div class="bg-light p-2 rounded">
                                                                    {{ $item->keluhan ?: '-' }}
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="font-weight-bold">
                                                                    <i class="fas fa-search mr-1"></i>
                                                                    Pemeriksaan:
                                                                </label>
                                                                <div class="bg-light p-2 rounded">
                                                                    {{ $item->pemeriksaan ?: '-' }}
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="font-weight-bold">
                                                                    <i class="fas fa-clipboard-check mr-1"></i>
                                                                    Penilaian:
                                                                </label>
                                                                <div class="bg-light p-2 rounded">
                                                                    {{ $item->penilaian ?: '-' }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="font-weight-bold">
                                                                    <i class="fas fa-tasks mr-1"></i>
                                                                    RTL (Rencana Tindak Lanjut):
                                                                </label>
                                                                <div class="bg-light p-2 rounded">
                                                                    {{ $item->rtl ?: '-' }}
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="font-weight-bold">
                                                                    <i class="fas fa-file-prescription mr-1"></i>
                                                                    Instruksi:
                                                                </label>
                                                                <div class="bg-light p-2 rounded">
                                                                    {{ $item->instruksi ?: '-' }}
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-0">
                                                                <label class="font-weight-bold">
                                                                    <i class="fas fa-chart-line mr-1"></i>
                                                                    Evaluasi:
                                                                </label>
                                                                <div class="bg-light p-2 rounded">
                                                                    {{ $item->evaluasi ?: '-' }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Back Button -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body text-center">
                                <a href="{{ route('rawatjalan.index') }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Rawat Jalan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('styles')
<style>
    .info-box {
        box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
        border-radius: .25rem;
        margin-bottom: 1rem;
    }
    
    .small-box {
        border-radius: .25rem;
        box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
        margin-bottom: 1rem;
    }
    
    .card {
        box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
    }
    
    .bg-light {
        background-color: #f8f9fa !important;
    }
    
    .content-header h1 {
        margin: 0;
        font-size: 1.8rem;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize card collapse functionality
        $('[data-card-widget="collapse"]').on('click', function() {
            var card = $(this).closest('.card');
            var cardBody = card.find('.card-body');
            var icon = $(this).find('i');
            
            if (cardBody.is(':visible')) {
                cardBody.slideUp();
                icon.removeClass('fa-minus').addClass('fa-plus');
                card.addClass('collapsed-card');
            } else {
                cardBody.slideDown();
                icon.removeClass('fa-plus').addClass('fa-minus');
                card.removeClass('collapsed-card');
            }
        });
        
        // Add smooth scrolling for better UX
        $('html, body').animate({
            scrollTop: 0
        }, 'slow');
    });
</script>
@endpush