<?php

namespace App\Livewire\Projects\Tasks;

use App\Models\Projects\Task\Task;
use Livewire\Component;

class ArchivedTask extends Component
{
    public $projectId;
    public $archivedTasks;

    public function render()
    {
        $this->loadData();
        // dd($this->archivedTasks);
        return view('livewire.projects.tasks.archived-task');
    }

    public function mount() {
        $this->projectId;
    }

    public function loadData()
    {
        $this->archivedTasks = Task::getArchivedTasks($this->projectId);
    }

    public function restore($id)
    {
        Task::restoreTask($id);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Restored',
            'text' => 'It will list on the table.'
        ]);
    }

    #[On('alertConfirm')]
    public function alertConfirm($id)
    {
        // dd('apakah delete');
        $this->dispatch('swal:confirm', [
            'type' => 'warning',
            'message' => 'Are you sure?',
            'text' => 'You won\'t be able to revert this!',
            'id' => $id,
            'dispatch' => 'delete-task',
        ]);
    }

    #[On('delete-task')]
    public function delete($id)
    {
        // dd('apakah delete');
        Task::delete($id);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Deleted',
            'text' => 'It will not list on the table.'
        ]);
        $this->dispatch('task-updated');
    }
}
