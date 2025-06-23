@extends('layouts.materio')

@section('content')
    <h4 class="mb-4">Data Rawat Inap</h4>

    <div class="col-md-12 mb-3">
        Total <strong>{{ $total }}</strong> data.
    </div>

    <form method="GET" action="{{ route('rawatinap.index') }}" class="row g-3 mb-4 align-items-end">
        <div class="col-md-3">
            <label class="form-label fw-semibold">Cari No Rawat</label>
            <input type="text" name="search" class="form-control" placeholder="Contoh: 2025/06/01/000012"
                value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold">Tanggal Mulai</label>
            <input type="date" name="tgl_dari" class="form-control" value="{{ request('tgl_dari') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold">Tanggal Akhir</label>
            <input type="date" name="tgl_sampai" class="form-control" value="{{ request('tgl_sampai') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label d-block">&nbsp;</label>
            <button type="submit" class="btn btn-primary w-100">
                <i class="bx bx-filter-alt me-1"></i> Filter
            </button>
        </div>
    </form>


    <div class="col-12">
        <div class="card overflow-hidden">
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>No Rawat</th>
                            <th>Tgl Registrasi</th>
                            <th>Dokter</th>
                            <th>Pasien</th>
                            <th>Poli</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rawatInap as $data)
                            <tr>
                                <td class="text-truncate">{{ $data->no_rawat }}</td>
                                <td class="text-truncate">{{ $data->tgl_registrasi }}</td>
                                <td class="text-truncate">{{ $data->nm_dokter }}</td>
                                <td class="text-truncate">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <h6 class="mb-0 text-truncate">{{ $data->nm_pasien }}</h6>
                                            <small class="text-muted text-truncate">No RM: {{ $data->no_rkm_medis }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-truncate">{{ $data->nm_poli }}</td>
                                <td>
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('rawatinap.detail', urlencode($data->no_rawat)) }}"
                                            class="btn btn-sm btn-primary">
                                            Detail
                                        </a>
                                        <a href="{{ route('rawatinap.pemeriksaan', urlencode($data->no_rawat)) }}"
                                            class="btn btn-sm btn-outline-secondary">
                                            Lihat Klaim
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center my-3">
                {{-- {{ $rawatInap->links('pagination::simple-default') }} --}}
                {{ $rawatInap->links('pagination::simple-bootstrap-4') }}

            </div>
        </div>
    </div>
@endsection
