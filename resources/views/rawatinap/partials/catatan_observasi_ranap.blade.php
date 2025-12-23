<div class="accordion" id="accordionObservasiRanap">
    <div class="card shadow-sm">
        <div class="card-header py-2 px-3" id="headingObservasiRanap">
            <h5 class="mb-0" style="font-size: 1rem;">
                <button class="btn btn-link w-100 text-left text-dark" type="button" data-toggle="collapse"
                    data-target="#collapseObservasiRanap" aria-expanded="false" aria-controls="collapseObservasiRanap">
                    <strong>Catatan Observasi Ranap</strong>
                    <i class="fas fa-chevron-down ml-2 rotate-icon"></i>
                </button>
            </h5>
        </div>

        <div id="collapseObservasiRanap" class="collapse" aria-labelledby="headingObservasiRanap"
            data-parent="#accordionObservasiRanap">
            <div class="card-body p-2">
                @if ($catatanObservasiRanap && count($catatanObservasiRanap) > 0)
                <div class="mb-3" style="max-width: 100%; height: 280px;">
                    <h6 class="fw-bold mb-2 text-center">Grafik Observasi Ranap</h6>

                    <div style="position: relative; height: 230px;">
                        <canvas id="grafikObservasiRanap"></canvas>
                    </div>
                </div>

                @php
                $labels = [];
                $gcs = [];
                $tdSistolik = [];
                $tdDiastolik = [];
                $hr = [];
                $rr = [];
                $suhu = [];
                $spo2 = [];

                foreach ($catatanObservasiRanap as $obs) {
                $labels[] = \Carbon\Carbon::parse($obs->tgl_perawatan . ' ' . $obs->jam_rawat)->format('d M H:i');
                $gcs[] = (int) $obs->gcs;

                if (strpos($obs->td, '/') !== false) {
                [$sis, $dias] = explode('/', $obs->td);
                $tdSistolik[] = (int) trim($sis);
                $tdDiastolik[] = (int) trim($dias);
                } else {
                $tdSistolik[] = null;
                $tdDiastolik[] = null;
                }

                $hr[] = (int) $obs->hr;
                $rr[] = (int) $obs->rr;
                $suhu[] = (float) str_replace(',', '.', $obs->suhu);
                $spo2[] = (int) $obs->spo2;
                }
                @endphp

                <script>
                    document.addEventListener("DOMContentLoaded", function () {

            var ctx = document.getElementById('grafikObservasiRanap').getContext('2d');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($labels),
                    datasets: [
                        {
                            label: 'TD Sistolik',
                            data: @json($tdSistolik),
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 2,
                            fill: false
                        },
                        {
                            label: 'TD Diastolik',
                            data: @json($tdDiastolik),
                            borderColor: 'rgba(255, 99, 132, .4)',
                            borderWidth: 2,
                            fill: false
                        },
                        {
                            label: 'HR',
                            data: @json($hr),
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 2,
                            fill: false
                        },
                        {
                            label: 'RR',
                            data: @json($rr),
                            borderColor: 'rgba(255, 159, 64, 1)',
                            borderWidth: 2,
                            fill: false
                        },
                        {
                            label: 'Suhu',
                            data: @json($suhu),
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 2,
                            fill: false,
                            yAxisID: 'y2'
                        },
                        {
                            label: 'SpO2',
                            data: @json($spo2),
                            borderColor: 'rgba(153, 102, 255, 1)',
                            borderWidth: 2,
                            fill: false
                        },
                        {
                            label: 'GCS',
                            data: @json($gcs),
                            borderColor: 'rgba(100, 100, 100, 1)',
                            borderWidth: 2,
                            fill: false
                        }
                    ]
                },

                options: {
                    responsive: true,
                    maintainAspectRatio: false,

                    interaction: { mode: 'nearest', intersect: false },

                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 10,
                                font: { size: 10 }
                            }
                        },
                        tooltip: {
                            bodyFont: { size: 10 },
                            titleFont: { size: 11 }
                        }
                    },

                    elements: {
                        line: { tension: 0.3 },
                        point: { radius: 2 }
                    },

                    scales: {
                        y: {
                            beginAtZero: false
                        },
                        y2: {
                            position: 'right',
                            grid: { drawOnChartArea: false },
                            beginAtZero: false
                        }
                    }
                }
            });

        });
                </script>

                @endif


                @if ($catatanObservasiRanap && count($catatanObservasiRanap) > 0)

                @php
                $customLabels = [
                'td' => 'Tekanan Darah',
                'nadi' => 'Nadi',
                'spo2' => 'Saturasi Oksigen',
                'kesadaran' => 'Kesadaran',
                'pernafasan' => 'Pernafasan',
                'suhu' => 'Suhu',

                ];
                $hiddenFields = ['no_rawat', 'kd_dokter'];
                @endphp

                

                @else
                <div class="alert alert-info m-0">
                    <i class="fas fa-info-circle"></i> Belum ada catatan observasi Ranap untuk pasien ini.
                </div>
                @endif
            </div>
        </div>
    </div>
</div>