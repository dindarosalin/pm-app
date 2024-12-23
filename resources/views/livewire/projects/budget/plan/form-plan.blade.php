<div>
    <!--FORM OFF CANVAS-->
    <div wire:ignore.self class="offcanvas offcanvas-end" tabindex="-1" id="planForm" aria-labelledby="planFormabel" data-bs-scroll="true"
        data-bs-backdrop="false">
        <div class="offcanvas-header">
            <h5 id="planLabel">Budget Plan Project</h5>
            <button wire:click="btnClose_Offcanvas" type="button" class="btn-close text-reset"
                data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <!--ISI FORM-->
        <div class="offcanvas-body">
            <form wire:submit.prevent="store">

                <div class="input-group mb-3">
                    <select wire:model="selectCategory" class="form-select form-select-sm" name="categories"
                        id="categories">
                        <option value="">Select Category</option>
                        @foreach ($this->categories ?? [] as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>

                    <button class="btn btn-outline-secondary btn-sm" wire:click='loadSubCategory' type="button"
                        id="button-addon2">
                        Pilih
                    </button>
                </div>

                <select wire:model="selectSubCategory" class="form-select form-select-sm mb-2" name="sub_categories"
                    id="sub_categories">
                    <option value="">Select Sub Category</option>
                    @foreach ($sub_categories as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" wire:model="name" class="form-control form-control-sm">
                </div>
                <div class="mb-3">
                    <label class="form-label">Satuan</label>
                    <input type="text" wire:model="uom" class="form-control form-control-sm" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kuantitas</label>
                    <input type="number" wire:model="quantity" id="qty" class="form-control form-control-sm"
                        required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Harga Satuan</label>
                    <input type="number" wire:model="unit_price" id="price" class="form-control form-control-sm"
                        required>
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>


</div>



























{{-- @push('scripts')
    
{{-- <div class="mb-3">
                    <label class="form-label">Total Harga</label>
                    <input type="text" wire:model="total_per_item" id="item_total"
                        class="form-control form-control-sm" readonly>
                </div> --}}
{{-- <script> --}}
    {{-- //Hitung --}}
{{-- 
    //         $('#price').change(function() {
    //             var quantity = $("#qty").val();
    //             var iPrice = $("#price").val();

    //             var total = quantity * iPrice;

    //     // console.log(total);
        
    //             @this.set('total_per_item', total);

    //         });
    //     });
    // }); --}}
   
         {{-- $("#item_total").val(total); // sets the total price input to the quantity * price --}}

    {{-- // function totalPerItem()
    // {
    //     let quantity = Number(document.getElementById("quantity").value);
    //     let unit_price = Number(document.getElementById("unit-price").value);
    //     let total_per_item = document.getElementById("total-per-item");

    //     // cek quantity dan unit price sudah diisi
    //     if (quantity > 1 && unit_price > 0) {
    //         // hitung
    //         let totalperitem = quantity * unit_price;
    //         // menampilkan hasil hitung
    //         total_per_item.value = totalperitem;
    //     } else {
    //         // jika salah satu kosong set total per item = 0
    //         total_per_item.value = 0;
    //     }
    // }

    // // event listener pada input
    // document.getElementById("quantity").addEventListener('input, totalPerItem');
    // document.getElementById("unit-price").addEventListener('input, totalPerItem');
</script>
@endpush --}}





