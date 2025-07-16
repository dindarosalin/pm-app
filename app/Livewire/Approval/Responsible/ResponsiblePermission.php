<?php

namespace App\Livewire\Approval\Responsible;

use App\Models\Approvals\ApprovalPermissions;
use App\Models\Approvals\ApprovalPermissionTypes;
use App\Models\Approvals\ApprovalRules;
use App\Models\Employee\EmployeeHierarchy;
use App\Models\Settings\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class ResponsiblePermission extends Component
{
    public $auth, $permissions, $accountableList, $delegationList, $subjectList;
    public $subject, $accountable, $permDetail, $startDate, $endDate, $totalDays, $emergencyContact, $relationship, $delegation, $noteDelegation, $submitDate, $fileName, $filePath;
    public $permissionId, $statusId;
    public $permissionRules;
    public $file;
    public $userId;

    public $approvalId = 1; //PERMISSION

    use WithFileUploads;
    public function render()
    {
        $this->loadData();
        // dd($this->accountableList);
        return view('livewire.approval.responsible.responsible-permission');
    }

    public function loadData()
    {
        $this->auth = Auth::user()->user_id;
        $this->accountableList = EmployeeHierarchy::getHierarchyUp($this->auth);
        $this->delegationList = User::get();
        $this->subjectList = ApprovalPermissionTypes::getAll();

        $this->permissions = ApprovalPermissions::getAllByUserId($this->auth);
        $this->permissionRules = ApprovalRules::getByType($this->approvalId);
    }

     // DATA ACCOUNTABLE ATAU ATASAN
        // $this->accountableList = Role::getAll();

    public function save()
    {
        $this->uploadFile();

        if ($this->permissionId) {
            ApprovalPermissions::update($this->permissionId, $this->all());
        } else {
            $this->statusId = 1;
            ApprovalPermissions::create($this->all());
        }

        $this->reset();
        // $this->dispatch('close-offcanvas');
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Saved',
            'text' => 'It will list on the table.',
        ]);

    }

    public function uploadFile()
    {
        if ($this->file) {
            // $this->validate([
            //     'file' => 'file|max:2048|mimes:pdf,doc,docx,jpg,jpeg,png',
            // ]);

            // Hapus file lama jika ada dan sedang update
            if ($this->filePath && Storage::disk('public')->exists($this->filePath)) {
                Storage::disk('public')->delete($this->filePath);
            }

            $storedFile = $this->file->store('approval_files', 'public');

            $this->filePath = $storedFile;
            $this->fileName = $this->file->getClientOriginalName();
        }
    }

    public function edit($id)
    {
        $this->dispatch('show-offcanvas');
        $p = ApprovalPermissions::getById($id);

        $this->permissionId = $p->id;
        $this->subject = $p->subject;
        $this->accountable = $p->accountable;
        $this->approvalId = $p->approval_id;
        $this->permDetail = $p->permission_detail;
        $this->startDate = $p->start_date;
        $this->endDate = $p->end_date;
        $this->totalDays = $p->total_days;
        $this->emergencyContact = $p->emergency_contact;
        $this->relationship = $p->relationship_emergency_contact;
        $this->delegation = $p->delegation;
        $this->noteDelegation = $p->delegation_detail;
        $this->statusId = $p->status_id;
        $this->fileName = $p->file_name;
        $this->filePath = $p->file_path;
        $this->submitDate = $p->submission_date;
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
        ApprovalPermissions::delete($id);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Deleted',
            'text' => 'It will not list on the table.',
        ]);
    }

    public function updatedStartDate()
    {
        $this->calculateTotalDays();
    }

    public function updatedEndDate()
    {
        $this->calculateTotalDays();
    }

    public function calculateTotalDays()
    {
        if ($this->startDate && $this->endDate) {
            $start = Carbon::parse($this->startDate);
            $end = Carbon::parse($this->endDate);
            $this->totalDays = $start->diffInDays($end) + 1; // +1 jika ingin menyertakan hari pertama
        } else {
            $this->totalDays = null;
        }
    }
}
