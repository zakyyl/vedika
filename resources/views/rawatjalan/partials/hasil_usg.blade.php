<div class="accordion mt-3" id="accordionPemeriksaanUSG">
    <div class="card shadow-sm">
        <div class="card-header py-2 px-3" id="headingUSG">
            <h5 class="mb-0" style="font-size: 1rem;">
                <button class="btn btn-link w-100 text-left text-dark" type="button" data-toggle="collapse"
                    data-target="#collapseUSG" aria-expanded="false" aria-controls="collapseUSG">
                    <strong>Hasil Pemeriksaan USG</strong>
                    <i class="fas fa-chevron-down ml-2 rotate-icon"></i>
                </button>
            </h5>
        </div>
        <div id="collapseUSG" class="collapse" aria-labelledby="headingUSG" data-parent="#accordionPemeriksaanUSG">
            <div class="card-body p-2">
                @if (!empty($hasil_usg) && count($hasil_usg) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm table-hover">
                            <thead class="table-light text-center align-middle">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Janin</th>
                                    <th>Letak</th>
                                    <th>Anak</th>
                                    <th>Plasenta</th>
                                    <th>Air Ketuban</th>
                                    <th>AFI</th>
                                    <th>EFW</th>
                                    <th>TTP</th>
                                    <th>Kesimpulan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hasil_usg as $item)
                                    <tr>
                                        <td class="text-nowrap text-center">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                                        <td>{{ $item->janin ?? '-' }}</td>
                                        <td>{{ $item->letak ?? '-' }}</td>
                                        <td>{{ $item->anak ?? '-' }}</td>
                                        <td>{{ $item->plasenta ?? '-' }}</td>
                                        <td>{{ $item->jumlah_air_ketuban ?? '-' }}</td>
                                        <td>{{ $item->afi ?? '-' }}</td>
                                        <td>{{ $item->efw ?? '-' }}</td>
                                        <td>{{ $item->ttp ?? '-' }}</td>
                                        <td><small class="text-muted">{{ $item->kesimpulan ?? '-' }}</small></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info m-0"><i class="fas fa-info-circle"></i> Tidak ada hasil pemeriksaan USG.</div>
                @endif
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header py-2 px-3" id="headingGynecologi">
            <h5 class="mb-0" style="font-size: 1rem;">
                <button class="btn btn-link w-100 text-left text-dark" type="button" data-toggle="collapse"
                    data-target="#collapseGynecologi" aria-expanded="false" aria-controls="collapseGynecologi">
                    <strong>Hasil USG Gynecologi</strong>
                    <i class="fas fa-chevron-down ml-2 rotate-icon"></i>
                </button>
            </h5>
        </div>
        <div id="collapseGynecologi" class="collapse" aria-labelledby="headingGynecologi"
            data-parent="#accordionPemeriksaanUSG">
            <div class="card-body p-2">
                @if (!empty($hasil_usg_gynecologi) && count($hasil_usg_gynecologi) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm table-hover">
                            <thead class="table-light text-center align-middle">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Deskripsi</th>
                                    <th>Kesan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hasil_usg_gynecologi as $item)
                                    <tr>
                                        <td class="text-nowrap text-center">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                                        <td>{{ $item->deskripsi ?? '-' }}</td>
                                        <td>{{ $item->kesan ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info m-0"><i class="fas fa-info-circle"></i> Tidak ada hasil USG Gynecologi.</div>
                @endif
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
    <div class="card-header py-2 px-3" id="headingEcho">
        <h5 class="mb-0" style="font-size: 1rem;">
            <button class="btn btn-link w-100 text-left text-dark" type="button" data-toggle="collapse"
                data-target="#collapseEcho" aria-expanded="false" aria-controls="collapseEcho">
                <strong>Hasil Pemeriksaan Echo</strong>
                  <i class="fas fa-chevron-down ml-2 rotate-icon"></i>
            </button>
        </h5>
    </div>
    
    

    <div id="collapseEcho" class="collapse" aria-labelledby="headingEcho" data-parent="#accordionPemeriksaanUSG">
        <div class="card-body p-3">
            @if (!empty($hasil_echo) && count($hasil_echo) > 0)
                <div class="timeline">
                    @foreach ($hasil_echo as $item)
                        <div class="timeline-item mb-4">
                            <div class="timeline-content border-left pl-4">
                                <h6 class="mb-1 text-dark">
                                    <i class="fas fa-calendar mr-1"></i>
                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }} – {{ $item->nm_dokter ?? '-' }}
                                </h6>
                                <ul class="mb-1 small text-muted">
                                    <li><strong>EF:</strong> {{ $item->ef ?? '-' }}</li>
                                    <li><strong>IVS:</strong> {{ $item->ivs ?? '-' }}</li>
                                    <li><strong>LVIDd:</strong> {{ $item->LVIDd ?? '-' }} | <strong>LVIDs:</strong> {{ $item->LVIDs ?? '-' }}</li>
                                    <li><strong>LV PWd:</strong> {{ $item->LVPWd ?? '-' }} | <strong>LV PWs:</strong> {{ $item->LVPWs ?? '-' }}</li>
                                    <li><strong>IVS Fraction:</strong> {{ $item->IVSfract ?? '-' }}</li>
                                    <li><strong>Kesimpulan:</strong> {{ $item->conclusion ?? '-' }}</li>
                                    <li><span class="badge bg-success"><strong>Saran:</strong></span> {{ $item->suggestion ?? '-' }}</li>
                                    <li><strong>Diagnosa:</strong> {{ $item->dx ?? '-' }}</li>
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info m-0">
                    <i class="fas fa-info-circle"></i> Tidak ada hasil pemeriksaan Echo.
                </div>
            @endif
        </div>
    </div>
</div>


    <div class="card shadow-sm">
    <div class="card-header py-2" id="headingEKG">
        <h5 class="mb-0" style="font-size: 1rem;">
            <button class="btn btn-link w-100 text-left text-dark" type="button" data-toggle="collapse"
                data-target="#collapseEKG" aria-expanded="false" aria-controls="collapseEKG">
                <strong>Hasil Pemeriksaan EKG</strong>
                  <i class="fas fa-chevron-down ml-2 rotate-icon"></i>
            </button>
        </h5>
    </div>
    <div id="collapseEKG" class="collapse" aria-labelledby="headingEKG" data-parent="#accordionPemeriksaanUSG">
        <div class="card-body p-2">
            @if (!empty($hasil_ekg) && count($hasil_ekg) > 0)
                <div class="timeline" style="max-height: 500px; overflow-y: auto;">
                    @foreach ($hasil_ekg as $item)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-danger"></div>
                            <div class="timeline-content">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-light py-2">
                                        <div class="row align-items-center">
                                            <div class="col-8">
                                                <h6 class="mb-0 text">
                                                    <i class="fas fa-calendar mr-1"></i>
                                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y H:i') }}
                                                </h6>
                                            </div>
                                            <div class="col-4 text-right">
                                                <span class="badge badge-primary">{{ $item->nm_dokter ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <table class="table table-borderless table-sm">
                                                    <tr>
                                                        <td class="font-weight-bold text-info">Irama:</td>
                                                        <td>{{ $item->irama ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="font-weight-bold text-success">Rate:</td>
                                                        <td>{{ $item->rate ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="font-weight-bold text-warning">Axis:</td>
                                                        <td>{{ $item->axis ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="font-weight-bold text-danger">Hiper:</td>
                                                        <td>{{ $item->hiper ?? '-' }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-md-6">
                                                <table class="table table-borderless table-sm">
                                                    <tr>
                                                        <td class="font-weight-bold">Iskemia:</td>
                                                        <td>{{ $item->iskemia ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="font-weight-bold">Lain-lain:</td>
                                                        <td>{{ $item->lain ?? '-' }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="mt-2 p-2 bg-primary text-white rounded">
                                            <strong>Kesimpulan:</strong> {{ $item->kesimpulan ?? '-' }}
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                      <div class="alert alert-info m-0">
                    <i class="fas fa-info-circle"></i> Tidak ada hasil pemeriksaan EKG.
                </div>
            @endif
        </div>
    </div>
</div>
    
    <div class="accordion" id="accordionlaporantindakan">
    <div class="card shadow-sm">
        <div class="card-header py-2 px-3" id="headinglaporantindakan">
            <h5 class="mb-0" style="font-size: 1rem;">
                <button class="btn btn-link w-100 text-left text-dark" type="button" data-toggle="collapse"
                    data-target="#collapselaporantindakan" aria-expanded="false" aria-controls="collapselaporantindakan">
                    <strong>Laporan Tindakan</strong>
                    <i class="fas fa-chevron-down ml-2 rotate-icon"></i>
                </button>
            </h5>
        </div>
        <div id="collapselaporantindakan" class="collapse" aria-labelledby="headinglaporantindakan" data-parent="#accordionlaporantindakan">
            <div class="card-body p-2">
                @if (!empty($laporan_tindakan) && count($laporan_tindakan) > 0)
                    <div class="list-group" style="max-height: 400px; overflow-y: auto;">
                        @foreach ($laporan_tindakan as $item)
                            <div class="list-group-item mb-2">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y H:i') }}</h6>
                                    <small class="text-muted">{{ $item->nm_dokter ?? '-' }}</small>
                                </div>
                                <p class="mb-1"><strong>Diagnosa Pra Tindakan:</strong></p>
                                <p class="mb-1">{{ $item->diagnosa_pra_tindakan ?? '-' }}</p>
                                <p class="mb-1"><strong>Diagnosa Pasca Tindakan:</strong></p>
                                <p class="mb-0">{{ $item->diagnosa_pasca_tindakan ?? '-' }}</p>
                                <p class="mb-1"><strong>Tindakan:</strong></p>
                                <p class="mb-0">{{ $item->tindakan_medik ?? '-' }}</p>
                                <p class="mb-1"><strong>Uraian:</strong></p>
                                <p class="mb-0">{{ $item->uraian ?? '-' }}</p>
                                <span class="badge bg-info"><p class="mb-1"><strong>Hasil:</strong></p></span>
                                <p class="mb-0">{{ $item->hasil ?? '-' }}</p>
                                <span class="badge bg-success"><p class="mb-1"><strong>Kesimpulan:</strong></p></span>
                                <p class="mb-0">{{ $item->kesimpulan ?? '-' }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info m-0"><i class="fas fa-info-circle"></i> Tidak ada laporan tindakan.</div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>
