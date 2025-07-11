<div class="mt-2 card-header row row-cols-2 row-cols-md-4 row-cols-md-5 g-2">
    <div class="col">
        <label for="" class="label-form">Filter by Start Date:</label>
        <select wire:model.live.debounce="timeFrame.start_date_estimation" id="timeFrame"
            class="form-select form-select-sm">
            <option value="all">All</option>
            <option value="today">Today</option>
            <option value="yesterday">Yesterday</option>
            <option value="week">This Week</option>
            <option value="last_week">Last Week</option>
            <option value="month">This Month</option>
            <option value="last_month">Last Month</option>
            <option value="year">This Year</option>
            <option value="custom-start-date">Custom Date Range</option>
        </select>

        @if ($fromToDate === 'custom-start-date')
            <div id="custom-start-date">
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
    <div class="col">
        <label for="" class="label-form">Filter by End Date:</label>
        <select wire:model.live.debounce="timeFrame.end_date_estimation" id="timeFrame"
            class="form-select form-select-sm">
            <option value="all">All</option>
            <option value="today">Today</option>
            <option value="yesterday">Yesterday</option>
            <option value="week">This Week</option>
            <option value="last_week">Last Week</option>
            <option value="month">This Month</option>
            <option value="last_month">Last Month</option>
            <option value="year">This Year</option>
            <option value="custom-end-date">Custom Date Range</option>
        </select>

        @if ($fromToDate === 'custom-end-date')
            <div id="custom-end-date">
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
    <div class="col">
        <label for="" class="label-form">Filter by Status:</label>
        <select wire:model.live.debounce="filters.status_id" class="form-select form-select-sm">
            <option value="">Select Status</option>
            @foreach ($statuses as $status)
                <option wire:key='{{ $status->id }}' value="{{ $status->id }}">
                    {{ $status->task_status }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col">
        <label for="" class="label-form">Filter by Category:</label>
        <select wire:model.live.debounce="filters.category_id" class="form-select form-select-sm">
            <option value="">Select Category</option>
            @foreach ($categories as $status)
                <option wire:key='{{ $status->id }}' value="{{ $status->id }}">
                    {{ $status->category_name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col">
        <label for="" class="label-form">Filter by Assign To:</label>
        <select wire:model.live.debounce="filters.assign_to" class="form-select form-select-sm">
            <option value="">Select Employee</option>
            @if ($employees->count() >= 1)
                <option value="{{ $auth }}" selected>Me</option>
                @foreach ($employees as $employee)
                    <option wire:key='{{ $employee['id'] }}' value="{{ $employee['id'] }}">
                        {{ $employee['name'] }}
                    </option>
                @endforeach
            @else
                <option value="{{ $auth }}" selected>{{ $auth }}</option>
            @endif
        </select>
    </div>
    <div class="col">
        <label for="" class="label-form">Search Title:</label>
        <input type="text" wire:model.live.debounce="search" class="form-control form-control-sm col"
            placeholder="Search..." />
    </div>
    <div class="col d-flex align-items-end">
        <button wire:click="resetFilter" class="btn btn-outline-success btn-sm col me-1">
            <i class="fa-solid fa-rotate-left"></i> Reset Filter
        </button>
    </div>
</div>
