<div class="accordion mt-3" id="accordionPemeriksaanUSG">
    {{-- HASIL USG --}}
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

    {{-- USG GYNECOLOGI --}}
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

    {{-- ECHO --}}
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
            <div class="card-body p-2">
                @if (!empty($hasil_echo) && count($hasil_echo) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm table-hover">
                            <thead class="table-light text-center align-middle">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Dokter</th>
                                    <th>EF</th>
                                    <th>IVS</th>
                                    <th>LVIDd</th>
                                    <th>LVIDs</th>
                                    <th>LV PWd</th>
                                    <th>LV PWs</th>
                                    <th>IVS Fraction</th>
                                    <th>Kesimpulan</th>
                                    <th>Saran</th>
                                    <th>Diagnosa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hasil_echo as $item)
                                    <tr>
                                        <td class="text-nowrap text-center">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                                        <td>{{ $item->nm_dokter ?? '-' }}</td>
                                        <td>{{ $item->ef ?? '-' }}</td>
                                        <td>{{ $item->ivs ?? '-' }}</td>
                                        <td>{{ $item->LVIDd ?? '-' }}</td>
                                        <td>{{ $item->LVIDs ?? '-' }}</td>
                                        <td>{{ $item->LVPWd ?? '-' }}</td>
                                        <td>{{ $item->LVPWs ?? '-' }}</td>
                                        <td>{{ $item->IVSfract ?? '-' }}</td>
                                        <td><small>{{ $item->conclusion ?? '-' }}</small></td>
                                        <td><small class="text-muted">{{ $item->suggestion ?? '-' }}</small></td>
                                        <td>{{ $item->dx ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info m-0"><i class="fas fa-info-circle"></i> Tidak ada hasil pemeriksaan Echo.</div>
                @endif
            </div>
        </div>
    </div>

    {{-- EKG --}}
    <div class="card shadow-sm">
        <div class="card-header py-2 px-3" id="headingEKG">
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
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm table-hover">
                            <thead class="table-light text-center align-middle">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Dokter</th>
                                    <th>Irama</th>
                                    <th>Rate</th>
                                    <th>Axis</th>
                                    <th>Hiper</th>
                                    <th>Iskemia</th>
                                    <th>Lain</th>
                                    <th>Kesimpulan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hasil_ekg as $item)
                                    <tr>
                                        <td class="text-nowrap text-center">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y H:i') }}</td>
                                        <td>{{ $item->kd_dokter ?? '-' }}</td>
                                        <td>{{ $item->irama ?? '-' }}</td>
                                        <td>{{ $item->rate ?? '-' }}</td>
                                        <td>{{ $item->axis ?? '-' }}</td>
                                        <td>{{ $item->hiper ?? '-' }}</td>
                                        <td>{{ $item->iskemia ?? '-' }}</td>
                                        <td>{{ $item->lain ?? '-' }}</td>
                                        <td><small class="text-muted">{{ $item->kesimpulan ?? '-' }}</small></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info m-0"><i class="fas fa-info-circle"></i> Tidak ada hasil pemeriksaan EKG.</div>
                @endif
            </div>
        </div>
    </div>
</div>
