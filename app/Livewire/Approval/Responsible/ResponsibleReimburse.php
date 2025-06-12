<?php

namespace App\Livewire\Approval\Responsible;

use App\Models\Approvals\ApprovalReimburse;
use App\Models\Approvals\ApprovalRules;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class ResponsibleReimburse extends Component
{
    use WithFileUploads;
    public $auth, $file, $reimburses, $subject, $statusId, $reimburseId, $subDate, $description, $total, $fileName, $filePath;
    public $reimburseRules;
    public $approvalId = 4;

    public function render()
    {
        $this->loadData();
        return view('livewire.approval.responsible.responsible-reimburse');
    }

    public function loadData()
    {
        $this->auth = Auth::user()->user_id;
        $this->reimburses = ApprovalReimburse::getAllByUserId($this->auth);
        $this->reimburseRules = ApprovalRules::getByType($this->approvalId);
    }

    public function save()
    {
        $this->uploadFile();

        if ($this->reimburseId) {
            $this->updateReimburse($this->reimburseId);
        } else {
            $this->createReimburse();
        }

        $this->reset();
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Saved',
            'text' => 'It will list on the table.',
        ]);
    }

    public function createReimburse()
    {
        $this->statusId = 1;
        ApprovalReimburse::create([
            'approvalId' => $this->approvalId,
            'statusId' => $this->statusId,
            'subject' => $this->subject,
            'auth' => $this->auth,
            'description' => $this->description,
            'total' => 0,
            'fileName' => $this->fileName,
            'filePath' => $this->filePath,
        ]);
    }

    public function updateReimburse($id)
    {
        ApprovalReimburse::update($id, [
            'approvalId' => $this->approvalId,
            'statusId' => $this->statusId,
            'subject' => $this->subject,
            'auth' => $this->auth,
            'description' => $this->description,
            'total' => 0,
            'fileName' => $this->fileName,
            'filePath' => $this->filePath,
            'subDate' => $this->subDate,
        ]);
    }

    public function edit($id)
    {
        $this->dispatch(event: 'show-offcanvas');
        $r = ApprovalReimburse::getById($id);

        // dd($rab);
        $this->reimburseId = $r->id;
        $this->approvalId = $r->approval_id;
        $this->statusId = $r->status_id;
        $this->subject = $r->subject;
        $this->auth = $r->user_id;
        $this->description = $r->description;
        $this->total = $r->total;
        $this->fileName = $r->file_name;
        $this->filePath = $r->file_path;
        $this->subDate = $r->submission_date;
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
        ApprovalReimburse::delete($id);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Deleted',
            'text' => 'It will not list on the table.',
        ]);
    }

    public function uploadFile()
    {
        if ($this->file) {
            $this->validate([
                'file' => 'file|max:2048|mimes:pdf,doc,docx,jpg,jpeg,png',
            ]);

            // Hapus file lama jika ada dan sedang update
            if ($this->filePath && \Storage::disk('public')->exists($this->filePath)) {
                \Storage::disk('public')->delete($this->filePath);
            }

            $storedFile = $this->file->store('approval_files', 'public');

            $this->filePath = $storedFile;
            $this->fileName = $this->file->getClientOriginalName();
        }
    }
}
