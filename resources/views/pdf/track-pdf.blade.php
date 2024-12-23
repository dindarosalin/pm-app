<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Expense Budget Project</title>

    <style>
    /* body { */
        /* pake path absolut untuk masukin gambar berguna untuk menemukan file aset dalam operasi server-side.*/
    /* background-image: url('{{ public_path('img/logo-bg.png') }}'); 
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-color: rgba(255, 255, 255, 0.6);
    } */

    .w-half {
        width: 50%;
    }
    
    .w-full {
        width: 100%;
    }

    table {
        width: 100%;
        margin-bottom: 10px;
        border-spacing: 0;
    }


    thead th {
        background-color: #4CAF50;
        color: white
        border: 1px white;
    }

    tbody td{
        border: 1px black; 
    }

    .text-style {
        padding: 8px;
        text-align: center;
    }

    p {
        text-align: right;
        font-weight: 300;
    }

    .total {
    font-weight: bold;
    }

    </style>
</head>

<body>
    <table class="w-full">
        <td class="w-half">
            <img src="{{ public_path('img/Full-namelogo.png') }}" alt="plan" width="200">
        </td>
        <td class="w-half">
            <p>Budget Plan Project : {{ $projectName }}</p>
        </td>
    </table>

    <table>
        <thead>
            <tr>
                <th class="text-style color-column">Kategori</th>
                <th class="text-style color-column">Sub Kategori</th>
                <th class="text-style color-column">Nama</th>
                <th class="text-style color-column">UOM</th>
                <th class="text-style color-column">Kuantitas</th>
                <th class="text-style color-column">Harga Satuan</th>
                <th class="text-style color-column">Total per Item</th>
            </tr>
        </thead>
        <tbody>
            @php
                $mergeCategory = '';
                $mergeSubCategory = '';
                $categoryRowspan = [];
                $subCategoryRowspan = [];
            @endphp

            @foreach($tracks as $track)
                @php
                    if ($mergeCategory != $track->category_name) {
                        $mergeCategory = $track->category_name;
                        $categoryRowspan[$mergeCategory] = $tracks->where('category_name', $mergeCategory)->count();
                    }
                @endphp
                @php
                    if ($mergeSubCategory != $track->sub_category_name) {
                        $mergeSubCategory = $track->sub_category_name;
                        $subCategoryRowspan[$mergeSubCategory] = $tracks->where('sub_category_name', $mergeSubCategory)->count();
                    }
                @endphp
                <tr>

                    @if ($categoryRowspan[$track->category_name] > 0)
                        <td rowspan="{{ $categoryRowspan[$track->category_name] }}">
                            {{ $track->category_name }}
                        </td>
                        @php
                            $categoryRowspan[$track->category_name] = 0;
                        @endphp 
                    @endif
                    @if ($subCategoryRowspan[$track->sub_category_name] > 0)
                        <td rowspan="{{ $subCategoryRowspan[$track->sub_category_name] }}">
                            {{ $track->sub_category_name }}
                        </td>
                        @php
                            $subCategoryRowspan[$track->sub_category_name] = 0;
                        @endphp 
                    @endif
                    {{-- <td class="text-style">{{ $track->category_name }}</td> --}}
                    {{-- <td class="text-style">{{ $track->sub_category_name }}</td> --}}
                    <td class="text-style">{{ $track->name }}</td>
                    <td class="text-style">{{ $track->uom }}</td>
                    <td class="text-style">{{ $track->quantity }}</td>
                    <td class="text-style">{{ number_format($track->unit_price, 2) }}</td>
                    <td class="text-style">{{ number_format($track->total_per_item, 2) }}</td>
                </tr>
            @endforeach
            <tr class="total text-style">
                <td colspan="6">Total Expense</td>
                <td>{{ number_format($total_all, 2) }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
   
    

    

