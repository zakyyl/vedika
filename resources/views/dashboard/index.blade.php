@extends('layouts.materio')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold mb-4">Dashboard</h4>

  <div class="row g-3">
    <div class="col-md-6 col-xl-3">
      <div class="card shadow-sm border-0">
        <div class="card-body d-flex align-items-center">
          <div class="avatar bg-primary text-white me-3 rounded">
            <i class="bx bx-walk fs-4"></i>
          </div>
          <div>
            <h6 class="mb-1">Rawat Jalan</h6>
            <h4 class="mb-0">{{ $totalRawatJalan }}</h4>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-xl-3">
      <div class="card shadow-sm border-0">
        <div class="card-body d-flex align-items-center">
          <div class="avatar bg-success text-white me-3 rounded">
            <i class="bx bx-hotel fs-4"></i>
          </div>
          <div>
            <h6 class="mb-1">Rawat Inap</h6>
            <h4 class="mb-0">{{ $totalRawatInap }}</h4>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-xl-3">
      <div class="card shadow-sm border-0">
        <div class="card-body d-flex align-items-center">
          <div class="avatar bg-info text-white me-3 rounded">
            <i class="bx bx-user fs-4"></i>
          </div>
          <div>
            <h6 class="mb-1">Jumlah Pasien</h6>
            <h4 class="mb-0">{{ $totalPasien }}</h4>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-xl-3">
      <div class="card shadow-sm border-0">
        <div class="card-body d-flex align-items-center">
          <div class="avatar bg-warning text-white me-3 rounded">
            <i class="bx bx-user-pin fs-4"></i>
          </div>
          <div>
            <h6 class="mb-1">Jumlah Dokter</h6>
            <h4 class="mb-0">{{ $totalDokter }}</h4>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
