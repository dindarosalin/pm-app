<?php

namespace App\Livewire\Master\Approval;

use App\Models\Approvals\ApprovalTypesModel;
use Livewire\Attributes\On;
use Livewire\Component;

class ApprovalTypes extends Component
{
    public $approvals;
    public $appId, $approvalName, $approvalDescription;

    public function render()
    {
        $this->approvals = ApprovalTypesModel::getAll();
        return view('livewire.master.approval.approval-types');
    }

    public function save(){
        // dd('masuk save');
        if ($this->appId) {
            ApprovalTypesModel::Update($this->all(), $this->appId);
        } else {
            ApprovalTypesModel::Create($this->all());
        }
        $this->reset();
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Deleted',
            'text' => 'It will not list on the table.'
        ]);
    }

    #[On('edit')]
    public function edit($id) {
        $this->dispatch('show-offcanvas');
        $var = ApprovalTypesModel::getById($id);

        $this->appId = $var->id;
        $this->approvalName = $var->name;
        $this->approvalDescription = $var->description;
    }


    public function alertConfirm($id)
    {
        $this->dispatch('swal:confirm', [
            'type' => 'warning',
            'message' => 'Are you sure?',
            'text' => 'You won\'t be able to revert this!',
            'id' => $id,
            'dispatch' => 'delete-type'
        ]);
    }

    #[On('delete-type')]
    public function delete($id)
    {
        ApprovalTypesModel::delete($id);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Deleted',
            'text' => 'It will not list on the table.'
        ]);
    }
}
