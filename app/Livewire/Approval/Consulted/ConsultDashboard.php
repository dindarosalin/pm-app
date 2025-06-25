<?php

namespace App\Livewire\Approval\Consulted;

use App\Models\Approvals\ApprovalAbsences;
use App\Models\Approvals\ApprovalPermissions;
use App\Models\Approvals\ApprovalProjectProcurement;
use App\Models\Approvals\ApprovalRab;
use App\Models\Approvals\ApprovalReimburse;
use DB;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ConsultDashboard extends Component
{
    public $approvals, $permissions, $absences, $rabs, $reimburses, $projects;
    public $auth;
    public $approvalTotal;
    public function render()
    {
        $this->loadData();
        return view('livewire.approval.consulted.consult-dashboard');
    }

    public function loadData()
    {
        $this->auth = Auth::user()->user_id;
        $this->getAllApproval();
    }

    public function getAllApproval()
    {
        $finance = DB::table('app_role_user')->where('user_id', $this->auth)->where('role_id', '08')->value('user_id');

        if ($this->auth == $finance) {
            $this->rabs = ApprovalRab::getAllByFinance($this->auth)->map(function ($item) {
                $item->subject_name = $item->subject_name ?? ($item->subject ?? '-');
                return $item;
            });

            $this->reimburses = ApprovalReimburse::getAllByFinance($this->auth)->map(function ($item) {
                $item->subject_name = $item->subject_name ?? ($item->subject ?? '-');
                return $item;
            });

            $this->projects = ApprovalProjectProcurement::getAllByRole($this->auth)->map(function ($item) {
                $item->subject_name = $item->project_name ?? '-';
                return $item;
            });
        } else {
            $this->permissions = ApprovalPermissions::getAllByRole($this->auth)->map(function ($item) {
                $item->subject_name = $item->subject_name ?? ($item->subject ?? '-');
                return $item;
            });

            $this->absences = ApprovalAbsences::getAllByRole($this->auth)->map(function ($item) {
                $item->subject_name = $item->subject_name ?? ($item->subject ?? '-');
                return $item;
            });
        }
        // dd(Auth::user(), $this->auth);

        // dd($this->permissions, $this->rabs, $this->reimburses, $this->projects);

        $this->approvals = collect()->merge($this->permissions)->merge($this->absences)->merge($this->rabs)->merge($this->reimburses)->merge($this->projects);
        $this->approvalTotal = $this->approvals->count();
    }

}
