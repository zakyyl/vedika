<!-- partials/rawatjalan/informasi_pasien.blade.php -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Informasi Pasien</h3>
    </div>
    <div class="card-body">
        <table class="table table-borderless">
            <tr><td width="40%">No Rawat</td><td>: {{ $data->no_rawat }}</td></tr>
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
