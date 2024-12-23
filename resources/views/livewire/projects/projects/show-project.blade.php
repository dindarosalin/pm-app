@section('title', 'Projects')
<div>
    {{-- offcanvas digunakan untuk create data dan update data --}}
    <div class="offcanvas offcanvas-end" tabindex="-1" id="projectForm"
        aria-labelledby="projectFormLabel"data-bs-scroll="true">
        <div class="offcanvas-header">
            <h5 id="projectFormLabel">Form</h5>
            <button type="button" class="btn-close text-reset" wire:click='btnClose_Offcanvas' data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form wire:submit.prevent="save">
                <div class="mb-3">
                    <label class="form-label">Title<span class="text-sm text-danger">*</span> </label>
                    <input type="text" wire:model="title" class="form-control form-control-sm" required>
                </div>
                <div class="form-floating mb-3">
                    <textarea wire:model="description" class="form-control form-control-sm" id="floatingTextarea2"
                        placeholder="Project Description" style="height: 100px"></textarea>
                    <label for="floatingTextarea2">Description</label>
                </div>
                <div class="mb-3">
                    <label class="form-label">Client<span class="text-sm text-danger">*</span></label>
                    <input type="text" wire:model="client" class="form-control form-control-sm" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Project Manager<span class="text-sm text-danger">*</span></label>
                    <select wire:model="project_manager" class="form-select form-select-sm mb-3" id="project_manager"
                        aria-label="Default select example" required>
                        <option value="" selected>Select Project Manager</option>
                        @foreach ($pm as $pm_name)
                            <option wire:key='{{ $pm_name->user_id }}' value="{{ $pm_name->user_id }}">
                                {{ $pm_name->user_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Team<span class="text-sm text-danger">*</span></label>
                    <select id="teams" class="form-select form-select-sm mb-3" wire:model="selectedTeams" multiple
                        required>
                        @foreach ($departments as $department)
                            <option wire:key='{{ $department->id }}' value="{{ $department->id }}">
                                {{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Start Date<span class="text-sm text-danger">*</span></label>
                    <input type="date" wire:model="start_date" class="form-control form-control-sm" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Due Date Estimation<span class="text-sm text-danger">*</span></label>
                    <input type="date" wire:model="due_date_estimation" class="form-control form-control-sm"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Product Value<span class="text-sm text-danger">*</span></label>
                    <input type="number" wire:model="budget" class="form-control form-control-sm">
                </div>

                <div class="mb-3">
                    <label class="form-label">Attachments</label>
                    <input type="file" wire:model="attachments" class="form-control form-control-sm" multiple>
                    <div wire:loading wire:target="attachments">Uploading...</div>
                    <div>
                        {{-- preview dari tmp file --}}
                        @if ($attachments)
                            <div>
                                @foreach ($attachments as $key => $attachment)
                                    <div class=" flex">
                                        <p>{{ $attachment->getClientOriginalName() }}</p>
                                        <p wire:click="removeAttachment('new', {{ $key }})"
                                            class="text-danger btn btn-sm">Hapus</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- preview dari database --}}
                        @if ($existingAttachments)
                            <div>
                                @foreach ($existingAttachments as $key => $attachment)
                                    <div class="flex">
                                        <a href="{{ asset('storage/' . $attachment['path']) }}" target="_blank">
                                            {{ $attachment['name'] }}
                                        </a>

                                        <p wire:click="removeAttachment('existing', {{ $key }})"
                                            class="text-danger btn btn-sm">Hapus</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                <div class="flex">
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                    <button wire:click='btnClose_Offcanvas' class="btn btn-secondary btn-sm">cancel</button>
                </div>
                <div wire:loading wire:target="save">Saving...</div>
            </form>
        </div>
    </div>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="viewProject" aria-labelledby="viewProjectLabel">
        <div class="offcanvas-header">
            <h5 id="viewProjectLabel">View Project</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            @if ($projectShow)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Title</th>
                                <td>{{ $projectShow->title }}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{{ $projectShow->description }}</td>
                            </tr>
                            <tr>
                                <th>Client</th>
                                <td>{{ $projectShow->client }}</td>
                            </tr>
                            <tr>
                                <th>Project Manager</th>
                                <td>{{ $projectShow->pm_name }}</td>
                            </tr>
                            <tr>
                                <th>Team</th>
                                <td>{{ $projectShow->team_names }}</td>
                            </tr>
                            <tr>
                                <th>Product Value</th>
                                <td>Rp.{{ number_format($projectShow->budget, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Start Date</th>
                                <td>{{ $projectShow->start_date }}</td>
                            </tr>
                            <tr>
                                <th>Due Date Estimation</th>
                                <td>{{ $projectShow->due_date_estimation }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    {{-- <span class="badge text-bg-success">{{ $projectShow->status_name }}</span></strong> --}}
                                    <span
                                    class="badge 
                                @switch($projectShow->status)
                                    @case('New')
                                        text-bg-primary
                                        @break
                                    @case('On Progress')
                                        text-bg-warning
                                        @break
                                    @case('Complete')
                                        text-bg-success
                                        @break
                                    @case('Cancel')
                                        text-bg-info
                                        @break
                                    @case('Hold')
                                        text-bg-warning
                                    @break
                                @endswitch">{{ $projectShow->status }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Attachments</th>
                                <td>
                                    @if ($projectShow->attachments)
                                        @foreach ($projectShow->attachments as $attachment)
                                            <div class="attachment-item">
                                                <a href="{{ asset('storage/' . $attachment['path']) }}"
                                                    target="_blank">
                                                    {{ $attachment['name'] }}
                                                </a>
                                            </div>
                                        @endforeach
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>

    {{-- <button wire:click="showAlert">Tampilkan Alert</button> --}}

    <div class="card">
        <div class="mt-2 card-header row row-cols-2 row-cols-md-4 row-cols-md-5 g-2">
            <div class="col">
                <label for="timeFrame" class="form-label">Filter by Tanggal dibuat:</label>
                <select wire:model.live.debounce="timeFrame.created_at" id="timeFrame"
                    class="form-select form-select-sm">
                    <option value="all">All</option>
                    <option value="today">Today</option>
                    <option value="yesterday">Yesterday</option>
                    <option value="week">This Week</option>
                    <option value="last_week">Last Week</option>
                    <option value="month">This Month</option>
                    <option value="last_month">Last Month</option>
                    <option value="year">This Year</option>
                    <option value="custom-created">Custom Date Range</option>
                </select>

                @if ($fromToDate === 'custom-created')
                    <div id="custom-created">
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
                <label for="timeFrame" class="form-label">Filter by Start Date Project:</label>
                <select wire:model.live.debounce="timeFrame.start_date" id="timeFrame"
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
                    <option value="custom-start">Custom Date Range</option>
                </select>
                @if ($fromToDate === 'custom-start')
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

            <div class="col">
                <label for="timeFrame" class="form-label">Filter by Due Date Project:</label>
                <select wire:model.live.debounce="timeFrame.due_date_estimation" id="timeFrame"
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
                    <option value="custom-end">Custom Date Range</option>
                </select>
                @if ($fromToDate === 'custom-end')
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

            <div class="col">
                <label class="form-label">Filter by Project Manager:</label>
                <select wire:model.live.debounce="filters.project_manager" class="form-select form-select-sm">
                    <option value="">Select PM</option>
                    @foreach ($pm as $pm_name)
                        <option wire:key='{{ $pm_name->user_id }}' value="{{ $pm_name->user_id }}">
                            {{ $pm_name->user_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col">
                <label class="form-label">Filter By Status Project:</label>
                <select wire:model.live.debounce="filters.status_id" class="form-select form-select-sm">
                    <option value="">Select Status</option>
                    @foreach ($projectStatuses as $status)
                        <option wire:key='{{ $status->id }}' value="{{ $status->id }}">
                            {{ $status->project_status }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col">
                <label for="customRange1" class="form-label">Product Value:</label>
                <div class="d-flex align-items-center">
                    <input type="range" wire:model.live.debounce="fromNumber.budget" min="1000000"
                        max="100000000" class="form-range" id="customRange1">
                    <input wire:model.live.debounce="fromNumber.budget" class="ms-2 form-control form-control-sm"
                        type="number" />
                </div>
            </div>

            <div class="col">
                <label for="customRange1" class="form-label">Completion:</label>
                <div class="d-flex align-items-center">
                    <input type="range" wire:model.live.debounce="fromNumber.completion" min="0"
                        max="100" class="form-range" id="customRange1">
                    <input wire:model.live.debounce="fromNumber.completion"
                        class="ms-2 form-control form-control-sm w-25" type="number" />
                </div>
            </div>

            <div class="col">
                <label for="" class="form-label">Search</label>
                <input type="text" wire:model.live.debounce="search" class="form-control form-control-sm"
                    placeholder="Search Projects..." />
            </div>
            <div class="col text-end d-flex align-items-end">
                <button wire:click="resetFilter" class="btn btn-outline-success btn-sm col me-1">
                    <i class="fa-solid fa-rotate-left"></i>
                </button>
                <button wire:click="$dispatch('show-create-offcanvas')" class="btn btn-success btn-sm col me-1"><i
                        class="fa-solid fa-plus"></i></button>
                <a href="{{ route('projects.project.archived') }}" role="button" class="btn btn-danger btn-sm col text-white" wire:navigate> 
                    <i class="fa-solid fa-box-archive"></i></a>
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th role="button">Status</th>
                        {{-- <th role="button" wire:click="applySortBy('created_at')">
                            Created <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-arrow-down-up" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5m-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5" />
                            </svg>
                        </th> --}}
                        <th role="button" wire:click="applySortBy('title')">
                            Title <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-arrow-down-up" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5m-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5" />
                            </svg>
                        </th>
                        <th role='button' wire:click="applySortBy('pm_name')">
                            Manager <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-arrow-down-up" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5m-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5" />
                            </svg>
                        </th>
                        <th role='button' wire:click="applySortBy('client')">
                            Client <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-arrow-down-up" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5m-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5" />
                            </svg>
                        </th>
                        <th>Teams</th>
                        <th role='button' wire:click="applySortBy('budget')">
                            Value <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-arrow-down-up" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5m-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5" />
                            </svg>
                        </th>
                        <th role='button' wire:click="applySortBy('due_date_estimation')">
                            Due Date <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-arrow-down-up" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5m-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5" />
                            </svg>
                        </th>
                        <th role='button' wire:click="applySortBy('completion')">
                            % <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-arrow-down-up" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5m-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5" />
                            </svg>
                        </th>
                        <th role='button'>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($projects as $project)
                        <tr wire:key='{{ $project->id }}'>
                            <td><span
                                    class="badge
                                @switch($project->status)
                                    @case('New')
                                        text-bg-primary
                                        @break
                                    @case('On Progress')
                                        text-bg-warning
                                        @break
                                    @case('Complete')
                                        text-bg-success
                                        @break
                                    @case('Cancel')
                                        text-bg-info
                                        @break
                                    @case('Hold')
                                        text-bg-warning
                                    @break
                                @endswitch">{{ $project->status }}</span>
                            </td>
                            {{-- <td>{{ date('d F Y', strtotime($project->created_at)) }}</td> --}}
                            <td>
                                <a href="{{ route('projects.dashboard.task', $project->id) }}"
                                    wire:navigate.defer>{{ $project->title }}</a>
                            </td>
                            <td>{{ $project->pm_name }}</td>
                            <td>{{ $project->client }}</td>
                            <td>{{ $project->team_names }}</td>
                            <td>Rp.{{ number_format($project->budget, 0, ',', '.') }}</td>
                            <td>{{ date('d F Y', strtotime($project->due_date_estimation)) }}</td>
                            <td>{{ $project->completion }}%</td>
                            <td>
                                <div class="d-flex gap-2 justify-content-center align-items-center">
                                    <!-- View icon -->
                                    <button class="btn btn-outline-primary btn-sm" wire:click='showById({{ $project->id }})'>
                                        <p class="m-0 p-0">
                                            <i class="fa-regular fa-eye"></i>
                                        </p>
                                    </button>

                                    <!-- Edit icon -->
                                    <button class="btn btn-outline-warning btn-sm" wire:click='edit({{ $project->id }})'>
                                        <p class="m-0 p-0">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </p>
                                    </button>

                                    <!-- Delete icon -->
                                    <button class="btn btn-outline-danger btn-sm" wire:click="alertConfirm({{ $project->id }})">
                                        <p class="m-0 p-0">
                                            <i class="fa-solid fa-box-archive"></i>
                                        </p>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- <div class="row mt-3 justify-content-between">
            <div class="col-auto">
                <p>Menampilkan {{ $projectPaginate->count() }} dari total {{ $projectPaginate->total() }} data.</p>
            </div>
            <div class="col-auto">
                {{ $projectPaginate->links('pagination::bootstrap-5') }}
            </div>
        </div> --}}
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('show-create-offcanvas', event => {
            const offcanvas = new bootstrap.Offcanvas('#projectForm');
            offcanvas.show();
        });
        window.addEventListener('close-offcanvas', event => {
            const offcanvas = new bootstrap.Offcanvas('#projectForm');
            offcanvas.hide();
        });
        window.addEventListener('show-edit-offcanvas', event => {
            const offcanvas = new bootstrap.Offcanvas('#projectForm');
            offcanvas.show();
        });
        document.addEventListener('livewire:init', () => {
            Livewire.on('show-view-offcanvas', (event) => {
                const offcanvas = new bootstrap.Offcanvas('#viewProject');
                offcanvas.show();
            });
        });
        window.addEventListener('custom-created', event => {
            const collapseElement = document.getElementById('custom-created');
            const bsCollapse = new bootstrap.Collapse(collapseElement);
            bsCollapse.show();
        });
    </script>
@endpush
