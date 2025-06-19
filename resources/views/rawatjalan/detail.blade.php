@extends('layouts.materio')

@section('content')
<div class="container">
  <h4 class="mb-4 fw-bold">Detail Rawat Jalan</h4>

  @if ($data)
  <div class="row g-4">
    <div class="col-md-4">
      <div class="card shadow-sm rounded-4 h-100">
        <div class="card-header bg-primary text-white fw-bold rounded-top-4">Informasi Umum</div>
        <div class="card-body">
          <p><strong>No Rawat:</strong><br>{{ $data->no_rawat }}</p>
          <p><strong>Tanggal Registrasi:</strong><br>{{ $data->tgl_registrasi }} {{ $data->jam_reg }}</p>
          <p><strong>Dokter:</strong><br>{{ $data->nm_dokter }}</p>
          <p><strong>Poli:</strong><br>{{ $data->nm_poli }}</p>
          <p><strong>Status Pendaftaran:</strong><br>{{ $data->stts_daftar }}</p>
          <p><strong>Status Lanjut:</strong><br>{{ $data->status_lanjut }}</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm rounded-4 h-100">
        <div class="card-header bg-secondary text-white fw-bold rounded-top-4">Informasi Pasien</div>
        <div class="card-body">
          <p><strong>Nama Pasien:</strong><br>{{ $data->nm_pasien }}</p>
          <p><strong>Jenis Kelamin:</strong><br>{{ $data->jk === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
          <p><strong>Umur:</strong><br>{{ $data->umur }}</p>
          <p><strong>No Rekam Medis:</strong><br>{{ $data->no_rkm_medis }}</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm rounded-4 h-100">
        <div class="card-header bg-info text-white fw-bold rounded-top-4">Penanggung Jawab</div>
        <div class="card-body">
          <p><strong>Nama Penanggung Jawab:</strong><br>{{ $data->p_jawab }}</p>
          <p><strong>Hubungan:</strong><br>{{ $data->hubunganpj }}</p>
          <p><strong>Alamat:</strong><br>{{ $data->almt_pj }}</p>
          <p><strong>Jenis Pembayaran:</strong><br>{{ $data->png_jawab }}</p>
          <p><strong>Biaya Registrasi:</strong><br>Rp{{ number_format($data->biaya_reg, 0, ',', '.') }}</p>
        </div>
      </div>
    </div>
  </div>


  <div class="mt-4 d-flex justify-content-between align-items-center">
    <a href="{{ route('rawatinap.index') }}" class="btn btn-outline-secondary rounded-pill">
      &larr; Kembali ke daftar
    </a>

    <a href="#" class="btn btn-success rounded-pill">
      Ubah Status Pengajuan
    </a>
  </div>

  @if(session('success'))
    <div class="alert alert-success mt-3">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger mt-3">{{ session('error') }}</div>
  @endif
  <div class="card mt-4 shadow-sm rounded-4">
    <div class="card-header bg-success text-white fw-bold rounded-top-4">
      Upload Resume Keperawatan
    </div>
    <div class="card-body">
      <form action="{{ route('rawatjalan.upload_resume', $data->no_rawat) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
          <label class="form-label">Nomor Rawat</label>
          <input type="text" class="form-control" value="{{ $data->no_rawat }}" readonly>
        </div>
        <div class="mb-3">
          <label for="kode" class="form-label">Kategori Berkas</label>
          <select name="kode" id="kode" class="form-select" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach($kategori as $item)
              <option value="{{ $item->kode }}">{{ $item->nama }}</option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label for="file" class="form-label">Pilih Berkas (.pdf / .jpg)</label>
          <input type="file" name="file" id="file" class="form-control" accept=".pdf,.jpg,.jpeg" required>
        </div>

        <button type="submit" class="btn btn-primary rounded-pill px-4">Upload</button>
      </form>
    </div>
  </div>

  @else
    <div class="alert alert-warning mt-4">Data tidak ditemukan.</div>
  @endif
</div>
@endsection
