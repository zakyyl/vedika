<div class="accordion" id="accordionBilling">
    <div class="card shadow-sm">
        <div class="card-header py-2 px-3" id="headingBilling">
            <h5 class="mb-0" style="font-size: 1rem;">
                <button class="btn btn-link w-100 text-left text-dark" type="button" data-toggle="collapse"
                    data-target="#collapseBilling" aria-expanded="false" aria-controls="collapseBilling">
                    <strong>Data Billing</strong>
                    <i class="fas fa-chevron-down ml-2 rotate-icon"></i>
                </button>
            </h5>
        </div>
        <div id="collapseBilling" class="collapse" aria-labelledby="headingBilling" data-parent="#accordionBilling">
            <div class="card-body p-2">
                @if ($billing && count($billing) > 0)
                    <table class="table table-sm table-borderless mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Perawatan</th>
                                <th>Pemisah</th>
                                <th>Biaya</th>
                                <th>Jumlah</th>
                                <th>Tambahan</th>
                                <th>Total Biaya</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($billing as $item)
                                <tr>
                                    <td>{{ $item->no }}</td>
                                    <td>{{ $item->nm_perawatan }}</td>
                                    <td>{{ $item->pemisah }}</td>
                                    <td>{{ $item->biaya }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>{{ $item->tambahan }}</td>
                                    <td>{{ $item->totalbiaya }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold">
                                <td colspan="6" class="text-end">Total:</td>
                                <td>{{ number_format($totalBilling, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                @else
                    <div class="alert alert-info py-2 px-3 mb-0">
                        <i class="fas fa-info-circle"></i> Tidak ada data billing untuk pasien ini.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
