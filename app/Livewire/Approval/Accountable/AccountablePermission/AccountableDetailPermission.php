<?php

namespace App\Livewire\Approval\Accountable\AccountablePermission;

use App\Models\Approvals\ApprovalPermissions;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AccountableDetailPermission extends Component
{
    public $permissionId;
    public $auth;
    public $permissionDetail;
    public $statusCode, $note;
    public function render()
    {
        // dd($this->permissionId);
        $this->loadData();
        // dd($this->permissionDetail);
        return view('livewire.approval.accountable.accountable-permission.accountable-detail-permission');
    }

    public function mount($permissionId)
    {
        $this->permissionId = (int) $permissionId;
    }

    public function loadData()
    {
        $this->auth = Auth::user()->user_id;
        $this->permissionDetail = ApprovalPermissions::getById($this->permissionId);
    }

    public function updatePermission()
    {
        // if ($this->statusCode === 3) {
        //     // need revision
        //     ApprovalPermissions::updateStatus($this->permissionId, $this->statusCode, $this->note);
        // } else {
        //     ApprovalPermissions::updateStatus($this->permissionId, $this->statusCode, $this->note);
        // }

        ApprovalPermissions::updateStatus($this->permissionId, $this->statusCode, $this->note);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Saved',
            'text' => 'It will list on the table.',
        ]);
    }
}
