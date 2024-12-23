<x-layouts.app>
    @section('title')
    Akun User
    @endsection

    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- notification -->
        @include("template.notification")

        <!-- Bordered Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Ubah Password Akun User</h5>
                <small class="text-muted float-end">
                    <button onclick="window.location.href='{{ url('/settings/accounts') }}'" class="btn btn-outline-primary btn-sm float-right d-flex align-items-center"><i class="bx bx-chevron-left"></i> Kembali</button>
                </small>
            </div>
            <form action="{{ url('/settings/accounts/edit_password_process') }}" method="post" autocomplete="off">
                <div class="card-body">
                    {{ csrf_field()}}
                    <input type="hidden" name="user_id" value="{{ $account->user_id }}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Password Baru<span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="new_password" required>
                                <small class="form-text text-muted">Minimal 8 karakter, minimal mengandung angka dan huruf kapital.</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Ulangi Password Baru<span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="repeat_new_password" required>
                                <small class="form-text text-muted">Minimal 8 karakter, minimal mengandung angka dan huruf kapital.</small>
                            </div>
                        </div>
                    </div>

                    <br>
                </div>
                <div class="mb-2 float-end">
                    <button type="submit" class="btn btn-success btn-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
