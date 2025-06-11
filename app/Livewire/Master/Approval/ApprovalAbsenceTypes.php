<?php

namespace App\Livewire\Master\Approval;

use Livewire\Attributes\On;
use Livewire\Component;

class ApprovalAbsenceTypes extends Component
{
    public $absences;
    public $id, $name, $description;

    public function render()
    {
        $this->absences = \App\Models\Approvals\ApprovalAbsenceTypes::getAll();
        return view('livewire.master.approval.approval-absence-types');
    }

    public function save(){
        // dd('masuk save');
        if ($this->id) {
            \App\Models\Approvals\ApprovalAbsenceTypes::Update($this->id, $this->all(), );
        } else {
            \App\Models\Approvals\ApprovalAbsenceTypes::Create($this->all());
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
        $var = \App\Models\Approvals\ApprovalAbsenceTypes::getById($id);

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
        \App\Models\Approvals\ApprovalAbsenceTypes::delete($id);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Deleted',
            'text' => 'It will not list on the table.'
        ]);
    }
}
