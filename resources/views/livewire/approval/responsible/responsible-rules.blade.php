@section('title', 'Upload Rules')

<div>
    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offCanvasForm"
        aria-labelledby="offCanvasFormLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offCanvasFormLabel">Upload Rules</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form wire:submit.prevent='save'>
                <div class="mb-3">
                    <select class="form-select form-select-sm" wire:model='approvalId'>
                        <option value="">Select Approval Type</option>
                        @foreach ($approvalTypes as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="formFileSm" class="form-label">Upload Rule File</label>
                    <input class="form-control form-control-sm" id="formFileSm" type="file"
                        wire:model.defer='newAttachment' accept="application/pdf">
                    <span wire:loading wire:target='newAttachment'>Uploading...</span>
                </div>
                <button type="submit" class="btn btn-sm btn-primary">Save</button>
            </form>

        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <p>List of Approval Rules</p>
                <button class="btn btn-sm btn-outline-primary" wire:click="$dispatch('show-offcanvas')">
                    <span class="fa fa-plus"></span>
                </button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Approval Type</th>
                        <th>File</th>
                        <th>Last Update</th>
                        <th>Uploaded By</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rules as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->approval_name }}</td>
                            <td>
                                <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="text-primary">
                                    {{ basename($item->file_name) }}
                                </a>
                            </td>
                            <td>
                                {{ $item->last_updated }}
                            </td>
                            <td>{{ $item->creator_name }}</td>
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
        window.addEventListener('close-offcanvas-rules', event => {
            const offcanvas = new bootstrap.Offcanvas('#offCanvasForm');
            offcanvas.hide();
        });
    </script>
@endpush
