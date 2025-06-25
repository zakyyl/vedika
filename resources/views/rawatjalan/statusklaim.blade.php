@extends('layouts.master')

@section('title', 'Daftar Resume Rawat Jalan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Daftar Resume yang Sudah Diupload</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('rawatinap.detail', $no_rawat) }}">Detail Rawat Jalan</a></li>
                        <li class="breadcrumb-item active">Daftar Resume</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if ($berkas->isEmpty())
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Peringatan!</h5>
                        Belum ada berkas diunggah untuk No. Rawat: <strong>{{ $no_rawat }}</strong>
                    </div>
                @else
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-file-medical mr-1"></i>
                                Resume Rawat Jalan
                            </h3>
                            <div class="card-tools">
                                <span class="badge badge-primary">{{ $berkas->count() }} File</span>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Kategori Berkas</th>
                                            <th>Lokasi File</th>
                                            <th style="width: 120px" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($berkas as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <strong>{{ $item->nama_kategori }}</strong>
                                                </td>
                                                <td>
                                                    <small class="text-muted">{{ $item->lokasi_file }}</small>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ asset('storage/' . $item->lokasi_file) }}" 
                                                       target="_blank"
                                                       class="btn btn-sm btn-primary"
                                                       data-toggle="tooltip" 
                                                       title="Download File">
                                                        <i class="fas fa-download"></i>
                                                        Download
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="row mt-3">
                    <div class="col-12">
                        <a href="{{ route('rawatinap.detail', $no_rawat) }}" 
                           class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i>
                            Kembali ke Detail Rawat Jalan
                        </a>
                    </div>
                </div>
                
            </div>
        </div>
        
    </section>
@endsection