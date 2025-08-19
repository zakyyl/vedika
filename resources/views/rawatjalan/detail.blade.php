@extends('layouts.master')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-md-6">
                    <h1 class="m-0">Detail Rawat Jalan</h1>
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
                        <li class="breadcrumb-item"><a href="{{ route('rawatjalan.index') }}">Rawat Jalan</a></li>
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
                    @include('rawatjalan.partials.info_pasien')
                    @include('rawatjalan.partials.sep-card')

                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    @include('rawatjalan.partials.upload_resume')
                </div>
            </div>
            @include('rawatjalan.partials.pemeriksaan', ['data' => $pemeriksaan])

            @if (!empty($suratKontrol))
                @include('rawatjalan.partials.surat_kontrol')
            @endif

            @include('rawatjalan.partials.modal_update')

            @if (!empty($rawatDr) || !empty($rawatPr) || !empty($rawatDrPr))
                @include('rawatjalan.partials.tindakan')
            @endif

            @if (!empty($uji_fungsi_kfr) || !empty($layanan_kfr) || !empty($layanan_program_kfr))
                @include('rawatjalan.partials.kfr')
            @endif


            @if (!empty($operasi) || !empty($laporanOperasi))
                @include('rawatjalan.partials.operasi')
            @endif
            @if (!empty($hasil_radiologi) || !empty($tindakan_radiologi))
                @include('rawatjalan.partials.radiologi')
            @endif
            @if (
                !empty($hasilUsg) ||
                    !empty($hasil_usg_gynecologi) ||
                    !empty($hasil_echo) ||
                    !empty($hasil_ekg) ||
                    !empty($laporan_tindakan))
                @include('rawatjalan.partials.hasil_usg')
            @endif
            @if (!empty($laboratorium))
                @include('rawatjalan.partials.hasil_labor')
            @endif
            @if (!empty($pemberian_obat))
                @include('rawatjalan.partials.pemberian_obat')
            @endif
            @if (!empty($billing))
                @include('rawatjalan.partials.billing')
            @endif

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
        @else
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i> Data tidak ditemukan.
            </div>
        @endif
    </section>
@endsection
