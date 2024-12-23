@section('title', 'Holidays')
<div>
    <div class="offcanvas offcanvas-end"  data-bs-scroll="true" tabindex="-1" id="offCanvasFormProject" aria-labelledby="offCanvasFormProjectLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offCanvasFormProjectLabel">Form Holiday</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form wire:submit='save'>
                <div class="mb-3">
                    <label class="form-label">Holiday Name:</label>
                    <input wire:model='holidayName' class="form-control form-control-sm mb-2" type="text" placeholder="Holiday Name">
                </div>
                <div class="mb-3">
                    <label class="form-label">Holiday Date:</label>
                    <input wire:model='holidayDate' class="form-control form-control-sm mb-2" type="date" placeholder="Holiday Date">
                </div>
                <div class="form-floating">
                    <textarea wire:model='holidayDescription' class="form-control" placeholder="Leave a comment here" id="floatingTextarea"></textarea>
                    <label for="floatingTextarea">Holiday Description</label>
                </div>
                <div class="form-check form-switch mb-3">
                    <input wire:model='holidayType' class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                    <label class="form-check-label" for="flexSwitchCheckChecked">National Holiday</label>
                  </div>
                <button type="submit" class="btn btn-sm btn-success">Save</button>
            </form>
        </div>
    </div>

    <div class="table-responsive card">
        <div class="d-flex justify-content-between card-header">
            <p>List of Holidays</p>
            <button wire:click="$dispatch('show-form-offcanvas')" class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-plus"></i> New Holiday </button>
        </div>
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($holidays as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->date }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->is_national }}</td>
                    <td>
                        <div class="d-flex gap-2 justify-content-center align-items-center">

                            <!-- Edit icon -->
                            <p role="button" wire:click='edit({{ $item->id }})'class="text-warning m-0 p-0" style="cursor: pointer;">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </p>

                            <!-- Delete icon -->
                            <p role="button"  wire:click="alertConfirm({{ $item->id }})" class="text-danger m-0 p-0" style="cursor: pointer;">
                                <i class="fa-solid fa-trash"></i>
                            </p>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data libur.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{-- {{ $holidays->links() }} --}}
    <!-- pagination -->
    {{-- <div class="row mt-3 justify-content-between">
        <div class="col-auto">
            <p>Menampilkan {{ $holidays->count() }} dari total {{ $holidays->total() }} data.</p>
        </div>
        <div class="col-auto">
            {{ $holidays->links('pagination::bootstrap-5') }}
        </div>
    </div> --}}

</div>

@push('scripts')
    <script>
        window.addEventListener('show-form-offcanvas', event => {
            const offcanvas = new bootstrap.Offcanvas('#offCanvasFormProject');
            offcanvas.show();
        });
    </script>
@endpush

