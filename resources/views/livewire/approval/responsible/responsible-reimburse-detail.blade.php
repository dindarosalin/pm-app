@section('title', 'Reimburse Detail')

<div>
    <div class="offcanvas offcanvas-end w-50" data-bs-scroll="true" tabindex="-1" id="offCanvasForm"
        aria-labelledby="offCanvasFormLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offCanvasFormLabel">Reimburse Form</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <p>Lorem ipsum dolor sit amet consectetur adipiscing elit. Consectetur adipiscing elit quisque faucibus ex
                sapien vitae. Ex sapien vitae pellentesque sem placerat in id. Placerat in id cursus mi pretium tellus
                duis.</p>
            <form wire:submit.prevent='save'>
                <div class="mb-3 row">
                    <div class="col">
                        <label class="form-label">Item Name:</label>
                        <input wire:model='name' class="form-control form-control-sm" type="text"
                            placeholder="Item Name">
                    </div>
                    <div class="col">
                        <label class="form-label">Select UOM:</label>

                        <select class="form-select form-select-sm" wire:model='uom'>
                            <option value="">Select UOM</option>
                            @foreach ($uoms as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <div class="col">
                        <label class="form-label">Item Price:</label>
                        <input wire:model='iPrice' class="form-control form-control-sm" type="number"
                            placeholder="Price Per Item">
                    </div>
                    <div class="col">
                        <label class="form-label">Quantity:</label>
                        <input wire:model='qty' class="form-control form-control-sm" type="number"
                            placeholder="Quantity">
                    </div>
                </div>

                <div class="mb-3 form-floating">
                    <textarea class="form-control" wire:model='description' placeholder="Description" id="floatingTextarea2"></textarea>
                    <label for="floatingTextarea2">Item Description</label>
                </div>

                <button type="submit" class="btn btn-sm btn-primary">Save</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p>List of <strong>{{ $reimburse->subject }}</strong>  </p>
                </div>
                <div>

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
                        <th>Name</th>
                        <th>Item Description</th>
                        <th>UOM</th>
                        <th>Quantity</th>
                        <th>Item Price</th>
                        <th>Total Price Per Item</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->uom }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->item_price }}</td>
                            <td>{{ $item->total_item_price }}</td>
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
        window.addEventListener('close-offcanvas', event => {
            const offcanvas = new bootstrap.Offcanvas('#offCanvasForm');
            offcanvas.hide();
        });
    </script>
@endpush
