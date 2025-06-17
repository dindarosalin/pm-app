<?php

namespace App\Livewire\Approval\Responsible;

use App\Models\Approvals\ApprovalAbsences;
use App\Models\Approvals\ApprovalPermissions;
use App\Models\Approvals\ApprovalProjectProcurement;
use App\Models\Approvals\ApprovalRab;
use App\Models\Approvals\ApprovalReimburse;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ResponsibleDashboard extends Component
{
    public $approvals, $permissions, $absences, $rabs, $reimburses, $projects;
    public $auth;

    public $approvalTotal;

    public function render()
    {
        $this->loadData();
        return view('livewire.approval.responsible.responsible-dashboard');
    }

    public function loadData()
    {
        $this->auth = Auth::user()->user_id;
        $this->getAllApproval();
    }

    public function getAllApproval()
    {
        $this->permissions = ApprovalPermissions::getAllByUserId($this->auth)->map(function ($item) {
            $item->subject_name = $item->subject_name ?? ($item->subject ?? '-');
            return $item;
        });

        $this->absences = ApprovalAbsences::getAllByUserId($this->auth)->map(function ($item) {
            $item->subject_name = $item->subject_name ?? ($item->subject ?? '-');
            return $item;
        });

        $this->rabs = ApprovalRab::getAllByUserId($this->auth)->map(function ($item) {
            $item->subject_name = $item->subject_name ?? ($item->subject ?? '-');
            return $item;
        });

        $this->reimburses = ApprovalReimburse::getAllByUserId($this->auth)->map(function ($item) {
            $item->subject_name = $item->subject_name ?? ($item->subject ?? '-');
            return $item;
        });

        $this->projects = ApprovalProjectProcurement::getAllByUserId($this->auth)->map(function ($item) {
            $item->subject_name = $item->project_name ?? '-';
            return $item;
        });

        // dd($this->permissions, $this->rabs, $this->reimburses, $this->projects);

        $this->approvals = collect()->merge($this->permissions)->merge($this->absences)->merge($this->rabs)->merge($this->reimburses)->merge($this->projects);
        $this->approvalTotal = $this->approvals->count();
    }
}
