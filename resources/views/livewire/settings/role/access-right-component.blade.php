<div>
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- notification -->
        @include("template.notification")

        <!-- Bordered Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Ubah Hak Akses : {{ $this->rs_role["role_name"] }}</h5>
                <small class="text-muted float-end">
                    <button onclick="window.location.href='{{ url('/settings/role') }}'" class="btn btn-outline-primary btn-sm float-right d-flex align-items-center"><i class="bx bx-chevron-left"></i> Kembali</button>
                </small>
            </div>
            <div class="card-body">
                <div class="d-inline-block me-3">
                    <div class="form-check mb-3">
                        <input type="checkbox" wire:model="cbAll" wire:click="cbAll_Clicked" id="cbAll" name="cbAll" class="form-check-input">
                        <label class="form-check-label ">Check All</label>
                    </div>
                </div>
                <div class="d-inline-block">
                    <button wire:click='btnSaveAccessRight_clicked' type="submit" class="btn btn-success btn-sm"><i class='bx bxs-save'></i> Simpan</button>
                </div>
                <div class="table-responsive ">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                {{-- <th width="5%">No</th> --}}
                                <th width="5%">ID</th>
                                <th width="35%">Menu</th>
                                <th>Hak Akses
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($rs_menu_parent)>0)
                                @foreach ($rs_menu_parent as $parent_index => $menu_parent)
                                    <tr>
                                        {{-- <td class="text-center">{{ $parent_index + 1 }}</td> --}}
                                        <td class="text-center">{{ $menu_parent->menu_id }}</td>
                                        <td>{{ !empty($menu_parent->parent_menu_id) ? '-- -- '.$menu_parent->menu_name : $menu_parent->menu_name }}</td>
                                        <td>
                                            <div class="form-check">
                                            <input type="checkbox" wire:model="cbMenuList" wire:click="cbMenuList_Clicked" id="cb{{ $menu_parent->menu_id }}" name="control" value="{{ $menu_parent->menu_id }}" class="form-check-input">
                                            <label id="lbl{{ $menu_parent->menu_id }}" class="form-check-label">All</label>
                                            </div>
                                            @if (count($rs_menu_control)>0)
                                                @foreach ($rs_menu_control as $menu_control_index => $menu_control_item)
                                                    @if ($menu_parent->menu_id==$menu_control_item->menu_id)
                                                    <div class="form-check">
                                                        <input type="checkbox" wire:model="cbControlList" wire:click="cbControlList_Clicked" id="cb{{ $menu_parent->menu_id }}-{{ $menu_control_item->id }}" value="{{ $menu_parent->menu_id }}-{{ $menu_control_item->id }}" name="control" class="form-check-input">
                                                        <label class="form-check-label">{{ $menu_control_item->control_name }}</label>
                                                    </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </td>
                                    </tr>
                                    @foreach ($rs_menu_child as $child_index => $menu_child)
                                        @if ($menu_child->parent_menu_id == $menu_parent->menu_id)
                                            <tr>
                                                {{-- <td class="text-center">{{ $child_index + 1 }}</td> --}}
                                                <td class="text-center">{{ $menu_child->menu_id }}</td>
                                                <td>{{ !empty($menu_child->parent_menu_id) ? '-- -- '.$menu_child->menu_name : $menu_child->menu_name }}</td>
                                                <td>
                                                    <div class="form-check">
                                                    <input type="checkbox" wire:model="cbMenuList" wire:click="cbMenuList_Clicked" id="cb{{ $menu_child->menu_id }}" name="control" value="{{ $menu_child->menu_id }}" class="form-check-input">
                                                    <label id="lbl{{ $menu_child->menu_id }}" class="form-check-label">All</label>
                                                    </div>
                                                    @if (count($rs_menu_control)>0)
                                                        @foreach ($rs_menu_control as $menu_control_index => $menu_control_item)
                                                            @if ($menu_child->menu_id==$menu_control_item->menu_id)
                                                            <div class="form-check">
                                                                <input type="checkbox" wire:model="cbControlList" wire:click="cbControlList_Clicked" id="cb{{ $menu_child->menu_id }}-{{ $menu_control_item->id }}" value="{{ $menu_child->menu_id }}-{{ $menu_control_item->id }}" name="control" class="form-check-input">
                                                                <label class="form-check-label">{{ $menu_control_item->control_name }}</label>
                                                            </div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="float-end mt-3 mb-3">
                    <button wire:click='btnSaveAccessRight_clicked' type="submit" class="btn btn-primary btn-sm"><i class='bx bxs-save'></i> Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>
