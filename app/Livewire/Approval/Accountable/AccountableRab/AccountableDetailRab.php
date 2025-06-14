<?php

namespace App\Livewire\Approval\Accountable\AccountableRab;

use App\Models\Approvals\ApprovalRab;
use App\Models\Approvals\ApprovalRabDetail;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AccountableDetailRab extends Component
{
    public $auth, $rabId;
    public $data, $rabDetailId, $statusCode, $note;
    public function render()
    {
        $this->loadData();
        // dd($this->data);
        return view('livewire.approval.accountable.accountable-rab.accountable-detail-rab');
    }

    public function mount($rabId)
    {
        $this->rabId = $rabId;
    }

    public function loadData()
    {
        $this->auth = Auth::user()->user_id;
        $this->data = ApprovalRabDetail::getByRabIdAll($this->rabId);
    }

    public function updateRab()
    {
        ApprovalRab::updateStatus($this->rabId, $this->statusCode, $this->note);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Saved',
            'text' => 'It will list on the table.',
        ]);
    }
}
