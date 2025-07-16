<?php

namespace App\Livewire\Approval\Accountable\AccountableAbsence;

use App\Models\Approvals\ApprovalAbsences;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AccountableDetailAbsence extends Component
{
    public $absenceId;
    public $auth;
    public $absenceDetail;
    public $statusCode, $note;
    public function render()
    {
        $this->loadData();
        return view('livewire.approval.accountable.accountable-absence.accountable-detail-absence');
    }

    public function mount($absenceId)
    {
        $this->absenceId = (int) $absenceId;
    }

    public function loadData()
    {
        $this->auth = Auth::user()->user_id;
        $this->absenceDetail = ApprovalAbsences::getById($this->absenceId);
    }

     public function updateAbsence()
    {
        ApprovalAbsences::updateStatus($this->absenceId, $this->statusCode, $this->note);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Saved',
            'text' => 'It will list on the table.',
        ]);
    }
}
