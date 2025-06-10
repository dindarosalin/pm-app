<?php

namespace App\Livewire\Approval\Responsible;

use App\Models\Approval\rab;
use App\Models\Approvals\ApprovalRab;
use App\Models\Approvals\ApprovalRules;
use App\Models\master\uom;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class ResponsibleRab extends Component
{
    // RAB VAR
    public $auth, $rabs, $subject, $statusId, $rabId, $subDate, $rabDesc, $total;

    // RAB DETAILS VAR
    public $rabRules;
    public $approvalId = 3;

    public function render()
    {
        $this->loadData();
        return view('livewire.approval.responsible.responsible-rab');
    }

    public function loadData()
    {
        $this->auth = Auth::user()->user_id;
        $this->rabs = ApprovalRab::getAll();
        $this->rabRules = ApprovalRules::getByType($this->approvalId);
    }

    public function save()
    {
        if ($this->rabId) {
            $this->updateRab($this->rabId);
        } else {
            $this->createRab();
        }
    }

    public function createRab()
    {
        $this->statusId = 1;
        ApprovalRab::create([
            'subject' => $this->subject,
            'statusId' => $this->statusId,
            'auth' => $this->auth,
            'approvalId' => $this->approvalId,
            'rabDesc' => $this->rabDesc,
            'total' => 0
        ]);
    }

    public function updateRab($id)
    {
        ApprovalRab::update($id,[
            'subject' => $this->subject,
            'statusId' => $this->statusId,
            'auth' => $this->auth,
            'approvalId' => $this->approvalId,
            'rabDesc' => $this->rabDesc,
            'total' => $this->total,
            'subDate' => $this->subDate,
        ]);
    }

    public function edit($id)
    {
        $this->dispatch('show-offcanvas');
        $rab = ApprovalRab::getById($id);

        // dd($rab);
        $this->rabId = $rab->id;
        $this->subject = $rab->subject;
        $this->statusId = $rab->status_id;
        $this->rabDesc = $rab->description;
        $this->total = $rab->total;
        $this->subDate = $rab->submission_date;
    }

    public function alertConfirm($id)
    {
        $this->dispatch('swal:confirm', [
            'type' => 'warning',
            'message' => 'Are you sure?',
            'text' => 'You won\'t be able to revert this!',
            'id' => $id,
            'dispatch' => 'delete',
        ]);
    }

    #[On('delete')]
    public function delete($id)
    {
        ApprovalRab::delete($id);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Deleted',
            'text' => 'It will not list on the table.',
        ]);
    }
}
