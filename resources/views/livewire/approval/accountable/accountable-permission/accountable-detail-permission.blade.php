@section('title', 'Permission Detail')

<div>
    <div class="card border rounded p-3">
        <h5 class="mb-3">Detail Permission</h5>

        <div class="card-body">
            <div class="row mb-2 gap-2">
                <div class="col border p-2 rounded">
                    <strong>ID:</strong> {{ $permissionDetail->id }}
                </div>
                <div class="col border p-2 rounded">
                    <strong>User ID:</strong> {{ $permissionDetail->user_name }}
                </div>
            </div>

            <div class="row mb-2 gap-2">
                <div class="col border p-2 rounded">
                    <strong>Subject:</strong> {{ $permissionDetail->subject_name }}
                </div>
                <div class="col border p-2 rounded">
                    <strong>Approval Type:</strong> {{ $permissionDetail->approval_name }}
                </div>
                <div class="col border p-2 rounded">
                    <strong>Status:</strong> <span
                        class="badge
                                @switch($permissionDetail->status_id)
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
                                @endswitch ">{{ $permissionDetail->status_name }}
                    </span>
                </div>
                <div class="col border p-2 rounded">
                    <strong>Last Updated:</strong> {{ $permissionDetail->last_updated }}
                </div>
            </div>

            <div class="row mb-2 ">
                <div class="col border p-2 rounded">
                    <strong>Permission Detail:</strong> {{ $permissionDetail->permission_detail }}
                </div>
            </div>

            <div class="row mb-2 gap-2">
                <div class="col border p-2 rounded">
                    <strong>Start Date:</strong> {{ $permissionDetail->start_date }}
                </div>
                <div class="col border p-2 rounded">
                    <strong>End Date:</strong> {{ $permissionDetail->end_date }}
                </div>
                <div class="col border p-2 rounded">
                    <strong>Total Days:</strong> {{ $permissionDetail->total_days }}
                </div>
                <div class="col border p-2 rounded">
                    <strong>Submission Date:</strong> {{ $permissionDetail->submission_date }}
                </div>
            </div>

            <div class="row mb-2 gap-2">
                <div class="col border p-2 rounded">
                    <strong>Emergency Contact:</strong> {{ $permissionDetail->emergency_contact }}
                </div>
                <div class="col border p-2 rounded">
                    <strong>Relationship:</strong> {{ $permissionDetail->relationship_emergency_contact }}
                </div>
            </div>

            <div class="row mb-2 gap-2">
                <div class="col border p-2 rounded">
                    <strong>Delegation:</strong> {{ $permissionDetail->delegation }}
                </div>
                <div class="col border p-2 rounded">
                    <strong>Delegation Detail:</strong> {{ $permissionDetail->delegation_detail }}
                </div>
            </div>
            <div class="row mb-2 ">
                <div class="col border p-2 rounded">
                    <strong>Note:</strong> {{ $permissionDetail->note  }}
                </div>
            </div>
            <div class="row border p-2 rounded">
                <strong>File:</strong>
                <a href="{{ asset('storage/' . $permissionDetail->file_path) }}" target="_blank">
                    {{ $permissionDetail->file_name }}
                </a>
            </div>
        </div>
    </div>

    <div class="card border rounded p-3">
        <div class="card-body">
            <form wire:submit='updatePermission'>
                <div class="mb-3">
                    <label class="form-label"><strong>Status:</strong></label>
                    <div class="d-flex gap-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" wire:model="statusCode" id="status-review"
                                value="2">
                            <label class="form-check-label badge text-bg-info" for="status-review">
                                On Review
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" wire:model="statusCode" id="status-revision"
                                value="3">
                            <label class="form-check-label badge text-bg-warning" for="status-revision">
                                Need Revision
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" wire:model="statusCode" id="status-approved"
                                value="4">
                            <label class="form-check-label badge text-bg-success" for="status-approved">
                                Approved
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" wire:model="statusCode" id="status-rejected"
                                value="5">
                            <label class="form-check-label badge text-bg-danger" for="status-rejected">
                                Rejected
                            </label>
                        </div>
                    </div>

                </div>

                <div class="mb-3 form-floating">
                    <textarea class="form-control" wire:model='note' placeholder="Note" id="floatingTextarea2"></textarea>
                    <label for="floatingTextarea2">Note</label>
                </div>

                <div class="mb-3 form-floating">
                    <div class="col border p-2 rounded">
                        <strong>Note Consulted: </strong> {{  $permissionDetail->note_consult }}
                    </div>
                </div>
                
                <button type="submit" class="btn btn-sm btn-primary">Save</button>
            
            </form>
            
        </div>

    </div>
</div>
