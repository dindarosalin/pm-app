@section('title', 'Reimburse Details')

<div>
    <div class="card">
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
                        {{-- <th>Action</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @if (!$data)
                        <p>Tida ada data</p>
                    @else
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->description }}</td>
                                <td>{{ $item->uom }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->item_price }}</td>
                                <td>{{ $item->total_item_price }}</td>

                            </tr>
                        @endforeach
                    @endif

                </tbody>
            </table>
        </div>
    </div>

    <div class="card border rounded p-3">
        <div class="card-body">
            <form>

                <div class="mb-3 form-floating">
                    <textarea class="form-control" wire:model='note' placeholder="Note" id="floatingTextarea2"></textarea>
                    <label for="floatingTextarea2">Note</label>
                </div>

                <button type="submit" class="btn btn-sm btn-primary">Save</button>
            </form>
        </div>

    </div>
</div>
