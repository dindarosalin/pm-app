<div>
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

            <div class="col align-self-end">
                <button wire:click="resetFilter" class="btn btn-outline-success btn-outline btn-sm"><i class="fa-solid fa-rotate-left"></i> Reset
                    Filter</button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive ">
                <table class="table table-striped caption-top table-sm">
                    <caption>Your Time Card Record of Today, Total: {{ $taskCount }}</caption>
                    <thead>
                        <tr>
                            <th role="button" wire:click="applySortBy('project_title')">
                                Project <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-arrow-down-up" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5m-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5" />
                                </svg>
                            </th>
                            <th role="button" wire:click="applySortBy('task_title')">
                                Task <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-arrow-down-up" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5m-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5" />
                                </svg>
                            </th>
                            <th role="button" wire:click="applySortBy('duration')">
                                Duration <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-arrow-down-up" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5m-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5" />
                                </svg>
                            </th>
                            <th role="button" wire:click="applySortBy('activity_date')">
                                Activity Date <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-arrow-down-up" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5m-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5" />
                                </svg>
                            </th>
                            <th role="button" wire:click="applySortBy('status_id')">
                                Status Task <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-arrow-down-up" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5m-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5" />
                                </svg>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($timeCards as $timeCard)
                            <tr wire:key='{{ $timeCard->id }}'>
                                <td>
                                    <a href="{{ route('projects.dashboard.task', $timeCard->project_id) }}"
                                        wire:navigate.defer>{{ $timeCard->project_title }}</a>
                                </td>
                                <td>
                                    <a href="{{ route('projects.tasks.show', $timeCard->project_id) }}"
                                        wire:navigate.defer>{{ $timeCard->task_title }} </a>
                                </td>
                                <td class="col-2">
                                    <div class="d-flex align-items-center justify-content-between" data-bs-toggle="tooltip" title="Input Duration">
                                        {{ $timeCard->duration }} 
                                        <button class="btn btn-sm p-0 m-0 text-warning ms-auto" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#inputDuration{{ $timeCard->id }}" aria-expanded="false"
                                            aria-controls="inputDuration{{ $timeCard->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                                <path
                                                    d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="collapse" id="inputDuration{{ $timeCard->id }}">
                                        <input type="number" step="60" class="form-control form-control-sm"
                                            wire:change="update({{ $timeCard->id }})" wire:model.blur='duration'>
                                        <div class="form-check">
                                            <input wire:model.blur='taskStatus' class="form-check-input" type="checkbox" data-bs-toggle="tooltip" title="Check When Task Is Done"
                                                value="5" id="flexCheckDefault" wire:change="update({{ $timeCard->id }})">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Done
                                            </label>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $timeCard->activity_date }}</td>
                                <td>
                                    <span
                                        class="badge
                                            @switch($timeCard->task_status )
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
                                        {{ $timeCard->task_status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
