<!-- partials/rawatjalan/form_upload_resume.blade.php -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Upload Resume</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('rawatjalan.upload_resume', $data->no_rawat) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Nomor Rawat</label>
                <input type="text" class="form-control" value="{{ $data->no_rawat }}" readonly>
            </div>
            <div class="form-group">
                <label>Kategori Berkas <span class="text-danger">*</span></label>
                <select name="kode" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategori as $item)
                        <option value="{{ $item->kode }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Pilih Berkas <small class="text-muted">(.pdf / .jpg)</small></label>
                <input type="file" name="file" class="form-control-file" accept=".pdf,.jpg,.jpeg" required>
                <small class="text-muted">Format: PDF, JPG, JPEG</small>
            </div>
            <div class="row">
                <div class="col-6">
                    <button type="submit" class="btn btn-success btn-block">Upload</button>
                </div>
                <div class="col-6">
                    <a href="{{ route('rawatjalan.statusklaim', ['no_rawat' => $data->no_rawat]) }}" class="btn btn-info btn-block">Lihat Resume</a>
                </div>
            </div>
        </form>
    </div>
</div>
