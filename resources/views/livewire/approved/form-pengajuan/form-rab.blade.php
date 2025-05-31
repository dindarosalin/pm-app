<div>
    <div wire:ignore.self class="offcanvas offcanvas-end" tabindex="-1" id="rabForm" aria-labelledby="rabFormabel" data-bs-scroll="true" data-bs-backdrop="false">
        
        <div class="offcanvas-header bg-success text-white">
            <h5 id="rabLabel">
                {{ $rabId ? 'Edit Pengajuan RAB' : 'Buat Pengajuan RAB' }}
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" 
                    aria-label="Close" wire:click="btnCloseOffcanvas"></button>
        </div>

        <div class="offcanvas-body">
            <form wire:submit.prevent="store">

                <div class="col-md-6 mb-3">
                        <label class="form-label">No. Telepon <span class="text-danger">*</span></label>
                        <input type="number" wire:model="telepon" class="form-control @error('telepon') is-invalid @enderror">
                        @error('telepon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                <!-- Jabatan dan Atasan -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jabatan <span class="text-danger">*</span></label>
                        <select wire:model="selectJobdesk" wire:change="loadHead" 
                                class="form-select @error('selectJobdesk') is-invalid @enderror">
                            <option value="">Pilih Jabatan</option>
                            @foreach ($jabatan as $item)
                                <option value="{{ $item->id }}">{{ $item->job }}</option>
                            @endforeach
                        </select>
                        @error('selectJobdesk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Atasan <span class="text-danger">*</span></label>
                        <select wire:model="selectHead" class="form-select @error('selectHead') is-invalid @enderror">
                            <option value="">Pilih Atasan</option>
                            @foreach ($atasan as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('selectHead') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Informasi RAB -->
                <div class="mb-3">
                    <label class="form-label">Jenis RAB <span class="text-danger">*</span></label>
                    <select wire:model="jenis_rab" class="form-select @error('jenis_rab') is-invalid @enderror">
                        <option value="">Pilih Jenis RAB</option>
                        @foreach ($jenisApprove as $item)
                            <option value="{{ $item->id }}">{{ $item->jenis }}</option>
                        @endforeach
                    </select>
                    @error('id_jenis_approve') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Submit Button -->
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


<!--Detail RAB-->
                {{-- <div class="mb-3">
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
                <button type="button" wire:click="addDetail" class="btn btn-primary btn-sm mb-3">
                    <i class="bi bi-plus"></i> Tambah Detail
                </button> --}}

                {{-- <h4>Daftar Detail</h4>
                <ul>
                    @foreach ($details as $index => $detail)
                    <li>{{ $detail['kebutuhan'] }} - {{ $detail['deskripsi']}} - {{ $detail['uom'] }} - {{ $detail['quantity'] }} - {{ $detail['unit_per_price'] }} </li>
                    @endforeach
                </ul> --}}