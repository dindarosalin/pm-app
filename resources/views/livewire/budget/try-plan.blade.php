<div>
    <div class="d-flex justify-content-end">
        <button wire:click="show_create_offcanvas" class="btn btn-sm btn-success mb-3 mx-2" type="button">
            Create Budget Plan Project
        </button>
        <button wire:navigate href="/budget/subcategory" class="btn btn-sm btn-primary mb-3 mx-2" type="button" data-bs-toggle="offcanvas">
            View Category
        </button>
    </div>
   

    <div class="offcanvas offcanvas-end" tabindex="-1" data-bs-scroll="true" id="createBudgetForm">
        <div class="offcanvas-header">
            <h5 id="createBudgetLabel">Buat Rancangan Anggaran</h5>
            <button wire:click="btnClose_Offcanvas" type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">
            <form wire:submit.prevent="store">

                <div class="input-group mb-3">
                    <select class="form-select form-select-sm" wire:model="selectCategory" name="categories"
                        id="categories">
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-outline-secondary btn-sm" wire:click='loadSubCategory' type="button"
                        id="button-addon2">Pilih</button>
                </div>
                <select class="form-select form-select-sm mb-2" wire:model="selectSubCategory" name="sub_categories"
                    id="sub_categories">
                    <option value="">Select Sub Category</option>
                    @foreach ($sub_categories as $subcategory)
                        <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                    @endforeach
                </select>

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
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
    
    <div class="card p-1 table-responsive">
        <div class="card">
            <div class="card-header row">
                    <div class="col">
                        <label for="timeFrame" class="form-label">Jangka Waktu: </label>
                        <select wire:model.live="timeFrame" id="timeFrame" class="form-select form-select-sm">
                            <option value="all">All</option>
                            <option value="daily">Today</option>
                            <option value="weekly">This Week</option>
                            <option value="monthly">This Month</option>
                            <option value="yearly">This Year</option>
                        </select>
                    </div>

                    <div class="col">
                        <label class="form-label">Filter Kategori: </label>
                        <select wire:model.live="filters.category_name"  class="form-select form-select-sm" >
                            <option value="">Pilih Kategori</option>
                            @foreach ($categories as $category)
                                <option wire:key='{{ $category->id }}' value="{{ $category->name }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col">
                        <label for="" class="form-label">Search</label>
                        <input type="text" wire:model.live="search" class="form-control form-control-sm" placeholder="Search Projects..." />
                    </div>

                    <div class="col align-self-end">
                        <button wire:click="resetFilter" class="btn btn-outline-success btn-outline btn-sm">Reset Filter</button>
                    </div>
            </div>
        </div>
        <table id="project-table" class="table table-striped table-hover table-sm" style="width:100%">
            <thead class="text-success fw-medium">
                <tr>

                    <th class="fw-medium" wire:click="sortBy('category_id')">
                        <button class="btn btn-sm fw-medium text-success d-flex gap-1 align-items-center">Kategori
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-up" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5m-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5"/>
                              </svg>
                        </button>
                    </th>
                    <th class="fw-medium" wire:click="sortBy('category_id')">
                        <button class="btn btn-sm fw-medium text-success d-flex gap-1 align-items-center">Kategori
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-up" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5m-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5"/>
                              </svg>
                        </button>
                    </th>

                    {{-- <th class="fw-medium text-center" rowspan="2">Kategori</th> --}}
                    <th class="fw-medium text-center" rowspan="2">Sub Kategori</th>
                    <th class="fw-medium text-center" rowspan="2">Nama</th>
                    <th class="fw-medium text-center" rowspan="2">UOM</th>
                    <th class="fw-medium text-center" rowspan="2">Kuantitas</th>
                    <th class="fw-medium text-center" rowspan="2">Harga Satuan</th>
                    <th class="fw-medium text-center" colspan="2">Anggaran Dana</th>
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

                   
                @endphp
                @foreach ($plans as $index => $plan)
                <tr wire:key='{{ $plan->id }}'>


                    {{-- for automatically merge --}}
                    @if ($plan->category_id != $mergeCategory)
                        {{-- if category now different with past category --}}
                        <td class="text-center" rowspan="{{ $plans->where('category_id', $plan->category_id)->count() }}">
                            {{ $plan->category_name }}
                        </td>
                        @php
                            $mergeCategory = $plan->category_id; //store category for compare next store --}}
                        @endphp  
                     @endif
                    {{-- <td class="text-center">{{ $plan->category->name ?? $plan->category_name }}</td> --}}
                    {{-- <td class="text-center">{{ $plan->sub_category_name ?? $plan->sub_category_name }}</td>                            --}}
                    <td class="text-center">{{ $plan->sub_category_name }}</td>
                    <td class="text-center">{{ $plan->name }}</td>
                    <td class="text-center">{{ $plan->uom }}</td>
                    <td class="text-center">{{ $plan->quantity }}</td>
                    <td class="text-center">{{ number_format ($plan->unit_price, 0) }}</td>
                    <td class="text-center">{{ number_format($plan->total_per_item, 0) }}</td>

                    @if ($plan->category_id != $mergeBudget)
                        <td class="text-center" rowspan="{{ $plans->where('category_id', $plan->category_id)->count() }}">
                            {{ number_format($totalByCategory[$plan->category_id]->total_all ?? 0) }}
                            {{-- {{$totalByCategory}} --}}
                            
                        </td>
                        @php
                            $mergeBudget = $plan->category_id;
                        @endphp
                    @endif
                    <td>
                        <button wire:click='editBudgetPlan({{$plan->id}})' class="btn btn-sm text-warning col">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                <path
                                    d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                            </svg>
                        </button>
                    </td>
                    <td>
                        <button wire:confirm="Are you sure want to delete this post?" 
                                wire:click='delete({{ $plan->id }})' class="btn btn-sm text-danger col">
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

@push('scripts')
    <script>
        // Menangani penampilan offcanvas
        window.addEventListener('show-offcanvas', event => {
            const offcanvasElement = document.getElementById('createBudgetForm');
            if (offcanvasElement) {
                const offcanvas = new bootstrap.Offcanvas(offcanvasElement);
                offcanvas.show();
            } else {
                console.error('Offcanvas element not found');
            }
        });

        window.addEventListener('show-edit-offcanvas', event => {
        const offcanvasElement = document.getElementById('createBudgetForm');
            if (offcanvasElement) {
                const offcanvas = new bootstrap.Offcanvas(offcanvasElement);
                offcanvas.show();
            } else {
                console.error('Offcanvas element not found');
            }
        });

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
        </script>
@endpush
