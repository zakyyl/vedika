<div class="col-12 mb-3">
    <div class="card shadow-sm">
        <div class="card-header py-2">
            <h5 class="card-title mb-0" style="font-size: 1rem;">Informasi Pasien</h5>
        </div>
        <div class="card-body py-2 px-3" style="font-size: 0.875rem;">
            <table class="table table-borderless mb-0">
                <tr><td width="25%">No Rawat</td><td>: {{ $data->no_rawat }}</td></tr>
                <tr><td>Tanggal</td><td>: {{ $data->tgl_registrasi }} {{ $data->jam_reg }}</td></tr>
                <tr><td>Dokter</td><td>: {{ $data->nm_dokter }}</td></tr>
                <tr><td>Poli</td><td>: {{ $data->nm_poli }}</td></tr>
                <tr><td>Status</td><td>: <span class="badge badge-info">{{ $data->status_lanjut }}</span></td></tr>
                <tr><td>Nama Pasien</td><td>: <strong>{{ $data->nm_pasien }}</strong></td></tr>
                <tr><td>Umur</td><td>: {{ $data->umur }}</td></tr>
                <tr><td>No RM</td><td>: {{ $data->no_rkm_medis }}</td></tr>
            </table>
        </div>
    </div>
</div>
