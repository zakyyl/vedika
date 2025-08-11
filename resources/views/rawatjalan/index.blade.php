@extends('layouts.master')

@section('title', 'Data Rawat Jalan')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Data Rawat Jalan</h1>
                </div>
                <div class="col-sm-6 text-sm-right">
                    <span class="text-muted">Total Data: <strong>{{ number_format($rawatJalan->total()) }}</strong></span>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            {{-- Filter Card --}}
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Filter Data</h3>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('rawatjalan.index') }}">
                        <div class="form-row align-items-end">
                            <div class="form-group col-md-3 mb-2">
                                <label>No. Rawat</label>
                                <input type="text" name="search" class="form-control" placeholder="No. Rawat/SEP"
                                    value="{{ request('search') }}">
                            </div>
                            <div class="form-group col-md-2 mb-2">
                                <label>Tanggal Mulai</label>
                                <input type="date" name="tgl_dari" class="form-control"
                                    value="{{ request('tgl_dari') }}">
                            </div>
                            <div class="form-group col-md-2 mb-2">
                                <label>Tanggal Akhir</label>
                                <input type="date" name="tgl_sampai" class="form-control"
                                    value="{{ request('tgl_sampai') }}">
                            </div>
                            <div class="form-group col-md-3 mb-2">
                                <label>Status Vedika</label>
                                <select name="status_vedika" class="form-control">
                                    <option value="">-- Semua Status --</option>
                                    <option value="Pengajuan"
                                        {{ request('status_vedika') == 'Pengajuan' ? 'selected' : '' }}>
                                        Pengajuan
                                    </option>
                                    <option value="Rujukan Internal"
                                        {{ request('status_vedika') == 'Rujukan Internal' ? 'selected' : '' }}>
                                        Rujukan Internal
                                    </option>
                                    <option value="Belum Ada Pengajuan"
                                        {{ request('status_vedika') == 'Belum Ada Pengajuan' ? 'selected' : '' }}>
                                        Belum Ada Pengajuan
                                    </option>

                                </select>
                            </div>
                            <div class="form-group col-md-2 mb-2">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-search mr-1"></i> Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Data Table Card --}}
            <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title">Daftar Rawat Jalan</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-sm mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>No Rawat</th>
                                    <th>No SEP</th>
                                    <th>Tanggal</th>
                                    <th>Dokter</th>
                                    <th>Pasien</th>
                                    <th>Poli</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rawatJalan as $data)
                                    <tr>
                                        {{-- <td>{{ $data->no_rawat }}</td> --}}
                                        <td>
                                            {{ $data->no_rawat }}
                                            <div class="mt-1">
                                                @php
                                                    $badgeClass = match ($data->status_vedika) {
                                                        'Pengajuan' => 'badge-primary',
                                                        'Rujukan Internal' => 'badge-success',
                                                        default => 'badge-warning',
                                                    };
                                                    $statusText = $data->status_vedika ?? 'Belum Ada Pengajuan';
                                                @endphp
                                                <span class="badge {{ $badgeClass }} badge-pill"
                                                    style="font-size: 0.70rem; padding: 0.25em 0.5em;">
                                                    {{ $statusText }}
                                                </span>

                                            </div>
                                        </td>
                                        <td>{{ $data->no_sep ?? '-' }}</td>
                                        <td>{{ $data->tgl_registrasi }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($data->nm_dokter, 25, '...') }}</td>
                                        <td>
                                            <strong>{{ \Illuminate\Support\Str::limit($data->nm_pasien, 20, '...') }}</strong><br>
                                            <small class="text-muted">RM: {{ $data->no_rkm_medis }}</small>
                                        </td>
                                        <td>{{ $data->nm_poli }}</td>
                                        <td class="text-center">
                                            @if (!empty($data->no_sep))
                                                <a href="{{ route('rawatjalan.detail', urlencode($data->no_rawat)) }}"
                                                    class="btn btn-sm btn-info" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @else
                                                <button type="button" class="btn btn-sm btn-info" title="Detail"
                                                    data-toggle="modal" data-target="#modalSepKosong">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            @endif

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

                @if ($rawatJalan->hasPages())
                    <div class="card-footer d-flex justify-content-center">
                        {{ $rawatJalan->appends(request()->query())->links('pagination::simple-bootstrap-4') }}
                    </div>
                @endif
            </div>

        </div>
    </section>

    {{-- Modal SEP Kosong --}}
    <div class="modal fade" id="modalSepKosong" tabindex="-1" role="dialog" aria-labelledby="modalSepKosongLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="modalSepKosongLabel">Perhatian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Data tidak dapat dibuka karena SEP belum ada.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection
