@section('title', 'Project Procurement')

<div>

    <div class="offcanvas offcanvas-end w-50" data-bs-scroll="true" tabindex="-1" id="offCanvasForm"
        aria-labelledby="offCanvasFormLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offCanvasFormLabel">Project Form</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <p>Lorem ipsum dolor sit amet consectetur adipiscing elit. Consectetur adipiscing elit quisque faucibus ex
                sapien vitae. Ex sapien vitae pellentesque sem placerat in id. Placerat in id cursus mi pretium tellus
                duis.</p>
            <form wire:submit.prevent='save'>
                {{-- SECTION 1 FOR RAB --}}
                <div class="mb-3">
                    <label class="form-label">Project Name:</label>
                    <input wire:model='projectName' class="form-control form-control-sm" type="text"
                        placeholder="Project Name">
                </div>

                <div class="mb-3 form-floating">
                    <textarea class="form-control" wire:model='description' placeholder="Description" id="floatingTextarea2"></textarea>
                    <label for="floatingTextarea2">Description</label>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Client Name:</label>
                        <input wire:model='client' class="form-control form-control-sm" type="text"
                            placeholder="Client Name">
                    </div>
                    <div class="col">
                        <label class="form-label">Select Accountable:</label>
                        <select class="form-select form-select-sm" wire:model='accountable'>
                            <option value="">UOM</option>
                            @foreach ($accountableList as $item)
                                <option value="{{ $item->user_id }}">{{ $item->user_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Budget:</label>
                    <input wire:model='budget' class="form-control form-control-sm" type="number" placeholder="Budget">
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Start Date Estimaton:</label>
                        <input wire:model='startDateEst' class="form-control form-control-sm" type="date"
                            placeholder="Start Date Estimaton">
                    </div>
                    <div class="col">
                        <label class="form-label">End Date Estimaton:</label>
                        <input wire:model='endDateEst' class="form-control form-control-sm" type="date"
                            placeholder="End Date Estimaton">
                    </div>
                </div>
                <button type="submit" class="btn btn-sm btn-primary">Save</button>
            </form>
        </div>
    </div>


    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p>List of Project Procurement</p>
                </div>
                <div>
                    <ul class="d-flex gap-2">
                        <li>
                            View Rules For This Approval:
                        </li>
                        @foreach ($rules as $item)
                            <li>
                                <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank"
                                    class="text-primary">
                                    {{ $item->file_name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <button class="btn btn-sm btn-outline-primary" wire:click="$dispatch('show-offcanvas')">
                    <span class="fa fa-plus"></span>
                </button>

            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Client</th>
                        <th>Submitted Date</th>
                        <th>Status</th>
                        <th>Last Update</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($projects as $item)
                        <tr>
                            <td>{{ $item->project_name }}</td>
                            <td>{{ $item->client }}</td>
                            <td>{{ $item->submission_date }}</td>
                            <td>
                                <span
                                        class="badge
                                @switch($item->status_id)
                                    @case('1')
                                        text-bg-primary
                                        @break
                                    @case('2')
                                        text-bg-info
                                        @break
                                    @case('3')
                                        text-bg-warning
                                        @break
                                    @case('4')
                                        text-bg-success
                                        @break
                                    @case('5')
                                        text-bg-danger
                                        @break
                                @endswitch ">{{ $item->status_name }}
                            </td>
                            <td>{{ $item->last_updated }}</td>
                            <td>
                                <div class="d-flex gap-2 justify-content-center align-items-center">
                                    <!-- Edit icon -->
                                    <p role="button"
                                        wire:click='edit({{ $item->id }})'class="text-warning m-0 p-0"
                                        style="cursor: pointer;">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </p>

                                    <!-- Delete icon -->
                                    <p role="button" wire:click="alertConfirm({{ $item->id }})"
                                        class="text-danger m-0 p-0" style="cursor: pointer;">
                                        <i class="fa-solid fa-trash"></i>
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        window.addEventListener('show-offcanvas', event => {
            const offcanvas = new bootstrap.Offcanvas('#offCanvasForm');
            offcanvas.show();
        });
        window.addEventListener('close-offcanvas', event => {
            const offcanvas = new bootstrap.Offcanvas('#offCanvasForm');
            offcanvas.hide();
        });
    </script>
@endpush
