@section('title', 'Task Flags')
<div>
    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offCanvasFormFlag"
        aria-labelledby="offCanvasFormFlagLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offCanvasFormFlagLabel">Form Task Flags</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form wire:submit='save'>
                <div class="mb-3">
                    <label class="form-label">Flag Name:</label>
                    <input wire:model='flagName' class="form-control form-control-sm" type="text"
                        placeholder="Flag Name">
                </div>
                <div class="mb-3">
                    <label class="form-label">Flag Code:</label>
                    <input wire:model='flagCode' class="form-control form-control-sm" type="text"
                        placeholder="Flag Code">
                </div>
                <button type="submit" class="btn btn-sm btn-primary">Save</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center my-2">
                <p>List of Task Flag</p>
                <button class="btn btn-sm btn-outline-primary" wire:click="$dispatch('show-offcanvas-flag')">
                    <span class="fa fa-plus"></span>
                    Create new flag
                </button>
            </div>
        </div>
        <div class="table-responsive card-body">
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Flag Name</th>
                        <th>Flag Code</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($taskFlags as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->flag_name }}</td>
                            <td>{{ $item->flag_code }}</td>
                            <td>
                                <div class="d-flex gap-2 align-items-center">

                                    <!-- Edit icon -->
                                    <p role="button" wire:click='edit({{ $item->id }})'class="text-warning m-0 p-0"
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
        window.addEventListener('show-offcanvas-flag', event => {
            const offcanvas = new bootstrap.Offcanvas('#offCanvasFormFlag');
            offcanvas.show();
        });
    </script>
@endpush
