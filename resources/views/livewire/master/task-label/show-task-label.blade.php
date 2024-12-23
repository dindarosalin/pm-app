@section('title', 'Task Label')
<div>
    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offCanvasFormlabel"
        aria-labelledby="offCanvasFormlabelLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offCanvasFormlabelLabel">Form Task Label:</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form wire:submit='save'>
                <div class="mb-3">
                    <label class="form-label">Label Name:</label>
                    <input wire:model='labelName' class="form-control form-control-sm" type="text"
                        placeholder="label Name">
                </div>
                <div class="mb-3">
                    <label class="form-label">Label Name:</label>
                    <input wire:model='labelCode' class="form-control form-control-sm" type="text"
                        placeholder="label Code">
                </div>
                <button type="submit" class="btn btn-sm btn-primary">Save</button>
            </form>
        </div>
    </div>

    <div class="table-responsive card">
        <div class="d-flex justify-content-between">
            <p>List of Task label</p>
            <button class="btn btn-sm btn-outline-primary" wire:click="$dispatch('show-offcanvas-label')">create new
                label</button>
        </div>
        <table class="table table-sm caption-top">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Label Name</th>
                    <th>Label Code</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($labels as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->label_name }}</td>
                        <td>{{ $item->label_code }}</td>
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

@push('scripts')
    <script>
        window.addEventListener('show-offcanvas-label', event => {
            const offcanvas = new bootstrap.Offcanvas('#offCanvasFormlabel');
            offcanvas.show();
        });
    </script>
@endpush
