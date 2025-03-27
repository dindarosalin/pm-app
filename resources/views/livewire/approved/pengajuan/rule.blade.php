{{-- <div>
    <div wire:key="dynamicModal" wire:ignore.self class="modal fade" id="dynamicModal" tabindex="-1" aria-labelledby="dynamicModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
             --}}
                {{-- <div class="modal-header"> --}}
                    {{-- <h5 class="modal-title" id="modalTitle">Ketentuan Pengajuan</h5> --}}
                    {{-- <h5 class="modal-title">
                        {{ $ruleId ? 'Edit' : 'Tambah' }} Ketentuan Pengajuan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> --}}

                {{-- <div class="modal-body"> --}}
                <!--UPLOAD-->
                    {{-- <form wire:submit.prevent="store"> --}}
                        <!--input jenis ketentuan (otomatis)-->
                        {{-- <div class="mb-3">
                            <label for="jenis" class="form-label">Jenis Ketentuan</label>
                            <input type="text" wire:model='jenis' class="form-control" id="jenis">
                            @error('jenis') 
                                <span class="text-danger">{{ $message }}</span> 
                            @enderror
                        </div> --}}

                        <!--input file-->
                        {{-- <div class="mb-3"> --}}
                            {{-- <label for="attachments" class="form-label">Upload File</label>
                            <input type="file" wire:model="attachments" class="form-control" id="attachments">
                            <div wire:loading wire:target="attachments">Uploading...</div> --}}

                            {{-- <label for="attachments" class="form-label">Upload File</label>
                                <input type="file" wire:model="attachments" class="form-control" id="attachments" {{ $existingAttachments ? '' : 'required' }}>
                                <div wire:loading wire:target="attachments">Uploading...</div>
                                @error('attachments') 
                                    <span class="text-danger">{{ $message }}</span> 
                                @enderror
                            </div> --}}

                            {{-- @if ($attachments)
                                <div class="mb-3">
                                    @foreach ($attachments as $key => $attachment)
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="me-2">{{ $attachment->getClientOriginalName() }}</span>
                                            <button type="button" wire:click="removeFile('new', {{ $key }})" class="btn btn-sm btn-danger">Hapus</button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif --}}

                            {{-- @if (!empty($existingAttachments))
                                @foreach ($existingAttachments as $key => $attachment)
                                    @if (isset($attachment['file_path']))
                                        <!-- Tampilkan file -->
                                        @if ($existingAttachments)
                                            <div class="mb-3">
                                                @foreach ($existingAttachments as $key => $attachment)
                                                    <div class="d-flex align-items-center mb-2">
                                                        <a href="{{ asset('storage/' . $attachment['file_path']) }}" target="_blank" class="me-2">
                                                            {{ $attachment['file_name'] }}
                                                        </a>
                                                        <button type="button" wire:click="removeFile('existing', {{ $key }})" class="btn btn-sm btn-danger">Hapus</button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endif
                                @endforeach
                            @endif --}}

                            {{-- @if ($existingAttachments)
                                <div class="mb-3">
                                    @foreach ($existingAttachments as $key => $attachment)
                                        <div class="d-flex align-items-center mb-2">
                                            <a href="{{ asset('storage/' . $attachment['file_path']) }}" target="_blank" class="me-2">
                                                {{ $attachment['file_name'] }}
                                            </a>
                                            <button type="button" wire:click="removeFile('existing', {{ $key }})" class="btn btn-sm btn-danger">Hapus</button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif --}}
        

                        {{-- <div class="modal-footer">
                            @if($ruleId)
                                <button type="button" wire:click="delete({{ $ruleId }})" 
                                        class="btn btn-danger me-auto"
                                        onclick="return confirm('Yakin hapus ketentuan ini?')">
                                    Hapus
                                </button>
                            @endif
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="resetForm">Tutup</button>
                            <button type="submit" class="btn btn-primary">
                                {{ $ruleId ? 'Update' : 'Simpan' }}
                            </button>
                        </div> --}}


                        <!--Preview tmp file-->
                        {{-- @if ($attachments)
                            <div>
                                @foreach ($attachments as $key => $attachment)
                                    <div class="flex">
                                        <p>{{ $attachment->getClientOriginalName() }}</p>
                                        <p wire:click="removeFile('new', {{ $key }})"
                                            class="text-danger btn btn-sm">Hapus</p> 
                                    </div>
                                @endforeach
                            </div>  
                        @endif --}}

                        {{-- @if ($attachments)
                            <div>
                                @foreach ($attachments as $key => $attachment)
                                    <div class="flex">
                                        <p>{{ $attachment->getClientOriginalName() }}</p>
                                        <p wire:click="removeFile('new', {{ $key }})"
                                            class="text-danger btn btn-sm">Hapus</p> 
                                    </div>
                                @endforeach
                            </div>  
                        @endif --}}

                        <!--Preview dari database-->
                        {{-- @if ($existingAttachments)
                            <div>
                                @foreach ($existingAttachments as $key => $attachment)
                                    <div class="flex">
                                        <a href="{{ asset('storage/' . $attachment['file_path']) }}" target="_blank">
                                            {{ $attachment['file_name'] }}
                                        </a>

                                        <p wire:click="removeFile('existing', {{ $key }})"
                                            class="text-danger btn btn-sm">Hapus</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif --}}

                        {{-- @if ($existingAttachments)
                            <div>
                                @foreach ($existingAttachments as $key => $attachment)
                                    <div class="flex">
                                        <a href="{{ asset('storage/' . $attachment['file_path']) }}" target="_blank">
                                            {{ $attachment['file_name'] }}
                                        </a>

                                        <p wire:click="removeFile('existing', {{ $key }})"
                                            class="text-danger btn btn-sm">Hapus</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif --}}
                    
                        {{-- <button type="submit" class="btn btn-primary">Upload</button> --}}
                        {{-- <button type="submit" class="btn btn-primary">
                            {{ $ruleId ? 'Update' : 'Simpan' }}
                        </button> --}}
                    {{-- </form> --}}

                {{-- </div> --}}
                
                {{-- @if($ruleId)
                <div class="modal-footer">
                    <button type="button" wire:click="delete({{ $ruleId }})" 
                            class="btn btn-danger me-auto"
                            onclick="return confirm('Yakin hapus ketentuan ini?')">
                        Hapus
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>
                </div>
                @endif --}}
            {{-- </div> --}}
        {{-- </div>
    </div>
</div> --}}

<div> 
    <div wire:key="dynamicModal" wire:ignore.self class="modal fade" id="dynamicModal" tabindex="-1" aria-labelledby="dynamicModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $ruleId ? 'Edit' : 'Tambah' }} Ketentuan Pengajuan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="resetForm"></button>
                </div>

                <form wire:submit.prevent="store">
                    <div class="modal-body">
                        <!-- Input jenis ketentuan -->
                        <div class="mb-3">
                            <label for="jenis" class="form-label">Jenis Ketentuan</label>
                            <input type="text" wire:model='jenis' class="form-control" id="jenis" required>
                            @error('jenis') 
                                <span class="text-danger">{{ $message }}</span> 
                            @enderror
                        </div>

                        <!-- Input file -->
                        <div class="mb-3">
                            <label for="attachments" class="form-label">Upload File</label>
                            <input type="file" wire:model="attachments" class="form-control" id="attachments" {{ empty($existingAttachments) ? 'required' : '' }}>
                            <div wire:loading wire:target="attachments">Uploading...</div>
                            @error('attachments') 
                                <span class="text-danger">{{ $message }}</span> 
                            @enderror
                        </div>

                        <!-- Preview file baru -->
                        @if ($attachments)
                            <div class="mb-3">
                                @foreach ($attachments as $key => $attachment)
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="me-2">{{ $attachment->getClientOriginalName() }}</span>
                                        <button type="button" wire:click="removeFile('new', {{ $key }})" class="btn btn-sm btn-danger">Hapus</button>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Preview file existing -->
                        @if (!empty($existingAttachments))
                            <div class="mb-3">
                                @foreach ($existingAttachments as $key => $attachment)
                                    @if (isset($attachment['file_path']))
                                        <div class="d-flex align-items-center mb-2">
                                            <a href="{{ asset('storage/' . $attachment['file_path']) }}" target="_blank" class="me-2">
                                                {{ $attachment['file_name'] }}
                                            </a>
                                            <button type="button" wire:click="removeFile('existing', {{ $key }})" class="btn btn-sm btn-danger">Hapus</button>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                        @if($ruleId)
                            <button type="button" wire:click="delete({{ $ruleId }})" 
                                    class="btn btn-danger me-auto"
                                    onclick="return confirm('Yakin hapus ketentuan ini?')">
                                Hapus
                            </button>
                        @endif 
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="resetForm">Tutup</button> 
                        <button type="submit" class="btn btn-primary">
                            {{ $ruleId ? 'Update' : 'Simpan' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> 

<!===============================================================JS====================================>
<script>
    
    document.addEventListener("DOMContentLoaded", function () {
        const modal = new bootstrap.Modal(document.getElementById('dynamicModal'));
        
        // Buka modal saat edit
        Livewire.on('showEditModal', () => {
            modal.show();
        });
        
        // Tutup modal setelah update/create
        Livewire.on('close-modal', () => {
           modal.hide();
        });
        
        // Reset form saat modal ditutup
        document.getElementById('dynamicModal').addEventListener('hidden.bs.modal', function () {
            Livewire.dispatch('resetForm');
        });
    });
</script>

{{-- <script>
    document.addEventListener("DOMContentLoaded", function () {
        // Handle modal show/hide
        const modal = new bootstrap.Modal(document.getElementById('dynamicModal'));
        
        // Show modal when event is emitted
        Livewire.on('showEditModal', () => {
            modal.show();
        });
        
        // Hide modal when data is saved
        Livewire.on('ruleUpdated', () => {
            modal.hide();
        });
        
        // Reset modal when closed
        document.getElementById('dynamicModal').addEventListener('hidden.bs.modal', function () {
            Livewire.emit('resetFields');
        });
    });
</script> --}}


{{-- <script>
    document.addEventListener("DOMContentLoaded", function () {
        // tutup modal setelah data tersimpan
        Livewire.on('ruleUpdated', () => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('dynamicModal'));
            if (modal) {
                modal.hide();
            }
        });
        // buka modal dan kirim data jenis ke Livewire
        document.querySelectorAll(".open-modal").forEach(button => {
            button.addEventListener("click", function () {
                let title = this.getAttribute("data-title");
                let jenis = this.getAttribute("data-jenis"); // Ambil jenis ketentuan dari atribut data-jenis
                document.getElementById("modalTitle").textContent = title;
                
                // Kirim jenis ketentuan ke Livewire component
                Livewire.emit('setJenis', jenis);
            });
        });
    });
</script> --}}

{{-- <script>
    document.addEventListener("DOMContentLoaded", function () {
    // tutup modal setelah data tersimpan
    Livewire.on('ruleUpdated', () => {
        const modal = bootstrap.Modal.getInstance(document.getElementById('dynamicModal'));
        if (modal) {
            modal.hide();
        }
    });
    // buka modal
    document.querySelectorAll(".open-modal").forEach(button => {
        button.addEventListener("click", function () {
            let title = this.getAttribute("data-title");
            document.getElementById("modalTitle").textContent = title;
        });
    });
});

</script> --}}


{{-- <script>
    // UBAH ISI MODAL OTOMATIS
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".open-modal").forEach(button => {
            button.addEventListener("click", function () {
                let title = this.getAttribute("data-title");
                let content = this.getAttribute("data-content");

                document.getElementById("modalTitle").textContent = title;
                document.getElementById("modalContent").textContent = content;
            });
        });
    });
</script> --}}
