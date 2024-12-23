<?php

namespace App\Livewire\Master\ProjectStatus;

use Livewire\Component;
use App\Models\Projects\Master\ProjectStatuses as ModelsProjectStatuses;
use Livewire\Attributes\On;

class ShowProjectStatus extends Component
{
    public $projectStatuses;
    public $projectStatusId, $statusName, $statusCode;
    
    public function render()
    {
        $this->projectStatuses = ModelsProjectStatuses::getAll();
        return view('livewire.master.project-status.show-project-status', [
            'projectStatuses' => $this->projectStatuses
        ]);
    }

    public function save(){
        // dd('masuk save');
        if ($this->projectStatusId) {
            ModelsProjectStatuses::Update($this->all(), $this->projectStatusId);
        } else {
            ModelsProjectStatuses::Create($this->all());
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
        $this->dispatch('show-offcanvas-project');
        $var = ModelsProjectStatuses::getById($id);
        $this->projectStatusId = $var->id;
        $this->statusName = $var->project_status;
        $this->statusCode = $var->code_status;
    }


    public function alertConfirm($id)
    {
        $this->dispatch('swal:confirm', [
            'type' => 'warning',
            'message' => 'Are you sure?',
            'text' => 'You won\'t be able to revert this!',
            'id' => $id,
            'dispatch' => 'delete-project-status'
        ]);
    }

    #[On('delete-project-status')]
    public function delete($id)
    {
        ModelsProjectStatuses::delete($id);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Deleted',
            'text' => 'It will not list on the table.'
        ]);
    }
}
