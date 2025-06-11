<?php

namespace App\Livewire\Approval\Responsible;

use App\Models\Approvals\ApprovalRules;
use App\Models\Approvals\ApprovalTypesModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class ResponsibleRules extends Component
{
    public $auth;
    public $approvalTypes, $rules;
    public $ruleId, $ruleName, $rulePath, $approvalId;
    public $newAttachment;
    use WithFileUploads;
    // public
    public function render()
    {
        $this->loadData();
        return view('livewire.approval.responsible.responsible-rules');
    }

    public function loadData()
    {
        $this->rules = ApprovalRules::getAll();
        $this->auth = Auth::user()->user_id;
        $this->approvalTypes = ApprovalTypesModel::getAll();
    }

    public function save()
    {
        // $this->validate([
        //     'approvalId' => 'required',
        //     'newAttachment' => $this->ruleId ? 'nullable|mimes:pdf|max:2048' : 'required|mimes:pdf|max:2048',
        // ]);

        // try {
            $data = [
                'approval_id' => (int) $this->approvalId,
                'auth' => (int) $this->auth,
            ];

            if ($this->newAttachment) {
                if ($this->ruleId && $this->rulePath) {
                    Storage::disk('public')->delete($this->rulePath);
                }

                $path = $this->newAttachment->store('rules', 'public');
                $data['file_path'] = $path;
                $data['file_name'] = $this->newAttachment->getClientOriginalName();

                $this->rulePath = $path;
                $this->fileName = $data['file_name'];
            } elseif (!$this->newAttachment && $this->ruleId) {
                $r = ApprovalRules::getById($this->ruleId);
                $data['file_path'] = $r->file_path;
                $data['file_name'] = $r->file_name;
            }

            if ($this->ruleId) {
                ApprovalRules::update($this->ruleId, $data);
            } else {
                ApprovalRules::create($data);
            }

            $this->dispatch('close-offcanvas-rules');
            $this->reset();
            $this->dispatch('swal:modal', [
                'type' => 'success',
                'message' => 'Data Saved',
                'text' => 'It will list on the table.',
            ]);
        // } catch (\Throwable $th) {
        //     report($th);
        //     session()->flash('error', 'Gagal menyimpan data.');
        // }
    }

    #[On('edit')]
    public function edit($id)
    {
        $this->dispatch('show-offcanvas');
        $r = ApprovalRules::getById($id);

        $this->approvalId = $r->approval_id;
        $this->ruleId = $r->id;
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
        ApprovalRules::delete($id);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Deleted',
            'text' => 'It will not list on the table.',
        ]);
    }
}
