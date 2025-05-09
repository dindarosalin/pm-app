<div>
    <div wire:ignore.self class="offcanvas offcanvas-end" tabindex="-1" id="rabForm" aria-labelledby="rabFormabel" data-bs-scroll="true" data-bs-backdrop="false">
        
        <div class="offcanvas-header bg-success text-white">
            <h5 id="rabLabel">
                {{ $rabId ? 'Edit Pengajuan Izin' : 'Buat Pengajuan Izin' }}
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
                    <label class="form-label">Deskripsi</label>
                    <input type="text" wire:model="deskripsi" class="form-control form-control-sm">
                </div>

                <div class="mb-3">
                    <label class="form-label">Satuan</label>
                    <input type="text" wire:model="uom" class="form-control form-control-sm">
                </div>

                <div class="mb-3">
                    <label class="form-label">Kuantitas</label>
                    <input type="number" wire:model="quantity" id="qty" class="form-control form-control-sm">
                </div>

                <div class="mb-3">
                    <label class="form-label">Harga Satuan</label>
                    <input type="number" wire:model="unit_per_price" id="price" class="form-control form-control-sm">
                </div>

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
