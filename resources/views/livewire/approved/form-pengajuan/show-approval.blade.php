<div>
    @section('title')
        Form Approval
    @endsection

    <!--KONEKSI-->
    <livewire:approved.form-pengajuan.form-cuti :title="'Form Approval'" />
    <livewire:approved.form-pengajuan.form-izin :title="'Form Approval'" />
    <livewire:approved.form-pengajuan.form-rab :title="'Form Approval'" />
    <livewire:approved.form-pengajuan.form-reimburse :title="'Form Approval'" />
    <livewire:approved.form-pengajuan.form-pengadaan :title="'Form Approval'" />

    <livewire:approved.form-pengajuan.detail-form :cuti="$cuti" />
    {{-- <livewire:approved.form-pengajuan.detail-form /> --}}


    <!--BUTTON CREATE PENGAJUAN APPROVAL DAN TABEL KETENTUAN-->
    <div class="card p-1 table-responsive">
        <table id="rule-table" class="table table-hover" style="width: 100%">
            <thead class="text-success fw-medium">
                <tr>
                    <th class="fw-medium text-center" rowspan="2">Jenis Ketentuan Approval</th>
                    <th class="fw-medium text-center" rowspan="2">Action</th>
                </tr>
            </thead>
    
            <tbody>
                @foreach ($rules as $rule)
                    <tr>
                        <td class="text-success text-center fw-bold">{{ $rule->jenis }}</td>

                        <td class="text-center">
                            <a href="{{ asset('storage/' . $rule->file_path) }}" target="_blank" class="btn btn-outline-success btn-sm" title="lihat file">
                                <i class="fa-regular fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    

    <!--TABEL BUKTI UPLOAD FORM-->
    <div class="card p-1 table-responsive">

        <!--FILTER-->
        <div class="card-header row row-cols-2 row-cols-md-4 row-cols-md-5 g-2">
            <div class="col">
                <label for="" class="form-label">Jenis Approval</label>
                <select class="form-select form-select-sm">
                    <option selected></option>
                    <option value="1">Cuti</option>
                    <option value="2">Izin Tidak Terencana</option>
                    <option value="3">Rencana Anggaran Belanja</option>
                    <option value="3">Reimburse</option>
                    <option value="3">Pengadaan Proyek</option>
                </select>
            </div>

            <div class="col">
                <label for="" class="form-label">Search</label>
                <input type="text" class="form-control form-control-sm">
            </div>

            <div class="col">
                <label for="" class="form-label">Tanggal</label>
                <select class="form-select form-select-sm">
                    <option value="today">Hari ini</option>
                    <option value="today">Minggu ini</option>
                    <option value="today">Minggu Lalu</option>
                    <option value="today">Bulan ini</option>
                    <option value="today">Bulan Lalu</option>
                    <option value="today">Tahun ini</option>
                    <option value="custom-created">Masukkan Tanggal</option>
                </select>
            </div>
        </div>

        {{-- OFF CANVAS VIEW DETAIL APPROVAL --}}
        <div class="offcanvas offcanvas-end" tabindex="-1" id="viewApproval" aria-labelledby="viewApprovalLabel">
            <div class="offcanvas-header">
                <h5 id="viewApprovalLabel">View Approval</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <div class="offcanvas-body">
                @if ($approvalShow)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <!--CUTI-->
                                @if ($jenis === 'cuti')
                                    <tr>
                                        <th>No Telepon</th>
                                        <td>{{ $approvalShow->no_telepon }}</td>
                                    </tr>

                                    <tr>
                                        <th>Jabatan</th>
                                        <td >{{ $approvalShow->job_description }}</td>
                                    </tr>

                                    <tr>
                                        <th>Atasan</th>
                                        <td>{{ $approvalShow->head_description }}</td>
                                    </tr>

                                    <tr>
                                            <th>Jenis Cuti</th>
                                        <td>{{ $approvalShow->approval_description }}</td>
                                    </tr>

                                    <tr>
                                        <th>Detail Cuti</th>
                                        <td>{{ $approvalShow->detail }}</td>
                                    </tr>


                                    <tr>
                                        <th>Tanggal Mulai</th>
                                        <td>{{ $approvalShow->tanggal_mulai }}</td>
                                    </tr>

                                    <tr>
                                        <th>Tanggal Akhir</th>
                                        <td>{{ $approvalShow->tanggal_akhir }}</td>
                                    </tr>

                                    <tr>
                                        <th>Jumlah Hari</th>
                                        <td>{{ $approvalShow->akumulasi }}</td>
                                    </tr>

                                    <tr>
                                        <th>Tanggal Pengajuan</th>
                                        <td>{{ $approvalShow->tanggal_pengajuan}}</td>
                                    </tr>

                                    <tr>
                                        <th>Nama Kontak Darurat</th>
                                        <td>{{ $approvalShow->nama_kontak_darurat }}</td>
                                    </tr>

                                    <tr>
                                        <th>No Telepon Darurat</th>
                                        <td>{{ $approvalShow->telp_darurat }}</td>
                                    </tr>

                                    <tr>
                                        <th>Nama Delegasi</th>
                                        <td>{{ $approvalShow->nama_delegasi }}</td>
                                    </tr>

                                    <tr>
                                        <th>Detail Delegasi</th>
                                        <td>{{ $approvalShow->detail_delegasi }}</td>
                                    </tr>

                                    <tr>
                                        <th>File Pendukung</th>
                                        <td>
                                            @foreach ($approvalShow->file_up as $file)
                                                <a href="{{ asset('storage/' . $file) }}" target="_blank">
                                                    {{ basename($file) }}
                                                </a><br>
                                            @endforeach
                                        </td>
                                    </tr>
                                @elseif ($jenis === 'izin')
                                    <!--IZIN-->
                                    <tr>
                                    <th>No Telepon</th>
                                    <td>{{ $approvalShow->telepon }}</td>
                                </tr>

                                <tr>
                                    <th>Jabatan</th>
                                    <td >{{ $approvalShow->job_description }}</td>
                                </tr>

                                <tr>
                                    <th>Atasan</th>
                                    <td>{{ $approvalShow->head_description }}</td>
                                </tr>

                                <tr>
                                        <th>Jenis Izin</th>
                                    <td>{{ $approvalShow->approval_description }}</td>
                                </tr>

                                <tr>
                                    <th>Detail Izin</th>
                                    <td>{{ $approvalShow->detail_izin }}</td>
                                </tr>


                                <tr>
                                    <th>Tanggal Mulai</th>
                                    <td>{{ $approvalShow->tgl_mulai }}</td>
                                </tr>

                                <tr>
                                    <th>Tanggal Akhir</th>
                                    <td>{{ $approvalShow->tgl_akhir }}</td>
                                </tr>

                                <tr>
                                    <th>Jumlah Hari</th>
                                    <td>{{ $approvalShow->akumulasi }}</td>
                                </tr>

                                <tr>
                                    <th>Tanggal Pengajuan</th>
                                    <td>{{ $approvalShow->tgl_ajuan}}</td>
                                </tr>

                                <tr>
                                    <th>Nama Kontak Darurat</th>
                                    <td>{{ $approvalShow->nama_darurat }}</td>
                                </tr>

                                <tr>
                                    <th>No Telepon Darurat</th>
                                    <td>{{ $approvalShow->telp_darurat }}</td>
                                </tr>

                                <tr>
                                    <th>Hubungan Dengan Kontak Darurat</th>
                                    <td>{{ $approvalShow->relasi_darurat }}</td>
                                </tr>

                                <tr>
                                    <th>Nama Delegasi</th>
                                    <td>{{ $approvalShow->nama_delegasi }}</td>
                                </tr>

                                <tr>
                                    <th>Detail Delegasi</th>
                                    <td>{{ $approvalShow->detail_delegasi }}</td>
                                </tr>

                                <tr>
                                    <th>File Pendukung</th>
                                    <td>
                                        @foreach ($approvalShow->file_izin as $file)
                                            <a href="{{ asset('storage/' . $file) }}" target="_blank">
                                                {{ basename($file) }}
                                            </a><br>
                                        @endforeach
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <table id="approve-table" class="table table-hover" style="width: 100%">

            <thead class="text-success fw-medium">
                <tr>
                    <th class="fw-medium text-center" rowspan="2">id</th>
                    <th class="fw-medium text-center" rowspan="2">Jenis Approval</th>
                    <th class="fw-medium text-center" rowspan="2">Tanggal Pengajuan</th>
                    <th class="fw-medium text-center" rowspan="2">Action</th> <!--akan di disable oleh HR tergantung ketentuan-->
                </tr>
            </thead>

            <tbody>
                @foreach ($cutis as $cuti)
                <tr>
                    <td class="text-center">{{ $cuti->id }}</td>
                    <td class="text-center">{{ $cuti->jenis_cuti }}</td>
                    <td class="text-center">{{ $cuti->tanggal_pengajuan }}</td>
                   
                   {{-- ACTION CUTI --}}
                    <td class="text-center">
                        <button wire:click="showApprovalById({{ $cuti->id }}, 'cuti')" 
                            class="btn btn-outline-success btn-sm">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button wire:click="$dispatch('editCuti', {id: {{  $cuti->id }} })" class="btn btn-outline-warning btn-sm">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </button>
                        <button wire:click='deleteCuti({{ $cuti->id }})' class="btn btn-outline-danger btn-sm">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>

            <tbody>
                @foreach ($izins as $izin)
                <tr>
                    <td class="text-center">{{ $izin->id }}</td>
                    <td class="text-center">{{ $izin->jenis_izin }}</td>
                    <td class="text-center">{{ $izin->tgl_ajuan }}</td>

                   {{-- ACTION IZIN --}}
                    <td class="text-center">
                        <button wire:click="showApprovalById({{ $izin->id }}, 'izin')" class="btn btn-outline-success btn-sm">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button wire:click="$dispatch('editIzin', {id: {{  $izin->id }} })" class="btn btn-outline-warning btn-sm">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </button>
                        <button wire:click='deleteIzin({{ $izin->id }})' class="btn btn-outline-danger btn-sm">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-------------------------------JS---------------------------------------------------------------->
@push('scripts')
    <script>
        window.addEventListener('show-create-offcanvas-cuti', event => {
            const offcanvas = new bootstrap.Offcanvas('#cutiForm');
            offcanvas.show();
        });


        window.addEventListener('show-create-offcanvas-izin', event => {
            const offcanvas = new bootstrap.Offcanvas('#izinForm');
            offcanvas.show();
        });

        window.addEventListener('show-create-offcanvas-rab', event => {
            const offcanvas = new bootstrap.Offcanvas('#rabForm');
            offcanvas.show();
        });

        window.addEventListener('show-create-offcanvas-reimburse', event => {
            const offcanvas = new bootstrap.Offcanvas('#reimburseForm');
            offcanvas.show();
        });

        window.addEventListener('show-create-offcanvas-proyek', event => {
            const offcanvas = new bootstrap.Offcanvas('#pengadaanForm');
            offcanvas.show();
        });

        document.addEventListener('livewire:init', () => {
            Livewire.on('show-view-cuti-offcanvas', (event) => {
                const offcanvas = new bootstrap.Offcanvas('#viewApproval');
                offcanvas.show();
            })
        })

        document.addEventListener('livewire:init', () => {
            Livewire.on('show-view-izin-offcanvas', (event) => {
                const offcanvas = new bootstrap.Offcanvas('#viewApproval');
                offcanvas.show();
            })
        })

        // EDIT
        window.addEventListener('show-edit-offcanvas-cuti', event => {
            const offcanvas = new bootstrap.Offcanvas('#cutiForm');
            offcanvas.show();
        });

        window.addEventListener('show-edit-offcanvas-izin', event => {
            const offcanvas = new bootstrap.Offcanvas('#izinForm');
            offcanvas.show();
        });
    </script>
@endpush



{{-- @if ($approvalShow)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>No Telepon</th>
                                    <td>{{ $approvalShow->no_telepon }}</td>
                                </tr>

                                <tr>
                                    <th>Jabatan</th>
                                    <td >{{ $approvalShow->job_description }}</td>
                                </tr>

                                <tr>
                                    <th>Atasan</th>
                                    <td>{{ $approvalShow->head_description }}</td>
                                </tr>

                                <tr>
                                        <th>Jenis Cuti</th>
                                    <td>{{ $approvalShow->approval_description }}</td>
                                </tr>

                                <tr>
                                    <th>Detail Cuti</th>
                                    <td>{{ $approvalShow->detail }}</td>
                                </tr>


                                <tr>
                                    <th>Tanggal Mulai</th>
                                    <td>{{ $approvalShow->tanggal_mulai }}</td>
                                </tr>

                                <tr>
                                    <th>Tanggal Akhir</th>
                                    <td>{{ $approvalShow->tanggal_akhir }}</td>
                                </tr>

                                <tr>
                                    <th>Jumlah Hari</th>
                                    <td>{{ $approvalShow->akumulasi }}</td>
                                </tr>

                                <tr>
                                    <th>Tanggal Pengajuan</th>
                                    <td>{{ $approvalShow->tanggal_pengajuan}}</td>
                                </tr>

                                <tr>
                                    <th>Nama Kontak Darurat</th>
                                    <td>{{ $approvalShow->nama_kontak_darurat }}</td>
                                </tr>

                                <tr>
                                    <th>No Telepon Darurat</th>
                                    <td>{{ $approvalShow->telp_darurat }}</td>
                                </tr>

                                <tr>
                                    <th>Nama Delegasi</th>
                                    <td>{{ $approvalShow->nama_delegasi }}</td>
                                </tr>

                                <tr>
                                    <th>Detail Delegasi</th>
                                    <td>{{ $approvalShow->detail_delegasi }}</td>
                                </tr>

                                <tr>
                                    <th>File Pendukung</th>
                                    <td>
                                        @foreach ($approvalShow->file_up as $file)
                                            <a href="{{ asset('storage/' . $file) }}" target="_blank">
                                                {{ basename($file) }}
                                            </a><br>
                                        @endforeach
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>                  
                @endif --}}