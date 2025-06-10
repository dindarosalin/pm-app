@section('title', 'Pemission')

<div>
    <div class="offcanvas offcanvas-end w-50" data-bs-scroll="true" tabindex="-1" id="offCanvasForm"
        aria-labelledby="offCanvasFormLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offCanvasFormLabel">Permission Form</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <p>Lorem ipsum dolor sit amet consectetur adipiscing elit. Consectetur adipiscing elit quisque faucibus ex
                sapien vitae. Ex sapien vitae pellentesque sem placerat in id. Placerat in id cursus mi pretium tellus
                duis.</p>
            <form wire:submit.prevent='save'>
                <div class="mb-3">
                    <label class="form-label">Subject:</label>
                    <input wire:model='subject' class="form-control form-control-sm" type="text"
                        placeholder="Subject of Permission">
                </div>

                <div class="mb-3">
                    <select class="form-select form-select-sm" wire:model='accountable'>
                        <option value="">Select Accountable (Tujuan)</option>
                        @foreach ($accountableList as $item)
                            <option value="{{ $item->role_id }}">{{ $item->role_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 form-floating">
                    <textarea class="form-control" wire:model='permDetail' placeholder="Permission Detail" id="floatingTextarea2"></textarea>
                    <label for="floatingTextarea2">Permission Detail</label>
                </div>

                <div class="mb-3 row">
                    <div class="col">
                        <label class="form-label">Start Date:</label>
                        <input wire:model='startDate' class="form-control form-control-sm" type="date"
                            placeholder="Approval Name">
                    </div>

                    <div class="col">
                        <label class="form-label">End Date:</label>
                        <input wire:model='endDate' class="form-control form-control-sm" type="date"
                            placeholder="Approval Name">
                    </div>
                    <div class="col">
                        <label class="form-label">Total Days:</label>
                        <input wire:model='totalDays' class="form-control form-control-sm" type="number" disabled
                            placeholder="Total Days Automaticly">
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col">
                        <label class="form-label">Emergency Contact:</label>
                        <input wire:model='emergencyContact' class="form-control form-control-sm" type="text"
                            placeholder="Place Phone Number">
                    </div>
                    <div class="col">
                        <label class="form-label">Relationship:</label>
                        <input wire:model='relationship' class="form-control form-control-sm" type="text"
                            placeholder="Relationship with contact">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Delegation:</label>
                    <select class="form-select form-select-sm" wire:model='delegation'>
                        <option value="">Choose Delegation Recommendations</option>
                        @foreach ($delegationList as $item)
                            <option value="{{ $item->user_id }}">{{ $item->user_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 form-floating">
                    <textarea class="form-control" wire:model='noteDelegation' placeholder="Approval Description" id="floatingTextarea2"></textarea>
                    <label for="floatingTextarea2">Note For Delegations</label>
                </div>
                <div class="mb-3">
                    <label for="formFileSm" class="form-label">Upload Rule File</label>
                    <input class="form-control form-control-sm" id="formFileSm" type="file" wire:model.defer='file'
                        accept="application/pdf">
                    <span wire:loading wire:target='file'>Uploading...</span>
                </div>
                <button type="submit" class="btn btn-sm btn-primary">Save</button>
            </form>
        </div>
    </div>


    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p>List of Your Permissions</p>
                </div>
                <div>
                    <ul class="d-flex gap-2">
                        <li>
                            View Rules For This Approval:
                        </li>
                        @foreach ($permissionRules as $item)
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
                        <th>Subject</th>
                        <th>Submission Date</th>
                        <th>Status</th>
                        <th>Last Update</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $item)
                        <tr>
                            <td>{{ $item->subject }}</td>
                            <td>{{ $item->submission_date }}</td>
                            <td>{{ $item->status_id }}</td>
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
