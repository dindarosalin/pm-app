@section('title', 'Dashboard')
<div>

    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="row">
            <div class="card card-title">
                <h5>Dashboard Project</h5>
            </div>
            <!-- Detail Project -->
            <div class="col-md-12 col-xl-12 col-sm-12">
                <div class="card carc-switch p-3">
                    <div class="col-sm-12 col-xl-6 mb-3">
                        <h5>{{ $project->title }}</h5>
                        <span class="text-body-tertiary">{{ $project->description }}</span>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <table>
                                <tbody>
                                    {{-- <tr>
                                        <td class="align-top">Completion</td>
                                        <td class="align-top"> : </td>
                                        <td class="fw-semibold align-top">{{ $project->completion }}%</td>
                                    </tr> --}}
                                    <tr>
                                        <td class="align-top">Client</td>
                                        <td class="align-top"> : </td>
                                        <td class="align-top">{{ $project->client }}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top">Project manager</td>
                                        <td class="align-top"> : </td>
                                        <td class="align-top">{{ $project->pm_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top">Teams</td>
                                        <td class="align-top">:</td>
                                        <td class="align-top">{{ $project->team_names }}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top">Budget</td>
                                        <td class="align-top">:</td>
                                        <td class="align-top">Rp.{{ number_format($project->budget, 2, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-6">
                            <table>
                                <tr>
                                    <td>Created</td>
                                    <td> : </td>
                                    <td>{{ $project->created_at }}</td>
                                </tr>
                                <tr>
                                    <td>Start</td>
                                    <td> : </td>
                                    <td>{{ $project->start_date }}</td>
                                </tr>
                                <tr>
                                    <td>Due date</td>
                                    <td> : </td>
                                    <td>{{ $project->due_date_estimation }}</td>
                                </tr>
                                <tr>
                                    <td>Total Task</td>
                                    <td> : </td>
                                    <td>{{ $totalTasks }}</td>
                                </tr>

                            </table>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Health -->
            <div class="col-md-12 col-xl-4 col-sm-12 ">
                <div class="card card-switch p-3 overflow-y-scroll" style="min-height: 60vh; max-height: 50vh;">
                    <h5>Health</h5>
                    <div class="row row-cols-2">


                        <!-- Workload -->
                        <p>Task over due</p>
                        <p>{{ $taskOver }}</p>
                        <!-- Workload End -->

                        <!-- Progress -->
                        <p>Progress (Earned Value)</p>
                        <p>{{ $ev }}%</p>
                        <!-- Progress End -->

                        <!-- Earned Value -->
                        {{-- <p>Earned Value</p>
                        <p>{{ $ev }}%</p> --}}
                        <!-- Cost End -->

                        <!-- Planned Value -->
                        <p>Planned Value</p>
                        <p>{{ round($pv, 2) }}%</p>
                        <!-- Cost End -->

                        <!-- Actual Cost -->
                        <p>Actual Cost</p>
                        <p>Rp{{ number_format($ac) }}</p>
                        <!-- Cost End -->

                        <!-- Time -->
                        <p>Schedule performance index (SPI)</p>
                        <p>{{ $spiMessage }}</p>
                        <!-- Time End -->

                        <!-- Cost -->
                        <p>Cost performance index (CPI)</p>
                        <p>{{ $cpiMessage }}</p>
                        <!-- Cost End -->

                        <!-- Budget -->
                        {{-- <p>Budget Planned</p>
                        <p>Rp. {{ number_format($ev) }}</p> --}}
                        <!-- Budget End -->

                    </div>
                </div>
            </div>
            <!-- Health End -->

            <!-- Tasks -->
            <div class="col-md-12 col-xl-4 col-sm-12">
                <div class="card card-switch p-3" style="min-height: 60vh; max-height: 50vh;">
                    <h5>Tasks</h5>
                    <div class="chart-container" style="position: relative; height:50vh;">
                        <canvas id="tasksChart" style="width: 150px; height: 150px;"></canvas>
                    </div>
                </div>
            </div>
            <!-- Tasks End -->

            <!-- Cost -->
            <div class="col-md-12 col-xl-4 col-sm-12">
                <div class="card card-switch p-3" style="min-height: 60vh; max-height: 50vh;">
                    <h5>Cost</h5>
                    <canvas id="costChart" height="250px"></canvas>
                </div>
            </div>
            <!-- Cost End -->

            <!-- Time -->
            <div class="col-md-12 col-xl-4 col-sm-12">
                <div class="card card-switch p-3" style="min-height: 40vh;">
                    <h5>Time</h5>
                    <canvas id="timeChart"></canvas>
                </div>
            </div>
            <!-- Time End -->

            <!-- Progress -->
            {{-- @dd($percentagesProgress) --}}
            <div class="col-md-8 col-xl-8 col-sm-12">
                <div class="card card-switch p-3" style="min-height: 40vh;">
                    <h5>Progress</h5>
                    <div class="scroll overflow-y-scroll" style="max-height: 30vh">
                        @foreach ($percentagesProgress as $categoryName => $percentage)
                            <div class="row">
                                <!-- Analysis -->
                                <div class="col-md-3 col-sm-3 mt-2">
                                    <label>{{ $categoryName }}</label>
                                </div>
                                <div class="col-md-8 col-sm-8 mt-2">
                                    <div class="progress" role="analysis" aria-label="{{ $categoryName }}"
                                        aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar" style="width: {{ $percentage }}%">
                                            {{ $percentage }}%
                                        </div>
                                        {{-- @dd($percentagesProgress) --}}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- Progress End -->

            <!-- Workload -->
            <div class="col-md-12 col-xl-12 col-sm-12">
                <div class="card card-switch p-3">
                    <h5>Workload</h5>
                    <div id="chartContainer">
                        <div class="chart-container">
                            <canvas id="workloadChart" height="auto"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Workload -->
        </div>
    </div>
</div>

@push('scripts')
    {{-- chart --}}
    <script>
        // import ChartDataLabels from 'chartjs-plugin-datalabels';
        // =============== TASKS DATA ===============
        const taskDone = {{ $tasksDone }};
        const tasksInProgress = {{ $tasksInProgress }};
        const tasksNotStarted = {{ $tasksNotStarted }};

        // =============== COST DATA ===============
        const actual = {{ $actualBudget }};
        const planned = {{ $plannedBudget }};
        const budget = {{ $budget }};
        const plannedValue = {{ $plannedValue }};
        const totalTask = {{ $totalTasks }};

        const task = document.getElementById('tasksChart');
        const cost = document.getElementById('costChart');
        const time = document.getElementById('timeChart');



        // Set the canvas size (adjust the values as needed)

        new Chart(task, {
            type: 'doughnut',
            data: {
                labels: [
                    'Not Started',
                    'Complate',
                    'Inprogress'
                ],
                datasets: [{
                    label: 'Tasks',
                    data: [tasksNotStarted, taskDone, tasksInProgress],
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

        //Cost
        new Chart(cost, {
            type: 'bar',
            data: {
                labels: ['Budget Project', 'Planed Value', 'Budget Plan', 'Actual Cost'],
                datasets: [{
                    // label: 'Nama Project',
                    data: [budget, plannedValue, planned, actual],
                    borderWidth: 1,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                    ],
                }]
            },

            options: {
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR'
                                    }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                layout: {
                    padding: 0
                },
                scales: {
                    y: {
                        beginAtZero: true
                    },

                },


            }
        });

        //Time
        new Chart(time, {
            type: 'bar',
            data: {
                labels: " ",
                datasets: [{
                        label: ['Planned'],
                        data: [{{ round($pv, 2) }}],
                    },
                    {
                        label: ['Actual'],
                        data: [{{ round($ev, 2) }}],
                    },
                    {
                        label: ['Ahead'],
                        data: [{{ round($timeAhead, 2) }}],
                    }
                ],
                borderWidth: 1,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                ],
            },
            options: {
                indexAxis: 'y',
                elements: {
                    bar: {
                        borderWidth: 1,
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                label += context.parsed.x + '%'; // Tambahkan simbol persen di belakang nilai
                                return label;
                            }
                        }
                    },
                },
            },
        });


        //Workload
        const workload = document.getElementById('workloadChart').getContext('2d');

        // Determine bar thickness based on screen width
        function getBarThickness() {
            return window.innerWidth < 600 ? 10 : 20;
        }

        // Adjust the aspect ratio based on screen width
        function getAspectRatio() {
            return window.innerWidth < 600 ? 1 : 1.5;
        }

        // Adjust font size dynamically
        function getFontSize() {
            return window.innerWidth < 600 ? 10 : 12;
        }

        // Enable scrolling for y-axis
        function getYScaleOptions() {
            return {
                stacked: true,
                categoryPercentage: 0.8, // Adjust spacing between groups
                barPercentage: 0.9, // Adjust spacing between bars in a group
                ticks: {
                    font: {
                        size: getFontSize() // Dynamic font size
                    }
                }
            };
        }

        // Create the chart workload
        document.addEventListener('DOMContentLoaded', function() {
            const taskCounts = @json($workload);

            const labels = [];
            const doneData = [];
            const remainingData = [];
            const overdueData = [];
            const doneLateData = [];

            taskCounts.forEach(user => {
                labels.push(user.user_name);
                doneData.push(user.statuses.done || 0);
                remainingData.push(user.statuses.remaining || 0);
                overdueData.push(user.statuses.overdue || 0);
                doneLateData.push(user.statuses.done_late || 0);
            });

            const chart = new Chart(workload, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Completed',
                            data: doneData,
                            backgroundColor: 'rgba(75, 192, 192, 0.7)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                            borderDash: [5, 5],
                            // barThickness: getBarThickness(), // Dynamic bar thickness
                            // maxBarThickness: 50 // Set a maximum bar thickness
                        },
                        {
                            label: 'Remaining',
                            data: remainingData,
                            backgroundColor: 'rgba(255, 205, 86, 0.7)',
                            borderColor: 'rgba(255, 205, 86, 1)',
                            borderWidth: 1,
                            borderDash: [5, 5],
                            // barThickness: getBarThickness(),
                            // maxBarThickness: 50
                        },
                        {
                            label: 'Overdue',
                            data: overdueData,
                            backgroundColor: 'rgba(255, 99, 132, 0.7)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                            borderDash: [5, 5],
                            // barThickness: getBarThickness(),
                            // maxBarThickness: 50
                        },
                        {
                            label: 'Done late',
                            data: doneLateData,
                            backgroundColor: 'rgba(251, 133, 0, 0.7)',
                            borderColor: 'rgba(251, 133, 0, 1)',
                            borderWidth: 1,
                            borderDash: [5, 5],
                            // barThickness: getBarThickness(),
                            // maxBarThickness: 50
                        }
                    ],

                },
                options: {
                    indexAxis: 'y',
                    // responsive: true,
                    maintainAspectRatio: false,
                    // aspectRatio: getAspectRatio(), // Dynamic aspect ratio
                    elements: {
                        bar: {
                            borderWidth: 1,
                        }
                    },
                    scales: {
                        x: {
                            stacked: true,
                            // beginAtZero: true,
                            max: totalTask,
                            ticks: {
                                font: {
                                    size: getFontSize() // Dynamic font size
                                }
                            }
                        },
                        y: getYScaleOptions(), // Dynamic y-axis options
                    },
                    plugins: {
                        legend: {
                            labels: {
                                font: {
                                    size: getFontSize() // Dynamic legend font size
                                }
                            }
                        }
                    }
                }
            });
        });

        // Update chart when the window is resized
        window.addEventListener('resize', () => {
            chart.options.aspectRatio = getAspectRatio();
            chart.options.scales.y = getYScaleOptions();
            chart.options.scales.x.ticks.font.size = getFontSize();
            chart.options.plugins.legend.labels.font.size = getFontSize();
            chart.data.datasets.forEach((dataset) => {
                dataset.barThickness = getBarThickness();
            });
            chart.update();
        });
    </script>
@endpush
