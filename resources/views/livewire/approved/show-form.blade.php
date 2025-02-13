<div>
    @section('title')
        FormApproval
    @endsection
    <div class="card p-1 table-responsive">
        <table id="approveform-table" class="table table-hover table-sm" style="width: 100%">
            <thead class="text-success fw-medium">
                <tr>
                    {{-- <th class="fw-medium text-center" rowspan="2">No</th> --}}
                    <th class="fw-medium text-center" rowspan="2">Ketentuan Approval</th>
                    <th class="fw-medium text-center" rowspan="2">Form Approval</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#cutiBackdrop">
                                Cuti
                            </button>
                        </td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-success m-2" type="button">Form Cuti</button>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#izinBackdrop">
                            Izin Tidak Terencana
                        </button>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-success m-2" type="button">Form Izin Tidak Terencana</button>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#rabBackdrop">
                            Rencana Anggaran Belanja
                        </button>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-success m-2" type="button">Form Rencana Anggaran Belanja</button>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#reimburseBackdrop">
                            Reimburse
                        </button>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-success m-2" type="button">Form Reimburse</button>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#proyekBackdrop">
                            Pengadaan Proyek
                        </button>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-success m-2" type="button">Form Pengadaan Proyek</button>
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- MODAL --}}
        {{-- cuti --}}
        <div class="modal fade" id="cutiBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="staticBackdropLabel">Ketentuan Pengajuan Cuti</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  ...
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  <button type="button" class="btn btn-sm btn-outline-success">Simpan</button>
                </div>
              </div>
            </div>
        </div>

          {{-- izin tidak terencana --}}
        <div class="modal fade" id="izinBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="staticBackdropLabel">Ketentuan Pengajuan Izin Tidak Terencana</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  ...
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  <button type="button" class="btn btn-sm btn-outline-success">Simpan</button>
                </div>
              </div>
            </div>
          </div>

          {{-- RAB --}}
        <div class="modal fade" id="rabBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="staticBackdropLabel">Ketentuan Pengajuan Rencana Anggaran Belanja</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  ...
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  <button type="button" class="btn btn-sm btn-outline-success">Simpan</button>
                </div>
              </div>
            </div>
          </div>

          {{-- Reimburse --}}
        <div class="modal fade" id="reimburseBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="staticBackdropLabel">Ketentuan Pengajuan Reimburse</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  ...
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  <button type="button" class="btn btn-sm btn-outline-success">Simpan</button>
                </div>
              </div>
            </div>
          </div>

          {{-- pengadaan proyek --}}
        <div class="modal fade" id="proyekBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="staticBackdropLabel">Ketentuan Pengajuan Pengadaan Proyek</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  ...
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  <button type="button" class="btn btn-sm btn-outline-success">Simpan</button>
                </div>
              </div>
            </div>
          </div>
    </div>
        {{-- END MODAL --}}
</div>

