<!--CONTENT-->
<div>
    <div class="card table-responsive">
        <table id="project-table" class="table table-striped table-hover table-sm" style="width:100%">
            <thead class="text-success fw-medium">
                <tr>
                    <th class="fw-medium text-center">No</th>
                        <th class="fw-medium text-center">Project List</th>
                        <th class="fw-medium text-center">Time Estimation</th>
                        <th class="fw-medium text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($projects as $item)
                <tr>
                    <td class="text-center">{{$item->id}}</td>
                    <td class="text-center">{{$item->title}}</td>
                    <td class="text-center">{{$item->due_date_estimation}}</td>
                    <td class="d-flex gap-1 justify-content-center">
                        <button class="btn btn-primary btn-sm" wire:navigate href="/budget/plan">Budget Plan</button>
                        <button class="btn btn-primary btn-sm" wire:navigate href="/budget/track">Expense Track</button>
                        <button class="btn btn-primary btn-sm">Invoice</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


@push('scripts')
    <script>
        $('#project-table').DataTable({
            "aoColumnDefs": [
                {
                    'bSortable': false,
                    'aTargets': [1]
                },
                {
                    'bSortable': false,
                    'aTargets': [3]
                },
                { width: '20%', targets: 2 },
                // { width: '6%', targets: 8 },
                // { width: '10%', targets: 3 },               
            ],
            initComplete: function() {
                this.api()
                    .columns([3, 4, 8])
                    .every(function() {
                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function(d, j) {
                                select.append(
                                    '<option value="' + d + '">' + d + '</option>'
                                );
                            });
                    });
            }
        });
    </script>
@endpush



            {{-- <tbody>
                @foreach ($budgets as $budget)
                    <tr>
                        <td>{{ $loop->iteration }}</td> <!-- urut no baris-->
                        <td>
                            @if ($budget->title)
                                @php
                                    $titles = json_decode($budget->title, true); // Dekode JSON menjadi array --}}
                                {{-- @endphp
                                @if (is_array($titles))
                                    {{ implode(', ', $titles) }} <!-- Gabungkan array menjadi string -->
                                @else
                                    {{ $budget->title }} <!-- Tampilkan langsung jika tidak dalam format array --> --}}
                                {{-- @endif
                            @else --}}
                                {{-- Tidak ada data
                            @endif
                        </td>
                        <td>
                            @if ($budget->due_date_estimation)
                                @php
                                    $dueDates = json_decode($budget->due_date_estimation, true); // Dekode JSON menjadi array
                                @endphp
                                @if (is_array($dueDates))
                                    {{ implode(', ', $dueDates) }} <!-- Gabungkan array menjadi string -->
                                @else
                                    {{ $budget->due_date_estimation }} <!-- Tampilkan langsung jika tidak dalam format array -->
                                @endif
                            @else
                                Tidak ada data --}}
                            {{-- @endif
                        </td>
                        <td class="d-flex gap-1 justify-content-center">
                            <button wire:click="budget-plan({{ $budget['id'] }})" class="btn btn-primary btn-sm" wire:navigate href="/budget/plan">Budget Plan</button>
                            <button wire:click="expense-track({{ $budget['id'] }})" class="btn btn-primary btn-sm">Expense Track</button>
                            <button wire:click="invoice({{ $budget['id'] }})" class="btn btn-primary btn-sm">Invoice</button>
                        </td> --}}


                        {{-- <td class="text-center">{{ $budget['id'] }}</td>
                            <td class="text-center">{{ $budget['project'] }}</td>
                            <td class="text-center">{{ $budget['time_estimation'] }}</td>
                            <td class="d-flex gap-1 justify-content-center">
                                <button wire:click="budget-plan({{ $budget['id'] }})" class="btn btn-primary btn-sm" wire:navigate href="/budget/plan">Budget Plan</button>
                                <button wire:click="expense-track({{ $budget['id'] }})" class="btn btn-primary btn-sm">Expense Track</button>
                                <button wire:click="invoice({{ $budget['id'] }})" class="btn btn-primary btn-sm">Invoice</button>
                            </td>
                        </td> --}}
                    {{-- </tr>
                @endforeach
            </tbody> --}}
            

        



                {{-- // {
                //     'bSortable': false,
                //     'aTargets': [4]
                // },
                // {
                //     'bSortable': false,
                //     'aTargets': [7]
                // },
                // {
                //     'bSortable': false,
                //     'aTargets': [8]
                // },
                // {
                //     'bSortable': false,
                //     'aTargets': [9]
                // },
                
                        // var column = this;
                        // Create select element and listener
                        // var headName = $(column.header()).text().trim();
                        // var select = $(
                        //         '<select class="form-select form-select-sm fw-medium"><option value="">' +
                        //         headName + '</option></select>'
                        //     )
                        //     .appendTo($(column.header()).empty())
                        //     .on('change', function() {
                        //         column
                        //             .search($(this).val(), {
                        //                 exact: true
                        //             })
                        //             .draw();
                        //     });

                        // Add list of options --}}
                        





{{-- <div class="main-content">
        <div class="col-lg-12 col-md-12 col-sm-12">

            <!--DataTables (filter dan search)-->
            <table id="tabel-data" class="table table-striped table-bordered text-center --bs-table-bg" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Project List</th>
                        <th>Estimation Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Nusapala Parking</td>
                        <td>23 juni 2024 - 15 Januari 2024</td>
                        <td>
                            <button class="btn btn-info btn-sm" wire:navigate href="/budget/plan">Budget Plan</button>
                            <button class="btn btn-info btn-sm">Expense track</button>
                            <button class="btn btn-info btn-sm">Invoicing</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Nusapala Autobotics</td>
                        <td>23 juni 2024 - 15 Januari 2024</td>
                        <td>
                            <button class="btn btn-info btn-sm">Budget Plan</button>
                            <button class="btn btn-info btn-sm">Expense track</button>
                            <button class="btn btn-info btn-sm">Invoicing</button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Diponegoro Ticket</td>
                        <td>23 juni 2024 - 15 Januari 2024</td>
                        <td>
                            <button class="btn btn-info btn-sm">Budget Plan</button>
                            <button class="btn btn-info btn-sm">Expense track</button>
                            <button class="btn btn-info btn-sm">Invoicing</button>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Project D</td>
                        <td>23 juni 2024 - 19 Januari 2024</td>
                        <td>
                            <button class="btn btn-info btn-sm">Budget Plan</button>
                            <button class="btn btn-info btn-sm">Expense track</button>
                            <button class="btn btn-info btn-sm">Invoicing</button>
                        </td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Project E</td>
                        <td>23 Februari 2024 - 15 Desember 2024</td>
                        <td>
                            <button class="btn btn-info btn-sm">Budget Plan</button>
                            <button class="btn btn-info btn-sm">Expense track</button>
                            <button class="btn btn-info btn-sm">Invoicing</button>
                        </td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>Project F</td>
                        <td>23 juni 2024 - 15 Januari 2024</td>
                        <td>
                            <button class="btn btn-info btn-sm">Budget Plan</button>
                            <button class="btn btn-info btn-sm">Expense track</button>
                            <button class="btn btn-info btn-sm">Invoicing</button>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div> --}}

    <!--DataTables jQuery-->
{{-- <script src="https://code.jquery.com/jquery-3.1.0.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

<!--DataTables JS-->
<script src="{{ asset('js/budget/budget.js') }}"></script>
{{-- <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script> --}}

<!--DataTables CSS-->
{{-- <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" /> --}}
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" /> --}} 

{{-- <div class="d-flex justify-end">
        <button class="btn btn-primary btn-sm btn-success mb-3" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
        
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightlabel">
            <div class="offcanvas-header">
                <h5 id="offcanvasRightLabel">Offcanvas right</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <div class="offcanvas-body"></div>
        </div>

        <div class="card table-responsive">
            <table id="project-table" class="table table-striped table-hover table-sm" style="width: 100%">
                <thead class="text-success fw-medium">
                    <tr>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($budgets as $budget)
                        <tr>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </button>
    </div> --}}
    
{{-- </div> --}}