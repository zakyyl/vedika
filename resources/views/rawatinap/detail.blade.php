@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detail Rawat Inap</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('rawatinap.index') }}">Rawat Inap</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @if ($data)
                <div class="row">
                    <!-- Informasi Umum -->
                    <div class="col-md-4">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-user-injured mr-2"></i>Informasi Umum</h3>
                            </div>
                            <div class="card-body">
                                <div class="info-box-content">
                                    <h5 class="text-primary mb-3"><i class="fas fa-id-card mr-2"></i>Data Pasien</h5>
                                    
                                    <dl class="row">
                                        <dt class="col-sm-5">No Rawat:</dt>
                                        <dd class="col-sm-7">{{ $data->no_rawat }}</dd>
                                        
                                        <dt class="col-sm-5">Tgl Registrasi:</dt>
                                        <dd class="col-sm-7">{{ $data->tgl_registrasi }} {{ $data->jam_reg }}</dd>
                                        
                                        <dt class="col-sm-5">Dokter:</dt>
                                        <dd class="col-sm-7">{{ $data->nm_dokter }}</dd>
                                        
                                        <dt class="col-sm-5">Poli:</dt>
                                        <dd class="col-sm-7">{{ $data->nm_poli }}</dd>
                                        
                                        <dt class="col-sm-5">Status Lanjut:</dt>
                                        <dd class="col-sm-7">
                                            <span class="badge badge-info">{{ $data->status_lanjut }}</span>
                                        </dd>
                                        
                                        <dt class="col-sm-5">Nama Pasien:</dt>
                                        <dd class="col-sm-7"><strong>{{ $data->nm_pasien }}</strong></dd>
                                        
                                        <dt class="col-sm-5">Umur:</dt>
                                        <dd class="col-sm-7">{{ $data->umur }}</dd>
                                        
                                        <dt class="col-sm-5">No RM:</dt>
                                        <dd class="col-sm-7">{{ $data->no_rkm_medis }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Resume -->
                    <div class="col-md-8">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-upload mr-2"></i>Upload Resume Keperawatan</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('rawatinap.upload_resume', $data->no_rawat) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    
                                    <div class="form-group">
                                        <label for="no_rawat" class="form-label">
                                            <i class="fas fa-hashtag mr-1"></i>Nomor Rawat
                                        </label>
                                        <input type="text" class="form-control" value="{{ $data->no_rawat }}" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="kode" class="form-label">
                                            <i class="fas fa-tags mr-1"></i>Kategori Berkas <span class="text-danger">*</span>
                                        </label>
                                        <select name="kode" id="kode" class="form-control select2" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach ($kategori as $item)
                                                <option value="{{ $item->kode }}">{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="file" class="form-label">
                                            <i class="fas fa-file mr-1"></i>Pilih Berkas <span class="text-muted">(.pdf / .jpg)</span>
                                        </label>
                                        <div class="custom-file">
                                            <input type="file" name="file" id="file" class="custom-file-input"
                                                accept=".pdf,.jpg,.jpeg" required>
                                            <label class="custom-file-label" for="file">Pilih file...</label>
                                        </div>
                                        <small class="form-text text-muted">Format yang diizinkan: PDF, JPG, JPEG</small>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-success btn-block">
                                                <i class="fas fa-upload mr-2"></i>Upload Berkas
                                            </button>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="{{ route('rawatinap.statusklaim', ['no_rawat' => $data->no_rawat]) }}"
                                                class="btn btn-info btn-block">
                                                <i class="fas fa-eye mr-2"></i>Lihat Resume Diupload
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alert Messages -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fas fa-check"></i>{{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fas fa-ban"></i>{{ session('error') }}
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="{{ route('rawatinap.index') }}" class="btn btn-default">
                                            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
                                        </a>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <button type="button" class="btn btn-warning" data-toggle="modal"
                                            data-target="#updateStatusModal">
                                            <i class="fas fa-edit mr-2"></i>Update Status Klaim
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Update Status -->
                <div class="modal fade" id="updateStatusModal" tabindex="-1" role="dialog" 
                    aria-labelledby="updateStatusModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-warning">
                                <h4 class="modal-title" id="updateStatusModalLabel">
                                    <i class="fas fa-edit mr-2"></i>Update Status Klaim
                                </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <form action="{{ route('rawatinap.update_status', $data->no_rawat) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <i class="fas fa-id-card mr-1"></i>No. Rekam Medis
                                                </label>
                                                <input type="text" class="form-control"
                                                    value="{{ $data->no_rkm_medis }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <i class="fas fa-hashtag mr-1"></i>No. Rawat
                                                </label>
                                                <input type="text" class="form-control" value="{{ $data->no_rawat }}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-file-medical mr-1"></i>No. SEP
                                        </label>
                                        <input type="text" class="form-control"
                                            value="{{ $vedikaData->nosep ?? 'Belum ada data SEP' }}" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="status" class="form-label">
                                            <i class="fas fa-flag mr-1"></i>Status Klaim <span class="text-danger">*</span>
                                        </label>
                                        <select name="status" id="status" class="form-control select2" required>
                                            <option value="">-- Pilih Status Klaim --</option>
                                            <option value="Pengajuan"
                                                {{ isset($vedikaData) && $vedikaData->status == 'Pengajuan' ? 'selected' : '' }}>
                                                Pengajuan</option>
                                            <option value="Perbaiki"
                                                {{ isset($vedikaData) && $vedikaData->status == 'Perbaiki' ? 'selected' : '' }}>
                                                Perbaiki</option>
                                            <option value="Disetujui"
                                                {{ isset($vedikaData) && $vedikaData->status == 'Disetujui' ? 'selected' : '' }}>
                                                Disetujui</option>
                                        </select>
                                        @if (isset($vedikaData) && $vedikaData->status)
                                            <small class="form-text text-muted">
                                                Status saat ini: <strong class="text-info">{{ $vedikaData->status }}</strong>
                                            </small>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="catatan" class="form-label">
                                            <i class="fas fa-sticky-note mr-1"></i>Catatan dan Umpan Balik
                                        </label>
                                        <textarea name="catatan" id="catatan" class="form-control" rows="5"
                                            placeholder="Masukkan catatan dan umpan balik untuk status klaim ini...">{{ isset($vedikaData) ? $vedikaData->catatan : '' }}</textarea>
                                        <small class="form-text text-muted">
                                            Berikan catatan detail mengenai status klaim dan umpan balik yang diperlukan
                                        </small>
                                    </div>

                                    @if (isset($vedikaData) && ($vedikaData->status || $vedikaData->catatan))
                                        <div class="callout callout-info">
                                            <h5><i class="fas fa-info mr-2"></i>Informasi Status Klaim Saat Ini:</h5>
                                            @if ($vedikaData->status)
                                                <p><strong>Status:</strong> 
                                                    <span class="badge badge-info">{{ $vedikaData->status }}</span>
                                                </p>
                                            @endif
                                            @if ($vedikaData->catatan)
                                                <p><strong>Catatan Sebelumnya:</strong><br>
                                                    {{ $vedikaData->catatan }}
                                                </p>
                                            @endif
                                        </div>
                                    @else
                                        <div class="callout callout-warning">
                                            <h5><i class="fas fa-exclamation-triangle mr-2"></i>Perhatian!</h5>
                                            <p>Belum ada data status klaim untuk rawat inap ini. Status dan catatan akan dibuat baru.</p>
                                        </div>
                                    @endif
                                </div>

                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                        <i class="fas fa-times mr-2"></i>Batal
                                    </button>
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-save mr-2"></i>
                                        {{ isset($vedikaData) && $vedikaData->status ? 'Update Status' : 'Buat Status Baru' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-warning">
                    <i class="icon fas fa-exclamation-triangle"></i>
                    Data tidak ditemukan.
                </div>
            @endif
        </div>
    </section>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({
        theme: 'bootstrap4'
    });
    
    // Custom file input label
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
});
</script>
@endpush
@endsection