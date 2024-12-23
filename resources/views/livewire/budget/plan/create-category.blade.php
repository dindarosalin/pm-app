{{-- <div> --}}
    {{-- <div class="d-flex justify-content-end">
        <button id="createButton" class="btn btn-sm btn-success mb-3 mx-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#createCategory" aria-controls="createCategory">
            Create Category
        </button>
        <button wire:navigate href="/budget/subcategory" class="btn btn-sm btn-primary mb-3 mx-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#createCategory" aria-controls="createCategory">
            Back
        </button>
    </div> --}}

    {{-- <div class="offcanvas offcanvas-end" tabindex="-1" id="createCategory" aria-labelledby="createCategoryLabel">
        <div class="offcanvas-header">
            <h5 id="createCategoryLabel">Buat Kategori</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
      <!--CATEGORY-->
        <div class="offcanvas-body">
            <form wire:submit.prevent="storeCategory" id="categoryForm">
                <div class="mb-3">
                    <label for="categoryName" class="form-label">Kategori</label>
                    <input type="text" wire:model="categoryName" class="form-control form-control-sm" id="categoryName" required>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div> --}}

    {{-- <div class="card p-1 table-responsive">
        <table id="subcategory-table" class="table table-striped table-hover table-sm" style="width: 100%">
            <thead class="text-success fw-medium">
                <tr>
                    <th class="fw-medium text-center">No</th>
                    <th class="fw-medium text-center">Kategori</th>
                    <th class="fw-medium text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td class="text-center">{{ $category->id}}</td>
                        <td class="text-center">{{ $category->name}}</td>
                        <td class="justify-content-between my-auto d-flex align-items-center">
                            <button wire:click='edit({{ $category->id }})' class="m-1 btn btn-warning text-white btn-sm" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path
                                        d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                                </svg>
                            </button>
                            <button wire:click="delete({{ $category->id }})" class="btn btn-danger btn-sm m-1">
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
    </div> --}}
    
{{-- </div> --}}


{{-- @push('scripts')
    
@endpush --}}
