<?php

namespace App\Livewire\Approval\Consulted\ConsultProjectProcurement;

use App\Models\Approvals\ApprovalProjectProcurement;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProjectTable extends Component
{
     public $auth, $projects;

    public function render()
    {
        $this->loadData();
        return view('livewire.approval.consulted.consult-project-procurement.project-table');
    }

    public function loadData()
    {
        $this->auth = Auth::user()->user_id;
        $this->projects = ApprovalProjectProcurement::getByAccountable($this->auth);
    }
}
