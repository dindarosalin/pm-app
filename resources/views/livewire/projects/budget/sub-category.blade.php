<div>
    <div class="d-flex justify-content-end">
        <button wire:click='btnSubCategory_Clicked' class="btn btn-sm btn-success mb-3 mx-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#createPlan" aria-controls="createPlan">
            Create Sub Category
        </button>
        <button wire:click='plan' class="btn btn-sm btn-primary mb-3 mx-2" type="button" data-bs-toggle="offcanvas">
            Plan
        </button>
        <button wire:click='track' class="btn btn-sm btn-primary mb-3 mx-2" type="button" data-bs-toggle="offcanvas">
            Expense
        </button>
    </div>

    <!--FORM OFFCANVAS-->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="subCategoryForm" aria-labelledby="createSubCategoryLabel">
        <div class="offcanvas-header">
            <h5 id="subCategoryFormLabel">Buat Sub Kategori</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">
            <form wire:submit.prevent="store">
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select wire:model="category_id" class="form-select form-select-sm mb-3" id="category_id"
                        aria-label="Default select example" required>
                        <option value="" selected>Pilih Kategori</option>
                        @foreach ($categories as $category)
                            <option wire:key='{{ $category->id }}' value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>  
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Sub kategori</label>
                    <input type="text" wire:model="name" class="form-control form-control-sm" id="name" required>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
                <div wire:loading>
                    Saving Created...
                </div>                 
            </form>
        </div>
    </div>


    <div class="card p-1 table-responsive">
        <table id="subcategory-table" class="table table-striped table-hover table-sm" style="width: 100%">
            <thead class="text-success fw-medium">
                <tr>
                    <th class="fw-medium text-center">No</th>
                    <th class="fw-medium text-center">Sub Kategori</th>
                    <th class="fw-medium text-center">Kategori</th>
                    <th class="fw-medium text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($subcategories as $subcategory)
                    <tr>
                        <td class="text-center">{{ $subcategory->id}}</td>
                        <td class="text-center">{{ $subcategory->name}}</td>
                        <td class="text-center">{{ $subcategory->category_name}}</td>
                        <td>
                            <button wire:click='edit({{ $subcategory->id }})' class="btn btn-sm text-warning col">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path
                                        d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                                </svg>
                            </button>
                        </td>
                        <td>
                            <button wire:confirm="Are you sure want to delete this post?" 
                                    wire:click='delete({{ $subcategory->id }})' class="btn btn-sm text-danger col">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path
                                            d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                        <path
                                            d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                    </svg>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
{{-- FOR OFFCANVAS --}}
    <script>
        window.addEventListener('show-create-offcanvas', event => {
            const offcanvas = new bootstrap.Offcanvas('#subCategoryForm');
            offcanvas.show();
        });

        window.addEventListener('show-edit-offcanvas', event => {
            const offcanvas = new bootstrap.Offcanvas('#subCategoryForm');
            offcanvas.show();
        });
        window.addEventListener('alert', event => {
            alert(event.detail.message);
        });
    </script>
@endpush