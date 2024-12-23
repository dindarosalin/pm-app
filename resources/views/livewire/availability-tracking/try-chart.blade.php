<div>
    {{-- <div class="container mt-4">
        <div class="row">
            <div class="col text-center">
                <button onclick="setDateRange('day')" class="btn btn-outline-success me-2">Daily</button>
                <button onclick="setDateRange('week')" class="btn btn-outline-success me-2">Weekly</button>
                <button onclick="setDateRange('month')" class="btn btn-outline-success me-2">Monthly</button>
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group mb-3">
                <span class="input-group-text">Start Date</span>
                <input type="date" id="startDate" class="form-control form-control-sm">
            </div>
        </div>
        <div class="col-md-6">
            <div class="input-group mb-3">
                <span class="input-group-text">End Date</span>
                <input type="date" id="endDate" class="form-control form-control-sm">
            </div>
        </div>

        <div class="col text-center">
            <button onclick="applyCostumDateRange()" class="btn btn-sm-success">Custom Date Range</button>
        </div>
    </div> --}}

    {{-- <div class="chartCard mt-4">
        <div class="chartBox">
            <canvas id="myChart"></canvas>
        </div>
    </div> --}}


    {{-- KODE ASLI --}} 
    <div class="chartCard">
        <div class="chartBox">
            <canvas id="myChart"></canvas>
                <button onclick="dateFilter('day')">Daily</button>
                <button onclick="dateFilter('week')">Weekly</button>
                <button onclick="dateFilter('month')">Monthly</button>
        </div>
    </div>
</div>

@push('scripts')
    
      <script>
    //   setup 
        const data = {
            // labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Weekly Sales',
                // data: [18, 12, 6, 9, 12, 3, 9],
                data: [
                    {x: new Date('2024-10-10T00:00:00'), y: 3},
                    {x: new Date('2024-10-27T00:00:00'), y: 5},
                    {x: new Date('2024-12-30T00:00:00'), y: 17},
                    {x: new Date('2024-12-15T00:00:00'), y: 26},
                    {x: new Date('2024-11-06T00:00:00'), y: 4},
                    {x: new Date('2024-11-10T00:00:00'), y: 8},
                    {x: new Date('2024-11-11T00:00:00'), y: 10},
                ],
                backgroundColor: [
                    'rgba(255, 26, 104, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(0, 0, 0, 0.2)'
                    ],
                    borderColor: [
                    'rgba(255, 26, 104, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(0, 0, 0, 1)'
                    ],
                    borderWidth: 1
            }]
        };

        // config 
            const config = {
                type: 'bar',
                data,
                options: {
                    scales: {
                        x: {
                            type: 'time',
                            time: {
                                unit: 'day'
                            },
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            };

        // render init block
        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );

        function dateFilter(time)
        {
            myChart.config.options.scales.x.time.unit = time;
            myChart.update();
        }
      </script>
        
@endpush
