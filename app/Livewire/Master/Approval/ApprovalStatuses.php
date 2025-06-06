<?php

namespace App\Livewire\Master\Approval;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Approvals\ApprovalStatuses as ApprovalStatusesModel;

class ApprovalStatuses extends Component
{

    public $statuses, $statusId, $name, $code, $description;

    public function render()
    {
        $this->statuses = ApprovalStatusesModel::getAll();
        return view('livewire.master.approval.approval-statuses');
    }

    public function save(){
        // dd('masuk save');
        if ($this->statusId) {
            ApprovalStatusesModel::Update($this->all(), $this->statusId);
        } else {
            ApprovalStatusesModel::Create($this->all());
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
        $var = ApprovalStatusesModel::getById($id);

        $this->statusId = $var->id;
        $this->name = $var->name;
        $this->code = $var->code;
        $this->description = $var->description;
    }


    public function alertConfirm($id)
    {
        $this->dispatch('swal:confirm', [
            'type' => 'warning',
            'message' => 'Are you sure?',
            'text' => 'You won\'t be able to revert this!',
            'id' => $id,
            'dispatch' => 'delete-status'
        ]);
    }

    #[On('delete-status')]
    public function delete($id)
    {
        ApprovalStatusesModel::delete($id);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Deleted',
            'text' => 'It will not list on the table.'
        ]);
    }
}
