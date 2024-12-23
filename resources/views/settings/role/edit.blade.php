<x-layouts.app>

    @section('title')
    Role
    @endsection


    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- notification -->
        @include("template.notification")

        <!-- Bordered Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Ubah Role</h5>
                <small class="text-muted float-end">
                    <button onclick="window.location.href='{{ url('/settings/role') }}'" class="btn btn-outline-primary btn-sm float-right d-flex align-items-center"><i class="bx bx-chevron-left"></i> Kembali</button>
                </small>
            </div>
            <form action="{{ url('/settings/role/edit_process') }}" method="post" autocomplete="off">
                <div class="card-body">
                    {{ csrf_field()}}
                    <input type="hidden" name="role_id" value="{{$role->role_id}}">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label >Nama Role <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="role_name" value="{{ old('role_name', $role->role_name) }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label>Deskripsi Role <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="role_description" value="{{ old('role_description', $role->role_description) }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label >Role Permission <span class="text-danger">*</span> <i class="bx bx-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title='Berikan nilai "1" atau "0" untuk masing - masing huruf "CRUD".'></i></label>
                                <input type="text" class="form-control" name="role_permission" value="{{ old('role_permission', $role->role_permission) }}" placeholder="CRUD" minlength="4" required>
                            </div>
                        </div>
                    </div>

                    <br>
                </div>
                <div class="float-end">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
