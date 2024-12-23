<?php

namespace App\Livewire\Master\TaskStatus;

use Livewire\Component;
use App\Models\Projects\Master\TaskStatuses as ModelsTaskStatuses;
use Livewire\Attributes\On;

class ShowTaskStatus extends Component
{
    public $taskStatuses;
    public $taskStatusId;
    public $statusName, $statusCode;

    public function render()
    {
        $this->taskStatuses = ModelsTaskStatuses::getAll();
        return view('livewire.master.task-status.show-task-status', [
            'taskStatuses' => $this->taskStatuses
        ]);
    }

    public function save(){
        if ($this->taskStatusId) {
            ModelsTaskStatuses::Update($this->all(), $this->taskStatusId);
        } else {
            ModelsTaskStatuses::Create($this->all());
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
        $this->dispatch('show-offcanvas-task');
        $task = ModelsTaskStatuses::getById($id);
        $this->taskStatusId = $task->id;
        $this->statusName = $task->task_status;
        $this->statusCode = $task->code_status;
    }


    public function alertConfirm($id)
    {
        $this->dispatch('swal:confirm', [
            'type' => 'warning',
            'message' => 'Are you sure?',
            'text' => 'You won\'t be able to revert this!',
            'id' => $id,
            'dispatch' => 'delete-task-status'
        ]);
    }

    #[On('delete-task-status')]
    public function delete($id)
    {
        ModelsTaskStatuses::delete($id);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Deleted',
            'text' => 'It will not list on the table.'
        ]);
    }
}
