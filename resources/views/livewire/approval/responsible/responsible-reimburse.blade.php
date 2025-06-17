@section('title', 'Reimburse')

<div>
    <div class="offcanvas offcanvas-end w-50" data-bs-scroll="true" tabindex="-1" id="offCanvasForm"
        aria-labelledby="offCanvasFormLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offCanvasFormLabel">Reimburse Form</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form wire:submit.prevent='save'>
                <div class="mb-3">
                    <label class="form-label">Subject:</label>
                    <input wire:model='subject' class="form-control form-control-sm" type="text"
                        placeholder="Subject of Permission">
                </div>
                <div class="mb-3 form-floating">
                    <textarea class="form-control" wire:model='description' placeholder="Description" id="floatingTextarea2"></textarea>
                    <label for="floatingTextarea2">Description</label>
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
                        @foreach ($reimburseRules as $item)
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
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reimburses as $item)
                        <tr>
                            <td>{{ $item->subject }}</td>
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
                            <td>{{ $item->total }}</td>
                            <td>
                                <div class="d-flex gap-2 justify-content-center align-items-center">

                                    <a role="button" href="reimburse-responsible/{{ $item->id }}" wire:navigate>
                                        <i class="fa-solid fa-folder-plus"></i>
                                    </a>
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
