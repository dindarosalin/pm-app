<div>
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- notification -->
        @include("template.notification")

        <!-- Bordered Table -->
        <div class="card">
            <h5 class="card-header">Data Karyawan</h5>

            <div class="card-body">
                <div class="row justify-content-end mb-2">
                    <div class="col-auto ">
                        {{-- <form action="{{ url('/admin/HR/employee/add-process') }}" method="post">
                            {{ csrf_field()}}
                            <button type="submit" class="btn btn-outline-primary btn-sm float-right"><i class="mb-1 bx bx-plus"></i> Tambah Data</button>
                        </form> --}}
                        <button class="btn btn-outline-primary btn-sm mb-2 d-flex align-items-center" wire:click="$set('showModal', true)">
                            <i class="mb-1 bx bx-plus"></i> Tambah Data
                        </button>
                    </div>
                </div>

                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr class="text-center">
                                <th>Atasan</th>
                                <th>Karyawan</th>
                                <th width="18%">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($employees->count() > 0)
                            @foreach($employees as $index => $employee)
                                @foreach ($employee->child as $key=>$child)
                                <tr>
                                    @if($key == 0)
                                    <td rowspan="{{ $employee->child->count() }}">
                                        {{ $employee->getEmploye()->user_name }}
                                    </td>
                                    @endif
                                    <td>
                                        {{ $child->getEmploye()->user_name }}
                                    </td>
                                    <td class="text-center">
                                        <button wire:click="destroy({{ $child->id }})" class="btn btn-outline-danger btn-sm m-1 " onclick="return confirm('Yakin ingin menghapus data?')">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            @endforeach
                            @else
                            <tr>
                                <td class="text-center" colspan="6">Tidak ada data.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <!-- pagination -->
                <div class="row mt-3 justify-content-between">
                    <div class="col-auto">
                        <p>Menampilkan {{ $employees->count() }} dari total {{ $employees->total() }} data.</p>
                    </div>
                    <div class="col-auto ">
                        {{ $employees->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @if($showModal)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Karyawan</h5>
                        <button type="button" class="btn-close" wire:click="$set('showModal', false)" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="save">
                            <div class="mb-3">
                                <label for="selectedKaryawan" class="form-label">Karyawan</label>
                                <div wire:ignore>
                                    <select id="selectedKaryawan" class="form-select" wire:model="selectedKaryawan">
                                        <option value="">-- Pilih Karyawan --</option>
                                        @foreach($karyawan as $emp)
                                            <option value="{{ $emp->user_id }}">{{ $emp->user_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('selectedKaryawan') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="selectedAtasan" class="form-label">Atasan</label>
                                <div wire:ignore>
                                    <select id="selectedAtasan" class="form-select" wire:model="selectedAtasan">
                                        <option value="">-- Pilih Atasan --</option>
                                        @foreach($atasan as $a)
                                            <option value="{{ $a->user_id }}">{{ $a->getEmploye()->user_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('selectedAtasan') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
