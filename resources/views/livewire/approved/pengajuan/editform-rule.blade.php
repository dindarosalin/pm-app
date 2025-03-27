<div>
    <!--FORM OFFCANVAS-->
    <div wire:ignore.self class="offcanvas offcanvas-end" tabindex="-1" id="ruleForm" aria-labelledby="ruleFormLabel" data-bs-scroll="true" data-bs-backdrop="false">
        
        <div class="offcanvas-header">
            <h5 id="ruleLabel">Ketentuan Approval</h5>
            <button wire:click="btnClose_Offcanvas" type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <!--ISI FORM-->
        <div class="offcanvas-body">
            <form wire:submit.prevent="store">

                <div class="mb-3">
                    <label class="form-label">Jenis Ketentuan</label>
                    <input type="text" wire:model="jenis" class="form-control form-control-sm">
                </div>

                <div class="mb-3">
                    <label for="attachemnts" class="form-label">Upload File</label>
                    <input type="file" wire:model="file_path" class="form-control" id="file_path">
                    <small class="text-muted">Format: PDF (Max: 2MB)</small>
                    <div wire:loading wire:target="file_path">Uploading...</div>
                </div>

                <!-- Preview File Baru -->
                @if ($newFile)
                    <div class="alert alert-info p-2 mb-3">
                        <div class="-flex justify-content-between align-items-center">
                            <button type="button" wire:click="$set('newFile', null)" class="btn btn-sm btn-danger">
                                Hapus
                            </button>
                        </div>
                    </div>
                @endif

                 <!-- Preview File Existing -->
                 @if ($file_path)
                 <div class="alert alert-secondary p-2 mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ asset('storage/' . $file_path) }}" target="_blank" class="text-decoration-none">
                            <i class="far fa-file me-2"></i>
                            {{ basename($file_path) }}
                        </a>
                        <button type="button" wire:click="$set('file_path', null)" class="btn btn-sm btn-danger">
                            Hapus
                        </button>
                    </div>
                 </div>
                 @endif

                 <div class="d-flex gap-2 mt-4">
                    <button type="button" wire:click="btnClose_Offcanvas" class="btn btn-secondary">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        <span wire:loading.remove>{{ $ruleId ? 'Update' : 'Simpan' }}</span>
                        <span wire:loading wire:target="store">
                            <span class="spinner-border spinner-border-sm"></span> 
                            Memproses...
                        </span>
                    </button>
                 </div>
            </form>
        </div>
    </div>
</div>





{{-- <div>
    <!--OFF CANVAS EDIT KETENTUAN-->
    <div wire:ignore.self class="offcanvas offcanvas-end" tabindex="-1" id="editRuleCanvas" aria-labelledby="editRuleLabel">
        <div class="offcanvas-header">
            {{-- <h5 id="ruleLabel">Edit Ketentuan Approval</h5> --}}
            {{-- <h5 class="offcanvas-title">Edit Ketentuan</h5> --}}
            {{-- <button wire:click="btnClose_Offcanvas" type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button> --}}
            {{-- <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button> --}}
        {{-- </div> --}}

        <!--FORM-->
        {{-- <form wire:submit.prevent="update"> --}}
            {{-- <div class="offcanvas-body"> --}}
                <!-- Tampilkan Jenis -->
                {{-- <div class="mb-3"> --}}
                    {{-- <label class="form-label">Jenis Ketentuan</label> --}}
                    {{-- <input type="text" wire:model="jenis" class="form-control" readonly> --}}
                {{-- </div> --}}

                <!-- File Saat Ini -->
                {{-- <div class="mb-3"> --}}
                    {{-- <label class="form-label">File Saat Ini</label> --}}
                    {{-- <div class="alert alert-secondary p-2"> --}}
                        {{-- <a href="{{ asset('storage/' . $file_path) }}" target="_blank"> --}}
                            {{-- {{ $file_name }} --}}
                        {{-- </a> --}}
                    {{-- </div> --}}
                {{-- </div> --}}

                <!-- Input File Baru -->
                {{-- <div class="mb-3">
                    <label class="form-label">File Baru (Opsional)</label>
                    <input type="file" wire:model="newFileRule" class="form-control">
                    @error('newFileRule') <small class="text-danger">{{ $message }}</small> @enderror
                    <div wire:loading wire:target="newFileRule">Mengunggah...</div>
                </div> --}}

                 <!-- Preview File Baru -->
                {{-- @if ($newFileRule)
                    <div class="alert alert-info p-2">
                        File baru: <strong>{{ $newFileRule->getClientOriginalName() }}</strong>
                        <button type="button" wire:click="$set('newFileRule', null)" 
                            class="btn btn-sm btn-danger float-end">
                            Hapus
                        </button>
                    </div>
                @endif --}}

                <!-- Input Nama File -->
                {{-- <div class="mb-3">
                    <label class="form-label">Nama File</label>
                    <input type="text" wire:model="file_name" class="form-control" required>
                    @error('file_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div> --}}
            {{-- </div> --}}

            {{-- <div class="offcanvas-footer p-3">
                <button type="submit" class="btn btn-primary w-100">
                    <span wire:loading.remove>Perbarui</span>
                    <span wire:loading wire:target="update">Memproses...</span>
                </button>
            </div>
        </form> --}}

        {{-- <div class="offcanvas-body">
            <form wire:submit.prevent="update">
                <!-- Jenis Ketentuan (Readonly) -->
                <div class="mb-3">
                    <label class="form-label">Jenis Ketentuan</label>
                    <input type="text" wire:model="jenis" class="form-control" readonly>
                </div>

                <!-- Upload File Baru -->
                <div class="mb-3">
                    <label class="form-label">Upload File Baru</label>
                    <input type="file" wire:model="newFileRuleRule" class="form-control form-control-sm">
                    <div wire:loading wire:target="newFileRule">Uploading...</div>
                </div>

                <!-- Preview File Baru -->
                @if ($newFileRule)
                    <div class="alert alert-info">
                        <strong>File Baru:</strong> {{ $newFileRule->getClientOriginalName() }}
                        <button type="button" class="btn btn-sm btn-danger" wire:click="$set('newFileRule', null)">Hapus</button>
                    </div>
                @endif

                 <!-- Preview File Sebelumnya -->
                 @if ($file_path)
                    <div class="alert alert-secondary">
                        <a href="{{ asset('storage/' . $file_path) }}" target="_blank">
                            Lihat File Saat Ini: {{ $file_name }}
                        </a>
                    </div>
                @endif

                <!--Preview File Baru-->
                {{-- @if ($newFileRule)
                    <div class="alert alert-info">
                        <strong>File Baru:</strong> {{ $newFileRule->getClientOriginalName() }}
                        <button type="button" class="btn btn-sm btn-danger" wire:click="$set('newFileRule', null)">Hapus</button>
                    </div>
                @endif --}}

                <!--Preview dari database-->
                {{-- @if ($file_path)
                    <div class="alert alert-secondary">
                        <a href="{{ asset('storage/' . $file_path) }}" target="_blank">
                            Lihat File Saat Ini
                        </a>
                        <button type="button" class="btn btn-sm btn-danger" wire:click="removeFile('existing')">Hapus</button>
                    </div>
                @endif --}}

                {{-- <button type="submit" class="btn btn-primary">Perbarui</button>
            </form> --}}
        {{-- </div>  --}}
    {{-- </div> --}}
{{-- </div>  --}}

<!=================================================================JS================================================================================================================>
{{-- <script>
    // Buka offcanvas saat event dipanggil
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('bukaOffcanvas', () => {
            new bootstrap.Offcanvas(document.getElementById('editRuleCanvas')).show();
        });
    });
</script> --}}

{{-- <script>
    window.addEventListener('show-edit-offcanvas', event => {
        const offcanvas = new bootstrap.Offcanvas(document.getElementById('editRule'));
        offcanvas.show();
    });
</script> --}}

{{-- <script>
    window.addEventListener('show-edit-offcanvas', event => {
        const offcanvas = new bootstrap.Offcanvas('editRule');
        offcanvas.show();
    });
</script> --}}