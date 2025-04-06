<?php

namespace App\Livewire\Projects\Tasks;

use Livewire\Component;
use App\Models\Projects\Task\Task;
use App\Models\Projects\Master\TaskCriterias;

class Priorities extends Component
{
    public $tasks, $criterias;
    public $c1, $c2, $c3, $c4;
    public $projectId, $auth;

    public function render()
    {
        $this->fc();
        return view('livewire.projects.tasks.priorities');
    }

    public function mount()
    {
        $this->projectId;
    }

    public function fc()
    {
        $this->tasks = Task::getAllProjectTasksByAuth($this->projectId, $this->auth);
        // $a = count($this->tasks->flag);
    
        $this->criterias = TaskCriterias::getAll();

        $flagsPerTask = []; // Inisialisasi array untuk menyimpan jumlah flag per task

        foreach ($this->tasks as $task) {
            $flagCount = 0;
            if (isset($task->flag)) { // Jika $task adalah array
                $flags = explode(', ', $task->flag);
                $flagCount = count($flags);
            } elseif (isset($task->flag)) { // Jika $task adalah objek
                $flags = explode(', ', $task->flag);
                $flagCount = count($flags);
            }
            // Menyimpan jumlah flag untuk task ini (menggunakan ID sebagai key)
            $flagsPerTask[$task->id ?? $task->id ?? null] = $flagCount;
        }

        $a = $flagsPerTask;
    
        dd($this->tasks, $a, $this->criterias);
    }
    
}
