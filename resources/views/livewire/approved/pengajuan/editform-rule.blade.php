<div>
    <!--OFF CANVAS EDIT KETENTUAN-->
    <div wire:ignore.self class="offcanvas offcanvas-end" tabindex="-1" id="editRule" aria-labelledby="editRulelabel" data-bs-scroll="true" data-bs-backdrop="false">
        <div class="offcanvas-header">
            <h5 id="ruleLabel">Edit Ketentuan Approval</h5>
            <button wire:click="btnClose_Offcanvas" type="button" class="btn-close text-reset"data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <!--FORM-->
        <div class="offcanvas-body">
            <form wire:submit.prevent="update">
                <div class="mb-3">
                    <label class="form-label">Upload File Ketentuan</label>
                    <input type="file" wire:model="newFileRule" class="form-control form-control-sm" multiple>
                    <div wire:loading wire:target="newFileRule">Uploading...</div>
                </div>

                <!--Preview File Baru-->
                @if ($newFileRule)
                    <div class="alert alert-info">
                        <strong>File Baru</strong> {{ $newFileRule->getClientOriginalName() }}
                        <button type="button" class="btn btn-sm btn-danger" wire:click="$set('newFileRule', null)">Hapus</button>
                    </div>  
                @endif

                <!--Preview dari database-->
                @if ($file_path)
                    <div class="alert alert-secondary">
                        <a href="{{ asset('storage/' . $file_path) }}" target="_blank">
                            Lihat File Saat Ini
                        </a>
                        <button type="button" class="btn btn-sm btn-danger" wire:click="removeFile">Hapus</button>
                    </div>
                @endif

                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>
</div>

<!=================================================================JS================================================================================================================>
<script>
    window.addEventListener('show-edit-offcanvas', event => {
        const offcanvas = new bootstrap.Offcanvas('editRule');
        offcanvas.show();
    })
</script>