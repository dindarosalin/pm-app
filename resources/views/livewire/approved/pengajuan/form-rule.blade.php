<div>
    <!--OFF CANVAS-->
    <div wire:ignore.self class="offcanvas offcanvas-end" tabindex="-1" id="ruleForm" aria-labelledby="ruleFormLabel" data-bs-scroll="true" data-bs-bacdrop="false">
        
        <div class="offcanvas-header">
            <h5 id="ruleLabel">Unggah Ketentuan Approval</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">
            <form wire:submit.prevent="store">

                <div class="mb-3">
                    <label class="form-label">Jenis Ketentuan Approval</label>
                    <input type="text" wire:model="jenis" class="form-control form-control-sm">
                </div>

                @if ($file_path)
                   <a href="{{ asset('storage/' . $file_path) }}" target="_blank" class="text-blue-500 hover:underline">
                    {{ basename($file_path) }} (Klik untuk melihat)
                   </a> 
                @endif

                <div class="mb-3">
                    <label for="" class="form-label">Unggah File</label>
                    <input wire:model.defer='newAttachment' type="file" accept="file/pdf" class="form-control" name="" id="newAttachment" aria-describedby="helpId" placeholder="">
                    <span wire:loading wire:target='newAttachment'>Uploading</span>
                </div>

                @error('newAttachment')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
