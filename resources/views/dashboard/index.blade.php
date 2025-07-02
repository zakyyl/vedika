@extends('layouts.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold mb-4">Dashboard</h4>

  <div class="row">
    <div class="col-md-3">
        <div class="info-box bg-info">
            <span class="info-box-icon"><i class="fas fa-procedures"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Rawat Jalan Bulan Ini</span>
                <span class="info-box-number">{{ $totalRawatJalan }}</span>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="info-box bg-warning">
            <span class="info-box-icon"><i class="fas fa-clipboard-list"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Pengajuan Ralan</span>
                <span class="info-box-number">{{ $pengajuanRawatJalan }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="info-box bg-primary">
            <span class="info-box-icon"><i class="fas fa-procedures"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Rawat Inap Bulan Ini</span>
                <span class="info-box-number">{{ $totalRawatInap }}</span>
            </div>
        </div>
    </div>


    <div class="col-md-3">
        <div class="info-box bg-danger">
            <span class="info-box-icon"><i class="fas fa-clipboard-check"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Pengajuan Ranap</span>
                <span class="info-box-number">{{ $pengajuanRawatInap }}</span>
            </div>
        </div>
    </div>
</div>

</div>
@endsection
