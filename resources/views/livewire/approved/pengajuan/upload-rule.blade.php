<div>
    @section('title')
        Upload Ketentuan
    @endsection

    <!--BUTTON NAVIGASI-->
    <div class="d-flex justify-content-end">
        <button wire:click='btnRule_Clicked' class="btn btn-sm btn-success mb-3 mx-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#createRule" aria-controls="createRule">
            Buat Ketentuan
        </button>
    </div>

    <!--KONEKSI-->
    <livewire:approved.pengajuan.form-rule :title="'Upload Ketentuan'" />
    {{-- <livewire:approved.pengajuan.rule :title="'Upload Ketentuan'" /> --}}

    <!--BUTTON NAVIGASI MODAL-->
    {{-- <div class="d-flex justify-content-end mb-3">
        <button type="button" 
            class="btn btn-outline-success btn-sm" 
            data-bs-toggle="modal" 
            data-bs-target="#dynamicModal">
            Upload Ketentuan Approval
        </button>
    </div> --}}

    <div class="card p-1 table-responsive">
        <table class="table table-hover" style="width: 100%">

            <thead class="text-success fw-medium">
                <tr>
                    <th class="fw-medium text-center">ID</th>
                    <th class="fw-medium text-center">Jenis Ketentuan</th>
                    <th class="fw-medium text-center">File</th>
                    <th class="fw-medium text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                    @foreach ($rules as $rule)
                    <tr>
                        <td class="text-center">
                            {{ $rule->id }}
                        </td>

                        <td class="text-center">
                            <span class="text-success fw-bold">{{ $rule->jenis }}</span>
                        </td>

                        <td class="text-center">
                            <a href="{{ asset('storage/' . $rule->file_path) }}" target="_blank">
                                {{ $rule->file_name }}
                            </a>
                        </td> 

                        <td>
                            <div class="d-flex gap-2 justify-content-center align-items-center">

                                <!--EDIT-->
                                <button type="button" class="btn btn-outline-warning btn-sm"
                                        wire:click="$dispatch('editRule', {id: {{ $rule->id }}})"
                                        data-bs-toggle="modal"
                                        data-bs-target="#dynamicModal">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>

                                <!--DELETE-->
                                <button type="button" class="btn btn-outline-danger btn-sm">
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
<!------------------------------------JS--------------------------------------------------------->
@push('scripts')
    <script>
        window.addEventListener('show-create-offcanvas', event => {
            const offcanvas = new bootstrap.Offcanvas('#ruleForm');
            offcanvas.show();
        });
    </script>
@endpush




{{-- <div> --}}
    {{-- @section('title')
        UploadKetentuan
    @endsection --}}

    <!--Connect for modal in rule.blade-->
    {{-- <livewire:approved.pengajuan.rule :title="'Upload Ketentuan'" /> --}}

     <!-- Modal untuk setiap jenis ketentuan -->
     {{-- @foreach ([
        'ketentuan cuti',
        'ketentuan izin tidak terencana', 
        'ketentuan rencana anggaran belanja',
        'ketentuan reimburse',
        'ketentuan pengadaan proyek'
    ] as $jenis)
        <livewire:approved.pengajuan.rule 
            :title="'Upload Ketentuan'"
            :key="'modal-'.$jenis"
            wire:key="'modal-'.$jenis" />
    @endforeach --}}

    {{-- <div class="card text-center text-success fw-medium">
        <div class="card-header">
            Upload Ketentuan Approval
        </div>

        <div class="card-body">
            <div class="container mt-4">
                <div class="d-flex flex-column gap-2"> --}}
                    {{-- @foreach ([
                        ['Cuti', 'Pengajuan cuti untuk karyawan', 'ketentuan cuti'],
                        ['Izin Tidak Terencana', 'Pengajuan izin tidak terencana untuk karyawan', 'ketentuan izin tidak terencana'],
                        ['Rencana Anggaran Belanja', 'Pengajuan Rencana Anggaran Belanja', 'ketentuan rencana anggaran belanja'],
                        ['Reimburse', 'Pengajuan Reimburse', 'ketentuan reimburse'],
                        ['Pengadaan Proyek', 'Pengajuan Pengadaan Proyek', 'ketentuan pengadaan proyek']
                    ] as $item)
                        <button type="button" class="btn btn-sm btn-outline-success open-modal focus-ring focus-ring-success" 
                            data-bs-toggle="modal" 
                            data-bs-target="#dynamicModal" 
                            {{-- data-bs-target="#modal-{{ str_replace(' ', '-', strtolower($item[2])) }}" --}}
                            {{-- data-title="{{ $item[0] }}" 
                            data-content="{{ $item[1] }}"
                            data-jenis="{{ $item[2] }}" > --}}
                            {{-- wire:click="setJenis('{{ $item[2] }}')"> --}}
                            {{-- {{ $item[0] }}
                        </button>
                    @endforeach --}} 
                {{-- </div>
            </div>
        </div>
    </div>  --}}
    
    {{-- <div class="card p-1 table-responsive">
        <table class="table table-hover" style="width: 100%">

            <thead class="text-success fw-medium">
                <tr>
                    <th class="fw-medium text-center">ID Ketentuan</th>
                    <th class="fw-medium text-center">Jenis Ketentuan</th>
                    <th class="fw-medium text-center">File</th>
                    <th class="fw-medium text-center">Action</th>
                </tr>
            </thead> --}}

            {{-- <tbody>
                @foreach ($rules as $rule)
                    <tr>
                        <td class="text-center">{{ $rule->id }}</td>

                        <td class="text-center"> --}}
                            {{-- <a href="{{ asset('storage/' . $rule->file_path) }}" target="_blank">
                                {{ $rule->jenis }}
                            </a> --}}
                            {{-- <span class="text-success fw-bold">{{ $rule->jenis }}</span>
                        </td>

                        <td class="text-center">
                            <a href="{{ asset('storage/' . $rule->file_path) }}" target="_blank">
                                {{ $rule->file_name }}
                            </a>
                        </td> --}}

                        {{-- <td>
                            <div class="d-flex gap-2 justify-content-center align-items-center"> 
                                <!--Edit Icon-->
                                <button wire:click="$dispatch('editRule', { id: {{ $rule->id }} })" 
                                        class="btn btn-outline-warning btn-sm">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>
                                <!--Delete Icon-->
                                <button wire:click="delete({{ $rule->id }})"
                                        class="btn btn-outline-danger btn-sm"
                                        onclick="return confirm('Yakin hapus ketentuan ini?')">
                                    <i class="fa-solid fa-trash"></i>
                                </button> 
                            </div>
                        </td> --}}
                    {{-- </tr>
                @endforeach
            </tbody>
        </table>
    </div>  
</div>  --}}
{{-- <script>
    document.addEventListener("livewire:init", () => {
        Livewire.on('showEditModal', (data) => {
            // Buka modal spesifik berdasarkan jenis ketentuan
            const modalId = 'modal-' + data.jenis.replace(/\s+/g, '-').toLowerCase();
            const modal = new bootstrap.Modal(document.getElementById(modalId));
            modal.show();
        });
    });
</script> --}}
{{-- Run HTML
Perbaikan unt --}}

{{-- <script>
    document.addEventListener("livewire:init", () => {
        // Handle modal edit
        Livewire.on('showEditModal', () => {
            const modal = new bootstrap.Modal('#dynamicModal');
            modal.show();
        });
    });
</script> --}}