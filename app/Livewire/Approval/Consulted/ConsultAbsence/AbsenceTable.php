<?php

namespace App\Livewire\Approval\Consulted\ConsultAbsence;

use App\Models\Approvals\ApprovalAbsences;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AbsenceTable extends Component
{
    public $auth, $absences;
    public function render()
    {
        $this->loadData();
        return view('livewire.approval.consulted.consult-absence.absence-table');
    }

    public function loadData()
    {
        $this->auth = Auth::user()->user_id;
        $this->absences = ApprovalAbsences::getAll();
    }
}
