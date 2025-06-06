@section('title', 'Approval Types')
<div>
    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offCanvasForm"
        aria-labelledby="offCanvasFormLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offCanvasFormLabel">Form Approval Types:</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form wire:submit='save'>
                <div class="mb-3">
                    <label class="form-label">Approval Name:</label>
                    <input wire:model='approvalName' class="form-control form-control-sm" type="text"
                        placeholder="Approval Name">
                </div>
                <div class="mb-3 form-floating">
                    <textarea class="form-control" wire:model='approvalDescription' placeholder="Approval Description"
                        id="floatingTextarea2" style="height: 100px"></textarea>
                    <label for="floatingTextarea2">Approval Desctiption</label>
                </div>
                <button type="submit" class="btn btn-sm btn-primary">Save</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <p>List of Approval Type</p>
                <button class="btn btn-sm btn-outline-primary" wire:click="$dispatch('show-offcanvas')">
                    <span class="fa fa-plus"></span>
                    Create new Approval Type
                </button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($approvals as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->description }}</td>
                            <td>
                                <div class="d-flex gap-2 justify-content-center align-items-center">

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
        window.addEventListener('show-offcanvas', event => {
            const offcanvas = new bootstrap.Offcanvas('#offCanvasForm');
            offcanvas.show();
        });
    </script>
@endpush
