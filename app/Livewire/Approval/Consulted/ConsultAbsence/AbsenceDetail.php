<?php

namespace App\Livewire\Approval\Consulted\ConsultAbsence;

use App\Models\Approvals\ApprovalAbsences;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AbsenceDetail extends Component
{
    public $absenceId;
    public $auth, $absenceDetail;
    public $note;

    public function render()
    {
        $this->loadData();
        return view('livewire.approval.consulted.consult-absence.absence-detail');
    }

    public function mount($absenceId)
    {
        $this->absenceId = $absenceId;
    }

     public function loadData()
    {
        $this->auth = Auth::user()->user_id;
        $this->absenceDetail = ApprovalAbsences::getById($this->absenceId);
        $this->note = $this->absenceDetail->note;
    }

     public function updateAbsence()
    {
        ApprovalAbsences::updateNote($this->permissionId, $this->note);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Saved',
            'text' => 'It will list on the table.',
        ]);
    }
}
