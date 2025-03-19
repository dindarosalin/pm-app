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
                        ['Cuti', 'Pengajuan cuti untuk karyawan'],
                        ['Izin Tidak Terencana', 'Pengajuan izin tidak terencana untuk karyawan'],
                        ['Rencana Anggaran Belanja', 'Pengajuan Rencana Anggaran Belanja'],
                        ['Reimburse', 'Pengajuan Reimburse'],
                        ['Pengadaan Proyek', 'Pengajuan Pengadaan Proyek']
                    ] as $item)
                        <button type="button" class="btn btn-sm btn-outline-success open-modal focus-ring focus-ring-success" data-bs-toggle="modal" data-bs-target="#dynamicModal" data-title="{{ $item[0] }}" data-content="{{ $item[1] }}">
                            {{ $item[0] }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!--Connect for offcanvas in editform-rule.blade-->
    <div class="card p-1 table-responsive">
        <table class="table table-hover" style="width: 100%">
            <thead class="text-success fw-medium">
                <tr>
                    <th class="fw-medium text-center">ID Ketentuan</th>
                    <th class="fw-medium text-center">Daftar Ketentuan</th>
                    <th class="fw-medium text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rules as $rule)
                    <tr>
                        <td class="text-center">{{ $rule->id }}</td>
                        <td class="text-center">
                            <a href="{{ asset('storage/' . $rule->file_path) }}" target="_blank">
                                {{ $rule->file_name }}
                            </a>
                        </td>

                        <!--Off canvas-->
                       {{-- <div wire:ignore.self class="offcanvas offcanvas-end" tabindex="-1" id="editRule" aria-labelledby="editRuleLabel" data-bs-scroll="true">

                        <div class="offcanvas-header">
                            <h5 id="editRuleLabel">Edit Ketentuan</h5>
                            <button type="button" class="btn-close text-reset" wire:click="btnClose_Offcanvas" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>

                        <div class="offcanvas-body">
                            <form wire:submit.prevent="save">
                                <!--input nama rule-->
                                <div class="mb-3">
                                    <label class="form-label">Nama File<span class="text-sm text-danger">*</span></label>
                                    <input type="text" wire:model="file_name" class="form-control form-control-sm" required>
                                </div>
                                <!--input path rule-->
                                <div class="mb-3">
                                    <label class="form-label">Path File<span class="text-sm text-danger">*</span></label>
                                    <input type="text" wire:model="file_path" class="form-control form-control-sm" required>
                                </div>
                                <!--upload file-->
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
                                                <p wire:click="removeFile('new', {{ $key }})" class="text-danget btn btn-sm">Hapus</p>
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
                                                <p wire:click="removeFile('existing', {{ $key }})" class="text-danger btn btn-sm">Hapus</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                <!--Simpan dan Batal-->
                                <div class="flex">
                                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                                    <button type="button" wire:click="btnClose_Offcanvas" class="btn btn-secondary btn-sm">Batal</button>
                                </div>
                                <!-- Loading indicator saat menyimpan -->
                                <div wire:loading wire:target="save">Menyimpan...</div>
                            </form>
                        </div>
                       </div> --}}

                        <td>
                            <div class="d-flex gap-2 justify-content-center align-items-center">
                                <!--View Icon-->
                                <button class="btn btn-outline-primary btn-sm">
                                    <p class="m-0 p-0">
                                        <i class="fa-regular fa-eye"></i>
                                    </p>
                                </button>

                                <!--Edit Icon-->

                                <button wire:click="$dispatch('openEditRule', {{ $rule->id }})" data-bs-toggle="offcanvas" data-bs-target="#editRule" class="btn btn-outline-warning btn-sm">
                                    <p class="m-0 p-0">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </p>
                                </button>
                                {{-- <button wire:click="edit({{ $rule->id }})" data-bs-toggle="offcanvas" data-bs-target="#editRule" class="btn btn-outline-warning btn-sm">
                                    <p class="m-0 p-0">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </p>
                                </button> --}}

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
