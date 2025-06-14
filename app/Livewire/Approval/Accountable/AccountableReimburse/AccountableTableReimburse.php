<?php

namespace App\Livewire\Approval\Accountable\AccountableReimburse;

use App\Models\Approvals\ApprovalReimburse;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AccountableTableReimburse extends Component
{
    public $auth, $reimburses;
    public function render()
    {
        $this->loadData();
        return view('livewire.approval.accountable.accountable-reimburse.accountable-table-reimburse');
    }

    public function loadData()
    {
        $this->auth = Auth::user()->user_id;
        $this->reimburses = ApprovalReimburse::getAll();
    }
}
