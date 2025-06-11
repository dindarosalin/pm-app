<?php

namespace App\Livewire\Master\Approval;

use Livewire\Attributes\On;
use Livewire\Component;

class ApprovalPermissionTypes extends Component
{
    public $permissions;
    public $id, $name, $description;
    public function render()
    {
        $this->permissions = \App\Models\Approvals\ApprovalPermissionTypes::getAll();
        // dd($this->permissions);
        return view('livewire.master.approval.approval-permission-types');
    }

    public function save(){
        // dd('masuk save');
        if ($this->id) {
            \App\Models\Approvals\ApprovalPermissionTypes::Update($this->id, $this->all(), );
        } else {
            \App\Models\Approvals\ApprovalPermissionTypes::Create($this->all());
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
        $var = \App\Models\Approvals\ApprovalPermissionTypes::getById($id);

        $this->id = $var->id;
        $this->name = $var->name;
        $this->description = $var->description;
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
        \App\Models\Approvals\ApprovalPermissionTypes::delete($id);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Deleted',
            'text' => 'It will not list on the table.'
        ]);
    }
}
