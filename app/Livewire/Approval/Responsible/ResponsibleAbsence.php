<?php

namespace App\Livewire\Approval\Responsible;

use App\Livewire\Master\Approval\ApprovalAbsenceTypes;
use App\Models\Approvals\ApprovalAbsences;
use App\Models\Approvals\ApprovalAbsenceTypes as ApprovalsApprovalAbsenceTypes;
use App\Models\Approvals\ApprovalRules;
use App\Models\Employee\EmployeeHierarchy;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class ResponsibleAbsence extends Component
{
    public $auth, $absences, $accountableList, $delegationList, $subjectList;
    public $subject, $accountable, $absDetail, $startDate, $endDate, $totalDays, $emergencyContact, $relationship, $delegation, $noteDelegation, $submitDate, $fileName, $filePath;
    public $absenceId, $statusId;
    public $absenceRules;
    public $file;

    public $approvalId = 2; //ABSENCE
    // public $absences;

    use WithFileUploads;

    public function render()
    {
        $this->loadData();
        // dd($this->accountableList);
        // dd($this->auth);
        return view('livewire.approval.responsible.responsible-absence');
    }

    public function loadData()
    {
        $this->auth = Auth::user()->user_id;

        // DATA ACCOUNTABLE ATAU ATASAN
        $this->accountableList = EmployeeHierarchy::getHierarchyUp($this->auth);
        $this->delegationList = User::get();
        $this->subjectList = ApprovalsApprovalAbsenceTypes::getAll();

        $this->absences = ApprovalAbsences::getAll();
        $this->absenceRules = ApprovalRules::getByType($this->approvalId);
    }

    public function save()
    {
        // dd($this->all());
        $this->uploadFile();

        if ($this->absenceId) {
            ApprovalAbsences::update($this->absenceId, $this->all());
        } else {
            $this->statusId = 1;
            ApprovalAbsences::create($this->all());
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
            // hapus file lama jika ada dan sedang update
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
        $a = ApprovalAbsences::getById($id);

        $this->absenceId = $a->id;
        $this->subject = $a->subject;
        $this->accountable = $a->accountable;
        $this->approvalId = $a->approval_id;
        $this->absDetail = $a->absence_detail;
        $this->startDate = $a->start_date;
        $this->endDate = $a->end_date;
        $this->totalDays = $a->total_days;
        $this->emergencyContact = $a->emergency_contact;
        $this->relationship = $a->relationship_emergency_contact;
        $this->delegation = $a->delegation;
        $this->noteDelegation = $a->delegation_detail;
        $this->statusId = $a->status_id;
        $this->fileName = $a->file_name;
        $this->filePath = $a->file_path;
        $this->submitDate = $a->submission_date;
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
        ApprovalAbsences::delete($id);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Deleted',
            'text' => 'It will not list on the table.',
        ]);
    }

    public function updateStartDate()
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
            $start = \Carbon\Carbon::parse($this->startDate);
            $end = \Carbon\Carbon::parse($this->endDate);
            $this->totalDays = $start->diffInDays($end) + 1; // +1 to include the start date
        } else {
            $this->totalDays = 0;
        }
    }
}
