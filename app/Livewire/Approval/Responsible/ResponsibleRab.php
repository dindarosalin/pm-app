<?php

namespace App\Livewire\Approval\Responsible;

use App\Models\Approval\rab;
use App\Models\Approvals\ApprovalRab;
use App\Models\Approvals\ApprovalRules;
use App\Models\master\uom;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ResponsibleRab extends Component
{
    // RAB VAR
    public $auth, $rabs, $subject, $statusId, $rabId, $subDate, $rabDesc;

    // RAB DETAILS VAR
    public $rabDetailId, $name, $description, $uom, $qty, $iPrice, $iTPrice;
    public $rabRules, $step, $uoms;
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
        $this->uoms = uom::getAll();
    }

    public function save()
    {
        if ($this->rabId) {
            $this->updateRab($this->rabId);
            $this->updateDetailRab($this->rabDetailId);
        } else {
            $this->createRab();
            $this->createDetailRab();
        }
    }

    public function createRab()
    {
        $this->statusId = 1;
        ApprovalRab::create([
            $this->subject,
            $this->statusId,
            $this->auth,
        ]);
    }

    public function createDetailRab()
    {

    }

    public function updateRab($id)
    {

    }

    public function updateDetailRab($id)
    {

    }
}
