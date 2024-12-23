<x-layouts.app>
    @section('title')
    Akun User
    @endsection

    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- notification -->
        @include('template.notification')

        <!-- Bordered Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Ubah Akun User</h5>
                <small class="text-muted float-end">
                    <button onclick="window.location.href='{{ url('/settings/accounts') }}'" class="btn btn-outline-primary btn-sm float-right align-items-center d-flex"><i
                        class="bx bx-chevron-left"></i> Kembali</button>
                    </small>
                </div>
                <form action="{{ url('/settings/accounts/edit_process') }}" method="post" autocomplete="off">
                    <div class="card-body">
                        {{ csrf_field() }}
                        <input type="hidden" name="user_id" value="{{ $account->user_id }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="user_name" value="{{ $account->user_name }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Email<span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="user_email"
                                    value="{{ $account->user_email }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Nomor Telepon</label>
                                    <input type="number" class="form-control" name="no_telp"
                                    value="{{ old('no_telp', $account->no_telp) }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Aktifkan Akun? <span class="text-danger">*</span></label>
                                    <select class="form-select" name="user_active" required>
                                        <option value="1" @if ($account->user_active == '1') selected @endif>Ya</option>
                                        <option value="0" @if ($account->user_active == '0') selected @endif>Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Role User <span class="text-danger">*</span></label>
                                    <select class="form-select" id="role_id" name="role_id" required>
                                        <option value="" selected disabled>Pilih</option>
                                        @foreach ($rs_role as $role)
                                        <option value="{{ $role->role_id }}" @if ($account->role_id == $role->role_id) selected
                                            @endif>
                                            {{ $role->role_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Tipe User <span class="text-danger">*</span></label>
                                        <select class="form-select select-2" id="type" name="type" required>
                                            <option value="umum" @if ($account->type == 'umum') selected @endif>Umum</option>
                                            <option value="head" @if ($account->type == 'head') selected @endif>Head</option>
                                            <option value="pic" @if ($account->type == 'pic') selected @endif>PIC</option>
                                            <option value="admin" @if ($account->type == 'admin') selected @endif>Admin</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="float-end mb-2">
                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </x-layouts.app>
