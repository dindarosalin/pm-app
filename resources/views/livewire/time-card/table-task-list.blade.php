<div>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="viewOffCanvas" aria-labelledby="viewOffCanvasLabel">
        <div class="offcanvas-header">
            <h5 id="viewOffCanvasLabel">View Project</h5>
            <button type="button" class="btn-close text-reset"
                data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            @if ($taskShow)
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Project Name: <strong>{{ $taskShow->project_title }}</strong></li>
                    <li class="list-group-item">Title: <strong>{{ $taskShow->title }}</strong></li>
                    <li class="list-group-item">Summary: <strong>{!! $taskShow->summary !!}</strong></li>
                    <li class="list-group-item">Start: <strong>{{ $taskShow->start_date_estimation }}</strong></li>
                    <li class="list-group-item">End: <strong>{{ $taskShow->end_date_estimation }}</strong></li>
                    <li class="list-group-item">Created By: <strong>{{ $taskShow->created_by_name }}</strong></li>
                    <li class="list-group-item">Assign To: <strong>{{ $taskShow->assign_to_name }}</strong></li>
                    <li class="list-group-item">Flags: <strong>{{ $taskShow->flag }}</strong></li>
                    <li class="list-group-item">Category: <strong>{{ $taskShow->category_name }}</strong></li>
                    <li class="list-group-item">Status: 
                        <span
                                        class="badge
                                        @switch($taskShow->status_name )
                                            @case('New')
                                                text-bg-primary
                                                @break
                                            @case('Assign')
                                                text-bg-info
                                                @break
                                            @case('On Progress')
                                                text-bg-warning
                                                @break
                                            @case('Testing')
                                                text-bg-warning
                                                @break
                                            @case('Done')
                                                text-bg-success
                                                @break
                                            @case('Production')
                                                text-bg-success
                                                @break
                                            @case('Hold')
                                                text-bg-danger
                                                @break
                                            @case('Cancel')
                                                text-bg-danger
                                                @break
                                        @endswitch ">
                                        {{ $taskShow->status_name }}
                                    </span>
                    </li>
                </ul>            
            @endif
        </div>
    </div>

    <div class="card">
        <div class="mt-2 card-header row row-cols-2 row-cols-md-4 row-cols-md-5 g-2">
            <div class="col">
                <label class="form-label">Filter By Status Task:</label>
                <select wire:model.live.debounce="filters.status_id" class="form-select form-select-sm">
                    <option value="">Select Status</option>
                    @foreach ($taskStatuses as $status)
                        <option wire:key='{{ $status->id }}' value="{{ $status->id }}">
                            {{ $status->task_status }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col">
                <label for="" class="form-label">Search</label>
                <input type="text" wire:model.live.debounce="search" class="form-control form-control-sm"
                    placeholder="Search Projects..." />
            </div>

            <div class="col">
                <label for="timeFrame" class="form-label">Filter by Due Date:</label>
                <select wire:model.live.debounce="timeFrame.end_date_estimation" id="timeFrame"
                    class="form-select form-select-sm">
                    <option value="all">All</option>
                    <option value="today">Today</option>
                    <option value="tomorrow">Tomorrow</option>
                    <option value="yesterday">Yesterday</option>
                    <option value="week">This Week</option>
                    <option value="next_week">Next Week</option>
                    <option value="last_week">Last Week</option>
                    <option value="month">This Month</option>
                    <option value="next_month">Next Month</option>
                    <option value="last_mont">Last Month</option>
                    <option value="year">This Year</option>
                    <option value="custom-date">Custom Date Range</option>
                </select>
                @if ($fromToDate === 'custom-date')
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
                @endif
            </div>

            <div class="col align-self-end">
                <button wire:click="resetFilter" class="btn btn-outline-success btn-outline btn-sm">Reset
                    Filter</button>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped caption-top table-sm">
                <caption>Your Task Total: {{ $taskCount }}</caption>
                <thead>
                    <tr>
                        <th role="button" wire:click="applySortBy('project_title')">
                            Project <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-arrow-down-up" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5m-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5" />
                            </svg>
                        </th>
                        <th role="button" wire:click="applySortBy('title')">
                            Task <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-arrow-down-up" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5m-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5" />
                            </svg>
                        </th>
                        <th role="button" wire:click="applySortBy('start_date_estimation')">
                            Start Date <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-arrow-down-up" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5m-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5" />
                            </svg>
                        </th>
                        <th role="button" wire:click="applySortBy('end_date_estimation')">
                            Due Date <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-arrow-down-up" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5m-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5" />
                            </svg>
                        </th>
                        <th role="button" wire:click="applySortBy('status_id')">
                            Project <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-arrow-down-up" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5m-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5" />
                            </svg>
                        </th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach ($tasks as $project_id => $projectTasks) --}}
                        @foreach ($tasks as $task)
                            <tr>
                                <td>
                                    <a href="{{ route('projects.dashboard.task', $task->project_id) }}"
                                        wire:navigate.defer>{{ $task->project_title }}</a>
                                </td>
                                <td>
                                    <a href="{{ route('projects.tasks.show', $task->project_id) }}"
                                        wire:navigate.defer>{{ $task->title }} </a>
                                </td>
                                <td>{{ $task->start_date_estimation }}</td>
                                <td>{{ $task->end_date_estimation }}</td>
                                <td>
                                    <span
                                        class="badge
                                        @switch($task->status_name )
                                            @case('New')
                                                text-bg-primary
                                                @break
                                            @case('Assign')
                                                text-bg-info
                                                @break
                                            @case('On Progress')
                                                text-bg-warning
                                                @break
                                            @case('Testing')
                                                text-bg-warning
                                                @break
                                            @case('Done')
                                                text-bg-success
                                                @break
                                            @case('Production')
                                                text-bg-success
                                                @break
                                            @case('Hold')
                                                text-bg-danger
                                                @break
                                            @case('Cancel')
                                                text-bg-danger
                                                @break
                                        @endswitch ">
                                        {{ $task->status_name }}
                                    </span>
                                </td>
                                <td>
                                    <p role="button" wire:click="showById({{ $task->id }})" class="text-info m-0 p-0" style="cursor: pointer;">
                                        <i class="fa-regular fa-eye"></i>
                                    </p>
                                </td>
                            </tr>
                        @endforeach
                    {{-- @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('show-create-offcanvas', event => {
            const offcanvas = new bootstrap.Offcanvas('#timeCardForm');
            offcanvas.show();
        });

        window.addEventListener('close-offcanvas', event => {
            const offcanvas = new bootstrap.Offcanvas('#taskForm');
            offcanvas.hide();
        });

        window.addEventListener('show-view-offcanvas', event => {
            const offcanvas = new bootstrap.Offcanvas('#viewOffCanvas');
            offcanvas.show();
        });
    </script>
@endpush
