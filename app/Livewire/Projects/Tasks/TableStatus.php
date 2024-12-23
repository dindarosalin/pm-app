<?php

namespace App\Livewire\Projects\Tasks;

use App\Models\Projects\Project;
use App\Models\Projects\Task\Task;
use Livewire\Attributes\On;
use Livewire\Component;

class TableStatus extends Component
{
    public $tasks;
    public $projectId, $auth;
    public $statusId;
    public $taskCount;

    public $search = '';
    public $sortColumn = null;
    public $sortDirection = 'asc';

    public function mount($projectId, $status, $auth)
    {
        $this->projectId = $projectId;
        $this->statusId = $status;
        $this->loadTasks();
        $this->auth = $auth;

        // dd($this->tasks);
    }

    #[On('task-updated')]
    public function updateTaskList()
    {
        $this->loadTasks();
    }

    public function loadTasks()
    {
        $this->tasks = Task::getTaskStatusByAuth($this->projectId, $this->statusId, $this->auth);
        $this->taskCount = $this->tasks->count();
        
        $this->dispatch('updateTaskCount', $this->statusId, $this->taskCount);
    }

    public function render()
    {
        $this->loadTasks();
        $this->tasks = $this->filter($this->tasks);
        // dd($this->tasks);

        return view('livewire.projects.tasks.table-status', [
            'tasks' => $this->tasks,
            'taskCount' => $this->taskCount,
        ]);
    }

    
    public function filter($tasks)
    {
        // Pencarian
        if ($this->search) {
            $tasks = Task::scopeSearch($tasks, $this->search);
        }

        // Sorting
        if ($this->sortColumn) {
            $tasks = Project::scopeSorting($tasks, $this->sortColumn, $this->sortDirection);
        }

        return $tasks;
    }

    public function sortBy($column)
    {
        if ($this->sortColumn === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortColumn = $column;
            $this->sortDirection = 'asc';
        }
    }

    #[On('alertConfirm')]
    public function alertConfirm($id)
    {
        $this->dispatch('swal:confirm', [
            'type' => 'warning',
            'message' => 'Are you sure?',
            'text' => 'Your data will avail in archive',
            'id' => $id,
            'dispatch' => 'delete-task'
        ]);
    }

    #[On('delete-task')]
    public function delete($id)
    {
        // dd('apakah delete');
        Task::softDelete($id);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Deleted',
            'text' => 'It will not list on the table.'
        ]);
        $this->dispatch('task-updated');
    }
}

