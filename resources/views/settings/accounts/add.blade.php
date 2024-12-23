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
                <h5 class="mb-0">Tambah Akun User</h5>
                <small class="text-muted float-end">
                    <button onclick="window.location.href='{{ url('/settings/accounts') }}'" class="btn btn-outline-primary d-flex align-items-center btn-sm float-right"><i class="bx bx-chevron-left"></i> Kembali</button>
                </small>
            </div>
            <form action="{{ url('/settings/accounts/add_process') }}" method="post" autocomplete="off">
                <div class="card-body">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Nama</label>
                                <input type="text" class="form-control" name="user_name" value="{{ old('user_name') }}"
                                required>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" class="form-control" id="employee_id" name="employee_id" value="" required>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Email<span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="user_email" name="user_email" value=""
                                required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Password<span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="user_password" minlength="8"
                                maxlength="20" value="" required>
                                <small class="form-text text-muted">Minimal panjang 8 karakter mengandung angka dan huruf kapital.</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Nomor Telepon</label>
                                <input type="number" class="form-control" name="no_telp" value="{{ old('no_telp') }}">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Aktifkan Akun? <span class="text-danger">*</span></label>
                                <select class="form-select" name="user_active" required>
                                    <option value="1" @if( old('user_active')=='1' ) selected @endif>Ya</option>
                                    <option value="0" @if( old('user_active')=='0' ) selected @endif>Tidak</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Role User <span class="text-danger">*</span></label>
                                <select class="form-select select-2" id="role_id" name="role_id" required>
                                    <option value="" selected disabled>Pilih</option>
                                    @foreach ($rs_role as $role)
                                    <option value="{{ $role->role_id }}" @if (old('role_id') == $role->role_id) selected @endif>{{ $role->role_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Tipe User <span class="text-danger">*</span></label>
                                <select class="form-select select-2" id="type" name="type" required>
                                    <option value="umum" @if (old('type') == 'umum') selected @endif>Umum</option>
                                    <option value="head" @if (old('type') == 'head') selected @endif>Head</option>
                                    <option value="pic" @if (old('type') == 'pic') selected @endif>PIC</option>
                                    <option value="admin" @if (old('type') == 'admin') selected @endif>Admin</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
                <div class="float-end mb-2">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                </div>
            </div>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            $("#user_name").change(function() {
                var email = $(this).children(':selected').attr('data-email');
                var employee_id = $(this).children(':selected').attr('data-employee_id');
                // console.log(employee_id);
                $("#user_email").val(email);
                $("#employee_id").val(employee_id);
            });
        })
    </script>
</x-layouts.app>
