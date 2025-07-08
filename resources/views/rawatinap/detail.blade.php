@extends('layouts.master')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-md-6">
                    <h1 class="m-0">Detail Rawat Inap</h1>
                </div>
                <div class="col-md-6 text-md-right">
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#updateModal">
                        <i class="fas fa-edit"></i> Update Status
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('rawatinap.index') }}">Rawat Inap</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content px-3">
        @if ($data)
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif

            <div class="row mb-3">
                <div class="col-md-12">
                    @include('rawatinap.partials.info_pasien')
                    @include('rawatinap.partials.sep-card')
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    @include('rawatinap.partials.upload_resume')
                </div>
            </div>
            @include('rawatinap.partials.pemeriksaan', ['data' => $pemeriksaan])
            @include('rawatinap.partials.surat_kontrol')
            @include('rawatinap.partials.modal_update')
            @include('rawatinap.partials.tindakan')
            @include('rawatinap.partials.operasi')
            @include('rawatinap.partials.radiologi')
            @include('rawatinap.partials.hasil_labor')
            @include('rawatinap.partials.pemberian_obat')
            @include('rawatinap.partials.billing')

            <div class="card">
                <div class="card-footer">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <a href="{{ url()->previous() }}" class="btn btn-default">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                        <div class="col-md-6 text-md-right">
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#updateModal">
                                <i class="fas fa-edit"></i> Update Status
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        @else
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i> Data tidak ditemukan.
            </div>
        @endif
    </section>
@endsection
