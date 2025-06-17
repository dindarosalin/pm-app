<?php

namespace App\Livewire\Approval\Informed;

use App\Models\Approvals\ApprovalAbsences;
use App\Models\Approvals\ApprovalPermissions;
use App\Models\Approvals\ApprovalProjectProcurement;
use App\Models\Approvals\ApprovalRab;
use App\Models\Approvals\ApprovalReimburse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Collection;

class InformedDashboard extends Component
{
    public Collection $approvals;
    public ?int $auth = null;

    public function mount()
    {
        $this->approvals = collect();
    }

    public function render()
    {
        $this->loadData();
        // dd($this->approvals);

        return view('livewire.approval.informed.informed-dashboard');
    }

    public function loadData()
    {
        $this->auth = Auth::user()->user_id;

        $userHasRequiredRole = DB::table('app_role_user')
            ->where('user_id', $this->auth)
            ->whereIn('role_id', ['07', '09', '01'])
            ->value('user_id');

        $rabs = collect();
        $reimburses = collect();
        $projects = collect();
        $permissions = collect();
        $absences = collect();

        if ($userHasRequiredRole !== null) {
            $rabs = ApprovalRab::getAll()->map(function ($item) {
                $item->subject_name = $item->subject_name ?? ($item->subject ?? '-');
                return $item;
            });

            $reimburses = ApprovalReimburse::getAll()->map(function ($item) {
                $item->subject_name = $item->subject_name ?? ($item->subject ?? '-');
                return $item;
            });

            $projects = ApprovalProjectProcurement::getAll()->map(function ($item) {
                $item->subject_name = $item->project_name ?? '-';
                return $item;
            });

            $permissions = ApprovalPermissions::getAll()->map(function ($item) {
                $item->subject_name = $item->subject_name ?? ($item->subject ?? '-');
                return $item;
            });

            $absences = ApprovalAbsences::getAll()->map(function ($item) {
                $item->subject_name = $item->subject_name ?? ($item->subject ?? '-');
                return $item;
            });
        }

        $this->approvals = collect()->merge($permissions)->merge($absences)->merge($rabs)->merge($reimburses)->merge($projects);
    }
}
