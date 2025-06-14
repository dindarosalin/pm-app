<?php

namespace App\Livewire\Approval\Accountable\AccountableProject;

use App\Models\Approvals\ApprovalProjectProcurement;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AccountableDetailProject extends Component
{
    public $projectId;
    public $auth;
    public $project;
    public $statusCode, $note;
    public function render()
    {
        $this->loadData();
        return view('livewire.approval.accountable.accountable-project.accountable-detail-project');
    }

     public function mount($projectId)
    {
        $this->projectId = (int) $projectId;
    }

    public function loadData()
    {
        $this->auth = Auth::user()->user_id;
        $this->project = ApprovalProjectProcurement::getById($this->projectId);
    }

    public function updatePermission()
    {
        ApprovalProjectProcurement::updateStatus($this->projectId, $this->statusCode, $this->note);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Saved',
            'text' => 'It will list on the table.',
        ]);
    }

}
