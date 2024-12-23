<x-layouts.app>
    @section('title')
    Pengaturan Akun User
    @endsection

    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- notification -->
        @include("template.notification")

        <!-- Bordered Table -->
        <div class="card">
            <div class="card-body">
                <div class="row mb-2 card-header">
                    <div class="col-md-12">
                        <form class="form-inline" action="{{ url('/settings/accounts/search') }}" method="get" autocomplete="off">
                            <div class="row">
                                <div class="col-auto mt-1">
                                    <input class="form-control form-control-sm mr-sm-2" type="search" name="user_name" value="{{ !empty($user_name) ? $user_name : '' }}" placeholder="Nama" minlength="3" required>
                                </div>
                                <div class="col-auto mt-1">
                                    <button class="btn btn-outline-primary ml-1 btn-sm" type="submit" name="action" value="search">
                                        <i class="bx bx-search-alt-2"></i>
                                    </button>
                                    <button class="btn btn-outline-primary ml-1 btn-sm" type="submit" name="action" value="reset">
                                        <i class="bx bx-reset"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row justify-content-end mb-2">
                    <div class="col-auto ">
                        <button onclick="window.location.href='{{ url('/settings/accounts/add') }}'" class="btn btn-outline-primary btn-sm float-right"><i class="fas fa-plus"></i> Tambah Data</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr class="text-center">
                                <th width="5%">No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Tipe User</th>
                                <th width="10%">Status</th>
                                <th width="18%">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($rs_accounts->count() > 0)
                            @foreach($rs_accounts as $index => $account)
                            <tr>
                                <td class="text-center">{{ $index + $rs_accounts->firstItem() }}</td>
                                <td>{{ $account->user_name }}</td>
                                <td>{{ $account->user_email }}</td>
                                <td>{{ $account->role_name }}</td>
                                <td>{{ $account->type }}</td>
                                <td class="text-center" >
                                    @if($account->user_active == '1')
                                    Active
                                    @else
                                    Inactive
                                    @endif
                                </td>
                                <td class="d-flex" style="flex-direction: column;">
                                    {{-- @if($role_id == '01') --}}
                                    @if(Auth::user()->user_id != $account->user_id)
                                    <button href="#" data-id="{{ Crypt::encryptString($account->user_id) }}" data-m="{{ Crypt::encryptString($account->user_email) }}" class="btn btn-outline-primary btn-sm m-1 btn-take-over-login"> Login</button>
                                    {{-- @endif --}}
                                    @endif
                                    <button onclick="window.location.href='{{ url('/settings/accounts/edit_password') }}/{{ $account->user_id }}'" class="btn btn-outline-success btn-sm m-1"> Password</button>
                                    <button onclick="window.location.href='{{ url('/settings/accounts/edit') }}/{{ $account->user_id }}'" class="btn btn-outline-warning btn-sm m-1 "> Ubah</button>
                                    <button onclick="if (confirm('Apakah anda ingin menghapus Akun {{ $account->user_name }} ?')) { window.location.href='{{ url('/settings/accounts/delete_process') }}/{{ $account->user_id }}'; }" class="btn btn-outline-danger btn-sm m-1"> Hapus</button>

                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td class="text-center" colspan="7">Tidak ada data.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <!-- pagination -->
                <div class="row mt-3 justify-content-between">
                    <div class="col-auto">
                        <p>Menampilkan {{ $rs_accounts->count() }} dari total {{ $rs_accounts->total() }} data.</p>
                    </div>
                    <div class="col-auto ">
                        {{ $rs_accounts->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Loading-->
    <div class="modal fade" id="loadingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="loadingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mb-0 mt-2" id="text-loading">Loading...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(".btn-take-over-login").on("click", function(e){
            var id      = $(this).data('id');
            var m     = $(this).data('m');
            var url     = "{{ url('settings/take-over-login?') }}id="+id+"&m="+m;

            // confirm
            if(confirm("Yakin ingin berganti akun?")){
                // show loading
                $("#loadingModal").modal('show');

                setTimeout(function(){
                    $("#text-loading").html('Melakukan login...');
                }, 3000);

                setTimeout(function(){
                    $("#text-loading").html('Mengambil alih akun...');
                }, 6000);

                // take over login
                window.open(url, "_self");
            }
            else {
                // nothing
            }

        });
    </script>
</x-layouts.app>
