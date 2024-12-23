<div>

    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- notification -->
        @include("template.notification")

        <!-- Bordered Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Kontrol Akses {{$menu->menu_name}}</h5>
                <small class="text-muted float-end d-flex" style="gap: 5px;">
                    <button class="btn btn-outline-primary btn-sm d-flex align-items-center" type="button" wire:click="accessControlDefaultAdd" wire:confirm="Apakah anda ingin menambahkan kontrol default menu {{ $menu->menu_name }} ?" class="btn btn-primary btn-sm float-right">
                        <i class="bx bx-plus me-1"></i> Kontrol Akses Default
                    </button>
                    <button onclick="window.href='#'" type="button" class="btn btn-outline-primary btn-sm d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addControl">
                        <i class="bx bx-plus me-1"></i> Tambah Kontrol Akses
                    </button>
                    <button onclick="window.location.href='{{ url('/settings/menu') }}'" class="btn btn-outline-primary btn-sm d-flex align-items-center">
                        <i class="bx bx-chevron-left me-1"></i> Kembali
                    </button>
                </small>
                <!-- Button trigger modal -->
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr class="text-center">
                                <th width="5%">No</th>
                                <th>Kode</th>
                                <th>Nama Kontrol</th>
                                <th width="5%">Urutan</th>
                                <th width="15%">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($rs_menu_access->count() > 0)
                                @foreach($rs_menu_access as $index => $menu_access)
                                <tr wire:key="{{$menu_access->id}}">
                                    <td class="text-center">{{ $index +1 }}</td>
                                    <td>{{ $menu_access->code }}</td>
                                    <td>{{ $menu_access->control_name }}</td>
                                    <td class="text-center">{{ $menu_access->order_no }}</td>
                                    <td class="text-center">
                                        <a wire:click.prevent="accessControlEdit({{$menu_access->id}})" href="#" type="button" class="btn btn-outline-warning btn-xs" title="Ubah" data-bs-toggle="modal" data-bs-target="#editControl">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <button wire:click="deleteControlProcess({{$menu_access->id}})" wire:confirm="return confirm('Apakah anda ingin menghapus kontrol {{ $menu_access->control_name }} ?')" type="button" class="btn btn-outline-danger btn-xs" title="Hapus">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </td>

                                </tr>
                                @endforeach
                            @else
                                <tr class="text-center">
                                    <td  colspan="6">Tidak ada data.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal create -->
    <div wire:ignore.self class="modal fade" id="addControl" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addControlLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addControlLabel">Tambah Kontrol Akses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form-add-access-control"  wire:submit.prevent="accessControlAdd" autocomplete="off">
                    <div class="modal-body">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label>Kode <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="code" value="" wire:model.lazy="code" required>
                                        @error('code') <span class="error">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label >Nama Kontrol <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="control_name" value="" wire:model.lazy="control_name" required>
                                        @error('control_name') <span class="error">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label >Urutan <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="order_no" value="" wire:model.lazy="order_no" required>
                                        @error('order_no') <span class="error">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer float-end">
                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Modal edit-->
    <div wire:ignore.self class="modal fade" id="editControl" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editControlLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editControlLabel">Edit Kontrol Akses</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-edit-access-control"  wire:submit.prevent="accessControlEditProcess" autocomplete="off">
                <div class="modal-body">
                    <div class="card-body">

                        <input type="hidden" name="menu_control_id" wire:model="menu_control_id">

                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label>Kode <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="code" wire:model.lazy="code" required>
                                    @error('code') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label >Nama Kontrol <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="control_name"  wire:model.lazy="control_name"  required>
                                    @error('control_name') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label >Urutan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="order_no"  wire:model.lazy="order_no" required>
                                    @error('order_no') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer float-end">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {

        $("#addControl").on("hidden.bs.modal", function(){
            $("#form-add-access-control").trigger('reset');

            Livewire.emit('clearForm');
        });

        $("#editControl").on("hidden.bs.modal", function(){
            $("#form-edit-access-control").trigger('reset');

            Livewire.emit('clearForm');
        });

        window.addEventListener('close-modal', event => {
            $('#addControl').modal('hide');
            $('#editControl').modal('hide');
        });
    })
</script>
@endpush
