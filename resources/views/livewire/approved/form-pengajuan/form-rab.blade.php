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
            <!--RAB PARENT-->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">Informasi RAB</h6>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="store">
                        <div class="mb-3">
                            <label class="form-label">No. Telepon 
                                <span class="text-danger">*</span>
                            </label>
                            <input type="number" wire:model="telepon" class="form-control @error('telepon') is-invalid @enderror"
                                   placeholder="Masukkan No. Telepon">
                            @error('telepon')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!--Jabatan dan Atasan-->
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Jabatan
                                    <span class="text-danger">*</span>
                                </label>
                                <select wire:model="selectJobdesk" wire:change="loadHead"
                                        class="form-select @error('selectJobdesk') is-invalid @enderror">
                                    <option value="">Pilih Jabatan</option>
                                    @foreach ($jabatan as $item)
                                        <option value="{{ $item->id }}">{{ $item->job }}</option>
                                    @endforeach
                                </select>
                                @error('selectJobdesk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-2">
                                <label class="form-label">Atasan
                                    <span class="text-danger">*</span>
                                </label>
                                <select wire:model="selectHead" 
                                        class="form-select @error('selectHead') is-invalid @enderror">
                                    <option value="">Pilih Atasan</option>
                                    @foreach ($atasan as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('selectHead') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!--jenis RAB-->
                        <div class="mb-3">
                            <label class="form-label">
                                Jenis RAB 
                                <span class="text-danger">*</span>
                            </label>
                            <select wire:model="jenis_rab" 
                            class="form-select @error('jenis_rab') is-invalid @enderror">
                                <option value="">Pilih Jenis RAB</option>
                                @foreach ($jenisApprove as $item)
                                    <option value="{{ $item->id }}">{{ $item->jenis }}</option>
                                @endforeach
                            </select>
                            @error('jenis_rab') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-sm btn-success" wire:loading.attr=:disabled>
                                <span wire:loading.remove wire:target="store">
                                    {{ $rabId ? 'Update' : 'Simpan' }}  
                                </span>
                                <span wire:loading wire:target="store">
                                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                    Menyimpan...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!--RAB DETAIL SECTION-->
            @if ($rabId)
            <div class="card">
                <div class="card-header bg-light text-black d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Detail RAB</h6>
                    <button type="button" class="btn btn-sm btn-outline-success"
                            data-bs-toggle="modal" data-bs-target="#detailModal"
                            wire:click="resetDetailForm">
                        <i class="bi bi-plus"></i> Tambah Item RAB
                    </button>
                </div>

                <!--Tabel RAB Detail-->
                <div class="card-body p-0">
                    @if (count($details) > 0)
                        <div class="table-responsive">
                            <table class="table tabe-sm mb-0">
                                <thead class="table-success">
                                    <tr>
                                        <th class="fw-medium text-center">No</th>
                                        <th class="fw-medium text-center">Kebutuhan</th>
                                        <th class="fw-medium text-center">Deskripsi</th>
                                        <th class="fw-medium text-center">Satuan</th>
                                        <th class="fw-medium text-center">Kuantitas</th>
                                        <th class="fw-medium text-center">Harga Satuan</th>
                                        <th class="fw-medium text-center">Total</th>
                                        <th class="fw-medium text-center">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($details as $index => $detail)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td class="text-center">{{ $detail->kebutuhan }}</td>
                                            <td class="text-center">{{ $detail->deskripsi }}</td>
                                            <td class="text-center">{{ $detail->uom }}</td>
                                            <td class="text-center">{{ $detail->quantity }}</td>
                                            <td class="text-center">Rp {{ number_format($detail->unit_price, 0, ',', '.') }}</td>
                                            <td class="text-center">Rp {{ number_format($detail->quantity * $detail->unit_price, 0, ',', '.') }}</td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-sm btn-outline-warning"
                                                            data-bs-toggle="modal" data-bs-target="#detailModal"
                                                            wire:click="editRabDetail({{ $detail->id }})"
                                                            title="Edit">
                                                        <i class="bi bi-pencil"></i> Edit
                                                    </button>

                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                            wire:click="deleteRabDetail({{ $detail->id }})"
                                                            wire:confirm="Yakin ingin menghapus item ini?"
                                                            title="Hapus">
                                                        <i class="bi bi-trash"></i> Hapus
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                                <tfoot class="table-success">
                                    <tr>
                                        <th colspan="6" class="text-end">Total RAB:</th>
                                        <th>Rp {{ number_format($this->getTotalRabPrice(), 0, ',', '.') }}</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        
                        @else
                            <div class="text-center py-4 text-muted">
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <p>Belum ada detail item.<br>Klik tombol "Tambah Item" untuk menambah detail</p>
                            </div>
                        @endif
                    </div>
                </div>
            @else
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                Simpan RAB terlebih dahulu untuk menambahkan detail item.
            </div>
            @endif
        </div>
    </div>


    <!--Offcanvas untuk Detail RAB-->
    <div wire:ignore.self class="offcanvas offcanvas-end" tabindex="-1" id="detailOffcanvas" aria-labelledby="detailOffcanvasLabel">
        
        <div class="offcanvas-header bg-success text-white">
            <h5 id="detailOffcanvasLabel">
                {{ $rabDetailId ? 'Edit Item RAB' : 'Tambah Item RAB' }}
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close" 
                    wire:click="resetDetailForm"></button>
        </div>

        <div class="offcanvas-body">
            <!-- Konten Offcanvas -->
            <form wire:submit.prevent="storeDetail">

                <div class="mb-3">
                    <label class="fotm-label">Kebutuhan
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" wire:model="kebutuhan" class="form-control @error('kebutuhan') is-invalid @enderror"
                           placeholder="Masukkan Kebutuhan">
                    @error('kebutuhan') <div class="invalid-feedback">{{ $message }}</div> @enderror    
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <input type="text" wire:model="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                           placeholder="Masukkan Deskripsi">
                    @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror                            
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Satuan</label>
                        <input type="text" wire:model="uom" class="form-control @error('uom') is-invalid @enderror"
                               placeholder="Masukkan Satuan">
                        @error('uom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kuantitas 
                            <span class="text-danger">*</span>
                        </label>
                        <input type="number" wire:model="quantity" wire:input="calculateTotalPerItem"
                            class="form-control @error('quantity') is-invalid @enderror"
                            min="1" step="1" placeholder="1">
                        @error('quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Harga Satuan 
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" wire:model="unit_price" wire:input="calculateTotalPerItem"
                                    class="form-control @error('unit_price') is-invalid @enderror"
                                    min="0" step="0.01" placeholder="0">
                            @error('unit_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    @if ($quantity && $unit_price)
                        <div class="alert alert-success">
                            <strong>Total Harga:</strong> Rp {{ number_format($total_per_item, 0, ',', '.') }}
                        </div>
                    @endif
                </div>

                <div class="d-grid">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="offcanvas"
                            wire:click="resetDetailForm">
                        Batal
                    </button>

                    <button type="submit" class="btn btn-sm btn-success" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="storeDetail">
                            {{ $rabDetailId ? 'UpdateDetail' : 'Simpan Detail' }}
                        </span>
                        <span wire:loading wire:target="storeDetail">
                            <span class="spinner-border spinner-border-sm" role="status"></span>
                            Menyimpan...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- =========================================SCRIPT====================================================================== --}}
@push('scripts')
    <script>
        // auto close offcanvas setelah simpan
        window.addEventListener('close-offcanvas', event => {
            const offcanvas = document.getElementById('rabForm');
            const bsOffcanvas = bootstrap.Offcanvas.getInstance(offcanvas);
            if (bsOffcanvas) {
            bsOffcanvas.hide();
        }
        });

        // auto close offcanvas detail setelah simpan
        window.addEventListener('closeDetailOffcanvas', event => {
            const offcanvas = document.getElementById('detailOffcanvas');
            const bsOffcanvas = bootstrap.Offcanvas.getInstance(offcanvas);
            if (bsOffcanvas) {
                bsOffcanvas.hide();
            }
        });

        // auto open offcanvas detail saat menambah atau mengedit item
        window.addEventListener('openDetailOffcanvas', event => {
            const offcanvas = document.getElementById('detailOffcanvas');
            const bsOffcanvas = new bootstrap.Offcanvas(offcanvas);
            bsOffcanvas.show();
        });
        // auto close offcanvas saat klik tombol close
        document.querySelectorAll('[data-bs-dismiss="offcanvas"]').forEach(button => {
            button.addEventListener('click', () => {
                const offcanvas = document.getElementById('rabForm');
                const bsOffcanvas = new bootstrap.Offcanvas(offcanvas);
                bsOffcanvas.hide();
            });
        });
        // auto close offcanvas detail saat klik tombol close
        document.querySelectorAll('[data-bs-dismiss="offcanvas"]').forEach(button => {
            button.addEventListener('click', () => {
                const offcanvas = document.getElementById('detailOffcanvas');
                const bsOffcanvas = new bootstrap.Offcanvas(offcanvas);
                bsOffcanvas.hide();
            });
        });
    </script>
@endpush



{{-- <div class="mb-3">
                    <label class="form-label">Jenis RAB <span class="text-danger">*</span></label>
                    <select wire:model="jenis_rab" class="form-select @error('jenis_rab') is-invalid @enderror">
                        <option value="">Pilih Jenis RAB</option>
                        @foreach ($jenisApprove as $item)
                            <option value="{{ $item->id }}">{{ $item->jenis }}</option>
                        @endforeach
                    </select>
                    @error('id_jenis_approve') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!--Detail RAB-->
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
                    <input type="number" wire:model="unit_price" id="price" class="form-control form-control-sm">
                </div>

                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="store,storeDetail">Simpan</span>
                        <span wire:loading wire:target="store">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Menyimpan...
                        </span>
                    </button>
                </div>
            </form>  --}}

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

                {{-- <div class="row">
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
                </div> --}}