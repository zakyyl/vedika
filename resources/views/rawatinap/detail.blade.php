@extends('layouts.materio')

@section('content')
<div class="container">
  <h4 class="mb-4 fw-bold">Detail Rawat Inap</h4>

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
<!-- Tambahkan tombol Update Status di bagian yang sudah ada -->
<div class="mt-4 d-flex justify-content-between align-items-center">
  <a href="{{ route('rawatinap.index') }}" class="btn btn-outline-secondary rounded-pill">
    &larr; Kembali ke daftar
  </a>
  
  <!-- Tombol untuk membuka modal Update Status -->
  <button type="button" class="btn btn-warning rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#updateStatusModal">
    Update Status Klaim
  </button>
</div>

<!-- Modal Update Status -->
<div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-4">
      <div class="modal-header bg-warning text-white">
        <h5 class="modal-title fw-bold" id="updateStatusModalLabel">Update Status Klaim</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <form action="{{ route('rawatinap.update_status', $data->no_rawat) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label fw-bold">No. Rekam Medis</label>
                <input type="text" class="form-control bg-light" value="{{ $data->no_rkm_medis }}" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label fw-bold">No. Rawat</label>
                <input type="text" class="form-control bg-light" value="{{ $data->no_rawat }}" readonly>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">No. SEP</label>
            <input type="text" class="form-control bg-light" value="{{ $vedikaData->nosep ?? 'Belum ada data SEP' }}" readonly>
          </div>

          <div class="mb-3">
            <label for="status" class="form-label fw-bold">Status Klaim <span class="text-danger">*</span></label>
            <select name="status" id="status" class="form-select" required>
              <option value="">-- Pilih Status Klaim --</option>
              <option value="Pengajuan" {{ (isset($vedikaData) && $vedikaData->status == 'Pengajuan') ? 'selected' : '' }}>
                Pengajuan
              </option>
              <option value="Perbaiki" {{ (isset($vedikaData) && $vedikaData->status == 'Perbaiki') ? 'selected' : '' }}>
                Perbaiki
              </option>
              <option value="Disetujui" {{ (isset($vedikaData) && $vedikaData->status == 'Disetujui') ? 'selected' : '' }}>
                Disetujui
              </option>
            </select>
            @if(isset($vedikaData) && $vedikaData->status)
              <div class="form-text">Status saat ini: <strong>{{ $vedikaData->status }}</strong></div>
            @endif
          </div>

          <div class="mb-3">
            <label for="catatan" class="form-label fw-bold">Catatan dan Umpan Balik</label>
            <textarea name="catatan" id="catatan" class="form-control" rows="5" 
                      placeholder="Masukkan catatan dan umpan balik untuk status klaim ini...">{{ isset($vedikaData) ? $vedikaData->catatan : '' }}</textarea>
            <div class="form-text">Berikan catatan detail mengenai status klaim dan umpan balik yang diperlukan</div>
          </div>

          @if(isset($vedikaData) && ($vedikaData->status || $vedikaData->catatan))
          <div class="alert alert-info">
            <h6 class="fw-bold mb-2">Informasi Status Klaim Saat Ini:</h6>
            @if($vedikaData->status)
              <p class="mb-1"><strong>Status:</strong> {{ $vedikaData->status }}</p>
            @endif
            @if($vedikaData->catatan)
              <p class="mb-0"><strong>Catatan Sebelumnya:</strong> {{ $vedikaData->catatan }}</p>
            @endif
          </div>
          @else
          <div class="alert alert-warning">
            <strong>Perhatian:</strong> Belum ada data status klaim untuk rawat inap ini. Status dan catatan akan dibuat baru.
          </div>
          @endif
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-warning rounded-pill px-4">
            {{ isset($vedikaData) && $vedikaData->status ? 'Update Status' : 'Buat Status Baru' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

  <div class="card mt-4 shadow-sm rounded-4">
    <div class="card-header bg-success text-white fw-bold rounded-top-4">
      Upload Resume Keperawatan
    </div>
    <div class="card-body">
      <form action="{{ route('rawatinap.upload_resume', $data->no_rawat) }}" method="POST" enctype="multipart/form-data">
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
