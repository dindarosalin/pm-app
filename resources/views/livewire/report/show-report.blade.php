<div>
    @section('title')
        Report
    @endsection
    <div class="d-flex justify-content-end">
        <button class="btn btn-primary btn-sm btn-success mb-3" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Filter</button>
    </div>

    {{-- Offcanvas --}}

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasRightLabel">Filter</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            {{-- Show data --}}
            Show data:
            <div class="form-check">
                {{-- <input type="checkbox" class="toggle-vis form-check-input" id="0" data-column="0" checked>
                <label class="form-check-label" id="0"> Nama Projek</label> --}}


                <div class="">

                    <div class="form-check m-2">
                        <input class="form-check-input toggle-vis" type="checkbox" data-column="0" id="0"
                            checked>
                        <label class="form-check-label" for="0">
                            Nama Projek
                        </label>
                    </div>
                    <div class="form-check m-2">
                        <input class="form-check-input toggle-vis" type="checkbox" data-column="1" id="1"
                            checked>
                        <label class="form-check-label" for="1">
                            Status Projek
                        </label>
                    </div>
                    <div class="form-check m-2">
                        <input class="form-check-input toggle-vis" type="checkbox" data-column="2" id="2"
                            checked>
                        <label class="form-check-label" for="2">
                            Task
                        </label>
                    </div>
                    <div class="form-check m-2">
                        <input class="form-check-input toggle-vis" type="checkbox" data-column="3" id="3"
                            checked>
                        <label class="form-check-label" for="3">
                            Status Task
                        </label>
                    </div>
                    <div class="form-check m-2">
                        <input class="form-check-input toggle-vis" type="checkbox" data-column="4" id="4"
                            checked>
                        <label class="form-check-label" for="4">
                            Assign To
                        </label>
                    </div>
                    <div class="form-check m-2">
                        <input class="form-check-input toggle-vis" type="checkbox" data-column="5" id="5"
                            checked>
                        <label class="form-check-label" for="5">
                            Due Date
                        </label>
                    </div>
                </div>
            </div>

            {{-- Filter Status Projek --}}
            <div>
                {{-- <label for="status-filter-projek">Filter by Status Projek:</label>
                <select id="status-filter-projek">
                    <option value="">All</option>
                    <option value="On Progress">On Progress</option>
                    <option value="Delay">Delay</option>
                    <option value="On Track">On Track</option>
                </select> --}}

                <div id="filters">
                    {{-- Range date --}}
                    <div class="mb-3">
                        <label for="min-date" class="form-label">From Date:</label>
                        <input type="text" id="min-date" class="form-control datepicker" placeholder="yyyy-mm-dd">
                    </div>
                    <div class="mb-3">
                        <label for="max-date" class="form-label">To Date:</label>
                        <input type="text" id="max-date" class="form-control datepicker" placeholder="yyyy-mm-dd">
                    </div>
                    {{-- End Range date --}}
                    <div class="mb-3">
                        <select id="filter1" class="form-select col-3">
                            <option value="">Nama Project</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <select id="filter2" class="form-select col-3">
                            <option value="">Status Projek</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <select id="filter3" class="form-select col-3">
                            <option value="">Task</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <select id="filter4" class="form-select col-3">
                            <option value="">Status task</option> Task
                        </select>
                    </div>
                    <div class="mb-3">
                        <select id="filter5" class="form-select col-3">
                            <option value="">Assign to</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <select id="filter6" class="form-select col-3">
                            <option value="">Due date</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        {{-- End Show data --}}
    </div>

    <div class="card card-switch">
        <div>
            <table id="report-table" class="table table-striped table-hover table-sm" style="width:100%">
                <thead class="text-success">
                    <tr>
                        <th rowspan="1">Project Name</th>
                        {{-- <th rowspan="1">Project Completion</th> --}}
                        <th rowspan="1">Task Name</th>
                        <th rowspan="1">Status Task</th>
                        <th rowspan="1">Assign To</th>
                        <th rowspan="1">Due Date</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @dd($reports) --}}
                    @foreach ($reports as $report)
                        <tr>
                            {{-- {{ dd($reports) }} --}}
                            <td>{{ $report->project_title}}</td>
                            {{-- <td>{{ $report->completion }}</td> --}}
                            <td>{{ $report->title }}</td>
                            <td>{{ $report->task_status }}</td>
                            <td>{{ $report->user_name}}</td>
                            <td>{{ $report->end_date_estimation }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
    <script></script>

    <script>
        var table = $('#report-table').DataTable({
            dom: 'Bfrltip',
            paging: true,
            scrollX: true,

            // Individual column searching (select inputs)
            initComplete: function() {
                var api = this.api();

                // Iterate over each column
                api.columns().every(function(i) {
                    var column = this;
                    var filter = $('#filter' + (i + 1));

                    // Populate filter options
                    column.data().unique().sort().each(function(d, j) {
                        filter.append('<option value="' + d + '">' + d + '</option>');
                    });

                    // Handle filter change
                    filter.on('change', function() {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        column.search(val ? '^' + val + '$' : '', true, false).draw();
                    });
                });
            }
        });

        // Custom search for date range filter
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var min = $('#min-date').datepicker("getDate");
                var max = $('#max-date').datepicker("getDate");
                var date = new Date(data[5]); // Assuming the date is in the first column

                if (
                    (min === null && max === null) ||
                    (min === null && date <= max) ||
                    (min <= date && max === null) ||
                    (min <= date && date <= max)
                ) {
                    return true;
                }
                return false;
            }
        );

        // Initialize datepickers and handle date change
        $('.datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        });

        $('#min-date, #max-date').change(function() {
            table.draw();
        });


        $('input.toggle-vis').on('change', function(e) {
            // Get the column API object
            var column = table.column($(this).attr('data-column'));

            // Toggle the visibility
            column.visible(!column.visible());
        });

        //Filter Status
        $('#status-filter-projek').on('change', function() {
            var selectedStatus = $(this).val();
            table.column(1).search(selectedStatus)
                .draw(); // Assuming the status column is the 2nd column (index 1)
        });
    </script>
@endpush
