<?php

namespace App\Livewire\Approval\Consulted\ConsultRab;

use App\Models\Approvals\ApprovalRab;
use App\Models\Approvals\ApprovalRabDetail;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RabDetail extends Component
{
    public $auth, $rabId;
    public $data, $rabDetailId, $statusCode, $note;

    public function render()
    {
        $this->loadData();
        return view('livewire.approval.consulted.consult-rab.rab-detail');
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
