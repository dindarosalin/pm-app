<div>
    @section('title')
        Form Approval
    @endsection

    <!--KONEKSI-->
    {{-- <livewire:approved.pengajuan.upload-rule /> --}}

    <!--BUTTON CREATE PENGAJUAN APPROVAL DAN TABEL KETENTUAN-->
    <div class="card p-1 table-responsive">
        <div class="card-header row row-cols-2 row-cols-md-4 row-cols-md-5 g-2 d-flex justify-content-start">
            <button class="btn btn-sm btn-primary mb-3 mx-2" type="button">Form Cuti</button>
            <button class="btn btn-sm btn-primary mb-3 mx-2" type="button">Form Izin Tidak Terencana</button>
            <button class="btn btn-sm btn-primary mb-3 mx-2" type="button">Form Rencana Anggaran Belanja</button>
            <button class="btn btn-sm btn-primary mb-3 mx-2" type="button">Form Reimburse</button>
            <button class="btn btn-sm btn-primary mb-3 mx-2" type="button">Form Pengadaan Proyek</button>
        </div>

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
                        <td class="text-center">{{ $rule->jenis }}</td>

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
                    <th class="fw-medium text-center" rowspan="2">No</th>
                    <th class="fw-medium text-center" rowspan="2">Jenis Approval</th>
                    <th class="fw-medium text-center" rowspan="2">Tanggal Pengajuan</th>
                    <th class="fw-medium text-center" rowspan="2">Detail Pengajuan</th>
                    <th class="fw-medium text-center" rowspan="2">Action</th> <!--akan di disable oleh HR tergantung ketentuan-->
                </tr>
            </thead>

            <tbody></tbody>
        </table>
    </div>
</div>
