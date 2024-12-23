@section('title')
    Resources Workloads
@endsection
{{-- <div> --}}
    {{-- <div class="col-md-12 col-xl-12 col-sm-12"> --}}
        {{-- <div>
            <button id="previous">Previous</button>
            <span id="displayDate"></span>
            <button id="next">Next</button>
        </div> --}}
        {{-- <div class="card carc-switch-p3">
            <form id="form-filter"> --}}
                {{-- <div class="row">
                    <div class="col-md-6 mb-3">
                        <select id="form-select-day" class="form-select form-select-sm">
                            <option selected value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                        </select>
                    </div>

                    {{-- <div class="col-6 col-md-4 mb-3"> --}}
                        {{-- <input id="form-date" type="text" class="form-control form-control-sm datepicker" id="date-picker"> --}}
                    {{-- </div> --}}
                {{-- </div>  --}}


                {{-- <button class="btn btn-sm btn-success" type="submit" id="search-button">Search</button>
                <button class="btn btn-sm btn-outline-success" type="reset">Reset</button>
            </form>
            <canvas id="myChart" height="250px"></canvas>
        </div> --}}
    {{-- </div> --}}

    
{{-- </div> --}}
<div>
    <canvas id="myChart"></canvas>
</div>

@push('scripts')
    <script>
        //========================================GET PV , EV, SPI===========================================================================
        const pvDaily = @json($pvDaily);
        // const pvWeekly = @json($pvWeekly);
        // const pvMonthly = @json($pvMonthly);
        const evDailyArray = @json($evDailyArray);
        // const evWeeklyArray = @json($evWeeklyArray);
        const spiDailyArray = @json($spiDailyArray);

        const activityDate = @json($activityDate);


        document.addEventListener('livewire:init', () => {
            Livewire.on('get-pv-daily', (data) => {
                console.log(pvDaily);
            });
        });

        // document.addEventListener('livewire:init', () => {
        //     Livewire.on('get-pv-weekly', (data) => {
        //         console.log(pvWeekly);
        //     });
        // });

        // document.addEventListener('livewire:init', () => {
        //     Livewire.on('get-pv-monthly', (data) => {
        //         console.log(pvMonthly);
        //     });
        // });

        document.addEventListener('livewire:init', () => {
            Livewire.on('get-ev-daily', (data) => {
                console.log(evDailyArray);
            });
        });

        // document.addEventListener('livewire:init', () => {
        //     Livewire.on('get-ev-weekly', (evWeeklyArray) => {
        //     });
        // });

        document.addEventListener('livewire:init', () => {
            Livewire.on('get-spi-daily', (spiDailyArray) => {
                console.log(spiDailyArray);
            });
        });

        // document.addEventListener('livewire:init', () => {
        //     Livewire.on('get-ev-time', (activityDate) => {
        //         console.log($activityDate);
        //     });
        // });

        // COBA
    
        
        //========================================GET DATE IN MONTH FOR X(labels)==================================================================================

        const currentDate = new Date();
        const currentMonth = currentDate.getMonth();
        const currentYear = currentDate.getFullYear();

        const dateArray = []; //array tanggal untuk bulan tertentu

        for (let i = 0; i < 30; i++) {
            const newDate = new Date(currentDate);
            newDate.setDate(currentDate.getDate() + i);
            dateArray.push(newDate.toDateString());
        }

    //     get jumlah hari dalam bulan tertentu
    // const dayInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
    // for (let day = 1; day <= dayInMonth; day++) {
    //     const date =  new Date(currentYear, currentMonth, day); //membuat tanggal
    //     const formattedDate = date.toISOString().split('T')[0]; // YYYY-MM-DD
    //     dateArray.push(formattedDate); //tambah tangal ke array
    // }

    // membuat 'labels' untuk grafik berdasarkan 'evDailyArray'
    // const labels = [];

    // loop lewat 'evDailyArray' untuk menyesuaikan tanggal di labels
    // evDailyArray.foreach((ev, index) => {
    //     const labelDate =  new Date(dateArray[index]); // get date from 'dateArray'
    //     const formattedLabel = '${labelDate.getDate()}-${labelDate.getMonth() + 1}-${labelDate.getFullYear()}'; //format ke DD-MM-YYYY
    //     labels.push(formattedLabel); //tambahakan label ke array
    // });

        



        // // Buat tanggal awal di tanggal 1 bulan berjalan
        // const startDate = new Date(currentYear, currentMonth, 1);

        // // Mendapatkan jumlah hari dalam bulan berjalan
        // const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

        // // Array untuk menyimpan tanggal dari tanggal 1 hingga akhir bulan
        // const dailyArray = [];
        // const weeklyArray = [];
        // const monthlyArray = [];

        // // daily
        // for (let i = 0; i < daysInMonth; i++) {
        //     const newDate = new Date(startDate);
        //     newDate.setDate(startDate.getDate() + i);
        //     dailyArray.push(newDate.toDateString());
        // }

        // // weekly
        // let dayWeekly = new Date(currentYear, currentMonth, 1);

        // while (dayWeekly.getMonth() === currentMonth) {
        //     if (dayWeekly.getDay() === 1) {
        //         weeklyArray.push(new Date(dayWeekly));
        //     }
        //     dayWeekly.setDate(dayWeekly.getDate() + 1);
        // }
        

        // =======================================================KELOLA PV DAILY==============================================================================
       
       const pvData = [];

       for (let i = 0; i < dateArray.length; i++) {
        pvData.push(pvDaily);
       }
       
       console.log(pvData);

       const evData = [];

       for (let i = 0; i < evDailyArray.length; i++) {
        evData.push(evDailyArray[i]);
       }

       console.log(evData);
       
        // array for store value daily PV 
        // let pvData = [];
        // let arrayDatas = [];

        // // filter form
        // let day = "daily"
        // let formDate =""

        // const form = document.getElementById('form-filter').addEventListener("submit", (e)=> {
        //     e.preventDefault();

        //     day = document.getElementById('form-select-day').value;

        //     if (day == "daily") {
        //         const data = []
        //         // loop pvDaily for each date
        //         for (let i = 0; i < dailyArray.length; i++) {
        //             data.push(pvDaily);
        //         }
        //         pvData = data
        //         arrayDatas = dailyArray
        //         // console.log("pData: ", pvData, ", arrayData: ", arrayDatas)
        //         chart.update()
        //     } else if (day == "weekly") {
        //         const data = []
        //         for (let i = 0; i < weeklyArray.length; i++) {
        //             data.push(pvWeekly);
        //         }
        //         pvData = data
        //         arrayDatas.push(weeklyArray.map(date => date.toDateString()))
        //         console.log(pvData)
        //     } else if (day == "monthly") {
        //         console.log("monthly tanggal ", formDate)
        //     } else {
        //         console.error();
        //     }
        // })

        
        // =======================================================KELOLA PV DAILY==============================================================================

        const ctx = document.getElementById('myChart');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: dateArray,
                // labels: labels, //gunakan labels yang tah diformat
                datasets: [{
                        label: 'PV',
                        data: pvData,
                        borderWidth: 1
                    },
                    {
                        label: 'EV',
                        data: evData,
                        borderWidth: 1
                    },
                    {
                        label: 'SPI',
                        data: spiDailyArray,
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
 
    {{-- //     $(document).ready(function() {
    //         $('.datepicker').datepicker(); // Initialize date picker

    //         // Add click event listener to search button
    //         $('#search-button').click(function() {
    //             const selectedDate = $('#date-picker').val(); // Get the selected date
    //             // const selectedTimeFrame = $('#timeframe-select').val();

    //             // Assuming single date selection for now (modify if needed)
    //             // const startDate = selectedDate;
    //             // const endDate = selectedDate;

    //             // Implement functions for daily, weekly, and monthly data retrieval
    //             // let data;
    //             // if (selectedTimeframe === 'daily') {
    //             //     data = getDailyData(selectedDate); // Call function for daily data
    //             // } else if (selectedTimeframe === 'weekly') {
    //             //     data = getWeeklyData(selectedDate); // Call function for weekly data
    //             // } else {
    //             //     data = getMonthlyData(selectedDate); // Call function for monthly data
    //             // }

    //             // Update chart with retrieved data
    //             if (data) {
    //                 chart.data.labels = data.labels;
    //                 chart.data.datasets[0].data = data.pvData;
    //                 chart.data.datasets[1].data = data.evDailyArray;
    //                 chart.data.datasets[2].data = data.spiDailyArray;
    //                 chart.update();
    //             }
    //         });

    //         //     // Trigger existing function to fetch data and update chart
    //         //     fetch('/get-chart-data', {
    //         //       method: 'POST',
    //         //       data: {
    //         //         startDate: startDate,
    //         //         endDate: endDate
    //         //       }
    //         //     })
    //         //     .then(response => response.json())
    //         //     .then(data => {
    //         //       chart.data.labels = data.labels;
    //         //       chart.data.datasets[0].data = data.pvData;
    //         //       chart.data.datasets[1].data = data.evDailyArray;
    //         //       chart.data.datasets[2].data = data.spiDailyArray;
    //         //       chart.update();
    //         //     });
    //         //   });
    //     }); --}}
    // </script>
@endpush



{{-- // array to store daily PV value
// const pvArray = [];

// get first date and end date in month

// create an array of dates  and corresponding PV values
// const dateArray = [];
// const pvData = [];

// Iterate over each day of the month
// for (let date = firstDayOfMonth; date <= lastDayOfMonth; date.setDate(date.getDate() + 1)) {
//     const formattedDate = date.toISOString().split('T')[0];
//     dateArray.push(formattedDate);
//     pvData.push($pvDaily[formattedDate] || 0); // Handle missing PV values
// }

// loop $pvDaily for each day (of Month)
// for (let i = 0; i < dateArray.length; i++) {
//     const date
// }
// for (let date = firstDateOfMonth; date <= lastDateOfMonth; date.setDate(date.getDate() + 1)) {
//     const formatDate = date.toISOString().split('T')[0];
//     const pvForDaily = $pvDaily[formatDate];

    // push date to array
    // dateArray.push(formatDate);

// }
// console.log(dateArray); --}}

{{-- // const firstDateOfMonth = new Date(new Date().getFullYear(), new Date().getMonth(), 1);
        // const lastDateOfMonth = new Date(new Date().getFullYear(), new Date().getMonth(), + 1, 0);

        // function getDate(year, month) 
        // {
        //     const date = new Date.getMonth(year, month, 1);
        //     const dates = []; //store date after get month

            
        // } --}}

{{-- // for (let date = firstDateOfMonth; date < lastDateOfMonth; date.setDate(date.getDate() + 1)) {
            //     const dateString = date.toDateString(); //ubah tanggal jadi string
            //     const pvValue = pvDaily[dateString] || 0; //get nilai PV daily / 0 jika tidak ada data
    
            //     // store objek tanggal dan nilai PV ke dalm array
            //     pvArray.push(pv :pvValue);
            // }
            // console.log(pvArray); --}}

{{-- //    KODE BISA
       
            // CONFIG
            
            // new Chart(chart, {
            //     type: 'bar',
            //     // labels: labels,
            //     data: {
            //         datasets: [{
            //             label: '# of Votes',
            //             data: [{
            //                 x: '2021-11-06',
            //                 y: 500000
            //             }],
            //             borderWidth: 1,
            //         }]
            //     },
            //     options: {
            //         scales: {
            //             y: {
            //                 beginAtZero: true
            //             },
            //             x: {
            //                 type: 'time',
            //                 time: {
            //                     unit: 'day'
            //                 }
            //             }
            //         }
    
            //     }
            // });
            // RENDER THE CHART
            // const ctx = document.getElementById('myChart').getContext('2d');
            // new Chart(ctx, config); --}}

{{-- // for (let i = 0; i < dateArray.length; i++) {
                //     const dateString = dateArray[i].toISOString().split('T')[0]; // Format date for comparison
                //     const pvValue = pvDaily[dateString] || 0; // Get PV value or default to 0
                //     pvData.push(pvValue);
                //     console.log(pvValue); 
                // } --}}
{{-- // x: {
                    //     type: 'category',
                    //     tikcs: {
                    //         autoSkip: false, //nonaktif autoskip untuk memastikan semua label tampil
                    //         maxRotation: 90, //putar label jika terlalu rapat
                    //         minRotation: 45 //atur rotasi minimum menghindri tumpang tindi
                    //     }
                    // } --}}
{{-- <div class="col mb-3">
                    <input type="date" class="form-control form-control-sm">
                    {{-- <button class="btn btn-outline-success" type="button" id="button-addon1"></button> --}}
{{-- </div>  --}}
{{-- <input type="date" name="" id="" class="form-control"> --}}
