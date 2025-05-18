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

        <table id="approve-table" class="table table-hover" style="width: 100%">

            <thead class="text-success fw-medium">
                <tr>
                    <th class="fw-medium text-center" rowspan="2">Jenis Approval</th>
                    <th class="fw-medium text-center" rowspan="2">Tanggal Pengajuan</th>
                    <th class="fw-medium text-center" rowspan="2">Detail Pengajuan</th>
                    <th class="fw-medium text-center" rowspan="2">Action</th> <!--akan di disable oleh HR tergantung ketentuan-->
                </tr>
            </thead>

            <tbody>
                @foreach ($cutis as $cuti)
                <tr>
                    <td class="text-center">{{ $cuti->jenis_cuti }}</td>
                    <td class="text-center">{{ $cuti->tanggal_pengajuan }}</td>
                    <td class="text-center"> 
                        <button wire:click="detailCuti({{ $cuti->id }})" class="btn btn-outline-success btn-sm">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-outline-warning btn-sm">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </button>
                        <button class="btn btn-outline-danger btn-sm">
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

        window.addEventListener('show-modal-cuti', event => {
            const myModal = new bootstrap.Modal(document.getElementById('detailModal'));
                myModal.show();
        })
    </script>
@endpush
