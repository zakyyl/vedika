@extends('layouts.materio')

@section('content')
    <div class="container mt-4">
        <h4 class="mb-4 fw-bold">Daftar Resume yang Sudah Diupload Rawat Jalan</h4>

        @if ($berkas->isEmpty())
            <div class="alert alert-warning">
                Belum ada berkas diunggah untuk No. Rawat: <strong>{{ $no_rawat }}</strong>
            </div>
        @else
            <div class="card rounded-4 shadow-sm">
                <div class="card-body">
                    @foreach ($berkas as $item)
                        <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                            <div>
                                <strong>{{ $item->nama_kategori }}</strong><br>
                                <small>{{ $item->lokasi_file }}</small>
                            </div>
                            <a href="{{ asset('storage/' . $item->lokasi_file) }}" target="_blank"
                                class="btn btn-sm btn-outline-primary">
                                Download
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <a href="{{ route('rawatinap.detail', $no_rawat) }}" class="btn btn-outline-secondary rounded-pill mt-3">
            &larr; Kembali ke Detail Rawat Jalan
        </a>
    </div>
@endsection
