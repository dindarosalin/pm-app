<?php

namespace App\Livewire\Approval\Accountable\AccountableAbsence;

use App\Models\Approvals\ApprovalAbsences;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AccountableTableAbsence extends Component
{
    public $auth, $absences;
    public function render()
    {
        $this->loadData();
        // dd($this->absences);
        return view('livewire.approval.accountable.accountable-absence.accountable-table-absence');
    }

    public function loadData()
    {
        $this->auth = Auth::user()->user_id;
        $this->absences = ApprovalAbsences::getByAccountable($this->auth);
    }

}
