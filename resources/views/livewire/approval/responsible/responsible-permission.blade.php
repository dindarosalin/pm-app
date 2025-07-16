@section('title', 'Permission')

<div>
    <div wire:ignore.self class="offcanvas offcanvas-end w-50" data-bs-scroll="true" tabindex="-1" id="offCanvasForm"
        aria-labelledby="offCanvasFormLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offCanvasFormLabel">Permission Form</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            {{-- <button wire:click="btnClose_Offcanvas" type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button> --}}
        </div>

        <div class="offcanvas-body">
            <form wire:submit.prevent='save'>
                <div class="mb-3">
                    <select class="form-select form-select-sm" wire:model='subject'>
                        <option value="">Select Subject</option>
                        @foreach ($subjectList as $item)
                            <option wire:key='{{ $item->id }}' value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>

                @if ($accountableList)
                    <div class="mb-3">
                        <select class="form-select form-select-sm" wire:model='accountable'>
                            <option value="">Select Accountable (Tujuan)</option>
                            @foreach ($accountableList as $item)
                                <option wire:key='{{ $item['id'] }}' value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                    </div> 
                @endif
                
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
                </div>

                <div class="mb-3 row">
                    <div class="col">
                        <label class="form-label">Emergency Contact:</label>
                        <input wire:model='emergencyContact' class="form-control form-control-sm" type="number"
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
                    <label for="formFileSm" class="form-label">Upload File</label>
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
                            <td>{{ $item->subject_name }}</td>
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
