@extends('layouts.master')

@section('title', 'Data Rawat Inap')

@section('content')
<!-- Content Header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data Rawat Inap</h1>
            </div>
            <div class="col-sm-6 text-sm-right">
                <span class="text-muted">Total Data: <strong>{{ number_format($rawatInap->total()) }}</strong></span>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<section class="content">
    <div class="container-fluid">

        <!-- Filter Form -->
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Filter Data</h3>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('rawatinap.index') }}">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>No. Rawat</label>
                            <input type="text" name="search" class="form-control"
                                   placeholder="Contoh: 2025/06/01/000012" value="{{ request('search') }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Tanggal Mulai</label>
                            <input type="date" name="tgl_dari" class="form-control" value="{{ request('tgl_dari') }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Tanggal Akhir</label>
                            <input type="date" name="tgl_sampai" class="form-control" value="{{ request('tgl_sampai') }}">
                        </div>
                        <div class="form-group col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-search mr-1"></i> Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table Card -->
        <div class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title">Daftar Rawat Inap</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-sm mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>No Rawat</th>
                                <th>Tanggal</th>
                                <th>Dokter</th>
                                <th>Pasien</th>
                                <th>Poli</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rawatInap as $data)
                                <tr>
                                    <td>{{ $data->no_rawat }}</td>
                                    <td>{{ $data->tgl_registrasi }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($data->nm_dokter, 25, '...') }}</td>
                                    <td>
                                        <strong>{{ \Illuminate\Support\Str::limit($data->nm_pasien, 20, '...') }}</strong><br>
                                        <small class="text-muted">RM: {{ $data->no_rkm_medis }}</small>
                                    </td>
                                    <td>{{ $data->nm_poli }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('rawatinap.detail', urlencode($data->no_rawat)) }}"
                                           class="btn btn-sm btn-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('rawatinap.pemeriksaan', urlencode($data->no_rawat)) }}"
                                           class="btn btn-sm btn-secondary" title="Klaim">
                                            <i class="fas fa-clipboard-check"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x d-block mb-2"></i>
                                        Tidak ada data ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($rawatInap->hasPages())
                    <div class="card-footer d-flex justify-content-center">
                        {{ $rawatInap->appends(request()->query())->links('pagination::simple-bootstrap-4') }}
                    </div>
                @endif
        </div>

    </div>
</section>
@endsection
