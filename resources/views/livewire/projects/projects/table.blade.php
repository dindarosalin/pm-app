<div>
    <input type="text" wire:model.live="search" placeholder="Search Projects..." />

    <!-- Filter Dropdowns -->
    <select wire:model.live="filters.team">
        <option value="">Select team</option>
        @foreach ($teams as $team)
            <option value="{{ $team->name }}">{{ $team->name }}</option>
        @endforeach
    </select>

    <select wire:model.live="filters.pm_name">
        <option value="">Select PM</option>
        @foreach ($pm as $pm_name)
            <option value="{{ $pm_name->name }}">{{ $pm_name->name }}</option>
        @endforeach
    </select>

    <div>
        <label >Filter Time:</label>
        <select wire:model.live="timeFrame" id="timeFrame">
            <option value="all">All</option>
            <option value="weekly">This Week</option>
            <option value="monthly">This Month</option>
        </select>
    </div>
    <div>
        <div class="d-flex gap-2">
            <div>
                <label for="fromDate" class="form-label">From Date:</label>
                <input type="date" wire:model.live='fromDate' id="fromDate" class="form-control form-control-sm ">
            </div>
            <div>
                <label for="toDate" class="form-label">To Date:</label>
                <input type="date" wire:model.live='toDate' id="toDate" class="form-control form-control-sm ">
            </div>
        </div>
    </div>    

    <button wire:click='resetFilter'>reset filter</button>

    <table>
        <thead>
            <tr>
                <th>
                    <button wire:click="sortBy('created_at')">Sort by Created At</button>
                </th>
                <th wire:click="sortBy('title')">
                    <button wire:click="sortBy('title')">Sort by Title</button>
                </th>
                <th wire:click="sortBy('pm_name')">
                    <button wire:click="sortBy('pm_name')">project Manager</button>
                </th>
                <th>
                    Teams
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                <tr>
                    <td>{{ $project->created_at }}</td>
                    <td>{{ $project->title }}</td>
                    <td>{{ $project->pm_name }}</td>
                    <td>{{ $project->team }}</td>
                    <td>
                        <button wire:click='getProjectById({{ $project->id }})'>view</button>
                    </td>
                    <!-- More data columns as needed -->
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
