@extends('layouts.master')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold mb-4">Dashboard</h4>

        <div class="row mb-4">
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

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Pengajuan Klaim Rawat Jalan {{ $monthlyData['tahun'] ?? date('Y') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <canvas id="pengajuanRalanChart" height="120"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Pengajuan Klaim Rawat Inap {{ $monthlyData['tahun'] ?? date('Y') }}</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="pengajuanRanapChart" height="120"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {

                const labels = @json($monthlyData['labels']);

                const createSimpleChart = (canvasId, data, label, barColor, lineColor) => {
                    const maxVal = Math.max(...data) * 1.2;

                    const datasets = [{
                            type: 'bar',
                            label: label,
                            data: data,
                            backgroundColor: barColor,
                            borderRadius: 6,
                            order: 1,
                            datalabels: {
                                display: false
                            }
                        },
                        {
                            type: 'line',
                            label: `Kasus ${label}`,
                            data: data,
                            borderColor: lineColor,
                            backgroundColor: lineColor,
                            fill: false,
                            tension: 0.4,
                            pointBackgroundColor: lineColor,
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            order: 0,
                            datalabels: {
                                display: true,
                                color: '#000',
                                anchor: 'end',
                                align: 'top',
                                font: {
                                    weight: 'bold',
                                    size: 11
                                },
                                formatter: (value) => value ? value.toLocaleString() : '0'
                            }
                        }
                    ];

                    new Chart(document.getElementById(canvasId).getContext('2d'), {
                        data: {
                            labels: labels,
                            datasets: datasets
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        usePointStyle: true,
                                        padding: 20
                                    }
                                },
                                tooltip: {
                                    callbacks: {
                                        label: (context) =>
                                            `${context.dataset.label}: ${context.parsed.y.toLocaleString()} kasus`
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    suggestedMax: maxVal,
                                    ticks: {
                                        callback: (value) => value.toLocaleString(),
                                        font: {
                                            size: 11
                                        }
                                    },
                                    grid: {
                                        color: '#f0f0f0'
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    },
                                    ticks: {
                                        font: {
                                            size: 11
                                        }
                                    }
                                }
                            }
                        },
                        plugins: [ChartDataLabels]
                    });
                };

                
                createSimpleChart(
                    'pengajuanRalanChart',
                    @json($monthlyData['pengajuanRalan']),
                    'Pengajuan Klaim Rawat Jalan',
                    'rgba(255, 193, 7, 0.8)',
                    '#dc3545'
                );

                
                createSimpleChart(
                    'pengajuanRanapChart',
                    @json($monthlyData['pengajuanRanap']),
                    'Pengajuan Klaim Rawat Inap',
                    '#007bff',
                    'rgba(220, 53, 69, 0.8)'
                );

            });
        </script>
    @endpush

    <style>
        .info-box {
            display: flex;
            align-items: center;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
        }

        .info-box:hover {
            transform: translateY(-2px);
        }

        .info-box-icon {
            font-size: 28px;
            margin-right: 15px;
            min-width: 50px;
            text-align: center;
            opacity: 0.8;
        }

        .info-box-content {
            flex: 1;
        }

        .info-box-text {
            font-size: 14px;
            margin-bottom: 5px;
            opacity: 0.9;
        }

        .info-box-number {
            font-size: 24px;
            font-weight: bold;
        }

        .card {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border: none;
            border-radius: 8px;
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .card-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 1px solid #dee2e6;
            border-radius: 8px 8px 0 0 !important;
        }

        #pengajuanRalanChart,
        #pengajuanRanapChart {
            min-height: 280px;
        }
    </style>
@endsection
