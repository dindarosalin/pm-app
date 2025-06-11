<div>
    <h1>RAB Detail</h1>
    <table>
        <thead>
            <tr>
                <th>Kebutuhan</th>
                <th>Deskripsi</th>
                <th>UOM</th>
                <th>Kuantitas</th>
                <th>Harga Satuan</th>
                <th>Total Per Item</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($rab as $item)
                <tr>
                    <td>{{ $item->kebutuhan }}</td>
                    <td>{{ $item->deskripsi }}</td>
                    <td>{{ $item->uom }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->unit_per_price }}</td>
                    <td>{{ $item->total_per_item }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
