<?php

namespace App\Livewire\Approval\Consulted\ConsultPermission;

use App\Models\Approvals\ApprovalPermissions;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PermissionTable extends Component
{
    public $auth, $permissions;
    public function render()
    {
        $this->loadData();
        // dd($this->permissions);
        return view('livewire.approval.consulted.consult-permission.permission-table');
    }

    public function loadData()
    {
        $this->auth = Auth::user()->user_id;
        $this->permissions = ApprovalPermissions::getAll();
    }
}
