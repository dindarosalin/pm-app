@section('title', 'Absence Detail')
<div>
    <div class="card border rounded p-3">
        <h5 class="mb-3">Detail Absence</h5>

        <div class="card-body">
            <div class="row mb-2 gap-2">
                <div class="col border p-2 rounded">
                    <strong>ID:</strong> {{ $absenceDetail->id }}
                </div>
                <div class="col border p-2 rounded">
                    <strong>User ID:</strong> {{ $absenceDetail->user_name }}
                </div>
            </div>

            <div class="row mb-2 gap-2">
                <div class="col border p-2 rounded">
                    <strong>Subject:</strong> {{ $absenceDetail->subject_name }}
                </div>
                <div class="col border p-2 rounded">
                    <strong>Approval Type:</strong> {{ $absenceDetail->approval_name }}
                </div>
                <div class="col border p-2 rounded">
                    <strong>Status:</strong> <span
                        class="badge
                                @switch($absenceDetail->status_id)
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
                                @endswitch ">{{ $absenceDetail->status_name }}
                    </span>
                </div>
                <div class="col border p-2 rounded">
                    <strong>Last Updated:</strong> {{ $absenceDetail->last_updated }}
                </div>
            </div>

            <div class="row mb-2 ">
                <div class="col border p-2 rounded">
                    <strong>Absence Detail:</strong> {{ $absenceDetail->absence_detail }}
                </div>
            </div>

            <div class="row mb-2 gap-2">
                <div class="col border p-2 rounded">
                    <strong>Start Date:</strong> {{ $absenceDetail->start_date }}
                </div>
                <div class="col border p-2 rounded">
                    <strong>End Date:</strong> {{ $absenceDetail->end_date }}
                </div>
                <div class="col border p-2 rounded">
                    <strong>Total Days:</strong> {{ $absenceDetail->total_days }}
                </div>
                <div class="col border p-2 rounded">
                    <strong>Submission Date:</strong> {{ $absenceDetail->submission_date }}
                </div>
            </div>

            <div class="row mb-2 gap-2">
                <div class="col border p-2 rounded">
                    <strong>Emergency Contact:</strong> {{ $absenceDetail->emergency_contact }}
                </div>
                <div class="col border p-2 rounded">
                    <strong>Relationship:</strong> {{ $absenceDetail->relationship_emergency_contact }}
                </div>
            </div>

            <div class="row mb-2 gap-2">
                <div class="col border p-2 rounded">
                    <strong>Delegation:</strong> {{ $absenceDetail->delegation }}
                </div>
                <div class="col border p-2 rounded">
                    <strong>Delegation Detail:</strong> {{ $absenceDetail->delegation_detail }}
                </div>
            </div>
            <div class="row mb-2 ">
                <div class="col border p-2 rounded">
                    <strong>Note:</strong> {{ $absenceDetail->note  }}
                </div>
            </div>
            <div class="row border p-2 rounded">
                <strong>File:</strong>
                <a href="{{ asset('storage/' . $absenceDetail->file_path) }}" target="_blank">
                    {{ $absenceDetail->file_name }}
                </a>
            </div>
        </div>
    </div>

    <div class="card border rounded p-3">
        <div class="card-body">
            <form wire:submit='updateAbsence'>
                <div class="mb-3">
                <div class="mb-3 form-floating">
                    <textarea class="form-control" wire:model='note' placeholder="Note" id="floatingTextarea2"></textarea>
                    <label for="floatingTextarea2">Note</label>
                </div>

                <button type="submit" class="btn btn-sm btn-primary">Save</button>
            </form>
        </div>

    </div>
</div>
