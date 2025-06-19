@extends('layouts.materio')

@section('content')
<h4 class="mb-4">Data Rawat Jalan</h4>

<div class="col-md-12 mb-3">
    Total <strong>{{ $total }}</strong> data.
</div>

<form method="GET" action="{{ route('rawatjalan.index') }}" class="row g-3 mb-4">
  <div class="col-md-4">
    <input type="text" name="search" class="form-control" placeholder="Cari No Rawat..." value="{{ request('search') }}">
  </div>
  <div class="col-md-3">
    <input type="date" name="tgl_dari" class="form-control" value="{{ request('tgl_dari') }}">
  </div>
  <div class="col-md-3">
    <input type="date" name="tgl_sampai" class="form-control" value="{{ request('tgl_sampai') }}">
  </div>
  <div class="col-md-2">
  <button type="submit" class="btn btn-primary w-100">Filter</button>
</div>


</form>

<div class="col-12">
  <div class="card overflow-hidden">
    <div class="table-responsive">
      <table class="table table-sm">
        <thead>
          <tr>
            {{-- <th>No Reg</th> --}}
            <th>No Rawat</th>
            <th>Tgl Registrasi</th>
            {{-- <th>Jam</th> --}}
            <th>Dokter</th>
            <th>Pasien</th>
            {{-- <th>JK</th> --}}
            {{-- <th>Umur</th> --}}
            <th>Poli</th>
            {{-- <th>PJ</th> --}}
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($rawatJalan as $data)
          <tr>
            {{-- <td class="text-truncate">{{ $data->no_reg }}</td> --}}
            <td class="text-truncate">{{ $data->no_rawat }}</td>
            <td class="text-truncate">{{ $data->tgl_registrasi }}</td>
            {{-- <td class="text-truncate">{{ $data->jam_reg }}</td> --}}
            <td class="text-truncate">{{ $data->nm_dokter }}</td>
            <td class="text-truncate">
            <div class="d-flex align-items-center">
                <div>
                <h6 class="mb-0 text-truncate">{{ $data->nm_pasien }}</h6>
                <small class="text-muted text-truncate">No RM: {{ $data->no_rkm_medis }}</small>
                </div>
            </div>
            </td>
            {{-- <td class="text-truncate">{{ $data->jk }}</td> --}}
            {{-- <td class="text-truncate">{{ $data->umurdaftar }} Th</td> --}}
            <td class="text-truncate">{{ $data->nm_poli }}</td>
            {{-- <td class="text-truncate">{{ $data->png_jawab }}</td> --}}
            {{-- <td> <a href="{{ route('rawatjalan.detail', $data->no_rawat) }}" class="btn btn-sm btn-info">Detail Data</a> </td> --}}
            <td><a href="{{ route('rawatjalan.detail', urlencode($data->no_rawat)) }}" class="btn btn-primary w-100">Detail Data</a></td>

          </tr>
          @empty
          <tr>
            <td colspan="10" class="text-center">Tidak ada data ditemukan.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center my-3">
      {{ $rawatJalan->links('pagination::bootstrap-5') }}
    </div>
  </div>
</div>
@endsection
