<?php

namespace App\Livewire\Projects\Release;

use Livewire\Component;
use App\Models\Projects\Task\Task;


class TaskDone extends Component
{
    //Variable
    public $tasks;

    public $projectId;

    public $taskCount;

    public $auth = 1;
    public $statusId = ['5'];

    public $selectedTasks; 

    public function mount()
    {
        //Get task done
        $this->loadTasks();
        
    }
    #[\Livewire\Attributes\On('refresh')]
    public function loadTasks()
    {
        if ($this->auth == 1) {
            $this->tasks = Task::getDoneProjectTasks($this->projectId, $this->statusId);
            $this->taskCount = $this->tasks->count();
        } else {
            $this->tasks = Task::getDoneProjectTasks($this->projectId, $this->statusId, $this->auth);
            $this->taskCount = $this->tasks->count();
        }

        $this->dispatch('updateTaskCount', $this->statusId, $this->taskCount);
    }

    // #[On('checkboxUpdated')]
    public function generateReleaseNote()
    {

        $selectedTasksData = task::collectData($this->selectedTasks);
        // dd($selectedTasksData);
        // dd($this->selectedTasks);
        $this->dispatch('taskId', ['tasks'=>$this->selectedTasks]);
        $this->dispatch('openModalWithData', ['tasks'=> $selectedTasksData]);
    }

    public function render()
    {
        return view('livewire.projects.release.task-done');
    }
}
