@section('title', 'Project Statuses')
<div>
    <div class="offcanvas offcanvas-end"  data-bs-scroll="true" tabindex="-1" id="offCanvasFormProject" aria-labelledby="offCanvasFormProjectLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offCanvasFormProjectLabel">Form Project Statuses</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form wire:submit='save'>
                <div class="mb-3">
                    <label class="form-label">Status Name:</label>
                    <input wire:model='statusName' class="form-control form-control-sm" type="text" placeholder="Status Name">
                </div>
                <div class="mb-3">
                    <label class="form-label">Status Code:</label>
                    <input wire:model='statusCode' class="form-control form-control-sm" type="text" placeholder="Status Code">
                </div>
                <button type="submit" class="btn btn-sm btn-primary">Save</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center my-2">
            <p>List of Project Status</p>
            <button class="btn btn-sm btn-outline-primary" wire:click="$dispatch('show-offcanvas-project')">
                <span class="fa fa-plus"></span>
                Create new project status
            </button>
        </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Status Name</th>
                    <th>Code Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projectStatuses as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->project_status }}</td>
                    <td>{{ $item->code_status }}</td>
                    <td>
                        <div class="d-flex gap-2 align-items-center">

                            <!-- Edit icon -->
                            <button class="btn btn-outline-warning btn-sm"  wire:click='edit({{ $item->id }})'>
                                <p class="m-0 p-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                                    </svg>
                                </p>
                            </button>

                            <!-- Delete icon -->
                            <button class="btn btn-outline-danger btn-sm" wire:click="alertConfirm({{ $item->id }})">
                                <p class="m-0 p-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                    </svg>
                                </p>
                            </button>
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
        window.addEventListener('show-offcanvas-project', event => {
            const offcanvas = new bootstrap.Offcanvas('#offCanvasFormProject');
            offcanvas.show();
        });
    </script>
@endpush
