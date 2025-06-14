<?php

namespace App\Livewire\Approval\Accountable\AccountableProject;

use App\Models\Approvals\ApprovalProjectProcurement;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AccountableTableProject extends Component
{
    public $auth, $projects;
    public function render()
    {
        $this->loadData();
        return view('livewire.approval.accountable.accountable-project.accountable-table-project');
    }

    public function loadData()
    {
        $this->auth = Auth::user()->user_id;
        $this->projects = ApprovalProjectProcurement::getByAccountable($this->auth);
    }
}
