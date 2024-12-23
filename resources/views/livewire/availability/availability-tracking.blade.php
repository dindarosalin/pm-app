<div>
    @section('title')
        Resources Track
    @endsection

    {{-- OFF CANVAS FOR PERFORMA --}}
    <div class="offcanvas offcanvas-end w-50" tabindex="-1" id="viewPerforma" aria-labelledby="viewPerformaLabel">
        <div class="offcanvas-header">
            <h5 id="viewPerformaLabel">View Performa Karyawan</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">

            <ul class="list-group list-group-flush">
                <li class="list-group-item">Planed for Week Value: <strong>Rp.{{ number_format($pvWeek)}}</strong></li>
                <li class="list-group-item">Earned for Week Value: <strong>Rp.{{ number_format($evWeek)}}</strong></li>
                <li class="list-group-item">Cost Performance Index for Week Value: <strong>{{ round($cpiWeek, 2) }}</strong>
                    <span 
                        class="badge
                        @switch( $label )
                            @case('Over Budget')
                                text-bg-danger
                                @break
                            @case('Under Budget')
                                text-bg-primary
                            @break
                            @case('Planed')
                                text-bg-success
                            @break
                            @default 
                        @endswitch" >{{ $label }} 
                    </span>
                </li>
                <li class="list-group-item">Schedule Performance Index for Week Value: <strong>{{ round($spiWeek, 2) }}</strong>
                    <span 
                        class="badge
                        @switch( $status )
                            @case('Behind Schedule')
                                text-bg-danger
                                @break
                            @case('Ahead Schedule')
                                text-bg-primary
                            @break
                            @case('On Time')
                                text-bg-success
                            @break
                            @default 
                        @endswitch" >{{ $status }} 
                    </span>
                </li>
            </ul>

            <ul class="list-group list-group-flush">
                <li class="list-group-item">Planed for Month Value: <strong>Rp.{{ number_format($pvMonth)}}</strong></li>
                <li class="list-group-item">Earned for Month Value: <strong>Rp.{{ number_format($evMonth)}}</strong></li>
                <li class="list-group-item">Cost Performance Index for Month Value: <strong>{{ round($cpiMonth, 2) }}</strong>
                    <span 
                        class="badge
                        @switch( $situasi )
                            @case('Over Budget')
                                text-bg-danger
                                @break
                            @case('Under Budget')
                                text-bg-primary
                            @break
                            @case('Planed')
                                text-bg-success
                            @break
                            @default 
                        @endswitch" >{{ $situasi }} 
                    </span>
                </li>
                <li class="list-group-item">Schedule Performance Index for Month Value: <strong>{{ round($spiMonth, 2) }}</strong>
                    <span 
                        class="badge
                        @switch( $kondisi )
                            @case('Behind Schedule')
                                text-bg-danger
                                @break
                            @case('Ahead Schedule')
                                text-bg-primary
                            @break
                            @case('On Time')
                                text-bg-success
                            @break
                            @default 
                        @endswitch" >{{ $kondisi }} 
                    </span>
                </li>
            </ul>

        </div>
    </div>


    {{-- OFF CANVAS FOR COST --}}
    {{-- <div class="offcanvas offcanvas-end w-50" tabindex="-1" id="viewCost" aria-labelledby="viewCostLabel"> --}}
        {{-- <div class="offcanvas-header">
            <h5 id="viewCostLabel">View Project</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div> --}}
        {{-- <div class="offcanvas-body">
            
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Planed Value: <strong>{{ number_format($pv,2)}}</strong></li>
                <li class="list-group-item">Earned Value: <strong>{{ number_format($ev,2) }}</strong></li>
                <li class="list-group-item">Actual Cost: <strong>{{ number_format($ac,2) }}</strong></li>
                <li class="list-group-item">Schedule Performa Index: <strong>{{ number_format($spi,2) }}</strong>
                    <span 
                        class="badge
                        @switch( $status )
                            @case('Behind Schedule')
                                text-bg-danger
                                @break
                            @case('Ahead Schedule')
                                text-bg-primary
                            @break
                            @case('On Time')
                                text-bg-success
                            @break
                            @default 
                        @endswitch" >{{ $status }} </span>
                </li>
                
                <li class="list-group-item">Cost Performa Index: <strong>{{ number_format($cpi,2) }}</strong>
                    <span 
                        class="badge
                        @switch( $label )
                            @case('Over Budget')
                                text-bg-danger
                                @break
                            @case('Under Budget')
                                text-bg-primary
                            @break
                            @case('Planed')
                                text-bg-success
                            @break
                            @default 
                        @endswitch" >{{ $label }} </span>
                </li> 
            </ul>
      
        </div> --}}
    {{-- </div> --}}


    {{-- OFF CANVAS FOR VIEW AVAILIBILITY --}}
    <div class="offcanvas offcanvas-end w-50" tabindex="-1" id="viewAvails" aria-labelledby="viewAvailsLabel">
        <div class="offcanvas-header">
            <h5 id="viewAvailsLabel">View Project</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            @if ($avails)
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Name: <strong>{{ $avails->name }}</strong></li>

                    {{-- <li class="list-group-item">Role: <strong>{{ $avails->role_name }}</strong></li> --}}
                    {{-- <li class="list-group-item">Department: <strong>{{ $avails->department_name }}</strong></li> --}}

                </ul>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Project Name</th>
                            <th scope="col">Tasks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($avails->projects as $project)
                            <tr>
                                <td>
                                    <a href="{{ route('projects.dashboard.task', $project->title) }}"
                                        wire:navigate.defer>{{ $project->title }}</a>
                                </td>
                                <td>
                                    <ol class="list-group list-group-numbered">
                                        @foreach ($avails->tasks as $task)
                                            @if ($task->project_id === $project->id)
                                                <li class="list-group-item p-1">
                                                    <a href="{{ route('projects.tasks.show', $task->project_id) }}"
                                                        wire:navigate.defer>{{ $task->title }}</a>
                                                    @foreach ($avails->timecards as $timecard)
                                                        @if ($timecard->task_id === $task->id)
                                                            {{ (int)$timecard->duration }},
                                                        @endif
                                                    @endforeach
                                                </li>
                                            @endif
                                        @endforeach
                                    </ol>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

    </div>


    <div class="card">
        {{-- FILTER --}}
        <div class="mt-2 card-header row row-cols-2 row-cols-md-4 row-cols-md-5 g-2">
            <div class="col">
                <label for="" class="form-label">Search</label>
                <input type="text" wire:model.live.debounce="search" class="form-control form-control-sm"
                    placeholder="Search Name..." />
            </div>
            {{-- <div class="col">
                <label for="customRange1" class="form-label">Filter By Project Total:</label>
                <div class="d-flex align-items-center">
                    <input type="range" wire:model.live.debounce="fromNumber.projects" min="1" max="100"
                        class="form-range" id="customRange1">
                    <input wire:model.live.debounce="fromNumber.projects" class="ms-2 form-control form-control-sm w-50"
                        type="number" />
                </div>
            </div>

            <div class="col">
                <label for="customRange1" class="form-label">Filter By Tasks Total:</label>
                <div class="d-flex align-items-center">
                    <input type="range" wire:model.live.debounce="fromNumber.tasks" min="1" max="100"
                        class="form-range" id="customRange1">
                    <input wire:model.live.debounce="fromNumber.tasks" type="number"
                        class="ms-2 form-control form-control-sm w-50" />
                </div>
            </div>

            <div class="col">
                <label for="timeFrame" class="form-label">Filter by Date:</label>
                <select wire:model.live.debounce="timeFrame.tasks" id="timeFrame" class="form-select form-select-sm">
                    <option value="all">All</option>
                    <option value="today">Today</option>
                    <option value="yesterday">Yesterday</option>
                    <option value="week">This Week</option>
                    <option value="last_week">Last Week</option>
                    <option value="month">This Month</option>
                    <option value="last_month">Last Month</option>
                    <option value="year">This Year</option>
                    <option value="custom-date">Custom Date Range</option>
                </select>

                @if ($fromToDate === 'custom-date')
                    <div id="custom-date">
                        <div class="col gap-2 mt-2">
                            <div class="my-1">
                                <input type="date" wire:model.live.debounce="fromDate" id="fromDate"
                                    class="form-control form-control-sm" placeholder="From Date">
                            </div>
                            <div class="my-1">
                                <input type="date" wire:model.live.debounce="toDate" id="toDate"
                                    class="form-control form-control-sm" placeholder="To Date">
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col align-self-end d-flex gap-2">
                <button wire:click="resetFilter" class="btn btn-outline-success btn-outline btn-sm"><i class="fa-solid fa-rotate-left"></i> Reset Filter</button>
            </div> --}}
        </div>


        {{-- TABLE --}}
        <div class="table-responsive card-body p-0">
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th role="button" wire:click="applySortBy('name')">
                            Name <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-arrow-down-up" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5m-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5" />
                            </svg>
                        </th>
                        {{-- <th role="button" wire:click="applySortBy('role_name')">
                            Role <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-arrow-down-up" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5m-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5" />
                            </svg>
                        </th> --}}
                        <th role="button" wire:click="applySortBy('projects')">
                            Project <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-arrow-down-up" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5m-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5" />
                            </svg>
                        </th>
                        <th role="button" wire:click="applySortBy('tasks')">
                            Tasks <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-arrow-down-up" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5m-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5" />
                            </svg>
                        </th>
                        <th>Tasks Hours</th>
                        <th class="text-center">View Performa</th>
                        {{-- <th class="text-center">View Task</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                        <tr>
                            <td>{{ $employee->user_name }}</td>
                            {{-- @dd($employee) --}}
                            {{-- <td>{{ $employee->role_name }}</td> --}}
                            {{-- <td>{{ $employee->department_name }}</td> --}}

                            <td>{{ $employee->projects->count() }}</td>
                            <td>{{ $employee->tasks->count() }}</td>
                            <td>{{ $employee->timecards->sum('duration') }} Hours</td>

                            {{-- <td> --}}
                                {{-- <p role="button" wire:click='getCost({{ $employee->user_id }})'
                                    class="text-info m-0 p-0 text-center" style="cursor: pointer;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                        fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                        <path
                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                    </svg>
                                </p> --}}
                            {{-- </td> --}}

                            <td>
                                    <p role="button" class="text-info m-0 p-0 text-center" style="cursor: pointer;" 
                                        data-bs-toggle="offcanvas" 
                                        {{-- data-bs-target="#viewPerforma"  --}}
                                        {{-- aria-controls="viewPerforma" --}}
                                        wire:click='calculateAll({{ $employee->user_id }})'>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                            <path
                                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                        </svg>
                                    </p>
                                
                                {{-- <a href="/availability-tracking/performa/{id}" wire:navigate> --}}
                                    {{-- <p role="button" wire:navigate href="{{ route('availability-tracking.show.performa', ['employeeId' => $employee->user_id]) }}"
                                        class="text-info m-0 p-0 text-center" style="cursor: pointer;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                            <path
                                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                        </svg>
                                    </p> --}}
                                {{-- </a> --}}
                            </td>

                            {{-- <td> --}}
                                {{-- <p role="button" wire:click='showById({{ $employee->id }})'
                                    class="text-info m-0 p-0 text-center" style="cursor: pointer;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                        fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                        <path
                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                    </svg>
                                </p> --}}
                            {{-- </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
    {{-- <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('show-view-offcanvas', (event) => {
                const offcanvas = new bootstrap.Offcanvas('#viewAvails');
                offcanvas.show();
            });
        });
    </script> --}}

    {{-- COST --}}
    {{-- <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('open-getcost', (event) => {
                const offcanvas = new bootstrap.Offcanvas('#viewCost');
                offcanvas.show();
            });
        });
    </script> --}}

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('open-getPerforma', (event) => {
            const offcanvas = new bootstrap.Offcanvas('#viewPerforma');
            offcanvas.show();
        });
    });
</script>
@endpush
