<div>
    <div wire:ignore.self class="offcanvas offcanvas-end" tabindex="-1" id="reimburseForm" 
         aria-labelledby="reimburseFormLabel" data-bs-scroll="true" data-bs-backdrop="static">
        <div class="offcanvas-header bg-success text-white">
            <h5 id="reimburseLabel">
                {{ $reimburseId ? 'Edit Pengajuan Reimburse' : 'Buat Pengajuan Reimburse' }}
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" 
                    aria-label="Close" wire:click="btnCloseOffcanvas"></button>
        </div>

        <div class="offcanvas-body">
            <form wire:submit.prevent="store">

                <div class="mb-3">
                    <label class="form-label">Kebutuhan</label>
                    <input type="text" wire:model="kebutuhan" class="form-control form-control-sm">
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

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="store">Simpan</span>
                        <span wire:loading wire:target="store">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Menyimpan...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
