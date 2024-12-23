<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Budget Plan Project</title>

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

            @foreach($plans as $plan)
                @php
                    if ($mergeCategory != $plan->category_name) {
                        $mergeCategory = $plan->category_name;
                        $categoryRowspan[$mergeCategory] = $plans->where('category_name', $mergeCategory)->count();
                    }
                @endphp
                @php
                    if ($mergeSubCategory != $plan->sub_category_name) {
                        $mergeSubCategory = $plan->sub_category_name;
                        $subCategoryRowspan[$mergeSubCategory] = $plans->where('sub_category_name', $mergeSubCategory)->count();
                    }
                @endphp
                <tr>

                    @if ($categoryRowspan[$plan->category_name] > 0)
                        <td rowspan="{{ $categoryRowspan[$plan->category_name] }}">
                            {{ $plan->category_name }}
                        </td>
                        @php
                            $categoryRowspan[$plan->category_name] = 0;
                        @endphp 
                    @endif
                    @if ($subCategoryRowspan[$plan->sub_category_name] > 0)
                        <td rowspan="{{ $subCategoryRowspan[$plan->sub_category_name] }}">
                            {{ $plan->sub_category_name }}
                        </td>
                        @php
                            $subCategoryRowspan[$plan->sub_category_name] = 0;
                        @endphp 
                    @endif
                    {{-- <td class="text-style">{{ $plan->category_name }}</td> --}}
                    {{-- <td class="text-style">{{ $plan->sub_category_name }}</td> --}}
                    <td class="text-style">{{ $plan->name }}</td>
                    <td class="text-style">{{ $plan->uom }}</td>
                    <td class="text-style">{{ $plan->quantity }}</td>
                    <td class="text-style">{{ number_format($plan->unit_price, 2) }}</td>
                    <td class="text-style">{{ number_format($plan->total_per_item, 2) }}</td>
                </tr>
            @endforeach
            <tr class="total text-style">
                <td colspan="6">Total Budget Plan</td>
                <td>{{ number_format($total_all, 2) }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
   
    

    

