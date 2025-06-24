@extends('layouts.materio')

@section('content')
    <h5 class="fw-bold mb-3">Data Rawat Jalan</h5>

    <div class="mb-3">
        <small class="text-muted">Total data: <strong>{{ $total }}</strong></small>
    </div>

    <form method="GET" action="{{ route('rawatjalan.index') }}" class="row g-2 mb-4 align-items-end">
        <div class="col-md-3">
            <label class="form-label">No. Rawat</label>
            <input type="text" name="search" class="form-control form-control-sm"
                   placeholder="Contoh: 2025/06/01/000012" value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">Tanggal Mulai</label>
            <input type="date" name="tgl_dari" class="form-control form-control-sm"
                   value="{{ request('tgl_dari') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">Tanggal Akhir</label>
            <input type="date" name="tgl_sampai" class="form-control form-control-sm"
                   value="{{ request('tgl_sampai') }}">
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-sm btn-outline-primary w-100">
                <i class="bx bx-filter-alt me-1"></i> Filter
            </button>
        </div>
    </form>

<div class="card border-0 shadow-sm" style="min-height: 500px;">
    <div class="table-responsive">
        <table class="table table-hover table-sm align-middle mb-0">
                <thead class="table-light">
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
                    @forelse($rawatJalan as $data)
                        <tr>
                            <td>{{ $data->no_rawat }}</td>
                            <td>{{ $data->tgl_registrasi }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($data->nm_dokter, 25, '...') }}</td>
                            <td>
                            <div>
                                <span class="d-block">
                                    {{ \Illuminate\Support\Str::limit($data->nm_pasien, 20, '...') }}
                                </span>
                                <span class="badge bg-dark text-muted">RM: {{ $data->no_rkm_medis }}</span>
                            </div>
                            </td>
                            <td>{{ $data->nm_poli }}</td>
                            <td class="text-center">
                                <a href="{{ route('rawatjalan.detail', urlencode($data->no_rawat)) }}"
                                   class="btn btn-sm btn-primary">Detail</a>
                                <a href="{{ route('rawatjalan.pemeriksaan', urlencode($data->no_rawat)) }}"
                                   class="btn btn-sm btn-outline-secondary">Klaim</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Tidak ada data ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center py-3">
            {{ $rawatJalan->links('pagination::simple-bootstrap-4') }}
        </div>
    </div>
@endsection
