<?php

namespace App\Livewire\Approval\Consulted\ConsultPermission;

use App\Models\Approvals\ApprovalPermissions;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PermissionDetail extends Component
{
    public $permissionId;
    public $auth, $permissionDetail;

    public $note;
    public function render()
    {
        $this->loadData();
        return view('livewire.approval.consulted.consult-permission.permission-detail');
    }

    public function mount($permissionId)
    {
        $this->permissionId = $permissionId;
    }

    public function loadData()
    {
        $this->auth = Auth::user()->user_id;
        $this->permissionDetail = ApprovalPermissions::getById($this->permissionId);
        $this->note = $this->permissionDetail->note;
    }

    public function updatePermission()
    {
        ApprovalPermissions::updateNote($this->permissionId, $this->note);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Saved',
            'text' => 'It will list on the table.',
        ]);
    }

}
