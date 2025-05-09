<div>
        <div class="d-flex justify-content-end">
        <button wire:click='btnApproval_Clicked' class="btn btn-sm btn-outline-success mb-3 mx-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#approvalForm" aria-controls="approvalForm">
            Buat Jenis Approval
        </button>
    </div>

    <div wire:ignore.self class="offcanvas offcanvas-end" tabindex="-1" id="approvalForm" aria-labelledby="createApprovalLabel">
        <div class="offcanvas-header">
            <h5 id="approvalFormLabel">Buat Jenis Approval</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">
            <form wire:submit.prevent="store">
                <div class="mb-3">
                    <label class="form-label" for="jenis">Jenis Approval </label>
                    <input type="text" wire:model="jenis" class="form-control form-control-sm" id="jenis" autocomplete="off" required>
                </div>
                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                <div wire:loading>Menyimpan...</div>
            </form>
        </div>
    </div>

    <!--TABEL-->
    <div class="card p-1 table-responsive">
        <table id="approval-table" class="table table-striped table-hover table-sm" style="width: 100%">
            
            <thead class="text-success fw-medium">
                <tr>
                    <th class="fw-medium text-center">No</th>
                    <th class="fw-medium text-center">Jenis Approval</th>
                    <th class="fw-medium text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($approval ?? [] as $approvals)
                    <tr>
                        <td class="text-center">{{ $approvals->id }}</td>
                        <td class="text-center">{{ $approvals->jenis }}</td>
                        <td>
                            <div class="d-flex gap-2 justify-content-center align-items-center">
                                <button wire:click='edit({{ $approvals->id }})' class="btn btn-outline-warning btn-sm">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>

                                <button wire:confirm="Apakah Anda ingin menghapus file ini" wire:click='delete({{ $approvals->id }})' type="button" class="btn btn-outline-danger btn-sm">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('show-edit-offcanvas', event => {
            const offcanvas = new bootstrap.Offcanvas('#approvalForm');
            offcanvas.show();
        });
        window.addEventListener('alert', event => {
            alert(event.detail.message);
        });
    </script>
@endpush

