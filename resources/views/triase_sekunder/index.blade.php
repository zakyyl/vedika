@extends('layouts.master')

@section('content')
<div class="container">

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Perhatian!</strong>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


    <div class="card">
        <div class="card-header">
            <form action="{{ route('triase-sekunder.index') }}" method="GET" class="form-inline float-right">
                <div class="input-group input-group-sm">
                    <input type="text" name="search" class="form-control" placeholder="Cari no_rawat / nama / RM"
                        value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>

            <h3 class="card-title mt-2">Daftar Pasien Triase Sekunder</h3>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>No RM</th>
                        <th>Nama Pasien</th>
                        <th>No Rawat</th>
                        <th>Tanggal Triase</th>
                        <th>Anamnesa Singkat</th>
                        <th>Catatan</th>
                        <th>Plan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($triase as $item)
                    <tr>
                        <td>{{ $loop->iteration + ($triase->currentPage() - 1) * $triase->perPage() }}</td>
                        <td>{{ $item->no_rkm_medis }}</td>
                        <td>{{ $item->nm_pasien }}</td>
                        <td>{{ $item->no_rawat }}</td>
                        <td>{{ $item->tanggaltriase }}</td>
                        <td class="text-wrap" style="max-width: 250px;">
                            {{ $item->anamnesa_singkat }}
                        </td>
                        <td class="text-wrap" style="max-width: 250px;">
                            {{ $item->catatan }}
                        </td>
                        <td class="text-wrap" style="max-width: 200px;">
                            {{ $item->plan }}
                        </td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-toggle="modal"
                                data-target="#editModal{{ $loop->index }}">
                                Edit
                            </button>
                        </td>
                    </tr>

                    <div class="modal fade" id="editModal{{ $loop->index }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">

                                <form method="POST" action="{{ route('triase-sekunder.update', $item->no_rawat) }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Triase Sekunder</h5>
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">

                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>No Rawat</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    value="{{ $item->no_rawat }}" readonly>
                                            </div>

                                            <div class="col-md-4">
                                                <label>No RM</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    value="{{ $item->no_rkm_medis }}" readonly>
                                            </div>

                                            <div class="col-md-4">
                                                <label>Nama</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    value="{{ $item->nm_pasien }}" readonly>
                                            </div>
                                        </div>

                                        <hr class="my-2">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Anamnesa Singkat</label>
                                                <textarea name="anamnesa_singkat" class="form-control form-control-sm"
                                                    rows="2">{{ $item->anamnesa_singkat }}</textarea>
                                            </div>

                                            <div class="col-md-6 mt-2">
                                                <label>Catatan</label>
                                                <textarea name="catatan" class="form-control form-control-sm"
                                                    rows="2">{{ $item->catatan }}</textarea>
                                            </div>

                                            <div class="col-md-6 mt-2">
                                                <label>Plan <span class="text-danger">*</span></label>
                                                <select name="plan" class="form-control form-control-sm" required>
                                                    <option value="">-- Pilih Plan --</option>
                                                    <option value="Zona Hijau" {{ $item->plan == 'Zona Hijau' ?
                                                        'selected' : '' }}>
                                                        Zona Hijau
                                                    </option>
                                                    <option value="Zona Kuning" {{ $item->plan == 'Zona Kuning' ?
                                                        'selected' : '' }}>
                                                        Zona Kuning
                                                    </option>
                                                </select>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                            Batal
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            Simpan
                                        </button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">Data tidak tersedia</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($triase->hasPages())
        <div class="card-footer d-flex justify-content-center">
            {{ $triase->links('pagination::simple-bootstrap-4') }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .table {
        font-size: 12px;

    }

    .table th,
    .table td {
        padding: 4px 6px;
        vertical-align: top;
    }
</style>
@endpush