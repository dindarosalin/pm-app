<?php

namespace App\Livewire\Approval\Accountable\AccountableRab;

use App\Models\Approvals\ApprovalRab;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AccountableTableRab extends Component
{
    public $auth, $rabs;
    public function render()
    {
        $this->loadData();
        // dd($this->rabs);
        return view('livewire.approval.accountable.accountable-rab.accountable-table-rab');
    }

    public function loadData()
    {
        $this->auth = Auth::user()->user_id;
        $this->rabs = ApprovalRab::getAll();
    }

}
