<ul class="list-group">
    @foreach ($items as $item)
        <li class="list-group-item">
            <div class="d-flex justify-content-between align-items-center">
                <span><strong>{{ $item->program }}</strong></span>
                <span class="text-muted" style="font-size: .85rem;">
                    {{ \Illuminate\Support\Carbon::parse($item->tanggal)->format('d M Y H:i') }}
                </span>
            </div>

            <hr class="my-2">

            <div class="mb-1"><strong>No. Rawat:</strong> {{ $item->no_rawat }}</div>
            <div class="mb-1"><strong>No. Rawat Layanan:</strong> {{ $item->no_rawat_layanan }}</div>

            <div class="mb-1">
                <strong>Pasien:</strong>
                {{ $item->nm_pasien }} ({{ $item->no_rkm_medis }})
                • {{ $item->jk }}
                • {{ $item->umurdaftar }}{{ $item->sttsumur }}
            </div>

            <div class="mb-2"><strong>Diagnosa Medis:</strong> {{ $item->diagnosa_medis }}</div>
            <div class="mb-2"><strong>Tatalaksana:</strong><br>{{ $item->tatalaksana }}</div>
            <div class="mb-2"><strong>Evaluasi:</strong><br>{{ $item->evaluasi }}</div>

            <div class="mb-2"><strong>Petugas:</strong> {{ $item->nama }} (NIP: {{ $item->nip }})</div>

            @if (!empty($item->photos))
                <div class="mt-2">
                    <strong>Dokumentasi:</strong>
                    <div class="d-flex flex-wrap">
                        @foreach ($item->photos as $url)
                            <a href="{{ $url }}" target="_blank" class="mr-2 mb-2">
                                <img src="{{ $url }}" alt="Foto Program KFR" class="img-thumbnail" style="max-width:140px; height:auto;">
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </li>
    @endforeach
</ul>
