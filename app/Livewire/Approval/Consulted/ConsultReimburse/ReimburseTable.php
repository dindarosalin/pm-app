<?php

namespace App\Livewire\Approval\Consulted\ConsultReimburse;

use App\Models\Approvals\ApprovalReimburse;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ReimburseTable extends Component
{
    public $auth, $reimburses;

    public function render()
    {
        $this->loadData();
        return view('livewire.approval.consulted.consult-reimburse.reimburse-table');
    }

    public function loadData()
    {
        $this->auth = Auth::user()->user_id;
        $this->reimburses = ApprovalReimburse::getAll();
    }
}
