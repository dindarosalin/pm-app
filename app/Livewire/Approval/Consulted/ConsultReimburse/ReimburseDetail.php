<?php

namespace App\Livewire\Approval\Consulted\ConsultReimburse;

use App\Models\Approvals\ApprovalReimburse;
use App\Models\Approvals\ApprovalReimburseDetail;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ReimburseDetail extends Component
{
    public $auth, $reimburseId;
    public $data, $reimburseDetailId, $statusCode, $note;

    public function render()
    {
        $this->loadData();
        return view('livewire.approval.consulted.consult-reimburse.reimburse-detail');
    }

    public function mount($reimburseId)
    {
        $this->reimburseId = $reimburseId;
    }

    public function loadData()
    {
        $this->auth = Auth::user()->user_id;
        $this->data = ApprovalReimburseDetail::getByReimburseIdAll($this->reimburseId);
    }

    public function updateReimburse()
    {
        ApprovalReimburse::updateStatus($this->reimburseId, $this->statusCode, $this->note);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Saved',
            'text' => 'It will list on the table.',
        ]);
    }
}
