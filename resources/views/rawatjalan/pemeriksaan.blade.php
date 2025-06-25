@extends('layouts.master')

@section('content')
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-clipboard-list mr-2"></i>Data Pemeriksaan Rawat Jalan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('rawatjalan.index') }}">Rawat Jalan</a></li>
                        <li class="breadcrumb-item active">Data Pemeriksaan</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            @if ($data->isEmpty())
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle mr-1"></i> Tidak ada data pemeriksaan untuk No. Rawat: <strong>{{ $no_rawat }}</strong>
                </div>
                <div class="text-center">
                    <a href="{{ route('rawatjalan.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left mr-1"></i>Kembali
                    </a>
                </div>
            @else
                <div class="accordion" id="pemeriksaanAccordion">
                    @foreach ($data as $index => $item)
                        <div class="card mb-2">
                            <div class="card-header" id="heading{{ $index }}">
                                <h2 class="mb-0">
                                    <button class="btn btn-link text-left w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="false" aria-controls="collapse{{ $index }}">
                                        {{ $item->no_rawat }} - {{ $item->nm_pasien }} | Dr. {{ $item->nm_dokter }} | {{ \Carbon\Carbon::parse($item->tgl_perawatan)->format('d/m/Y') }}
                                    </button>
                                </h2>
                            </div>

                            <div id="collapse{{ $index }}" class="collapse" aria-labelledby="heading{{ $index }}" data-bs-parent="#pemeriksaanAccordion">
                                <div class="card-body">
                                    <table class="table table-sm table-bordered">
                                        <tbody>
                                            <tr>
                                                <th>Tensi</th>
                                                <td>{{ $item->tensi ?: '-' }}</td>
                                                <th>Suhu</th>
                                                <td>{{ $item->suhu_tubuh ?: '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Nadi</th>
                                                <td>{{ $item->nadi ?: '-' }}</td>
                                                <th>Respirasi</th>
                                                <td>{{ $item->respirasi ?: '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>SpO2</th>
                                                <td>{{ $item->spo2 ?: '-' }}</td>
                                                <th>GCS</th>
                                                <td>{{ $item->gcs ?: '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>TB</th>
                                                <td>{{ $item->tinggi ?: '-' }}</td>
                                                <th>BB</th>
                                                <td>{{ $item->berat ?: '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>LP</th>
                                                <td>{{ $item->lingkar_perut ?: '-' }}</td>
                                                <th>Kesadaran</th>
                                                <td>{{ $item->kesadaran ?: '-' }}</td>
                                            </tr>
                                            @if($item->keluhan)
                                                <tr>
                                                    <th>Keluhan</th>
                                                    <td colspan="3">{{ $item->keluhan }}</td>
                                                </tr>
                                            @endif
                                            @if($item->pemeriksaan)
                                                <tr>
                                                    <th>Pemeriksaan</th>
                                                    <td colspan="3">{{ $item->pemeriksaan }}</td>
                                                </tr>
                                            @endif
                                            @if($item->alergi)
                                                <tr>
                                                    <th class="text-warning">Alergi</th>
                                                    <td colspan="3">{{ $item->alergi }}</td>
                                                </tr>
                                            @endif
                                            @if($item->penilaian)
                                                <tr>
                                                    <th>Penilaian</th>
                                                    <td colspan="3">{{ $item->penilaian }}</td>
                                                </tr>
                                            @endif
                                            @if($item->rtl)
                                                <tr>
                                                    <th>RTL</th>
                                                    <td colspan="3">{{ $item->rtl }}</td>
                                                </tr>
                                            @endif
                                            @if($item->instruksi)
                                                <tr>
                                                    <th>Instruksi</th>
                                                    <td colspan="3">{{ $item->instruksi }}</td>
                                                </tr>
                                            @endif
                                            @if($item->evaluasi)
                                                <tr>
                                                    <th>Evaluasi</th>
                                                    <td colspan="3">{{ $item->evaluasi }}</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('rawatjalan.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left mr-1"></i>Kembali ke Daftar
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection
