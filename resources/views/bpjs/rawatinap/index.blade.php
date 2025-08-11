@extends('layouts.master')

@section('title', 'Data Rawat Inap BPJS')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Data Rawat Inap BPJS</h1>
                </div>
                <div class="col-sm-6 text-sm-right">
                    <span class="text-muted">Total Data: <strong>{{ number_format($bpjs->total()) }}</strong></span>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Filter Data</h3>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('rawatinap.index_bpjs') }}">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>No. Rawat</label>
                                <input type="text" name="search" class="form-control" placeholder="No. Rawat/SEP/RM"
                                    value="{{ request('search') }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Tanggal Mulai</label>
                                <input type="date" name="tgl_dari" class="form-control"
                                    value="{{ request('tgl_dari') }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Tanggal Akhir</label>
                                <input type="date" name="tgl_sampai" class="form-control"
                                    value="{{ request('tgl_sampai') }}">
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

            <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title">Daftar Rawat Inap BPJS</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-sm mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>No Rawat</th>
                                    <th>No SEP</th>
                                    <th>Tanggal</th>
                                    <th>Pasien</th>
                                    {{-- <th>Jenis</th> --}}
                                    {{-- <th>Status</th> --}}
                                    {{-- <th>Petugas</th> --}}
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bpjs as $data)
                                    <tr>
                                        <td>
                                            {{ $data->no_rawat }}
                                            <div class="mt-1">
                                                <span
                                                    class="badge {{ $data->status ? 'badge-primary' : 'badge-warning' }} badge-pill"
                                                    style="font-size: 0.70rem; padding: 0.25em 0.5em;">
                                                    {{ $data->status ?? 'Belum Ada Pengajuan' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>{{ $data->nosep ?? '-' }}</td>
                                        <td>{{ $data->tgl_keluar }}</td>
                                        <td class="text-bold">
                                            {{ $data->nm_pasien }}
                                            <div class="text-muted small">RM:
                                                {{ $data->no_rkm_medis ?? '-' }}
                                            </div>
                                        </td>
                                        {{-- <td>{{ $data->jenis }}</td> --}}
                                        {{-- <td>{{ $data->status }}</td> --}}
                                        {{-- <td>{{ $data->username }}</td> --}}
                                        <td class="text-center">
                                            <a href="{{ route('rawatinap.detail', urlencode($data->no_rawat)) }}"
                                                class="btn btn-sm btn-info" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            <i class="fas fa-inbox fa-2x d-block mb-2"></i>
                                            Tidak ada data ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($bpjs->hasPages())
                    <div class="card-footer d-flex justify-content-center">
                        {{ $bpjs->appends(request()->query())->links('pagination::simple-bootstrap-4') }}
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
