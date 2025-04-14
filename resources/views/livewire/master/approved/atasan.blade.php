<div>
    <div class="d-flex justify-content-end">
        <button wire:click='btnHead_Clicked' class="btn btn-sm btn-success mb-3 mx-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#headForm" aria-controls="createHead">
            Tambah Atasan 
        </button>
    </div>

    <!--OFFCANVAS-->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="headForm" aria-labelledby="createHeadLabel">
        <div class="offcanvas-header">
            <h5 id="headFormLabel">Tambah Atasan By Jabatan</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">
            <form wire:submit.prevent="store">
                <div class="mb-3">
                    <label class="form-label">Jabatan</label>
                    <select wire:model="jobdesk_id" class="form-select form-select-sm mb-3" id="jobdesk_id" aria-label="Default select example" required>
                        <option value="" selected>Pilih Jabatan</option>

                        @foreach ($jobdesk as $item)
                            <option wire:key='{{ $item->id }}' value="{{ $item->id }}">
                                {{ $item->job }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Atasan</label>
                    <input type="text" wire:model="name" class="form-control form-control-sm" id="name" required>
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
                <div wire:loading>
                    Menyimpan...
                </div>
            </form>
        </div>
    </div>

    <!--TABLE-->
    <div class="card p-1 table-responsive">
        <table id="head-table" class="table table-striped table-hover table-sm" style="width: 100%">
            <thead class="text-success fw-medium">
                <tr>
                    <th class="fw-medium text-center">No</th>
                    <th class="fw-medium text-center">Nama Atasan</th>
                    <th class="fw-medium text-center">Jabatan</th>
                    <th class="fw-medium text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($head as $atasan)
                    <tr>
                        <td class="text-center">{{ $atasan->id }}</td>
                        <td class="text-center">{{ $atasan->name }}</td>
                        <td class="text-center">{{ $atasan->jobdesk_name }}</td>
                        <td>
                            <div class="d-flex gap-2 justify-content-center align-items-center">
                                <button wire:click='edit({{ $atasan->id }})' class="btn btn-outline-warning btn-sm">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>

                                <button wire:confirm="Apakah Anda ingin menghapus file ini" wire:click='delete({{ $atasan->id }})' type="button" class="btn btn-outline-danger btn-sm">
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

{{-- JS --}}
@push('scripts')
    <script>
        window.addEventListener('show-create-offcanvas', event=> {
            const offcanvas = new bootstrap.Offcanvas('#headForm');
            offcanvas.show();
        });

        window.addEventListener('show-edit-offcanvas', event=> {
            const offcanvas = new bootstrap.Offcanvas('#headForm');
            offcanvas.show();
        });

        window.addEventListener('alert', event => {
            alert(event.detail.message);
        });
    </script>
@endpush