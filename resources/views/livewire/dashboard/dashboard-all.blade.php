<div>
    @section('title')
        Dashboard
    @endsection


    <div class="col-lg-12 col-md-12 col-sm-12">
        {{-- Panel --}}
        <div class="row">
            <div class="col-md-2 col-xl-2">
                <div class="card">
                    <div class="text-center">
                        <h2 class="p-2">00</h2>
                        <p>Onsite</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-xl-2">
                <div class="card">
                    <div class="text-center">
                        <h2 class="p-2">00</h2>
                        <p>Work From Home</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-xl-2">
                <div class="card">
                    <div class="text-center">
                        <h2 class="p-2">00</h2>
                        <p>Project On Schedule</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-xl-2">
                <div class="card">
                    <div class="text-center">
                        <h2 class="p-2">00</h2>
                        <p>Project Delay</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-xl-2">
                <div class="card">
                    <div class="text-center">
                        <h2 class="p-2">00</h2>
                        <p>Total Resources</p>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <!-- Health -->
            <div class="col-md-12 col-xl-4 col-sm-12 ">
                <div class="card card-switch p-3 overflow-scroll" style="min-height: 40vh; max-height: 40vh;">
                    <h5>Health</h5>
                    <div class="row row-cols-3">

                        <!-- Label -->
                        <p>Project Name</p>
                        <p>CPI</p>
                        <p>SPI</p>
                        <!-- Label End -->

                        <!-- Project Health-->
                        @foreach($evmData as $data)
                        {{-- @dd($data['cpi']) --}}
                            <span>{{ $data['project_title'] }}</span>
                            <span class="{{ $data['cpi'] == 1 ? 'text-primary' : ($data['cpi'] > 1 ? 'text-success' : 'text-danger') }}">
                                <i class="bi bi-circle-fill" data-bs-toggle="tooltip" title="{{ $data['cpi'] == 1 ? 'Proyek sesuai anggaran' : ($data['cpi'] > 1 ? 'Di bawah rencana anggaran' : 'Biaya melebihi perencanaan') }}"></i>
                            </span>
                            <span class="{{ $data['spi'] == 1 ? 'text-primary' : ($data['spi'] > 1 ? 'text-success' : 'text-danger') }}">
                                <i class="bi bi-circle-fill" data-bs-toggle="tooltip" title="{{ $data['spi'] == 1 ? 'Proyek sesuai rencana' : ($data['spi'] > 1 ? 'Proyek lebih cepat' : 'Proyek terlambat') }}"></i>
                            </span>
                        @endforeach

                        <!-- Project Health End -->
                    </div>
                </div>
            </div>
            <!-- Health End -->

            {{-- Project --}}
            <div class="col-md-12 col-xl-4 col-sm-12">
                <div class="card card-switch p-3" style="min-height: 40vh; max-height: 40vh;">
                    <h5>Tasks</h5>
                    <div class="chart-container" style="position: relative; height:30vh;">
                        <canvas id="projectCharts" style="width: 100px; height: 100px;"></canvas>
                    </div>
                </div>
            </div>
            {{-- Project End --}}

            <!-- Progress -->
            <div class="col-xl-4 col-md-12 col-sm-12">
                <div class="card card-switch p-3" style="min-height: 40vh;">
                    <h5>Projects Progress</h5>
                    <div class="scroll overflow-y-scroll" style="max-height: 30vh">
                        <canvas id="projectProgress" style="height: auto"></canvas>

                    </div>
                </div>
            </div>
            <!-- End Progress -->

            <!-- Time -->
            <div class="col-md-12 col-xl-4 col-sm-12">
                <div class="card card-switch p-3" style="min-height: 40vh; max-height: 40vh;">
                    <h5>Time</h5>
                    <div class="scroll overflow-y-scroll" style="max-height: 100%">
                        <canvas id="timeChart" height="auto"></canvas>
                    </div>
                </div>
            </div>
            <!-- Time End -->

            <!-- Cost Chart -->
            <div class="col-xl-8 col-md-12 col-sm-12">
                <div class="card card-switch p-3" style="max-height: 40vh;">
                    <h5>Cost</h5>
                    <div class="scroll overflow-y-scroll" style="max-height: 100%">
                        <canvas id="costChart"></canvas>
                    </div>
                </div>
            </div>
            <!-- Cost Chart End -->

            <!-- Work Hours -->
            <div class="col-xl-12 col-md-12 col-sm-12">
                <div class="card card-switch p-3" style="max-height: 40vh;">
                    <h5>Work Hours/month</h5>
                    <div class="scroll overflow-y-scroll" style="max-height: 100%">
                        <canvas id="workHoursChart"></canvas>
                    </div>
                </div>
            </div>
            <!-- Work Hours End -->

        </div>
    </div>
</div>

@push('scripts')
    <script>
        // const projectDone = 1;
        // const projectInProgress = 2;
        // const projectNotStarted = 1;

        const project = document.getElementById('projectCharts');
        const projectChart = document.getElementById('projectProgress').getContext('2d');
        // const workload = document.getElementById('projectProgress').getContext('2d');
        const time = document.getElementById('timeChart');
        const costChart = document.getElementById('costChart').getContext('2d');
        const ctx = document.getElementById('workHoursChart').getContext('2d');

        new Chart(project, {
            type: 'doughnut',
            data: {
                labels: [
                    'Not Started',
                    'Complate',
                    'Inprogress'
                ],
                datasets: [{
                    label: 'Project',
                    data: [1, 2, 1],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(101, 205, 101)',
                        'rgb(255, 205, 86)',
                    ],
                    hoverOffset: 4
                }]
            },
            plugins: [ChartDataLabels],
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    datalabels: {
                        color: 'white', // Color of the labels
                        font: {
                            weight: 'bold', // Font weight
                            size: 12, // Font size
                        },
                        formatter: (value) => `${value}` // Formatter function for the label text
                    },

                },
                hover: {
                    mode: null,
                    intersect: true,
                },
            }
        });

        // Adjust font size dynamically
        function getFontSize() {
            return window.innerWidth < 600 ? 10 : 12;
        }

        // Project Progress
        new Chart(projectChart, {
            type: 'bar',
            data: {
                labels: @json($percentagesProgress->pluck('title')),
                datasets: [{
                    label: 'Progress (%)',
                    data: @json($percentagesProgress->pluck('completion')),
                    borderWidth: 1,
                    borderDash: [5, 5],
                    backgroundColor: ['#66bb6a', '#66bb6a', '#66bb6a', '#66bb6a']
                }]
            },
            options: {
                indexAxis: 'y',
                scales: {
                    x: {
                        ticks: {
                            beginAtZero: true,
                            max: 100,
                            font: {
                                size: getFontSize()
                            },
                        }
                    },

                },
                plugins: {
                    legend: {
                        display: false
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
                onResize: function(chart, size) {
                    chart.options.scales.y.ticks.maxTicksLimit = Math.floor(size.height / 20);
                }
            }
        });

        //Time
        new Chart(time, {
            type: 'bar',
            data: {
                labels: @json($percentagesProgress->pluck('title')),
                datasets: [{
                    label: 'Progress (%)',
                    // data: @json($percentagesProgress->pluck('completion')),
                    data: [-20, 57],
                    borderWidth: 1,
                    borderDash: [5, 5],
                    backgroundColor: ['#66bb6a', '#66bb6a', '#66bb6a', '#66bb6a']
                }]
            },
            options: {
                indexAxis: 'y',
                scales: {
                    x: {
                        ticks: {
                            beginAtZero: false,
                            max: 100,
                            font: {
                                size: getFontSize()
                            },
                        }
                    },

                },
                plugins: {
                    legend: {
                        display: false
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
                onResize: function(chart, size) {
                    chart.options.scales.y.ticks.maxTicksLimit = Math.floor(size.height / 20);
                }
            }
        });

        // Cost
        new Chart(costChart, {
            type: 'bar',
            data: {
                labels: ['Project A', 'Project B', 'Project C'],
                datasets: [{
                        label: 'Actual',
                        data: [1000000, 1500000, 1500000],
                        backgroundColor: '#FCD34D' // yellow-400
                    },
                    {
                        label: 'Planned',
                        data: [1900000, 1100000, 1100000],
                        backgroundColor: '#4ADE80' // green-400
                    },
                    {
                        label: 'Budget',
                        data: [2500000, 2000000, 1100000],
                        backgroundColor: '#FB7185' // rose-400
                    }
                ]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Cost'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                            }
                        }
                    }
                }
            }
        });

        // Work Hours per month
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Brandom', 'Jennifer', 'Mike'],
                datasets: [{
                        label: 'Work',
                        data: [4, 10, 10],
                        backgroundColor: '#FCD34D', // kuning
                        stack: 'Stack 0'
                    },
                    {
                        label: 'Target',
                        data: [12, 6, 6],
                        backgroundColor: '#FB7185', // merah muda
                        stack: 'Stack 0'
                    }
                ]
            },
            options: {
                indexAxis: 'y', // horizontal
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false,
                        text: 'Work Hours/month'
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jam Kerja'
                        }
                    },
                    y: {
                        stacked: true
                    }
                }
            }
        });
    </script>
@endpush
