<?php

namespace App\Livewire\Approval\Consulted\ConsultRab;

use App\Models\Approvals\ApprovalRab;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RabTable extends Component
{
    public $auth, $rabs;

    public function render()
    {
        $this->loadData();
        return view('livewire.approval.consulted.consult-rab.rab-table');
    }

    public function loadData()
    {
        $this->auth = Auth::user()->user_id;
        $this->rabs = ApprovalRab::getAll();
    }
}
