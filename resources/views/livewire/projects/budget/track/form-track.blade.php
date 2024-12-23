<div>
    
    <!--FORM OFFCANVAS-->
    <div  wire:ignore.self class="offcanvas offcanvas-end" tabindex="-1" id="trackForm" aria-labelledby="trackFormabel" data-bs-scroll="true"
        data-bs-backdrop="false">
        <div class="offcanvas-header">
            <h5 id="trackLabel">Track Expense Project</h5>
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
                <div class="mb-3">
                    <label class="form-label">Tanggal Pembelian</label>
                    <input type="date" wire:model="purchase_date" class="form-control form-control-sm"
                        required>
                </div>


                @if ($attachment)
                    <img src="{{ asset('storage/' . $attachment) }}" class=" mb-3 w-25 h-auto">                    
                @endif

                <div class="mb-3">
                    <label for="" class="form-label">Up File Nota</label>
                    <input wire:model.defer='newAttachment' type="file" accept="image/png, image/jpeg" class="form-control"
                        name="" id="newAttachment" aria-describedby="helpId" placeholder="">
                    <span wire:loading wire:target='newAttachment'>Uploading...</span>
                </div>

                @error('newAttachment')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>

</div>
