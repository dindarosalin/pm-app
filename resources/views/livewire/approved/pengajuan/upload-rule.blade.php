<div>
    @section('title')
        UploadKetentuan
    @endsection

    <!--Connect for modal in rule.blade-->
    <livewire:approved.pengajuan.rule :title="'Upload Ketentuan'" />

    <div class="card text-center text-success fw-medium">
        <div class="card-header">
            Upload Ketentuan Approval
        </div>

        <div class="card-body">
            <div class="container mt-4">
                <div class="d-flex flex-column gap-2">
                    @foreach ([
                        ['Cuti', 'Pengajuan cuti untuk karyawan', 'ketentuan cuti'],
                        ['Izin Tidak Terencana', 'Pengajuan izin tidak terencana untuk karyawan', 'ketentuan izin tidak terencana'],
                        ['Rencana Anggaran Belanja', 'Pengajuan Rencana Anggaran Belanja', 'ketentuan rencana anggaran belanja'],
                        ['Reimburse', 'Pengajuan Reimburse', 'ketentuan reimburse'],
                        ['Pengadaan Proyek', 'Pengajuan Pengadaan Proyek', 'ketentuan pengadaan proyek']
                    ] as $item)
                        <button type="button" class="btn btn-sm btn-outline-success open-modal focus-ring focus-ring-success" 
                            data-bs-toggle="modal" data-bs-target="#dynamicModal" 
                            data-title="{{ $item[0] }}" 
                            {{-- data-content="{{ $item[1] }}" --}}
                            data-jenis="{{ $item[2] }}">
                            {{ $item[0] }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!--Connect for offcanvas in editform-rule.blade-->
    <livewire:approved.pengajuan.editform-rule :title="'Upload Ketentuan'" />
    
    <div class="card p-1 table-responsive">
        <table class="table table-hover" style="width: 100%">

            <thead class="text-success fw-medium">
                <tr>
                    <th class="fw-medium text-center">ID Ketentuan</th>
                    <th class="fw-medium text-center">Jenis Ketentuan</th>
                    <th class="fw-medium text-center">Daftar Ketentuan</th>
                    <th class="fw-medium text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($rules as $rule)
                    <tr>
                        <td class="text-center">{{ $rule->id }}</td>

                        <td class="text-center">
                            {{-- <a href="{{ asset('storage/' . $rule->file_path) }}" target="_blank">
                                {{ $rule->jenis }}
                            </a> --}}
                            <span class="text-success fw-bold">{{ $rule->jenis }}</span>
                        </td>

                        <td class="text-center">
                            <a href="{{ asset('storage/' . $rule->file_path) }}" target="_blank">
                                {{ $rule->file_name }}
                            </a>
                        </td>

                        <td>
                            <div class="d-flex gap-2 justify-content-center align-items-center">
                                <!--Edit Icon-->
                                <button wire:click="$dispatch('openEditRule', { id: {{ $rule->id }} })" data-bs-toggle="offcanvas" data-bs-target="#editRule" class="btn btn-outline-warning btn-sm">
                                    <p class="m-0 p-0">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </p>
                                </button>
                                <!--Delete Icon-->
                                <button class="btn btn-outline-danger btn-sm">
                                    <p class="m-0 p-0">
                                        <i class="fa-solid fa-box-archive"></i>
                                    </p>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div> 
</div>
