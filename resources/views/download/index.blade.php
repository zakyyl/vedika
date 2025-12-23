@extends('layouts.master')

@section('title', 'Data Vedika')

@section('content')
<div class="container-fluid">
    <div class="card mb-3">
        
        <div class="card-body">
            <form method="GET" action="{{ route('download.index') }}">
                <div class="form-row align-items-end">
                    <div class="col-md-3">
                        <label>Tanggal Awal</label>
                        <input type="date" name="tanggal_awal" class="form-control"
                            value="{{ request('tanggal_awal') }}">
                    </div>

                    <div class="col-md-3">
                        <label>Tanggal Akhir</label>
                        <input type="date" name="tanggal_akhir" class="form-control"
                            value="{{ request('tanggal_akhir') }}">
                    </div>

                    <div class="col-md-3">
                        <label>Jenis Layanan</label>
                        <select name="jenis" class="form-control" required>
                            <option value="">-- Pilih Jenis Layanan --</option>
                            <option value="ranap" {{ request('jenis')=='ranap' ? 'selected' : '' }}>
                                Rawat Inap
                            </option>
                            <option value="ralan" {{ request('jenis')=='ralan' ? 'selected' : '' }}>
                                Rawat Jalan
                            </option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary btn-block">
                            Tampilkan
                        </button>
                    </div>
                    
                </div>

                @if(request()->filled('jenis'))
                <div class="mt-3">
                    <a href="{{ route('download.export.excel', request()->query()) }}" class="btn btn-primary btn-sm">
                        Download Excel
                    </a>

                    <a href="{{ route('download.export.pdf', request()->query()) }}" class="btn btn-danger btn-sm">
                        Download PDF
                    </a>
                </div>
                @endif

                @if(request()->filled('jenis'))
            <div class="mt-3">
                <span class="badge badge-secondary">
                    Total Data: {{ $data->total() }}
                </span>
            </div>
            @endif
            </form>
        </div>
    </div>

    @if(request()->filled('jenis'))
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover table-sm table-compact">

                <thead class="thead-dark">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Tgl Pengajuan</th>
                        <th>Tgl Registrasi</th>
                        <th>No RM</th>
                        <th>No Rawat</th>
                        <th>No SEP</th>
                        <th>Jenis</th>
                        <th>Dokter</th>
                        <th>Poli</th>
                        <th>No Peserta</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $row)
                    <tr>
                        <td class="text-center">
                            {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                        </td>
                        <td>{{ $row->tglpengajuan }}</td>
                        <td>{{ $row->tgl_registrasi }}</td>
                        <td>{{ $row->no_rkm_medis }}</td>
                        <td>{{ $row->no_rawat }}</td>
                        <td>{{ $row->nosep }}</td>
                        <td>
                            <span class="badge badge-info">{{ $row->jenis }}</span>
                        </td>
                        <td>{{ $row->nm_dokter }}</td>
                        <td>{{ $row->nm_poli }}</td>
                        <td>{{ $row->no_peserta }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted">
                            Data tidak ditemukan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($data->hasPages())
        <div class="card-footer d-flex justify-content-center">
            {{ $data->links('pagination::simple-bootstrap-4') }}
        </div>
        @endif
    </div>
    @endif

</div>
@endsection

@push('styles')
<style>
    .table-compact {
        font-size: 12px;
    }

    .table-compact th,
    .table-compact td {
        padding: 0.35rem 0.45rem;
        vertical-align: middle;
        white-space: nowrap;
    }

    .table-compact thead th {
        font-size: 12px;
    }

    .table-compact .badge {
        font-size: 11px;
        padding: 0.25em 0.4em;
    }
</style>
@endpush