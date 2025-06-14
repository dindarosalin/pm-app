<?php

namespace App\Livewire\Approval\Accountable\AccountablePermission;

use App\Models\Approvals\ApprovalPermissions;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AccountableTablePermission extends Component
{
    public $auth;

    public $permissions;
    public function render()
    {
        $this->loadData();
        // dd($this->permissions);
        return view('livewire.approval.accountable.accountable-permission.accountable-table-permission');
    }

    public function loadData()
    {
        $this->auth = Auth::user()->user_id;
        $this->permissions = ApprovalPermissions::getByAccountable($this->auth);
    }
}
