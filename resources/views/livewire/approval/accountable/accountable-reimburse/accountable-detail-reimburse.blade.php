@section('title', 'Reimburse Details')

<div>
    @livewire('approval.responsible.responsible-reimburse-detail', ['reimburseId' => $reimburseId])

    <div class="card border rounded p-3">
        <div class="card-body">
            <form wire:submit='updateReimburse'>
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

                <button type="submit" class="btn btn-sm btn-primary">Save</button>
            </form>
        </div>

    </div>
</div>
