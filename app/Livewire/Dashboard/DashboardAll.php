<?php

namespace App\Livewire\Dashboard;

use App\Models\Projects\Project;
use App\Models\Projects\Task\Task;
use DivisionByZeroError;
use Illuminate\Support\Carbon;
use Livewire\Component;
use App\Services\evmService;

class DashboardAll extends Component
{
    public $percentagesProgress;
    public $time;
    public $evmData;

    public function getDataOnsite()
    {
        
    }

    public function getDataWfh()
    {
        
    }

    public function projectOnSuchedule()
    {
        
    }

    public function projectBehindSchedule()
    {
        
    }

    public function totalResources()
    {
        
    }

    // public function earnedValue()
    // {

    //     try {

    //         $ev = round(task::getDoneProjectTasks($this->projectId, [5,6])->count() / Dashboard::allTask()->count() * 100, 2);
    //     } catch (DivisionByZeroError $e) {

    //         $ev = 0;
    //     }
    //     // $this->ev = $allTask;
    //     return $ev;
    // }

    // public function allTaskProjects()
    // {
    //     return task::getAllProjectTasks($this->projectId);
    // }

        // Menghitung presentase rencana penyelesaian proyek
        public function plannedValue()
    {

        $allTask = 0;
        // $all = new all();
        // $all = Dashboard::allTask();


        //mencari project yang harus diselesaikan sampai hari ini
        // $currentDate = Carbon::now();
        // $doTasks = $all->filter(function ($task) use ($currentDate) {
        //     return Carbon::parse($task->end_date_estimation)->lessThan($currentDate);
        // })->count();

        // try {

        //     $pv = ($doTasks / Dashboard::allTask()->count() * 100);
        // } catch (DivisionByZeroError $e) {

        //     $pv = 0;
        // }

        dd();
    }

    public function health()
    {
        

    }

    public function projectProgress()
    {
        return $progress = Project::getAll();
        // dd($this->percentagesProgress);
    }

    public function time()
    {
        // Menghitung persentase penyelesaian per proyek
        $allTasks = Task::getAllTasks();
        $completedTasks = Task::getDoneAllProjectTasks([5,6]);
        
        $projectProgress = $allTasks->map(function ($project) use ($completedTasks) {
            $completed = $completedTasks->firstWhere('project_id', $project->project_id);
            $done = $completed->total_tasks_done ?? 0;
        
            $percentage = $project->total_tasks > 0
                ? ($done / $project->total_tasks) * 100
                : 0;
        
            return [
                'project_id' => $project->project_title,
                'total_tasks' => $project->total_tasks,
                'total_tasks_done' => $done,
                'progress' => round($percentage, 2) . '%',
            ];
        });

        // dd($projectProgress);
        // return [$evAll, $taskDone];
    }

        

    public function mount()
    {
        $projects = Project::getAllProjectsDashboard();

        $this->evmData = $projects->map(function ($project) {
            return EvmService::calculateEVM($project);
        });

        
        // dd($this);
        // dd($this->plannedValue());
        $this->percentagesProgress = $this->projectProgress();
        $this->time();
    }
    

    
    public function render()
    {
        return view('livewire.dashboard.dashboard-all');
    }
}
