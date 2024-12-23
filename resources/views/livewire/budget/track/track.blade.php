<div>

    <div class="d-flex justify-content-end">
        <button wire:click="show_create_offcanvas" class="btn btn-sm btn-success mb-3 mx-2" type="button">
            Create Track Expense Project
        </button>
        <button wire:navigate href="/budget/subcategory" class="btn btn-sm btn-primary mb-3 mx-2" type="button" data-bs-toggle="offcanvas">
            View Category
        </button>
    </div>
   
    
    <!-- FORM CREATE BUDGET-->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="createTrackForm" aria-labelledby="createTrackFormabel" data-bs-scroll="true">
        <div class="offcanvas-header">
            <h5 id="createTrackLabel">Buat Tracking Pengeluaran</h5>
            <button wire:click="btnClose_Offcanvas" type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <!--TRACK-->
        <div class="offcanvas-body">
            <form wire:submit.prevent="store">

                <div class="input-group mb-3">
                    <select class="form-select form-select-sm" wire:model="selectCategory" name="categories"
                        id="categories">
                        <option value="">Select Category</option>
                        @foreach ($categories as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-outline-secondary btn-sm" wire:click='loadSubCategory' type="button"
                        id="button-addon2">Pilih</button>
                </div>
                <select class="form-select form-select-sm mb-2" wire:model="selectSubCategory" name="sub_categories"
                    id="sub_categories">
                    <option value="">Select Sub Category</option>
                    @foreach ($sub_categories as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                    @endforeach
                </select>

                {{-- CATEGORY --}}
                {{-- <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select wire:model.live="categoryId" class="form-select form-select-sm mb-3" id="category" name="category" aria-label="Default select example" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div> --}}

                {{-- SUB CATEGORY --}}
                {{-- <select wire:model.live="sub_category_id" name="sub_category" id="sub_category" class="form-select form-select-sm mb-3">
                    @foreach ($sub_categories as $subcategory)
                        <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                    @endforeach
                </select> --}}
                
                {{-- FORM TRACK --}}
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" wire:model="name" class="form-control form-control-sm" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">UOM</label>
                    <input type="text" wire:model="uom" class="form-control form-control-sm" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kuantitas</label>
                    <input type="number" wire:model="quantity" class="form-control form-control-sm" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Harga Satuan</label>
                    <input type="number" wire:model="unit_price" class="form-control form-control-sm" required>
                </div>
                {{-- <div class="mb-3">
                    <label class="form-label">Tanggal Pengeluaran</label>
                    <input type="date" wire:model="timestamp" class="form-control form-control-sm" required>
                </div> --}}
                {{-- <div class="mb-3">
                    <label class="form-label">Total per Item</label>
                    <input type="number" wire:model="total_per_item" class="form-control form-control-sm" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Total</label>
                    <input type="number" wire:model="total_all" class="form-control form-control-sm" readonly>
                </div> --}}
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>


    <div class="card p-1 table-responsive">
        {{-- FILTER --}}
        {{-- <div class="card">
            <div class="card-header row">
                <div class="m-2 text-start d-flex gap-2">
                    <div class="col">
                        <label for="timeFrame" class="form-label">Jangka Waktu:</label>
                        <select wire:model.live="timeFrame" id="timeFrame" class="form-select form-select-sm">
                            <option value="all">All</option>
                            <option value="daily">Today</option>
                            <option value="weekly">This Week</option>
                            <option value="monthly">This Month</option>
                            <option value="yearly">This Year</option>
                        </select>
                    </div>
                    <div class="col">
                        <label class="form-label">Filter Kategori:</label>
                        <select wire:model.live="filters.category_id" class="form-select form-select-sm">
                            <option value="">Pilih Kategori</option>
                            @foreach ($categories as $item)
                                <option wire:key='{{ $item->id }}' value="{{ $item->name }}">
                                    {{ $item->name }}
                                </option>                    
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <label for="" class="form-label">Search</label>
                        <input type="text" wire:model.live="search" class="form-control form-control-sm" placeholder="Search Track..." />
                    </div>
                    <div class="col align-self-end">
                        <button wire:click="resetFilter" class="btn btn-outline-success btn-outline btn-sm">Reset Filter</button>
                    </div>
                </div>
            </div>
        </div> --}}
        

        <table id="project-table" class="table table-striped table-hover table-sm" style="width:100%">
        
            {{-- tabel --}}
            <thead class="text-success fw-medium">
                <tr>
                    <th class="fw-medium text-center" rowspan="2">Kategori</th>
                    <th class="fw-medium text-center" rowspan="2">Sub Kategori</th>
                    <th class="fw-medium text-center" rowspan="2">Nama</th>
                    <th class="fw-medium text-center" rowspan="2">UOM</th>
                    <th class="fw-medium text-center" rowspan="2">Kuantitas</th>
                    <th class="fw-medium text-center" rowspan="2">Harga Satuan</th>
                    <th class="fw-medium text-center" colspan="2">Anggaran Dana</th>
                    <th class="fw-medium text-center" rowspan="2">Tanggal Pengeluaran</th>
                    <th class="fw-medium text-center" rowspan="2">Action</th>
                </tr>
                <tr>
                    <th class="fw-medium text-center">Total per Item</th>
                    <th class="fw-medium text-center">Total</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $mergeCategory = null;
                    $mergeBudget = null;
                    $mergeSubCat = null;
                @endphp
                
                    {{-- @foreach ($plans as $plan) --}}
                    @foreach ($tracks as $index => $track)
                        <tr wire:key='{{ $track->id }}'>
        
                            {{-- for automatically merge --}}
                            @if ($track->category_id != $mergeCategory)
                                {{-- if category now different with past category --}}
                                <td class="text-center" rowspan="{{ $tracks->where('category_id', $track->category_id)->count() }}">
                                    {{ $track->category_name }}
                                </td>
                                @php
                                    $mergeCategory = $track->category_id; //store category for compare next store
                                @endphp   
                            @endif

                            @if ($track->sub_category_id != $mergeSubCat)
                            {{-- if category now different with past category --}}
                            <td class="text-center" rowspan="{{ $tracks->where('sub_category_id', $track->sub_category_id)->count() }}">
                                {{ $track->sub_category_name }}
                            </td>
                            @php
                                $mergeSubCat = $track->sub_category_id; //store category for compare next store
                            @endphp   
                        @endif
                            {{-- <td class="text-center">{{ $track->category->name ?? $track->category_name }}</td> --}}
                            {{-- <td class="text-center">{{ $track->sub_category_name ?? $track->sub_category_name }}</td>                            --}}
                            <td class="text-center">{{ $track->name }}</td>
                            <td class="text-center">{{ $track->uom }}</td>
                            <td class="text-center">{{ $track->quantity }}</td>
                            <td class="text-center">{{ number_format ($track->unit_price, 0) }}</td>
                            <td class="text-center">{{ number_format($track->total_per_item, 0) }}</td>

                            @if ($track->category_id != $mergeBudget)
                                <td class="text-center" rowspan="{{ $tracks->where('category_id', $track->category_id)->count() }}">
                                    {{ number_format($totalByCategory[$track->category_id]->total_all ?? 0) }}
                                    {{-- {{$totalByCategory}} --}}
                                    
                                </td>
                                @php
                                    $mergeBudget = $track->category_id;
                                @endphp
                            @endif
                            <td class="text-center">{{ $track->created_at->format('Y-m-d') }}</td>
                            <td>
                                <button wire:click='edit({{$track->id}})' class="btn btn-sm text-warning col">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                        <path
                                            d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                                    </svg>
                                </button>
                            </td>
                            <td>
                                <button wire:confirm="Are you sure want to delete this post?" 
                                        wire:click='delete({{ $track->id }})' class="btn btn-sm text-danger col">
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
    // Menangani penampilan offcanvas
    window.addEventListener('show-offcanvas', event => {
        const offcanvasElement = document.getElementById('createTrackForm');
        if (offcanvasElement) {
            const offcanvas = new bootstrap.Offcanvas(offcanvasElement);
            offcanvas.show();
        } else {
            console.error('Offcanvas element not found');
        }
    });

    // window.addEventListener('show-offcanvas', event => {
    //     const offcanvas = new bootstrap.Offcanvas('#createTrackForm');
    //     offcanvas.show();
    // });

    // Menangani penampilan edit offcanvas
    window.addEventListener('show-edit-offcanvas', event => {
        const offcanvasElement = document.getElementById('createTrackForm');
        if (offcanvasElement) {
            const offcanvas = new bootstrap.Offcanvas(offcanvasElement);
            offcanvas.show();
        } else {
            console.error('Offcanvas element not found');
        }
    });

    // window.addEventListener('show-edit-offcanvas', event => {
    //     const offcanvas = new bootstrap.Offcanvas('#createTrackForm');
    //     offcanvas.show();
    // });

    // Menangani alert
    window.addEventListener('alert', event => {
        const { type, message } = event.detail;
        if (type === 'success') {
            alert('Sukses');
        } else if (type === 'error') {
            alert('Gagal');
        } else {
            alert(message); // handle other cases
        }
    });

    // window.addEventListener('alert', event => {
    //     alert(event.detail.message);
    // });
</script>
<script>
    window.addEventListener('alert', event => {
    const { type, message } = event.detail;
    if (type === 'success') {
        alert('Sukses');
    } else if (type === 'error') {
        alert('Gagal');
    } else {
        alert(message); // handle other cases
    }
});
    // window.addEventListener('alert', event => {
    //     const { type, message } = event.detail;
    //     if (type === 'success') {
    //         alert('Sukses');
    //     } else if (type === 'error') {
    //         alert('gagal');
    //     }
    // });
</script>
@endpush
