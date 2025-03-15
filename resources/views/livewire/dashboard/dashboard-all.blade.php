<div>
    @section('title')
        Dashboard
    @endsection


    <div class="col-lg-12 col-md-12 col-sm-12">
        {{-- Panel --}}
        <div class="d-sm-none d-md-inline row">
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
                        <p>Cost</p>
                        <p>Performance</p>
                        <!-- Label End -->

                        <!-- Project Health-->
                        <span>Asta project</span>
                        <span class="text-success">
                            <i class="bi bi-circle-fill" data-bs-toggle="tooltip" title="Under Budget"></i>
                        </span>
                        <span class="text-warning">
                            <i class="bi bi-circle-fill" data-bs-toggle="tooltip" title="On Schedule"></i>
                        </span>

                        <span>Asta flet</span>
                        <span class="text-danger">
                            <i class="bi bi-circle-fill" data-bs-toggle="tooltip" title="Over Budget"></i>
                        </span>
                        <span class="text-danger">
                            <i class="bi bi-circle-fill" data-bs-toggle="tooltip" title="Overdue"></i>
                        </span>

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
                        @foreach ($percentagesProgress as $projectName)
                            <div class="row">
                                <!-- Analysis -->
                                <div class="col-md-3 col-sm-3 mt-2">
                                    <label>{{ $projectName->title }}</label>
                                </div>
                                <div class="col-md-8 col-sm-8 mt-2">
                                    <div class="progress" role="analysis" aria-label="{{ $projectName->title }}"
                                        aria-valuenow="{{ $projectName->completion }}" aria-valuemin="0"
                                        aria-valuemax="100">
                                        <div class="progress-bar" style="width: {{ $projectName->completion }}%">
                                            {{ $projectName->completion }}%
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- Progress End -->
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
                            font:{
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

        
    </script>
@endpush
