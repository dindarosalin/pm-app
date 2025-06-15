@section('title', 'Categories')
<div>
    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offCanvasFormTaskCategory"
        aria-labelledby="offCanvasFormTaskCategoryLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offCanvasFormTaskCategoryLabel">Form Task Categories</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form wire:submit='save'>
                <div class="mb-3">
                    <label class="form-label">Status Name:</label>
                    <input wire:model='categoryName' class="form-control form-control-sm" type="text"
                        placeholder="Status Name">
                </div>
                <div class="mb-3">
                    <label class="form-label">Code:</label>
                    <input wire:model='categoryCode' class="form-control form-control-sm" type="text"
                        placeholder="Status Code">
                </div>
                <button type="submit" class="btn btn-sm btn-primary">Save</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center my-2">
                <p>List of Task Category</p>
                <button class="btn btn-sm btn-outline-primary" wire:click="$dispatch('show-offcanvas-category')">
                    <span class="fa fa-plus"></span>
                    Create new task category
                </button>
            </div>
        </div>
        <div class="table-responsive card-body">
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Status Name</th>
                        <th>Code Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($taskCategories as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->category_name }}</td>
                            <td>{{ $item->category_code }}</td>
                            <td>
                                <div class="d-flex gap-2 align-items-center">

                                    <p role="button" wire:click='edit({{ $item->id }})'class="text-warning m-0 p-0"
                                        style="cursor: pointer;">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </p>

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
        window.addEventListener('show-offcanvas-category', event => {
            const offcanvas = new bootstrap.Offcanvas('#offCanvasFormTaskCategory');
            offcanvas.show();
        });
    </script>
@endpush
