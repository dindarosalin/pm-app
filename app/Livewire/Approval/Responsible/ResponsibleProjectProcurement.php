<?php

namespace App\Livewire\Approval\Responsible;

use App\Models\Approvals\ApprovalProjectProcurement;
use App\Models\Approvals\ApprovalRules;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class ResponsibleProjectProcurement extends Component
{
    public $auth;
    public $approvalId = 5;
    public $projectId, $userId, $statusId, $subDate, $accountable, $description, $projectName, $client, $budget, $startDateEst, $endDateEst;
    public $accountableList, $projects, $rules;
    public function render()
    {
        $this->loadData();
        // dd($this->rules);
        return view('livewire.approval.responsible.responsible-project-procurement');
    }

    public function loadData()
    {
        $this->auth = Auth::user()->user_id;
        $this->accountableList = DB::table('app_user')
            ->join('app_role_user', 'app_user.user_id', '=', 'app_role_user.user_id')
            ->whereIn('app_role_user.role_id', [6, 12, 7, 8])
            ->select('app_user.*')
            ->distinct()
            ->get();
        $this->rules = ApprovalRules::getByType($this->approvalId);

        $this->projects = ApprovalProjectProcurement::getAll();
    }

    public function save()
    {
        if ($this->projectId) {
            $this->updateProject($this->projectId);
        } else {
            $this->createProject();
        }

        $this->reset();
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Saved',
            'text' => 'It will list on the table.',
        ]);
    }

    public function createProject()
    {
        ApprovalProjectProcurement::create([
            'user_id' => $this->auth,
            'approval_id' => $this->approvalId,
            'status_id' => 1,
            'submission_date' => $this->subDate,
            'accountable' => $this->accountable,
            'description' => $this->description,
            'project_name' => $this->projectName,
            'client' => $this->client,
            'budget' => $this->budget,
            'start_date_estimation' => $this->startDateEst,
            'end_date_estimation' => $this->endDateEst,
        ]);
    }

    public function updateProject($id)
    {
        ApprovalProjectProcurement::update($id, [
            'user_id'=> $this->userId,
            'approval_id' => $this->approvalId,
            'status_id' => $this->statusId,
            'submission_date' => $this->subDate,
            'accountable' => $this->accountable,
            'description' => $this->description,
            'project_name' => $this->projectName,
            'client' => $this->client,
            'budget' => $this->budget,
            'start_date_estimation' => $this->startDateEst,
            'end_date_estimation' => $this->endDateEst,
            'updated_by' => $this->auth,
        ]);
    }

    public function edit($id)
    {
        $this->dispatch('show-offcanvas');
        $v = ApprovalProjectProcurement::getById($id);

        $this->projectId = $v->id;
        $this->statusId = $v->status_id;
        $this->subDate = $v->submission_date;
        $this->accountable = $v->accountable;
        $this->description = $v->description;
        $this->projectName = $v->project_name;
        $this->client = $v->client;
        $this->budget = $v->budget;
        $this->startDateEst = $v->start_date_estimation;
        $this->endDateEst = $v->end_date_estimation;
        $this->userId = $v->user_id;
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
        ApprovalProjectProcurement::delete($id);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Deleted',
            'text' => 'It will not list on the table.',
        ]);
    }
}
