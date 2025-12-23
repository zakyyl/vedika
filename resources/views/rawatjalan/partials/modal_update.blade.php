<div class="modal fade" id="updateModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update Status Klaim</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ route('rawatjalan.update_status', $data->no_rawat) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>No. RM</label>
                                <input type="text" class="form-control" value="{{ $data->no_rkm_medis }}" readonly>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>No. Rawat</label>
                                <input type="text" class="form-control" value="{{ $data->no_rawat }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>No. SEP</label>
                        @if ($sepData && $sepData->no_sep)
                            <input type="text" class="form-control" value="{{ $sepData->no_sep }}" readonly>
                        @else
                            <input type="text" class="form-control" value="Belum ada data SEP" readonly>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="status">Status Klaim <span class="text-danger">*</span></label>
                        @php
                            $currentStatus = $vedikaData->status ?? null;
                            $userRole = Auth::user()->roles ?? 'guest';

                            $allowedStatus = match ($userRole) {
                                'bpjs' => ['Perbaiki', 'Disetujui'],
                                'casemix' => ['Pengajuan', 'Rujukan Internal'],
                                default => ['Pengajuan', 'Perbaiki', 'Disetujui', 'Rujukan Internal'],
                            };

                        @endphp

                        <select name="status" id="status" class="form-control" required>
                            <option value="" disabled {{ !$currentStatus ? 'selected' : '' }}>-- Pilih Status --
                            </option>

                            @foreach ($allowedStatus as $status)
                                <option value="{{ $status }}" {{ $currentStatus == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group">
                        <label>Catatan</label>
                        <textarea name="catatan" class="form-control" rows="4" placeholder="Masukkan catatan...">{{ isset($vedikaData) ? $vedikaData->catatan : '' }}</textarea>
                    </div>

                    @if (isset($vedikaData) && ($vedikaData->status || $vedikaData->catatan))
                        <div class="alert alert-info">
                            <h6>Informasi Status Klaim:</h6>
                            @if ($vedikaData->status)
                                <p><strong>Status:</strong> <span
                                        class="badge badge-info">{{ $vedikaData->status }}</span></p>
                            @endif
                            @if ($vedikaData->catatan)
                                <p><strong>Catatan:</strong> {{ $vedikaData->catatan }}</p>
                            @endif
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <p><strong>Perhatian:</strong> Belum ada data status klaim. Status baru akan dibuat.</p>
                        </div>
                    @endif

                    @if (!$sepData || !$sepData->no_sep)
                        <div class="alert alert-danger">
                            <p><strong>Peringatan:</strong> Pasien ini belum memiliki nomor SEP. Pastikan nomor SEP
                                sudah dibuat sebelum melakukan update status klaim.</p>
                        </div>
                    @endif
                </div>

                <input type="hidden" name="no_rkm_medis" value="{{ $data->no_rkm_medis }}">
                <input type="hidden" name="tgl_registrasi" value="{{ $data->tgl_registrasi }}">
                <input type="hidden" name="nosep" value="{{ $sepData->no_sep }}">
                <input type="hidden" name="jenis" value="Ralan">

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">
                        {{ isset($vedikaData) && $vedikaData->status ? 'Update' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
