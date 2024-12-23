@section('title', 'Menu')
<div>
    <style>
        .div-table:hover {
            background-color: #f5f5f5;
        }
    </style>
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- notification -->
        @include("template.notification")

        <!-- Bordered Table -->
        <div class="card">
            <div class="card-body">
                <div class="row mb-2 card-header">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-auto mt-1">
                                <input wire:model='txtKeyword' class="form-control form-control-sm mr-sm-2" type="search" name="menu_name" placeholder="Nama Menu">
                            </div>
                            <div class="col-auto mt-1">
                                <button class="btn btn-outline-primary ml-1 btn-sm" type="submit" name="action" value="search">
                                    <i class="bx bx-search-alt-2"></i>
                                </button>
                                <button class="btn btn-outline-primary ml-1 btn-sm" type="reset" name="action" value="reset">
                                    <i class="bx bx-reset"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <div>
                        Drag & drop judul menu untuk menyusun urutan menu!
                    </div>
                    <div class="col-auto">
                        {{-- @if (App\Models\Admin\BaseModel::isAuthorize($menu_id, "C")) --}}
                        <a href="{{ url('settings/menu/add') }}">
                            <button class="btn btn-outline-primary btn-sm">
                                <span class="fa fa-plus"></span> Tambah Data
                            </button>
                        </a>
                        {{-- @endif --}}
                    </div>
                </div>
                <div wire:sortable="tblUpdateParentMenuOrder" wire:sortable-group="tblUpdateChildMenuOrder" wire:sortable.options="{ animation: 50 }">
                    @foreach ($rs_menu_parent as $menu_parent)
                        <div wire:sortable.item="{{ $menu_parent->menu_id }}" wire:key="group-{{ $menu_parent->menu_id }}">
                            <div wire:sortable.handle role="button" class="div-table border mt-2 mb-1 pt-1 ps-1">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex align-items-center" style="gap: 2px;">
                                        <span style="font-weight: bold; font-size: 14px; gap: 10px;" class="d-flex align-items-center">
                                            <i class="{{$menu_parent->menu_icon}} mb-1"></i>
                                            ID:{{ $menu_parent->menu_id }} - {{ $menu_parent->menu_name }} -
                                        </span>
                                        @if ($menu_parent->menu_display)
                                            <i title="Tampil" class="btn-icon-primary bx bx-show"></i>
                                        @else
                                            <i title="Tidak Tampil" class="btn-icon-danger bx bx-hide"></i>
                                        @endif
                                        @if ($menu_parent->menu_active)
                                            <i title="Aktif" class="btn-icon-primary bx bx-check-circle"></i>
                                        @else
                                            <i title="Tidak Aktif" class="btn-icon-danger bx bx-x-circle"></i>
                                        @endif
                                    </div>
                                    <div class="me-1">
                                        <span>Parent Order: {{ $menu_parent->menu_sort }}</span> |
                                        <button onclick="window.location.href='{{ url('/settings/menu/access_control') }}/{{ $menu_parent->menu_id }}'" class="btn btn-outline-primary btn-sm" title="Menu Kontrol">
                                            <span class="bx bx-user-check"></span>
                                        </button>
                                        {{-- @if (App\Models\Admin\BaseModel::isAuthorize($menu_id, "U")) --}}
                                            <button onclick="window.location.href='{{ url('/settings/menu/edit') }}/{{ $menu_parent->menu_id }}'" class="btn btn-outline-warning btn-sm" title="Ubah">
                                                <span class="bx bx-edit"></span>
                                            </button>
                                        {{-- @endif --}}
                                        {{-- @if (App\Models\Admin\BaseModel::isAuthorize($menu_id, "D")) --}}
                                            <button onclick="window.location.href='{{ url('/settings/menu/delete_process') }}/{{ $menu_parent->menu_id }}'" class="btn btn-outline-danger btn-sm" onclick="return confirm('Apakah anda ingin menghapus menu {{ $menu_parent->menu_name }} ?')" title="Hapus">
                                                <span class="bx bx-trash"></span>
                                            </button>
                                        {{-- @endif --}}
                                    </div>
                                </div>
                            </div>
                            <div wire:sortable-group.item-group="{{ $menu_parent->menu_id }}" wire:sortable-group.options="{ animation: 50 }">
                                @foreach ($rs_menu_child as $menu_child)
                                    @if ($menu_child->parent_menu_id == $menu_parent->menu_id)
                                        <div wire:sortable-group.item="{{ $menu_child->menu_id }}" wire:key="menu-{{ $menu_child->menu_id }}" class="div-table border pt-1 mb-1 ps-1 ms-4">
                                            <div wire:sortable-group.handle role="button" class="d-flex justify-content-between">
                                                <div>
                                                    <span>ID: {{ $menu_child->menu_id }} - {{ $menu_child->menu_name }} - </span>
                                                    @if ($menu_child->menu_display)
                                                        <i title="Tampil" class="btn-icon-primary bx bx-show"></i>
                                                    @else
                                                        <i title="Tidak Tampil" class="btn-icon-danger bx bx-hide"></i>
                                                    @endif
                                                    @if ($menu_child->menu_active)
                                                        <i title="Aktif" class="btn-icon-primary bx bx-check-circle"></i>
                                                    @else
                                                        <i title="Tidak Aktif" class="btn-icon-danger bx bx-x-circle"></i>
                                                    @endif
                                                </div>
                                                <div class="me-1">
                                                    <span>Child Order: {{ $menu_child->menu_sort }}</span> |
                                                    <button onclick="window.location.href='{{ url('settings/menu/access_control') }}/{{ $menu_child->menu_id }}'" class="btn btn-outline-primary btn-sm" title="Menu Kontrol">
                                                        <i class="bx bx-user-check"></i>
                                                    </button>
                                                    {{-- @if (App\Models\Admin\BaseModel::isAuthorize($menu_id, "U")) --}}
                                                        <button onclick="window.location.href='{{ url('settings/menu/edit') }}/{{ $menu_child->menu_id }}'" class="btn btn-outline-warning btn-sm" title="Ubah">
                                                            <i class="bx bx-edit"></i>
                                                        </button>
                                                    {{-- @endif --}}
                                                    {{-- @if (App\Models\Admin\BaseModel::isAuthorize($menu_id, "D")) --}}
                                                        <button onclick="window.location.href='{{ url('settings/menu/delete_process') }}/{{ $menu_child->menu_id }}'" class="btn btn-outline-danger btn-sm" onclick="return confirm('Apakah anda ingin menghapus menu {{ $menu_parent->menu_name }} ?')" title="Hapus">
                                                            <i class="bx bx-trash"></i>
                                                        </button>
                                                    {{-- @endif --}}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
