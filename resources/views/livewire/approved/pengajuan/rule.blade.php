<div>
    <div wire:key="dynamicModal" wire:ignore.self class="modal fade" id="dynamicModal" tabindex="-1" aria-labelledby="dynamicModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Ketentuan Pengajuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

              <!--UPLOAD-->
              <form wire:submit.prevent="store">
                <!--input upload-->
                <div class="mb-3">
                    <label class="form-label">Upload File Ketentuan</label>
                    <input type="file" wire:model="attachments" class="form-control form-control-sm" multiple>
                    <div wire:loading wire:target="attachments">Uploading...</div>
                </div>

                <!--Preview tmp file-->
                @if ($attachments)
                    <div>
                        @foreach ($attachments as $key => $attachment)
                            <div class="flex">
                                <p>{{ $attachment->getClientOriginalName() }}</p>
                                <p wire:click="removeFile('new', {{ $key }})"
                                    class="text-danger btn btn-sm">Hapus</p> 
                            </div>
                        @endforeach
                    </div>  
                @endif

                <!--Preview dari database-->
                @if ($existingAttachments)
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
                @endif
               
                <button type="submit" class="btn btn-primary">Upload</button>
              </form>
            </div> 
            </div>
        </div>
    </div>
</div>



<!===============================================================JS====================================>
<script>
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

</script>


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

 {{-- <div class="mb-3">
                    <label for="newFileRule" class="form-label">Upload File Ketentuan</label>
                    <input wire:model="newFileRule" type="file" accept="application/pdf" class="form-control" id="newFileRule">
                </div> --}}
 {{-- @error('newFileRule')
                    <span class="text-danger">{{ $message }}</span>
                @enderror --}}

{{-- <form wire:submit.prevent="store">
    <!--ALERT SUCCESS-->
{{-- @if (session()->has('message'))
    <div class="alert alert-success mt-3">
        {{ session('message') }}
    </div>
@elseif (session()->has('error'))
    <div class="alert alert-danger mt-3">
        {{ session('error') }}
    </div>
@endif --}}
                <!--Session upload -->
                {{-- @if (session('role') === 'HR')
                    <div class="mb-3">
                        <label for="file" class="form-label">Pilih File</label>
                        <input type="file" class="form-control" wire:model="file">
                        @error('file')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                @else
                <p class="text-danger">Anda tidak memiliki izin untuk mengunggah file</p>
                @endif

                <!--PREVIEW-->
                @if ($file)
                    <p>Preview: {{ $file->getClientOriginalName() }}</p>
                    @if (in_array($file->extension(), ['jpg', 'jpeg', 'png']))
                        <img src="{{ $file->temporaryUrl() }}" class="img-thumbnail" width="100">
                    @elseif ($file->extension() === 'pdf')
                        <iframe src="{{ $file->temporaryUrl() }}" width="100%" height="200"></iframe>
                    @endif
                @endif
              </form>  --}}
              {{-- <div class="modal-footer"> --}}
                {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                @if (session('role') === 'HR')
                <button type="submit" class="btn btn-primary">Upload</button>
                @endif --}}
                
              {{-- </div> --}}