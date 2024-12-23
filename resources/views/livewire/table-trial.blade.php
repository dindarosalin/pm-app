<section>
    <div wire:ignore.self class="offcanvas offcanvas-end" tabindex="-1" id="offCanvasForm">
        <div class="offcanvas-header">
            <h5 id="offCanvasFormLabel">Form</h5>
            <button type="button" class="btn-close text-reset" wire:click='btnClose_Offcanvas' aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form wire:submit.prevent="store">
                <!-- Select Department -->

                <div class="input-group mb-3">
                    <select class="form-select form-select-sm" wire:model="selectedDept" name="departments"
                        id="departments">
                        <option value="">Select Department</option>
                        @foreach ($departments as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-outline-secondary btn-sm" wire:click='loadEmployees' type="button"
                        id="button-addon2">Pilih</button>
                </div>
                <select class="form-select form-select-sm mb-2" wire:model="selectedEmpl" name="employee"
                    id="employee">
                    <option value="">Select Employee</option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                    @endforeach
                </select>

                {{-- <select class="form-select form-select-sm mb-1" wire:model="selectedDept" name="departments" id="departments">
                    <option value="">Select Department</option>
                    @foreach ($departments as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select> --}}

                <!-- Select Employee -->


                <!-- Save Button -->
                <button class="btn btn-primary" type="submit">Save</button>
            </form>
        </div>
    </div>

    <div class="card">
        <button wire:click='showOffCanvas' class="btn btn-sm btn-info mb-2">offCanvas</button>
        <div class="row mb-3 gap-2 align-items-center justify-content-between">
            <div class="col">
                <label for="filterPM" class="form-label ">Filter Project Manager:</label>
                <select wire:model.live='role' id="filterPM" class="form-select form-select-sm"
                    aria-label="Small select example">
                    <option value="">filter</option>
                    <option value="4">pm 1</option>
                    <option value="5">pm 2</option>
                    <option value="7">pm 3</option>
                </select>
            </div>
            <div class="col">
                <label for="search" class="form-label">Search Keyword:</label>
                <input wire:model.live.debounce.300ms='search' id="search" type="text"
                    class="form-control form-control-sm" placeholder="Search">
            </div>
            <div class="col">
                <label for="timeFrame" class="form-label">Filter Time:</label>
                <select wire:model.live="timeFrame" id="timeFrame" class="form-select form-select-sm">
                    <option value="all">All</option>
                    <option value="weekly">This Week</option>
                    <option value="monthly">This Month</option>
                </select>
            </div>
            <div class="col">
                <div class="d-flex gap-2">
                    <div>
                        <label for="fromDate" class="form-label">Form Date:</label>
                        <input type="date" wire:model.live='fromDate' id="fromDate"
                            class="form-control form-control-sm ">
                    </div>
                    <div>
                        <label for="toDate" class="form-label">To Date:</label>
                        <input type="date" wire:model.live='toDate' id="toDate"
                            class="form-control form-control-sm ">
                    </div>
                </div>
            </div>
            <div class="col text-center">
                <button wire:click='resetFilter()' class="btn btn-sm btn-primary">reset filter</button>
            </div>
        </div>
        <table id="products-table" class="table table-bordered">
            <thead>
                <tr>
                    <th class="fw-bold">
                        <button wire:click="setSortBy('title')"
                            class="d-flex justify-items-center btn btn-sm btn-outline-secondary">
                            sorting
                            @if ($sortBy === 'title')
                                @if ($sortDir === 'ASC')
                                    asc
                                @else
                                    desc
                                @endif
                            @endif
                        </button>
                    </th>
                    <th class="fw-bold">B</th>
                    <th class="fw-bold">
                        <button wire:click="setSortBy('project_manager')"
                            class="d-flex justify-items-center btn btn-sm btn-outline-secondary">
                            sorting by PM
                            @if ($sortBy === 'project_manager')
                                @if ($sortDir === 'ASC')
                                    asc
                                @else
                                    desc
                                @endif
                            @endif
                        </button>
                    </th>
                    <th class="fw-bold">D</th>
                    <th class="fw-bold">E</th>
                    <th class="fw-bold">F</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    <tr wire:key='{{ $project->id }}'>
                        <td>{{ $project->title }}</td>
                        <td>{{ $project->team }}</td>
                        <td>{{ $project->project_manager }}</td>
                        <td>{{ $project->client }}</td>
                        <td>{{ $project->id }}</td>
                        <td>{{ $project->id }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-2 row">
            <div class="col-1">
                <select wire:model.live='perPage' class="form-select form-select-sm" aria-label="Small select example">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div class="col">
                {{ $projects->links() }}
            </div>
        </div>
    </div>
</section>

@push('scripts')
    <script>
        window.addEventListener('show-off-canvas', event => {
            const offcanvas = new bootstrap.Offcanvas('#offCanvasForm');
            offcanvas.show();
        });
        window.addEventListener('close-off-canvas', event => {
            const offcanvas = new bootstrap.Offcanvas('#offCanvasForm');
            offcanvas.hide();
        });
    </script>
@endpush
