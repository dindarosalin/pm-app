<div>
    @section('title')
        FormApproval
    @endsection

    <!--CONNECT FROM RULE-->
    {{-- @include('approved.pengajuan.rule') --}}
    {{-- <livewire:approved.pengajuan.rule :title="$title" /> --}}
    <livewire:approved.pengajuan.rule :title="'Form Approval'" />

    <div class="card p-1 table-responsive">
        <table id="approvesubmit-table" class="table table-hover" style="width: 100%">
            
            <thead class="text-success fw-medium">
                <tr>
                    <th class="fw-medium text-center fs-5" rowspan="2">Ketentuan</th>
                    <th class="fw-medium text-center fs-5" rowspan="2">Form Approval</th>
                </tr>
            </thead>

            <!--TBODY BARU-->
            <tbody>
                @foreach ([
                    ['Cuti', 'Pengajuan cuti untuk karyawan'],
                    ['Izin Tidak Terencana', 'Pengajuan izin tidak terencana untuk karyawan'],
                    ['Rencana Anggaran Belanja', 'Pengajuan Rencana Anggaran Belanja'],
                    ['Reimburse', 'Pengajuan Reimburse'],
                    ['Pengadaan Proyek', 'Pengajuan Pengadaan Proyek']
                ] as $item)
                
                <tr>
                    <td class="text-center">
                        <button type="button" class="btn btn-success open-modal" data-bs-toggle="modal" data-bs-target="#dynamicModal" data-title="{{ $item[0] }}" data-content="{{ $item[1] }}">
                            {{ $item[0] }}
                        </button>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-success">
                            Pengajuan {{ $item[0] }}
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>

            {{-- <tbody>
                <tr>
                    <td class="text-center">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#dynamicModal" data-title="Cuti" data-content="Pengajuan cuti untuk karyawan">Cuti</button>
                    </td>

                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-success">Pengajuan Cuti</button>
                    </td>
                </tr>

                <tr>
                    <td class="text-center">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#dynamicModal" data-title="Izin Tidak Terencana" data-content="Pengajuan izin tidak terencana untuk karyawan">Izin Tidak Terencana</button>
                    </td>

                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-success">Pengajuan Izin Tidak Terencana</button>
                    </td>
                </tr>

                <tr>
                    <td class="text-center">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#dynamicModal" data-title="Rencana Anggaran Belanja" data-content="Pengajuan Rencana Anggaran Belanja untuk karyawan">Rencana Anggaran Belanja</button>
                    </td>

                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-success">Pengajuan Rencana Anggaran Belanja</button>
                    </td>
                </tr>

                <tr>
                    <td class="text-center">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#dynamicModal" data-title="Reimburse" data-content="Pengajuan Reimburse untuk karyawan">Reimburse</button>
                    </td>

                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-success">Pengajuan Reimburse</button>
                    </td>
                </tr>

                <tr>
                    <td class="text-center">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#dynamicModal" data-title="Pengadaan Proyek" data-content="Pengajuan Pengadaan Proyek untuk karyawan">Pengadaan Proyek</button>
                    </td>

                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-success">Pengajuan Pengadaan Proyek</button>
                    </td>
                </tr>
            </tbody> --}}
        </table>
    </div>
    <div>
        <table>
            <thead>
                <tr>
                    <th>ketentuan cuti</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rules as $rule)
                    <tr>
                        <td>
                            <a href="{{ asset('storage/' . $rule->file_path) }}"
                            target="_blank">
                            {{  $rule->file_name }}
                        </a> 
                        </td>
                    </tr> 
                @endforeach
                
            </tbody>
        </table>
    </div>
    
</div>


