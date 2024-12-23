<div>

    <div class="d-flex justify-content-end">
        <button wire:click='show_create_offcanvas' class="btn btn-sm btn-success mb-3 mx-2" type="button">
            Create Project Budget
        </button>
        <button wire:navigate href="/budget/subcategory" class="btn btn-sm btn-primary mb-3 mx-2" type="button" data-bs-toggle="offcanvas">
            View Category
        </button>
    </div>
   
    
    <!-- FORM CREATE BUDGET-->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="createBudgetForm" aria-labelledby="createBudgetFormabel" data-bs-scroll="true">
        <div class="offcanvas-header">
            <h5 id="createBudgetLabel">Buat Rancangan Anggaran</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <!--PLAN-->
        <div class="offcanvas-body">
            <form wire:submit.prevent="store">

                {{-- CATEGORY --}}
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select wire:model.live="categoryId" class="form-select form-select-sm mb-3" id="category" name="category" aria-label="Default select example" required>
                        @foreach (DB::table('categories')->get() as $category)
                            <option value="{{ $category->id }}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>

                {{-- SUB CATEGORY --}}
                <select wire:model.live="sub_category_id" name="sub_category" id="sub_category" class="form-select form-select-sm mb-3">
                    @foreach (DB::table('sub_categories')->where('category_id', $categoryId)->get() as $subcategory)
                    <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                @endforeach
                </select>
                
                {{-- FORM PLAN --}}
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
        <table id="project-table" class="table table-striped table-hover table-sm" style="width:100%">
            <thead class="text-success fw-medium">
                <tr>
                    <th class="fw-medium text-center" rowspan="2">Kategori</th>
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
                
                    {{-- @foreach ($plans as $plan) --}}
                    @foreach ($plans as $index => $plan)
                        <tr wire:key='{{ $plan->id }}'> 
                            {{-- for automatically merge --}}
                            @if ($plan->category_id != $mergeCategory)
                                {{-- if category now different with past category --}}
                                <td class="text-center" rowspan="{{ $plans->where('category_id', $plan->category_id)->count() }}">
                                    {{ $plan->category_name }}
                                </td>
                                @php
                                    $mergeCategory = $plan->category_id; //store category for compare next store
                                @endphp   
                            @endif
                            {{-- <td class="text-center">{{ $plan->category->name ?? $plan->category_name }}</td> --}}
                            <td class="text-center">{{ $plan->sub_category_name ?? $plan->sub_category_name }}</td>                           
                            <td class="text-center">{{ $plan->name }}</td>
                            <td class="text-center">{{ $plan->uom }}</td>
                            <td class="text-center">{{ $plan->quantity }}</td>
                            <td class="text-center">{{ number_format ($plan->unit_price, 0) }}</td>
                            <td class="text-center">{{ number_format($plan->total_per_item, 0) }}</td>

                            @if ($plan->category_id != $mergeBudget)
                                <td class="text-center" rowspan="{{ $plans->where('category_id', $plan->category_id)->count() }}">
                                    {{ number_format($totalByCategory[$plan->category_id]->total_item, 0) }}
                                </td>
                                @php
                                    $mergeBudget = $plan->category_id;
                                @endphp
                            @endif
                               
                            <td>
                                <button wire:click='editBudgetPLan({{$plan->category_id}})' class="btn btn-sm text-warning col">
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
</div>
@push('scripts')
{{-- FOR OFFCANVAS --}}
<script>
    window.addEventListener('show-offcanvas', event => {
        const offcanvas = new bootstrap.Offcanvas('#createBudgetForm');
        offcanvas.show();
    });

    window.addEventListener('show-edit-offcanvas', event => {
        const offcanvas = new bootstrap.Offcanvas('#createBudgetForm');
        offcanvas.show();
    });
    window.addEventListener('alert', event => {
        alert(event.detail.message);
    });
</script>
<script>
    window.addEventListener('alert', event => {
        const { type, message } = event.detail;
        if (type === 'success') {
            alert('Sukses');
        } else if (type === 'error') {
            alert('gagal');
        }
    });
</script>

{{-- <script>

    $(document).ready(function () {
        /*------------------------------------------

        Country Dropdown Change Event

        --------------------------------------------*/

        $('#category-dropdown').on('change', function () {

            var idCategory = this.value;

            $("#sub-category-dropdown").html('');

            $.ajax({

                url: "{{url('api/fetch-category')}}",

                type: "POST",

                data: {

                    category_id: idCategory,

                    _token: '{{csrf_token()}}'

                },

                dataType: 'json',

                success: function (result) {

                    $('#category-dropdown').html('<option value="">-- Select Category --</option>');

                    $.each(result.states, function (key, value) {

                        $("#category-dropdown").append('<option value="' + value

                            .id + '">' + value.name + '</option>');

                    });

                    $('#sub-category-dropdown').html('<option value="">-- Select Sub Category --</option>');

                }

            });

        });

        /*------------------------------------------

        State Dropdown Change Event

        --------------------------------------------*/

        $('#category-dropdown').on('change', function () {

            var idCategory = this.value;

            $("#sub-category-dropdown").html('');

            $.ajax({

                url: "{{url('api/fetch-subcategories')}}",

                type: "POST",

                data: {

                    sub_category_id: idSubCategory,

                    _token: '{{csrf_token()}}'

                },

                dataType: 'json',

                success: function (res) {

                    $('#sub-category-dropdown').html('<option value="">-- Select Sub Category --</option>');

                    $.each(res.subcategories, function (key, value) {

                        $("#sub-category-dropdown").append('<option value="' + value

                            .id + '">' + value.name + '</option>');

                    });

                }

            });

        });



    });

</script> --}}
{{-- <form wire:submit.prevent="store"> --}}

            {{-- CATEGORY --}}
            {{-- <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select wire:model.live="categoryId" class="form-select form-select-sm mb-3" id="categories" name="categories" aria-label="Default select example" required>
                    <option value="">Pilih Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div> --}}

            {{-- SUB CATEGORY --}}
            {{-- <select name="subCategories" id="subCategories" class="form-select form-select-sm mb-3">
                @if(empty($subcategories))
                    <option value="">Pilih Sub Kategori</option>
                @else
                    @foreach($subcategories as $subcategory)
                        <option value="{{ $subcategory->id }}">
                            {{ $subcategory->name }}
                        </option>
                    @endforeach
                @endif
            </select> --}}
            
            {{-- FORM PLAN --}}
            {{-- <div class="mb-3">
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
            <div class="mb-3">
                <label class="form-label">Total per Item</label>
                <input type="number" wire:model="total_per_item" class="form-control form-control-sm">
            </div>
            <div class="mb-3">
                <label class="form-label">Total</label>
                <input type="number" wire:model="total_all" class="form-control form-control-sm">
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form> --}}




{{-- <script>
    function onChangeSelect(url, id, name) {
        // kirim permintaan AJAX untuk mendapatkan data berdasarkan iD yang dipilih
        $.ajax({
            url: url,
            type: 'GET',
            data: { id: id },
            success: function (data) {
                // kosongkan elemen select dan tambahkan opsi default
                $('#' + name).empty();
                $('#' + name).append('<option value="" selected>Pilih Salah Satu</option>');

                // tambahkan opsi berdasarkan data yang diterima
                $.each(data, function (key, value) {
                    $('#' + name).append('<option value="' + key + '">' + value + '</option>');
                });
            }
        });
    }

    $(function () {
        // ketika kategori dipilih, ambil sub category based on kategory yang dipilih
        $('#category_id').on('change', function () {
            onChangeSelect('{{ route("budget.get.subcategories") }}', $(this).val(), 'sub_category_id');
        });
    });
</script> --}}


{{-- <script>
    $(document).ready(function () {
        // insialisasi offcanvas
        var createBudgetOffcanvas = new bootstrap.Offcanvas(document.getElementById('createBudget'));
        var createBudgetPlanOffcanvas = new bootstrap.Offcanvas(document.getElementById('createPlan'));

        // handle form submission untuk introForm
        $('#introForm').on('submit' function(event) {
            event.preventDefault(); //Prevent default form submission

            // simulate form submission with livewire or ajax
            @this.call('store').then(() => {
                // hide the intro form offcanvas
                createBudgetOffcanvas.hide();

                // show the Bud
            })
        }); 
    });
    // document.addEventListener('livewire:load', function () {
        

        // show the createBudget Form dulu
    //     createBudgetOffcanvas.show()

    //     // listen to button clicks di dalam createbudget Form to open coressponding offcanvas
    //     document.getElementById('openCategory').addEventListener('click', function () {
    //         createBudgetOffcanvas.hide();

    //         // emit/dispatch event to buka off canvas kategori
    //         Livewire.dispatch('openCategoryOffcanvas');
    //     });

    //     document.getElementById('openSubCategory').addEventListener('click', function () {
    //         createBudgetOffcanvas.hide();

    //         // emit/dispatch event to buka off canvas kategori
    //         Livewire.dispatch('openSubCategoryOffcanvas');
    //     });

    //     document.getElementById('openBudgetPlan').addEventListener('click', function () {
    //         createBudgetOffcanvas.hide();
    //         createBudgetPlanOffcanvas.show();
    //     });

    //     // listen to the event to open the budget plan offcanvas
    //     Livewire.on('openBudgetPlanOffcanvas', function () {
    //         createBudgetOffcanvas.show();
    //     });

    //     // handle form submission for budget plan
    //     $(#budgetPlanForm).on('submit', function(event) {
    //         event.preventDefault();
    //         Livewire.dispatch('store'); //dispatch event to call the store method

    //         // Optional: You can hide offcanvas and show alert after successful store
    //         createBudgetPlanOffcanvas.hide();
    //         alert('Rencana Anggaran Project berhasil dibuat!');
    //     });
    // });
</script> --}}

            {{-- // @this.call('store').then(() => {
            //     createBudgetPlanOffcanvas.hide();
            //     alert('Rencana Anggaran Project berhasil dibuat!');
            // }).catch(error => {
            //     console.error('Error:', error);
            // });
         --}}
    







{{-- KODE AWAL --}}
                        {{-- <td class="text-center">{{$plan->category_name ?? ''}}</td>
                        <td class="text-center">{{$plan->sub_category_name}}</td>                           
                        <td class="text-center">{{$plan->name}}</td>
                        <td class="text-center">{{$plan->uom}}</td>
                        <td class="text-center">{{$plan->quantity}}</td>
                        <td class="text-center">{{$plan->unit_price}}</td>
                        <td class="text-center">{{$plan->total_per_item}}</td>
                        <td class="text-center">{{$plan->total_all}}</td> --}}
                        {{-- <td class="justify-content-between my-auto d-flex align-items-center">
    {{-- // $(document).ready(function () {
    //     // Inisialisasi offcanvas instances
    //     var createCategoryOffcanvas = new bootstrap.Offcanvas(document.getElementById('createCategory'));
    //     var createSubCategoryOffcanvas = new bootstrap.Offcanvas(document.getElementById('createSubCate'));
    //     var createBudgetPlanOffcanvas = new bootstrap.Offcanvas(document.getElementById('createBudget'));

    //     // Handle form submission for category
    //     $('#categoryForm').on('submit', function(event) {
    //         event.preventDefault(); // Prevent default form submission

    //         // Simulate form submission with Livewire or AJAX
    //         @this.call('storeCategory').then(() => {
    //         // Hide the category offcanvas
    //         createCategoryOffcanvas.hide();

    //         // Show the subcategory offcanvas
    //         createSubCategoryOffcanvas.show();
    //         }).catch(error => {
    //             console.error('Error:', error);
    //         });
    //     });

    //     $('#subCategoryForm').on('submit', function(event) {
    //         event.preventDefault(); // Prevent default form submission

    //         // Simulate form submission with Livewire or AJAX
    //         @this.call('storeSubCategory').then(() => {
    //         // Hide the category offcanvas
    //         createSubCategoryOffcanvas.hide();

    //         // Show the subcategory offcanvas
    //         createBudgetPlanOffcanvas.show();
    //         }).catch(error => {
    //             console.error('Error:', error);
    //         });
    //     });
    //     $('#budgetPlanForm').on('submit', function(event) {
    //         event.preventDefault();

    //         @this.call('store').then(() => {

    //             createBudgetPlanOffcanvas.hide();

    //             alert('budget plan created successfully!');
    //         }).catch(error => {
    //             console.error('Error:', error);
    //         });
    //     });

    // }); --}}

{{-- <script>
$(document).ready(function(){

    // kategori
    $("#selectCategory").select2({
        placeholder:'Pilih Kategori',
        ajax: {
            url: "{{route('budget.show.plan')}}",
            processResults: function({data}){
                return {
                    results: $.map(data, function(item){
                        return {
                            id: item.id,
                            text: item.name
                        };
                    })
                };
            }
        }
    });
});
</script>    --}}

@endpush










{{-- <button wire:click="getProjectById({{ $plan->id }})" class="m-1 btn btn-primary btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                    <path
                                        d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                    <path
                                        d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                </svg>
                            </button> --}}

    {{-- KODE ASLI --}}
        {{-- <div class="offcanvas-body">
            <form wire:submit.prevent="store()" id="budgetPlanForm">
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select wire:model="categoryName" class="form-select form-select-sm mb-3" id="selectcategory" aria-label="Default select example" required>
                        <option value="" selected>Select Category</option>
                        @foreach ($categories as $category_name)
                        <option wire:key='{{ $category_name->id}}' value="{{ $category_name->id}}">
                            {{ $category_name->name}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Sub Kategori</label>
                    <select wire:model="subCategoryName" class="form-select form-select-sm mb-3" id="selectSubCategory" aria-label="Default select example" required>
                        <option value="" selected>Select Sub Category</option>
                        @foreach ($sub_categories as $sub_category_name)
                        <option wire:key='{{ $sub_category_name->id}}' value="{{ $sub_category_name->id}}">
                            {{ $sub_category_name->name}}
                        </option>
                        @endforeach
                    </select>
                </div>
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
                    <input type="text" wire:model="quantity" class="form-control form-control-sm" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Harga Satuan</label>
                    <input type="text" wire:model="unit_price" class="form-control form-control-sm" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Total per Item</label>
                    <input type="text" wire:model="total_per_item" class="form-control form-control-sm" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Total</label>
                    <input type="text" wire:model="total_all" class="form-control form-control-sm" required>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div> --}}
    <!--FORM CATEGORY-->
    {{-- <div class="offcanvas offcanvas-end" tabindex="-1" id="createCategory" aria-labelledby="createCategoryLabel">
        <div class="offcanvas-header">
            <h5 id="createCategoryLabel">Buat Kategori</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
      <!--CATEGORY-->
        <div class="offcanvas-body">
            <form wire:submit.prevent="storeCategory()" id="categoryForm">
                <div class="mb-3">
                    <label for="categoryName" class="form-label">Kategori</label>
                    <input type="text" wire:model="categoryName" class="form-control form-control-sm" id="categoryName" required>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
                
            </form>
            
        </div>
    </div> --}}

    <!-- FORM SUB CATEGORY-->
    {{-- <div class="offcanvas offcanvas-end" tabindex="-1" id="createSubCate" aria-labelledby="createSubCatelabel">
        <div class="offcanvas-header">
            <h5 id="createSubCateLabel">Buat Sub Kategori</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <!--SUB CATEGORY-->
        <div class="offcanvas-body">
            <form wire:submit.prevent="storeSubCategory()" id="subCategoryForm">
                <div class="mb-3">
                    <label for="category_id" class="form-label">Kategori</label>
                    <select id="category_id" wire:model="category_id" class="form-select" required>
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" >{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') 
                      <span class="text-danger">{{ $message}}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="subCategoryName" class="form-label">Sub Kategori</label>
                    <input type="text" wire:model="subCategoryName" class="form-control form-control-sm" id="subCategoryName" required>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div> --}}
    
    {{-- kode sementara --}}
    {{-- <form wire:submit.prevent="store()" class="mt-2"> 
            <label for="">Kategori</label>
            <select name="selectCategory" id="selectCategory" class="form-select" >

            </select>
        </div>

        <div  class="mb-2">
            <label for="">Sub Kategori</label>
            <select name="selectSubCategory" id="selectSubCategory"></select>
        </div> 
    </form> --}}

      

        {{-- <div class="offcanvas offcanvas-end" tabindex="-1" id="viewPlan" aria-labelledby="viewPlanLabel">
            <div class="offcanvas-header">
                <h5 id="viewPlanLabel">View Project</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <div class="offcanvas-body">

            </div>
        </div> --}}

        
    {{-- </div> --}}
    {{-- <div>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="updatePlan" aria-labelledby="updatePlanLabel">
            <div class="offcanvas-header">
                <h5 id="updatePlanLabel">Update Project</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <div class="offcanvas-body">

            </div>
        </div>

       

        
    </div> --}}



    


                
    

    
    

        
        
        


     {{-- Handle form submission for subcategory
    // $('#subCategoryForm').on('submit', function(event) {
    //     event.preventDefault(); // Prevent default form submission

        // Simulate form submission with Livewire or AJAX
        // @this.call('storeSubCategory').then(() => {
            // Hide the subcategory offcanvas
            // createSubCategoryOffcanvas.hide();

            // Show the budget plan offcanvas
            // createBudgetPlanOffcanvas.show();
    //     }).catch(error => {
    //         console.error('Error:', error);
    //     });
    // });

    // Handle form submission for budget plan
    // $('#budgetPlanForm').on('submit', function(event) {
    //     event.preventDefault(); // Prevent default form submission

        // Simulate form submission with Livewire or AJAX
        // @this.call('storeBudgetPlan').then(() => {
            // Hide the budget plan offcanvas
            // createBudgetPlanOffcanvas.hide();

            // Optionally, you can show a success message or redirect
//             alert('Budget Plan created successfully!');
//         }).catch(error => {
//             console.error('Error:', error);
//         });
//     });
// });




        //   $(document).ready(function() {
            // Create offcanvas instances
            // var createCategoryOffcanvas = new bootstrap.Offcanvas(document.getElementById('createCategory'));
            // var createSubCategoryOffcanvas = new bootstrap.Offcanvas(document.getElementById('createSubCate'));
            // var createBudgetPlan = new bootstrap.Offcanvas(document.getElementById('createBudget'));

            // Handle form submission
            // $('#categoryForm').on('submit', function(event) {
                // event.preventDefault(); // Prevent default form submission

                // Submit the form via Livewire (or via Ajax if not using Livewire)
                // Example with Livewire:
                // @this.call('storeCategory').then(() => {
                    // Hide the current offcanvas
                    // createCategoryOffcanvas.hide();

                    // Show the subcategory offcanvas
                    // createSubCategoryOffcanvas.show();
                // }).catch(error => {
                    // console.error('Error:', error);
                // });
            // });

            // $('#subCategoryForm').on('submit', function(event) {
                // event.preventDefault();

        //         @this.call('storeSubCategory').then(() => {
        //             createSubCategoryOffcanvas.hide();
                    

        //             createBudgetPlan.show();
        //         }).catch(error => {
        //             console.error('Error:', error);
        //         });
        //     });
        // });
  
    



    


  --}}