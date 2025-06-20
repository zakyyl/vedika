@extends('layouts.materio')

@section('content')
<div class="container">
  <h4 class="mb-4 fw-bold">Detail Rawat Jalan</h4>

  @if ($data)
  <div class="row g-4 align-items-stretch">
    <div class="col-md-4">
      <div class="card shadow-sm rounded-4 h-100">
        <div class="card-header bg-primary text-white fw-bold rounded-top-4">Informasi Umum</div>
        <div class="card-body">
          <p></p>
          <p> <strong> Data Pasien </strong></p>
          <p><strong>No Rawat:</strong><br>{{ $data->no_rawat }}</p>
          <p><strong>Tanggal Registrasi:</strong><br>{{ $data->tgl_registrasi }} {{ $data->jam_reg }}</p>
          <p><strong>Dokter:</strong><br>{{ $data->nm_dokter }}</p>
          <p><strong>Poli:</strong><br>{{ $data->nm_poli }}</p>
          <p><strong>Status Lanjut:</strong><br>{{ $data->status_lanjut }}</p>
          <p><strong>Nama Pasien:</strong><br>{{ $data->nm_pasien }}</p>
          <p><strong>Umur:</strong><br>{{ $data->umur }}</p>
          <p><strong>No Rekam Medis:</strong><br>{{ $data->no_rkm_medis }}</p>
        </div>
      </div>
    </div>

    <div class="col-md-8">
      <div class="card shadow-sm rounded-4 h-100">
        <div class="card-header bg-primary text-white fw-bold rounded-top-4">
          Upload Resume Keperawatan
        </div>
        <div class="card-body">
          <form action="{{ route('rawatjalan.upload_resume', $data->no_rawat) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <p></p>
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
            <p></p>
          </form>
          <div class="card rounded-4 shadow-sm mb-4">
            <div class="card-header bg-light fw-bold">
              Daftar Resume yang Sudah Diupload
            </div>
            <div class="card-body">
              @forelse($berkas as $item)
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                  <div>
                    <strong>{{ $item->nama_kategori }}</strong><br>
                    <small>{{ $item->lokasi_file }}</small>
                  </div>
                  <a href="{{ asset('storage/' . $item->lokasi_file) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                    Download
                  </a>
                </div>
              @empty
                <p class="text-muted">Belum ada berkas diunggah.</p>
              @endforelse
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @if(session('success'))
    <div class="alert alert-success mt-3">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger mt-3">{{ session('error') }}</div>
  @endif

  <!-- Tombol dan Modal Update Status -->
  <div class="mt-4 d-flex justify-content-between align-items-center">
    <a href="{{ route('rawatinap.index') }}" class="btn btn-outline-secondary rounded-pill">
      &larr; Kembali ke daftar
    </a>

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
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">No. Rekam Medis</label>
                <input type="text" class="form-control bg-light" value="{{ $data->no_rkm_medis }}" readonly>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">No. Rawat</label>
                <input type="text" class="form-control bg-light" value="{{ $data->no_rawat }}" readonly>
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
                <option value="Pengajuan" {{ (isset($vedikaData) && $vedikaData->status == 'Pengajuan') ? 'selected' : '' }}>Pengajuan</option>
                <option value="Perbaiki" {{ (isset($vedikaData) && $vedikaData->status == 'Perbaiki') ? 'selected' : '' }}>Perbaiki</option>
                <option value="Disetujui" {{ (isset($vedikaData) && $vedikaData->status == 'Disetujui') ? 'selected' : '' }}>Disetujui</option>
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
  @else
    <div class="alert alert-warning mt-4">Data tidak ditemukan.</div>
  @endif
</div>
@endsection
