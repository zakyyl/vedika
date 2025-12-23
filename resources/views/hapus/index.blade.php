@extends('layouts.master')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Hapus Data Vedika</h5>
        </div>

        <div class="card-body">
            <form id="formCariVedika">
                @csrf

                <div class="form-group">
                    <label>No SEP</label>
                    <input type="text" name="no_sep" id="no_sep" class="form-control" placeholder="Masukkan No SEP"
                        required>
                </div>

                <button type="submit" class="btn btn-danger">
                    Cari & Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="card border-warning shadow-sm mb-4">
        {{-- <div class="card-header bg-warning text-dark d-flex align-items-center">
            <i class="fas fa-exclamation-triangle mr-2" style="font-size: 1.3rem;"></i>
            <h5 class="mb-0 font-weight-bold">
                PERINGATAN PENTING
            </h5>
        </div> --}}
        <div class="card-body">
            <p class="mb-0 " style="font-size: 1rem; font-weight: 500;">
                Mohon periksa data dengan <strong>sangat teliti</strong> sebelum melakukan proses
                <span class="text-danger font-weight-bold">penghapusan data</span>.
                <br>
                <span class="text-muted">
                    Tindakan ini bersifat permanen dan tidak dapat dibatalkan.
                </span>
            </p>
        </div>
    </div>

</div>

<div class="modal fade" id="modalHapusVedika" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <p>Yakin ingin menghapus data Vedika berikut?</p>
                <ul class="mb-0">
                    <li><b>No Rawat:</b> <span id="txtNoRawat"></span></li>
                    <li><b>No RM:</b> <span id="txtNoRM"></span></li>
                    <li><b>Nama Pasien:</b> <span id="txtNama"></span></li>
                </ul>

                <input type="hidden" id="hapusNoSep">
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">
                    Batal
                </button>
                <button class="btn btn-danger" onclick="hapusVedika()">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalInfo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-center">Informasi</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body text-center" id="infoMessage"></div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" data-dismiss="modal">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalSuccess" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Berhasil</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body text-center" id="successMessage"></div>
            <div class="modal-footer">
                <button class="btn btn-success btn-sm" data-dismiss="modal">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('formCariVedika').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch(`{{ route('hapus.confirm.form') }}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(async res => {
    const text = await res.text();

    try {
        const json = JSON.parse(text);
        if (!res.ok) throw json;
        return json;
    } catch (e) {
        throw { message: 'Data pasien tidak ditemukan' };
    }
})

    .then(data => {
        document.getElementById('txtNoRawat').innerText = data.no_rawat;
        document.getElementById('txtNoRM').innerText = data.no_rkm_medis;
        document.getElementById('txtNama').innerText = data.nm_pasien;
        document.getElementById('hapusNoSep').value = data.nosep;

        $('#modalHapusVedika').modal('show');
    })
    .catch(err => {
        document.getElementById('infoMessage').innerText =
            err.message || 'Data Vedika tidak ditemukan';
        $('#modalInfo').modal('show');
    });
});

function hapusVedika() {
    const noSep = document.getElementById('hapusNoSep').value;

    fetch(`{{ route('hapus') }}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ no_sep: noSep })
    })
    .then(res => res.json())
    .then(data => {
        $('#modalHapusVedika').modal('hide');
        document.getElementById('successMessage').innerText = data.message;
        $('#modalSuccess').modal('show');

        document.getElementById('formCariVedika').reset();
    })
    .catch(() => {
        document.getElementById('infoMessage').innerText =
            'Terjadi kesalahan saat menghapus data';
        $('#modalInfo').modal('show');
    });
}
</script>
@endpush